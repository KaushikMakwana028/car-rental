<?php
defined('BASEPATH') or exit('No direct script access allowed');

class General_model extends CI_Model
{
    private $document_types = array(
        'Driving License',
        'Aadhaar Card',
    );

    private $required_booking_documents = array(
        'Driving License',
        'Aadhaar Card',
    );

    public function __construct()
    {
        parent::__construct();
        $this->ensure_users_profile_columns();
        $this->ensure_users_booking_columns();
        $this->ensure_vehicle_pricing_columns();
        $this->ensure_booking_pricing_columns();
        $this->ensure_booking_status_values();
        $this->cleanup_orphan_temporary_customers();
    }

    public function get_all($table, $where = array(), $order_by = 'id DESC')
    {
        if (!empty($where)) {
            $this->db->where($where);
        }

        if (!empty($order_by)) {
            $this->db->order_by($order_by);
        }

        return $this->db->get($table)->result_array();
    }

    public function get_row($table, $where = array())
    {
        return $this->db->get_where($table, $where)->row_array();
    }

    public function get_user_by_id($user_id)
    {
        $user = $this->get_row('users', array('id' => (int) $user_id));
        if (empty($user)) {
            return array();
        }

        unset($user['password']);
        return $user;
    }

    public function insert($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function update($table, $where, $data)
    {
        return $this->db->where($where)->update($table, $data);
    }

    public function delete($table, $where)
    {
        return $this->db->where($where)->delete($table);
    }

    public function count_rows($table, $where = array())
    {
        if (!empty($where)) {
            $this->db->where($where);
        }

        return (int) $this->db->count_all_results($table);
    }

    public function authenticate_user($login_id, $password, $role)
    {
        $user = $this->db
            ->group_start()
            ->where('email', $login_id)
            ->or_where('phone', $login_id)
            ->group_end()
            ->where(array('role' => (int) $role, 'status' => 1))
            ->get('users')
            ->row_array();

        if (!$user || !password_verify($password, $user['password'])) {
            return array();
        }

        unset($user['password']);
        return $user;
    }

    public function create_user($data)
    {
        $existing = $this->get_row('users', array('email' => $data['email']));
        if (!empty($existing)) {
            return array('status' => false, 'message' => 'Email already exists.');
        }

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['role'] = (int) $data['role'];
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['status'] = 1;

        $user_id = $this->insert('users', $data);
        return array('status' => true, 'user_id' => $user_id);
    }

    public function resolve_customer_account($full_name, $phone, $email = '')
    {
        $full_name = trim($full_name);
        $phone = trim($phone);
        $email = trim($email);

        if ($phone !== '') {
            $existing_customer = $this->get_row('users', array(
                'phone' => $phone,
                'role' => 0,
            ));

            if (!empty($existing_customer)) {
                $update = array();
                if ($full_name !== '' && $existing_customer['full_name'] !== $full_name) {
                    $update['full_name'] = $full_name;
                }
                if ($email !== '' && $existing_customer['email'] !== $email) {
                    $update['email'] = $this->build_customer_email($email, $phone, (int) $existing_customer['id']);
                }

                if (!empty($update)) {
                    $this->update_user_profile((int) $existing_customer['id'], $update);
                }

                return (int) $existing_customer['id'];
            }
        }

        if ($email !== '') {
            $existing_customer = $this->get_row('users', array(
                'email' => $email,
                'role' => 0,
            ));

            if (!empty($existing_customer)) {
                $update = array();
                if ($full_name !== '' && $existing_customer['full_name'] !== $full_name) {
                    $update['full_name'] = $full_name;
                }
                if ($phone !== '' && $existing_customer['phone'] !== $phone) {
                    $update['phone'] = $phone;
                }

                if (!empty($update)) {
                    $this->update_user_profile((int) $existing_customer['id'], $update);
                }

                return (int) $existing_customer['id'];
            }
        }

        $password_seed = bin2hex(random_bytes(8));

        return (int) $this->insert('users', array(
            'full_name' => $full_name !== '' ? $full_name : 'Customer',
            'email' => $this->build_customer_email($email, $phone),
            'phone' => $phone,
            'password' => password_hash($password_seed, PASSWORD_DEFAULT),
            'role' => 0,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
    }

    public function update_user_profile($user_id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->update('users', array('id' => (int) $user_id), $data);
    }

    public function verify_user_password($user_id, $password)
    {
        $user = $this->db->select('password')->get_where('users', array('id' => (int) $user_id))->row_array();
        if (empty($user['password'])) {
            return false;
        }

        return password_verify($password, $user['password']);
    }

    public function update_user_password($user_id, $new_password)
    {
        return $this->update('users', array('id' => (int) $user_id), array(
            'password' => password_hash($new_password, PASSWORD_DEFAULT),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
    }

    public function get_dashboard_counts($role = 'admin', $user_id = 0)
    {
        $vehicles = $this->get_vehicles_with_live_status();
        $available_vehicles = 0;

        foreach ($vehicles as $vehicle) {
            if (isset($vehicle['status']) && $vehicle['status'] === 'available') {
                $available_vehicles++;
            }
        }

        $counts = array(
            'total_customers' => (int) $this->db->where('role', 0)->count_all_results('users'),
            'total_vehicles' => count($vehicles),
            'available_vehicles' => $available_vehicles,
            'total_bookings' => (int) $this->db->where('status !=', 'draft')->count_all_results('bookings'),
            'pending_bookings' => (int) $this->db->where(array('status' => 'pending'))->count_all_results('bookings'),
        );

        if ($role === 'customer' && $user_id > 0) {
            $counts['my_bookings'] = (int) $this->db
                ->where('customer_id', $user_id)
                ->where('status !=', 'draft')
                ->count_all_results('bookings');
            $counts['my_pending_bookings'] = (int) $this->db
                ->where(array('customer_id' => $user_id, 'status' => 'pending'))
                ->count_all_results('bookings');
        }

        return $counts;
    }

    public function get_bookings($filters = array())
    {
        $include_drafts = !empty($filters['include_drafts']);
        unset($filters['include_drafts']);

        $this->db->select('bookings.*, users.full_name AS customer_name, users.phone AS customer_phone, vehicles.name AS vehicle_name, vehicles.registration_no, vehicles.advance_amount, vehicles.image AS vehicle_image');
        $this->db->from('bookings');
        $this->db->join('users', 'users.id = bookings.customer_id', 'left');
        $this->db->join('vehicles', 'vehicles.id = bookings.vehicle_id', 'left');

        if ($include_drafts) {
            $this->db->where_in('bookings.status', array('draft', 'pending', 'confirmed', 'completed', 'cancelled'));
        } else {
            $this->db->where_in('bookings.status', array('pending', 'confirmed', 'completed', 'cancelled'));
        }

        if (!empty($filters)) {
            $this->db->where($filters);
        }

        $this->db->order_by('bookings.id', 'DESC');
        $bookings = $this->db->get()->result_array();

        return $this->enrich_bookings($bookings);
    }

    public function get_booking_for_flow($booking_id, $customer_id)
    {
        $rows = $this->get_bookings(array(
            'include_drafts' => true,
            'bookings.id' => (int) $booking_id,
            'bookings.customer_id' => (int) $customer_id,
        ));

        return !empty($rows) ? $rows[0] : array();
    }

    public function get_available_vehicles()
    {
        $vehicles = $this->get_vehicles_with_live_status();

        return array_values(array_filter($vehicles, function ($vehicle) {
            return isset($vehicle['status']) && $vehicle['status'] === 'available';
        }));
    }

    public function get_vehicles_with_live_status()
    {
        $vehicles = $this->get_all('vehicles', array(), 'id DESC');

        return $this->apply_live_vehicle_status($vehicles);
    }

    public function create_booking($data)
    {
        $skip_vehicle_booking = !empty($data['_skip_vehicle_booking']);
        unset($data['_skip_vehicle_booking']);

        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $booking_id = $this->insert('bookings', $data);

        return $booking_id;
    }

    public function calculate_booking_amount($vehicle, $booking_type = 'hours', $estimated_km = 0, $hours_slot = 0, $pickup_date = '', $return_date = '', $pickup_time = '', $return_time = '')
    {
        if (empty($vehicle)) {
            return 0;
        }

        $booking_type = $booking_type === 'km' ? 'km' : 'hours';
        $estimated_km = max(0, (int) $estimated_km);
        $hours_slot = (int) $hours_slot;

        if ($booking_type === 'km') {
            return (float) $vehicle['rate_per_day'] * $estimated_km;
        }

        $package_price = 0;
        if ($hours_slot === 6) {
            $package_price = (float) (isset($vehicle['price_6_hours']) ? $vehicle['price_6_hours'] : 0);
        }

        if ($hours_slot === 12) {
            $package_price = (float) (isset($vehicle['price_12_hours']) ? $vehicle['price_12_hours'] : 0);
        }

        if ($hours_slot === 24) {
            $package_price = (float) (isset($vehicle['price_24_hours']) ? $vehicle['price_24_hours'] : 0);
        }

        if ($package_price <= 0 || $hours_slot <= 0) {
            return 0;
        }

        $duration_hours = $this->calculate_booking_duration_hours($pickup_date, $return_date, $pickup_time, $return_time);
        $package_count = $duration_hours > 0 ? (int) ceil($duration_hours / $hours_slot) : 1;

        return $package_price * max(1, $package_count);
    }

    public function calculate_booking_duration_hours($pickup_date = '', $return_date = '', $pickup_time = '', $return_time = '')
    {
        $pickup_date = trim((string) $pickup_date);
        $return_date = trim((string) $return_date);
        $pickup_time = trim((string) $pickup_time);
        $return_time = trim((string) $return_time);

        if ($pickup_date === '' || $return_date === '') {
            return 0;
        }

        if ($pickup_time === '') {
            $pickup_time = '00:00';
        }

        if ($return_time === '') {
            $return_time = '00:00';
        }

        $pickup_stamp = strtotime($pickup_date . ' ' . $pickup_time);
        $return_stamp = strtotime($return_date . ' ' . $return_time);

        if ($pickup_stamp === false || $return_stamp === false || $return_stamp <= $pickup_stamp) {
            return 0;
        }

        return ($return_stamp - $pickup_stamp) / 3600;
    }

    public function normalize_time_value($time = '')
    {
        $time = trim((string) $time);
        if ($time === '') {
            return null;
        }

        $stamp = strtotime($time);
        if ($stamp === false) {
            return null;
        }

        return date('H:i:s', $stamp);
    }

    public function purge_draft_booking($booking_id, $customer_id)
    {
        $booking_id = (int) $booking_id;
        $customer_id = (int) $customer_id;

        if ($booking_id <= 0 || $customer_id <= 0) {
            return false;
        }

        $booking = $this->get_row('bookings', array(
            'id' => $booking_id,
            'customer_id' => $customer_id,
            'status' => 'draft',
        ));
        if (empty($booking)) {
            return false;
        }

        if ($this->db->table_exists('payment_requests')) {
            $requests = $this->db
                ->where('booking_id', $booking_id)
                ->where('customer_id', $customer_id)
                ->get('payment_requests')
                ->result_array();

            foreach ($requests as $request) {
                if (!empty($request['receipt_path'])) {
                    $absolute_path = FCPATH . ltrim(str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $request['receipt_path']), DIRECTORY_SEPARATOR);
                    if (is_file($absolute_path)) {
                        @unlink($absolute_path);
                    }
                }
            }

            $this->delete('payment_requests', array('booking_id' => $booking_id, 'customer_id' => $customer_id));
        }

        $this->update('documents', array('booking_id' => $booking_id, 'customer_id' => $customer_id), array(
            'booking_id' => null,
            'updated_at' => date('Y-m-d H:i:s'),
        ));

        if ($this->db->table_exists('payments')) {
            $this->delete('payments', array('booking_id' => $booking_id));
        }

        $deleted = $this->delete('bookings', array('id' => $booking_id, 'customer_id' => $customer_id, 'status' => 'draft'));
        if ($deleted) {
            $this->purge_temporary_customer_if_unused($customer_id);
        }

        return $deleted;
    }

    public function sync_booking_status_from_payment($booking_id)
    {
        $booking_id = (int) $booking_id;
        if ($booking_id <= 0) {
            return false;
        }

        $booking = $this->get_row('bookings', array('id' => $booking_id));
        if (empty($booking)) {
            return false;
        }

        if (isset($booking['status']) && $booking['status'] === 'completed') {
            return true;
        }

        $paid_amount = 0;
        if ($this->db->table_exists('payments')) {
            $paid_amount = (float) $this->db
                ->select_sum('amount')
                ->where('booking_id', $booking_id)
                ->get('payments')
                ->row()
                ->amount;
        }

        $update = array(
            'updated_at' => date('Y-m-d H:i:s'),
        );

        if ($paid_amount >= (float) $booking['amount'] && (float) $booking['amount'] > 0) {
            $update['status'] = 'completed';
            $result = $this->update('bookings', array('id' => $booking_id), $update);

            if (!empty($booking['vehicle_id'])) {
                $this->update('vehicles', array('id' => (int) $booking['vehicle_id']), array('status' => 'available'));
            }

            return $result;
        }

        if ($paid_amount > 0 && (!isset($booking['status']) || $booking['status'] === 'pending')) {
            $update['status'] = 'confirmed';
            return $this->update('bookings', array('id' => $booking_id), array(
                'status' => 'confirmed',
                'updated_at' => $update['updated_at'],
            ));
        }

        return true;
    }

    public function format_booking_code($booking_id, $created_at = '')
    {
        // If table is empty or truncated, next insert will be id=1
        // so booking code resets automatically with the id
        $booking_id = (int) $booking_id;
        $stamp      = !empty($created_at) ? strtotime($created_at) : false;

        if ($stamp === false) {
            $stamp = time();
        }

        return 'BK-' . date('dmy', $stamp) . '-' . str_pad((string) $booking_id, 4, '0', STR_PAD_LEFT);
    }

    public function get_customers_overview()
    {
        $this->db->select("
            users.id,
            users.full_name,
            users.email,
            users.phone,
            COUNT(bookings.id) AS total_bookings,
            COALESCE(SUM(bookings.amount), 0) AS total_spent,
            MAX(bookings.pickup_date) AS last_booking
        ", false);
        $this->db->from('users');
        $this->db->join('bookings', 'bookings.customer_id = users.id', 'left');
        $this->db->where('users.role', 0);
        $this->db->group_by(array('users.id', 'users.full_name', 'users.email', 'users.phone'));
        $this->db->order_by('users.id', 'DESC');

        $customers = $this->db->get()->result_array();

        foreach ($customers as &$customer) {
            $document_gate = $this->get_required_documents_status((int) $customer['id']);
            $customer['doc_status'] = $document_gate['overall_status'];
            $customer['doc_ready'] = $document_gate['is_ready'] ? 1 : 0;
            $customer['approved_docs'] = $document_gate['approved_count'];
            $customer['required_docs'] = $document_gate['required_count'];
        }

        return $customers;
    }

    public function get_payment_summary()
    {
        $summary = array(
            'total_collected' => 0,
            'advance_received' => 0,
            'remaining_to_collect' => 0,
            'refunds_issued' => 0,
        );

        if ($this->db->table_exists('payments')) {
            $summary['total_collected'] = (float) $this->db->select_sum('amount')->get('payments')->row()->amount;
            $summary['advance_received'] = (float) $this->db->select_sum('amount')->where('payment_type', 'advance')->get('payments')->row()->amount;
            $summary['refunds_issued'] = (float) $this->db->select_sum('amount')->where('payment_type', 'refund')->get('payments')->row()->amount;
        }

        $booking_total = (float) $this->db->select_sum('amount')->get('bookings')->row()->amount;
        $summary['remaining_to_collect'] = max(0, $booking_total - $summary['total_collected']);

        return $summary;
    }

    public function get_booking_payments($booking_id)
    {
        if (!$this->db->table_exists('payments')) {
            return array();
        }

        return $this->db
            ->where('booking_id', $booking_id)
            ->order_by('id', 'ASC')
            ->get('payments')
            ->result_array();
    }

    public function has_required_documents_for_booking($customer_id)
    {
        $summary = $this->get_required_documents_status($customer_id);
        return !empty($summary['is_ready']);
    }

    public function get_missing_required_documents($customer_id)
    {
        $summary = $this->get_required_documents_status($customer_id);
        return array_values(array_unique(array_merge($summary['missing_documents'], $summary['rejected_documents'])));
    }

    public function get_payment_settings()
    {
        $defaults = array(
            'id' => 0,
            'account_holder' => '',
            'bank_name' => '',
            'account_number' => '',
            'ifsc_code' => '',
            'branch_name' => '',
            'upi_id' => '',
            'qr_image' => '',
            'payment_instructions' => '',
            'updated_at' => '',
        );

        if (!$this->db->table_exists('payment_settings')) {
            return $defaults;
        }

        $row = $this->db
            ->order_by('id', 'DESC')
            ->get('payment_settings')
            ->row_array();

        return !empty($row) ? array_merge($defaults, $row) : $defaults;
    }

    public function get_public_contact_details()
    {
        $defaults = array(
            'full_name' => 'Cab Booking Fast',
            'phone' => '',
            'email' => '',
            'address' => '',
        );

        if (!$this->db->table_exists('users')) {
            return $defaults;
        }

        $admin = $this->db
            ->where(array('role' => 1, 'status' => 1))
            ->order_by('id', 'ASC')
            ->get('users')
            ->row_array();

        if (empty($admin)) {
            return $defaults;
        }

        return array(
            'full_name' => !empty($admin['full_name']) ? $admin['full_name'] : $defaults['full_name'],
            'phone' => !empty($admin['phone']) ? $admin['phone'] : '',
            'email' => !empty($admin['email']) ? $admin['email'] : '',
            'address' => isset($admin['address']) ? trim((string) $admin['address']) : '',
        );
    }

    public function save_payment_settings($data)
    {
        if (!$this->db->table_exists('payment_settings')) {
            return false;
        }

        $existing = $this->db->order_by('id', 'DESC')->get('payment_settings')->row_array();
        $data['updated_at'] = date('Y-m-d H:i:s');

        if (!empty($existing)) {
            return $this->update('payment_settings', array('id' => (int) $existing['id']), $data);
        }

        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->insert('payment_settings', $data);
    }

    public function create_payment_request($data)
    {
        if (!$this->db->table_exists('payment_requests')) {
            return 0;
        }

        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        return (int) $this->insert('payment_requests', $data);
    }

    public function get_customer_payment_requests($customer_id)
    {
        if (!$this->db->table_exists('payment_requests')) {
            return array();
        }

        $this->db->select('payment_requests.*, bookings.created_at AS booking_created_at, vehicles.name AS vehicle_name, vehicles.registration_no');
        $this->db->from('payment_requests');
        $this->db->join('bookings', 'bookings.id = payment_requests.booking_id', 'left');
        $this->db->join('vehicles', 'vehicles.id = bookings.vehicle_id', 'left');
        $this->db->where('payment_requests.customer_id', (int) $customer_id);
        $this->db->order_by('payment_requests.id', 'DESC');

        $rows = $this->db->get()->result_array();
        foreach ($rows as &$row) {
            $row['booking_code'] = !empty($row['booking_id']) ? $this->format_booking_code($row['booking_id'], isset($row['booking_created_at']) ? $row['booking_created_at'] : '') : '-';
        }
        unset($row);

        return $rows;
    }

    public function get_admin_payment_requests($status = '')
    {
        if (!$this->db->table_exists('payment_requests')) {
            return array();
        }

        $this->db->select('payment_requests.*, bookings.created_at AS booking_created_at, bookings.pickup_date, bookings.return_date, bookings.pickup_location, bookings.drop_location, bookings.amount AS booking_amount, vehicles.advance_amount, users.full_name AS customer_name, users.email AS customer_email, users.phone AS customer_phone, vehicles.name AS vehicle_name, vehicles.registration_no, vehicles.image AS vehicle_image');
        $this->db->from('payment_requests');
        $this->db->join('bookings', 'bookings.id = payment_requests.booking_id', 'left');
        $this->db->join('users', 'users.id = payment_requests.customer_id', 'left');
        $this->db->join('vehicles', 'vehicles.id = bookings.vehicle_id', 'left');

        if ($status !== '') {
            $this->db->where('payment_requests.status', $status);
        }

        $this->db->order_by('payment_requests.id', 'DESC');
        $rows = $this->db->get()->result_array();

        foreach ($rows as &$row) {
            $row['booking_code'] = !empty($row['booking_id']) ? $this->format_booking_code($row['booking_id'], isset($row['booking_created_at']) ? $row['booking_created_at'] : '') : '-';
        }
        unset($row);

        return $rows;
    }

    public function get_payment_request_by_id($request_id)
    {
        if (!$this->db->table_exists('payment_requests')) {
            return array();
        }

        $this->db->select('payment_requests.*, bookings.created_at AS booking_created_at, bookings.pickup_date, bookings.return_date, bookings.pickup_location, bookings.drop_location, bookings.amount AS booking_amount, vehicles.advance_amount, users.full_name AS customer_name, users.email AS customer_email, users.phone AS customer_phone, vehicles.name AS vehicle_name, vehicles.registration_no, vehicles.image AS vehicle_image');
        $this->db->from('payment_requests');
        $this->db->join('bookings', 'bookings.id = payment_requests.booking_id', 'left');
        $this->db->join('users', 'users.id = payment_requests.customer_id', 'left');
        $this->db->join('vehicles', 'vehicles.id = bookings.vehicle_id', 'left');
        $this->db->where('payment_requests.id', (int) $request_id);

        $row = $this->db->get()->row_array();
        if (!empty($row)) {
            $row['booking_code'] = !empty($row['booking_id']) ? $this->format_booking_code($row['booking_id'], isset($row['booking_created_at']) ? $row['booking_created_at'] : '') : '-';
        }

        return !empty($row) ? $row : array();
    }

    public function get_payment_request_for_booking($booking_id, $customer_id = 0)
    {
        if (!$this->db->table_exists('payment_requests')) {
            return array();
        }

        $this->db->from('payment_requests');
        $this->db->where('booking_id', (int) $booking_id);

        if ($customer_id > 0) {
            $this->db->where('customer_id', (int) $customer_id);
        }

        return (array) $this->db->order_by('id', 'DESC')->get()->row_array();
    }

    public function get_booking_photos($booking_id)
    {
        $booking_id = (int) $booking_id;
        if ($booking_id <= 0 || !$this->db->table_exists('booking_vehicle_photos')) {
            return array();
        }

        return $this->db
            ->select('booking_vehicle_photos.*, users.full_name AS uploaded_by_name')
            ->from('booking_vehicle_photos')
            ->join('users', 'users.id = booking_vehicle_photos.uploaded_by', 'left')
            ->where('booking_vehicle_photos.booking_id', $booking_id)
            ->order_by('booking_vehicle_photos.id', 'DESC')
            ->get()
            ->result_array();
    }

    public function create_booking_photo($data)
    {
        if (!$this->db->table_exists('booking_vehicle_photos')) {
            return 0;
        }

        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        return (int) $this->insert('booking_vehicle_photos', $data);
    }

    public function update_payment_request($request_id, $data)
    {
        if (!$this->db->table_exists('payment_requests')) {
            return false;
        }

        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->update('payment_requests', array('id' => (int) $request_id), $data);
    }

    public function get_payment_request_counts()
    {
        $counts = array(
            'total' => 0,
            'pending' => 0,
            'approved' => 0,
            'rejected' => 0,
        );

        if (!$this->db->table_exists('payment_requests')) {
            return $counts;
        }

        $rows = $this->db
            ->select('status, COUNT(*) AS total_rows', false)
            ->from('payment_requests')
            ->group_by('status')
            ->get()
            ->result_array();

        foreach ($rows as $row) {
            $status = strtolower($row['status']);
            $counts['total'] += (int) $row['total_rows'];
            if (isset($counts[$status])) {
                $counts[$status] = (int) $row['total_rows'];
            }
        }

        return $counts;
    }

    public function get_document_types()
    {
        return $this->document_types;
    }

    public function get_customer_documents_matrix($customer_id)
    {
        $rows = $this->db
            ->select('documents.*, bookings.created_at AS booking_created_at, vehicles.name AS vehicle_name')
            ->from('documents')
            ->join('bookings', 'bookings.id = documents.booking_id', 'left')
            ->join('vehicles', 'vehicles.id = bookings.vehicle_id', 'left')
            ->order_by('updated_at', 'DESC')
            ->order_by('id', 'DESC')
            ->where('documents.customer_id', $customer_id)
            ->get()
            ->result_array();

        $indexed = array();
        foreach ($rows as $row) {
            $indexed[$row['document_type']] = $row;
        }

        $matrix = array();
        foreach ($this->document_types as $type) {
            $row = isset($indexed[$type]) ? $indexed[$type] : array();
            $matrix[] = array(
                'document_type' => $type,
                'status' => !empty($row) ? $row['status'] : 'missing',
                'file_name' => !empty($row) ? $row['file_name'] : '',
                'file_path' => !empty($row) ? $row['file_path'] : '',
                'admin_notes' => !empty($row) ? $row['admin_notes'] : '',
                'booking_id' => !empty($row) ? $row['booking_id'] : 0,
                'id' => !empty($row) ? $row['id'] : 0,
                'vehicle_name' => !empty($row) ? $row['vehicle_name'] : '',
                'booking_created_at' => !empty($row) ? $row['booking_created_at'] : '',
                'booking_label' => !empty($row) && !empty($row['booking_id'])
                    ? $this->format_booking_code($row['booking_id'], isset($row['booking_created_at']) ? $row['booking_created_at'] : '') . (!empty($row['vehicle_name']) ? ' - ' . $row['vehicle_name'] : '')
                    : 'General',
                'updated_at' => !empty($row) ? $row['updated_at'] : '',
            );
        }

        return $matrix;
    }

    public function get_customer_documents_progress($customer_id)
    {
        $matrix = $this->get_customer_documents_matrix($customer_id);
        $submitted = 0;

        foreach ($matrix as $item) {
            if ($item['status'] !== 'missing') {
                $submitted++;
            }
        }

        return array(
            'submitted' => $submitted,
            'total' => count($matrix),
            'percentage' => count($matrix) > 0 ? round(($submitted / count($matrix)) * 100) : 0,
        );
    }

    public function get_required_documents_status($customer_id)
    {
        $summary = array(
            'is_ready' => false,
            'overall_status' => 'missing',
            'required_count' => count($this->required_booking_documents),
            'approved_count' => 0,
            'missing_count' => 0,
            'pending_count' => 0,
            'rejected_count' => 0,
            'missing_documents' => array(),
            'pending_documents' => array(),
            'rejected_documents' => array(),
            'approved_documents' => array(),
            'status_map' => array(),
        );

        if (!$this->db->table_exists('documents')) {
            $summary['missing_count'] = $summary['required_count'];
            $summary['missing_documents'] = $this->required_booking_documents;
            return $summary;
        }

        $rows = $this->db
            ->select('document_type, status')
            ->from('documents')
            ->where('customer_id', (int) $customer_id)
            ->where_in('document_type', $this->required_booking_documents)
            ->order_by('updated_at', 'DESC')
            ->order_by('id', 'DESC')
            ->get()
            ->result_array();

        foreach ($rows as $row) {
            if (!isset($summary['status_map'][$row['document_type']])) {
                $summary['status_map'][$row['document_type']] = strtolower(trim($row['status']));
            }
        }

        foreach ($this->required_booking_documents as $document_type) {
            $status = isset($summary['status_map'][$document_type]) ? $summary['status_map'][$document_type] : 'missing';
            $summary['status_map'][$document_type] = $status;

            if ($status === 'approved') {
                $summary['approved_count']++;
                $summary['approved_documents'][] = $document_type;
                continue;
            }

            if ($status === 'rejected') {
                $summary['rejected_count']++;
                $summary['rejected_documents'][] = $document_type;
                continue;
            }

            if ($status === 'pending') {
                $summary['pending_count']++;
                $summary['pending_documents'][] = $document_type;
                continue;
            }

            $summary['missing_count']++;
            $summary['missing_documents'][] = $document_type;
        }

        if ($summary['approved_count'] === $summary['required_count']) {
            $summary['is_ready'] = true;
            $summary['overall_status'] = 'approved';
        } elseif ($summary['rejected_count'] > 0) {
            $summary['overall_status'] = 'rejected';
        } elseif ($summary['pending_count'] > 0) {
            $summary['overall_status'] = 'pending';
        } else {
            $summary['overall_status'] = 'missing';
        }

        return $summary;
    }

    public function get_all_documents_for_admin()
    {
        $this->db->select('documents.*, users.full_name, users.email, users.phone, bookings.id AS booking_reference, bookings.created_at AS booking_created_at, vehicles.name AS vehicle_name');
        $this->db->from('documents');
        $this->db->join('users', 'users.id = documents.customer_id', 'left');
        $this->db->join('bookings', 'bookings.id = documents.booking_id', 'left');
        $this->db->join('vehicles', 'vehicles.id = bookings.vehicle_id', 'left');
        $this->db->order_by('documents.updated_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_admin_document_detail($document_id)
    {
        $this->db->select('documents.*, users.full_name, users.email, users.phone, bookings.id AS booking_reference, bookings.created_at AS booking_created_at, vehicles.name AS vehicle_name');
        $this->db->from('documents');
        $this->db->join('users', 'users.id = documents.customer_id', 'left');
        $this->db->join('bookings', 'bookings.id = documents.booking_id', 'left');
        $this->db->join('vehicles', 'vehicles.id = bookings.vehicle_id', 'left');
        $this->db->where('documents.id', $document_id);
        return $this->db->get()->row_array();
    }

    public function get_customer_activity_detail($customer_id)
    {
        $customer_id = (int) $customer_id;

        return array(
            'documents' => $this->get_customer_documents_matrix($customer_id),
            'bookings' => $this->get_bookings(array('bookings.customer_id' => $customer_id)),
            'document_gate' => $this->get_required_documents_status($customer_id),
        );
    }

    public function get_document_review_groups()
    {
        $customers = $this->get_customers_overview();
        $groups = array();

        foreach ($customers as $customer) {
            $documents = $this->get_customer_documents_matrix((int) $customer['id']);
            $pending_count = 0;
            $uploaded_count = 0;

            foreach ($documents as $document) {
                if ($document['status'] !== 'missing') {
                    $uploaded_count++;
                }

                if ($document['status'] === 'pending') {
                    $pending_count++;
                }
            }

            if ($uploaded_count === 0) {
                continue;
            }

            $groups[] = array(
                'customer' => $customer,
                'documents' => $documents,
                'pending_count' => $pending_count,
                'uploaded_count' => $uploaded_count,
                'total_count' => count($documents),
            );
        }

        return $groups;
    }

    public function sync_manual_booking_documents($customer_id, $booking_id, $aadhaar_number = '', $driving_license_number = '', $documents_verified = false)
    {
        $customer_id = (int) $customer_id;
        $booking_id = (int) $booking_id;

        if ($customer_id <= 0) {
            return false;
        }

        $this->update_user_profile($customer_id, array(
            'aadhaar_number' => trim($aadhaar_number),
            'driving_license_number' => trim($driving_license_number),
            'documents_verified' => $documents_verified ? 1 : 0,
        ));

        if (!$documents_verified || !$this->db->table_exists('documents')) {
            return true;
        }

        $notes = 'Verified manually by admin during booking.';
        $now = date('Y-m-d H:i:s');
        $manual_documents = array(
            'Aadhaar Card' => trim($aadhaar_number),
            'Driving License' => trim($driving_license_number),
        );

        foreach ($manual_documents as $document_type => $document_number) {
            $payload = array(
                'customer_id' => $customer_id,
                'booking_id' => $booking_id > 0 ? $booking_id : null,
                'document_type' => $document_type,
                'file_name' => '',
                'file_path' => '',
                'status' => 'approved',
                'admin_notes' => $document_number !== '' ? $notes . ' Number: ' . $document_number : $notes,
                'updated_at' => $now,
            );

            $existing = $this->get_row('documents', array(
                'customer_id' => $customer_id,
                'document_type' => $document_type,
            ));

            if (!empty($existing)) {
                $this->update('documents', array('id' => (int) $existing['id']), $payload);
                continue;
            }

            $payload['created_at'] = $now;
            $this->insert('documents', $payload);
        }

        return true;
    }

    private function enrich_bookings($bookings)
    {
        if (empty($bookings)) {
            return array();
        }

        $booking_ids = array();
        foreach ($bookings as $booking) {
            $booking_ids[] = (int) $booking['id'];
        }

        $payment_totals = $this->get_payment_totals_map($booking_ids);
        $payment_request_map = $this->get_payment_request_map($booking_ids);
        $photo_count_map = $this->get_booking_photo_counts_map($booking_ids);

        foreach ($bookings as &$booking) {
            $paid_amount = isset($payment_totals[$booking['id']]) ? (float) $payment_totals[$booking['id']] : 0;
            $amount = (float) $booking['amount'];
            $advance_amount = isset($booking['advance_amount']) ? (float) $booking['advance_amount'] : 0;
            $balance_amount = max(0, $amount - $paid_amount);
            $request_row = isset($payment_request_map[$booking['id']]) ? $payment_request_map[$booking['id']] : array();

            $booking['booking_code'] = $this->format_booking_code($booking['id'], isset($booking['created_at']) ? $booking['created_at'] : '');
            $booking['trip_label'] = $this->format_trip_range($booking['pickup_date'], $booking['return_date']);
            $booking['trip_route'] = trim($booking['pickup_location'] . ' - ' . $booking['drop_location'], ' -');
            $booking_type = !empty($booking['booking_type']) ? $booking['booking_type'] : 'km';
            $booking['display_km'] = !empty($booking['estimated_km']) ? (int) $booking['estimated_km'] . ' km' : 'N/A';
            $booking['booking_type'] = $booking_type;
            $booking['trip_mode_label'] = $booking_type === 'hours'
                ? (!empty($booking['hours_slot']) ? (int) $booking['hours_slot'] . ' Hours' : 'Hours')
                : $booking['display_km'];

            $booking['paid_amount'] = $paid_amount;
            $booking['requires_advance'] = isset($booking['requires_advance']) ? (int) $booking['requires_advance'] : 1;
            $booking['advance_due'] = $booking['requires_advance'] ? $advance_amount : 0;
            $booking['balance_amount'] = $balance_amount;
            $booking['effective_status'] = $booking['status'];
            if ($booking['effective_status'] === 'pending' && $paid_amount > 0) {
                $booking['effective_status'] = 'confirmed';
            }
            $booking['payment_status'] = $booking['requires_advance']
                ? $this->resolve_payment_status($paid_amount, $advance_amount, $amount)
                : 'Not Required';
            $booking['payment_badge'] = strtolower(str_replace(' ', '-', $booking['payment_status']));
            $booking['payment_request_id'] = !empty($request_row) ? (int) $request_row['id'] : 0;
            $booking['payment_request_status'] = !empty($request_row) ? $request_row['status'] : '';
            $booking['payment_request_type'] = !empty($request_row) ? $request_row['payment_type'] : '';
            $booking['payment_request_receipt'] = !empty($request_row) ? $request_row['receipt_path'] : '';
            $booking['payment_request_admin_notes'] = !empty($request_row) ? $request_row['admin_notes'] : '';
            $booking['booking_photo_count'] = isset($photo_count_map[$booking['id']]) ? (int) $photo_count_map[$booking['id']] : 0;
        }
        unset($booking);

        return $bookings;
    }

    private function ensure_users_profile_columns()
    {
        if (!$this->db->table_exists('users')) {
            return;
        }

        if (!$this->db->field_exists('profile_image', 'users')) {
            $this->db->query("ALTER TABLE `users` ADD COLUMN `profile_image` VARCHAR(255) DEFAULT NULL AFTER `phone`");
        }
    }

    private function ensure_users_booking_columns()
    {
        if (!$this->db->table_exists('users')) {
            return;
        }

        if (!$this->db->field_exists('aadhaar_number', 'users')) {
            $this->db->query("ALTER TABLE `users` ADD COLUMN `aadhaar_number` VARCHAR(80) DEFAULT NULL AFTER `profile_image`");
        }

        if (!$this->db->field_exists('driving_license_number', 'users')) {
            $this->db->query("ALTER TABLE `users` ADD COLUMN `driving_license_number` VARCHAR(80) DEFAULT NULL AFTER `aadhaar_number`");
        }

        if (!$this->db->field_exists('documents_verified', 'users')) {
            $this->db->query("ALTER TABLE `users` ADD COLUMN `documents_verified` TINYINT(1) NOT NULL DEFAULT 0 AFTER `driving_license_number`");
        }

        if (!$this->db->field_exists('address', 'users')) {
            $this->db->query("ALTER TABLE `users` ADD COLUMN `address` TEXT DEFAULT NULL AFTER `documents_verified`");
        }
    }

    private function ensure_vehicle_pricing_columns()
    {
        if (!$this->db->table_exists('vehicles')) {
            return;
        }

        if (!$this->db->field_exists('rate_per_day', 'vehicles')) {
            $this->db->query("ALTER TABLE `vehicles` ADD COLUMN `rate_per_day` DECIMAL(10,2) NOT NULL DEFAULT 0 AFTER `seats`");
        }

        if (!$this->db->field_exists('price_6_hours', 'vehicles')) {
            $this->db->query("ALTER TABLE `vehicles` ADD COLUMN `price_6_hours` DECIMAL(10,2) NOT NULL DEFAULT 0 AFTER `rate_per_day`");
        }

        if (!$this->db->field_exists('price_12_hours', 'vehicles')) {
            $this->db->query("ALTER TABLE `vehicles` ADD COLUMN `price_12_hours` DECIMAL(10,2) NOT NULL DEFAULT 0 AFTER `price_6_hours`");
        }

        if (!$this->db->field_exists('price_24_hours', 'vehicles')) {
            $this->db->query("ALTER TABLE `vehicles` ADD COLUMN `price_24_hours` DECIMAL(10,2) NOT NULL DEFAULT 0 AFTER `price_12_hours`");
        }

        if (!$this->db->field_exists('extra_hour_charge', 'vehicles')) {
            $this->db->query("ALTER TABLE `vehicles` ADD COLUMN `extra_hour_charge` DECIMAL(10,2) NOT NULL DEFAULT 0 AFTER `price_24_hours`");
        }
    }

    private function ensure_booking_pricing_columns()
    {
        if (!$this->db->table_exists('bookings')) {
            return;
        }

        if (!$this->db->field_exists('estimated_km', 'bookings')) {
            $this->db->query("ALTER TABLE `bookings` ADD COLUMN `estimated_km` INT NOT NULL DEFAULT 0 AFTER `drop_location`");
        }

        if (!$this->db->field_exists('booking_type', 'bookings')) {
            $this->db->query("ALTER TABLE `bookings` ADD COLUMN `booking_type` VARCHAR(20) NOT NULL DEFAULT 'km' AFTER `estimated_km`");
        }

        if (!$this->db->field_exists('pickup_time', 'bookings')) {
            $this->db->query("ALTER TABLE `bookings` ADD COLUMN `pickup_time` TIME NULL DEFAULT NULL AFTER `return_date`");
        }

        if (!$this->db->field_exists('return_time', 'bookings')) {
            $this->db->query("ALTER TABLE `bookings` ADD COLUMN `return_time` TIME NULL DEFAULT NULL AFTER `pickup_time`");
        }

        if (!$this->db->field_exists('hours_slot', 'bookings')) {
            $this->db->query("ALTER TABLE `bookings` ADD COLUMN `hours_slot` INT NOT NULL DEFAULT 0 AFTER `booking_type`");
        }

        if (!$this->db->field_exists('requires_advance', 'bookings')) {
            $this->db->query("ALTER TABLE `bookings` ADD COLUMN `requires_advance` TINYINT(1) NOT NULL DEFAULT 1 AFTER `hours_slot`");
        }
    }

    private function ensure_booking_status_values()
    {
        if (!$this->db->table_exists('bookings') || !$this->db->field_exists('status', 'bookings')) {
            return;
        }

        $status_field = $this->db->query("SHOW COLUMNS FROM `bookings` LIKE 'status'")->row_array();
        $status_type = !empty($status_field['Type']) ? strtolower((string) $status_field['Type']) : '';

        if (strpos($status_type, "enum('draft'") === false) {
            $this->db->query("ALTER TABLE `bookings` MODIFY `status` ENUM('draft','pending','confirmed','completed','cancelled') NULL DEFAULT 'pending'");
        }

        $this->db->query("UPDATE `bookings` SET `status` = 'draft' WHERE `status` IS NULL OR `status` = ''");
    }

    private function cleanup_orphan_temporary_customers()
    {
        if (!$this->db->table_exists('users') || !$this->db->table_exists('bookings')) {
            return;
        }

        $rows = $this->db->query("
            SELECT users.id
            FROM users
            LEFT JOIN bookings ON bookings.customer_id = users.id
            WHERE users.role = 0
              AND users.email LIKE 'walkin.%@local.customer'
            GROUP BY users.id
            HAVING COUNT(bookings.id) = 0
        ")->result_array();

        foreach ($rows as $row) {
            $this->purge_temporary_customer_if_unused((int) $row['id']);
        }
    }

    private function purge_temporary_customer_if_unused($customer_id)
    {
        $customer_id = (int) $customer_id;
        if ($customer_id <= 0) {
            return false;
        }

        $customer = $this->get_row('users', array(
            'id' => $customer_id,
            'role' => 0,
        ));
        if (empty($customer)) {
            return false;
        }

        $remaining_bookings = $this->count_rows('bookings', array('customer_id' => $customer_id));
        if ($remaining_bookings > 0) {
            return false;
        }

        $email = isset($customer['email']) ? (string) $customer['email'] : '';
        if (!preg_match('/^walkin\..+@local\.customer$/', $email)) {
            return false;
        }

        $documents = $this->get_all('documents', array('customer_id' => $customer_id));
        foreach ($documents as $document) {
            if (!empty($document['file_path'])) {
                $absolute_path = FCPATH . ltrim(str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $document['file_path']), DIRECTORY_SEPARATOR);
                if (is_file($absolute_path)) {
                    @unlink($absolute_path);
                }
            }
        }

        if ($this->db->table_exists('payment_requests')) {
            $requests = $this->db
                ->where('customer_id', $customer_id)
                ->get('payment_requests')
                ->result_array();

            foreach ($requests as $request) {
                if (!empty($request['receipt_path'])) {
                    $absolute_path = FCPATH . ltrim(str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $request['receipt_path']), DIRECTORY_SEPARATOR);
                    if (is_file($absolute_path)) {
                        @unlink($absolute_path);
                    }
                }
            }

            $this->delete('payment_requests', array('customer_id' => $customer_id));
        }

        return $this->delete('users', array('id' => $customer_id, 'role' => 0));
    }

    private function build_customer_email($email = '', $phone = '', $exclude_user_id = 0)
    {
        $email = trim($email);
        if ($email !== '') {
            $this->db->where('email', $email);
            if ($exclude_user_id > 0) {
                $this->db->where('id !=', (int) $exclude_user_id);
            }
            $existing_email = $this->db->get('users')->row_array();
            if (empty($existing_email)) {
                return $email;
            }
        }

        $phone_digits = preg_replace('/\D+/', '', $phone);
        if ($phone_digits === '') {
            $phone_digits = (string) time();
        }

        do {
            $generated_email = 'walkin.' . $phone_digits . '.' . mt_rand(1000, 9999) . '@local.customer';
            $existing_generated = $this->get_row('users', array('email' => $generated_email));
        } while (!empty($existing_generated));

        return $generated_email;
    }

    private function get_payment_totals_map($booking_ids)
    {
        if (empty($booking_ids) || !$this->db->table_exists('payments')) {
            return array();
        }

        $rows = $this->db
            ->select('booking_id, SUM(amount) AS total_paid', false)
            ->from('payments')
            ->where_in('booking_id', $booking_ids)
            ->group_by('booking_id')
            ->get()
            ->result_array();

        $map = array();
        foreach ($rows as $row) {
            $map[(int) $row['booking_id']] = (float) $row['total_paid'];
        }

        return $map;
    }

    private function apply_live_vehicle_status($vehicles, $reference_date = '')
    {
        if (empty($vehicles)) {
            return array();
        }

        $booking_map = $this->get_live_vehicle_booking_map($reference_date);

        foreach ($vehicles as &$vehicle) {
            $vehicle_id = isset($vehicle['id']) ? (int) $vehicle['id'] : 0;
            $base_status = isset($vehicle['status']) ? strtolower((string) $vehicle['status']) : 'available';

            if ($base_status === 'service') {
                $vehicle['active_booking'] = array();
                $vehicle['status'] = 'service';
                continue;
            }

            if ($vehicle_id > 0 && isset($booking_map[$vehicle_id])) {
                $vehicle['status'] = 'booked';
                $vehicle['active_booking'] = $booking_map[$vehicle_id];
                continue;
            }

            $vehicle['status'] = 'available';
            $vehicle['active_booking'] = array();
        }
        unset($vehicle);

        return $vehicles;
    }

    private function get_live_vehicle_booking_map($reference_date = '')
    {
        $reference_date = $reference_date !== '' ? $reference_date : date('Y-m-d');
        $bookings = $this->get_bookings();
        $map = array();

        foreach ($bookings as $booking) {
            $vehicle_id = isset($booking['vehicle_id']) ? (int) $booking['vehicle_id'] : 0;
            if ($vehicle_id <= 0 || isset($map[$vehicle_id])) {
                continue;
            }

            $status = !empty($booking['effective_status']) ? $booking['effective_status'] : $booking['status'];
            if (!in_array($status, array('pending', 'confirmed'), true)) {
                continue;
            }

            if (!app_booking_is_active_on_date(
                isset($booking['pickup_date']) ? $booking['pickup_date'] : '',
                isset($booking['return_date']) ? $booking['return_date'] : '',
                $reference_date
            )) {
                continue;
            }

            $map[$vehicle_id] = $booking;
        }

        return $map;
    }

    private function get_payment_request_map($booking_ids)
    {
        if (empty($booking_ids) || !$this->db->table_exists('payment_requests')) {
            return array();
        }

        $rows = $this->db
            ->from('payment_requests')
            ->where_in('booking_id', $booking_ids)
            ->order_by('id', 'DESC')
            ->get()
            ->result_array();

        $map = array();
        foreach ($rows as $row) {
            $booking_id = (int) $row['booking_id'];
            if (!isset($map[$booking_id])) {
                $map[$booking_id] = $row;
            }
        }

        return $map;
    }

    private function get_booking_photo_counts_map($booking_ids)
    {
        if (empty($booking_ids) || !$this->db->table_exists('booking_vehicle_photos')) {
            return array();
        }

        $rows = $this->db
            ->select('booking_id, COUNT(*) AS total_photos', false)
            ->from('booking_vehicle_photos')
            ->where_in('booking_id', $booking_ids)
            ->group_by('booking_id')
            ->get()
            ->result_array();

        $map = array();
        foreach ($rows as $row) {
            $map[(int) $row['booking_id']] = (int) $row['total_photos'];
        }

        return $map;
    }

    private function format_trip_range($pickup_date, $return_date)
    {
        $pickup_stamp = !empty($pickup_date) ? strtotime($pickup_date) : false;
        $return_stamp = !empty($return_date) ? strtotime($return_date) : false;

        if ($pickup_stamp === false && $return_stamp === false) {
            return 'Dates pending';
        }

        if ($pickup_stamp !== false && $return_stamp !== false) {
            return date('d M Y', $pickup_stamp) . ' - ' . date('d M Y', $return_stamp);
        }

        return $pickup_stamp !== false ? date('d M Y', $pickup_stamp) : date('d M Y', $return_stamp);
    }

    private function resolve_payment_status($paid_amount, $advance_amount, $amount)
    {
        if ($amount > 0 && $paid_amount >= $amount) {
            return 'Paid';
        }

        if ($advance_amount > 0 && $paid_amount >= $advance_amount) {
            return 'Advance Received';
        }

        if ($paid_amount > 0) {
            return 'Part Paid';
        }

        return 'Pending';
    }
}
