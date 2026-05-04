<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General_model extends CI_Model
{
    private $document_types = array(
        'Driving License',
        'Aadhaar Card',
        'Passport / Voter ID',
        'Passport Photo',
        'Payment Receipt',
        'Rental Agreement',
    );

    public function __construct()
    {
        parent::__construct();
        $this->ensure_users_profile_columns();
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
        $counts = array(
            'total_customers' => (int) $this->db->where('role', 0)->count_all_results('users'),
            'total_vehicles' => (int) $this->db->count_all('vehicles'),
            'available_vehicles' => (int) $this->db->where('status', 'available')->count_all_results('vehicles'),
            'total_bookings' => (int) $this->db->count_all('bookings'),
            'pending_bookings' => (int) $this->db->where('status', 'pending')->count_all_results('bookings'),
        );

        if ($role === 'customer' && $user_id > 0) {
            $counts['my_bookings'] = (int) $this->db->where('customer_id', $user_id)->count_all_results('bookings');
            $counts['my_pending_bookings'] = (int) $this->db
                ->where(array('customer_id' => $user_id, 'status' => 'pending'))
                ->count_all_results('bookings');
        }

        return $counts;
    }

    public function get_bookings($filters = array())
    {
        $this->db->select('bookings.*, users.full_name AS customer_name, users.phone AS customer_phone, vehicles.name AS vehicle_name, vehicles.registration_no, vehicles.advance_amount');
        $this->db->from('bookings');
        $this->db->join('users', 'users.id = bookings.customer_id', 'left');
        $this->db->join('vehicles', 'vehicles.id = bookings.vehicle_id', 'left');

        if (!empty($filters)) {
            $this->db->where($filters);
        }

        $this->db->order_by('bookings.id', 'DESC');
        $bookings = $this->db->get()->result_array();

        return $this->enrich_bookings($bookings);
    }

    public function get_available_vehicles()
    {
        return $this->get_all('vehicles', array('status' => 'available'), 'id DESC');
    }

    public function create_booking($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $booking_id = $this->insert('bookings', $data);

        if (!empty($data['vehicle_id'])) {
            $this->update('vehicles', array('id' => $data['vehicle_id']), array('status' => 'booked'));
        }

        return $booking_id;
    }

    public function format_booking_code($booking_id, $created_at = '')
    {
        $booking_id = (int) $booking_id;
        $stamp = !empty($created_at) ? strtotime($created_at) : false;

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
            $customer['doc_status'] = ((int) $customer['total_bookings'] > 3) ? 'complete' : (((int) $customer['total_bookings'] > 0) ? 'pending' : 'missing');
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

    public function get_document_types()
    {
        return $this->document_types;
    }

    public function get_customer_documents_matrix($customer_id)
    {
        $rows = $this->db
            ->where('customer_id', $customer_id)
            ->get('documents')
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

        foreach ($bookings as &$booking) {
            $paid_amount = isset($payment_totals[$booking['id']]) ? (float) $payment_totals[$booking['id']] : 0;
            $amount = (float) $booking['amount'];
            $advance_amount = isset($booking['advance_amount']) ? (float) $booking['advance_amount'] : 0;
            $balance_amount = max(0, $amount - $paid_amount);

            $booking['booking_code'] = $this->format_booking_code($booking['id'], isset($booking['created_at']) ? $booking['created_at'] : '');
            $booking['trip_label'] = $this->format_trip_range($booking['pickup_date'], $booking['return_date']);
            $booking['trip_route'] = trim($booking['pickup_location'] . ' - ' . $booking['drop_location'], ' -');
            $booking['display_km'] = !empty($booking['estimated_km']) ? (int) $booking['estimated_km'] . ' km' : 'N/A';
            $booking['paid_amount'] = $paid_amount;
            $booking['advance_due'] = $advance_amount;
            $booking['balance_amount'] = $balance_amount;
            $booking['payment_status'] = $this->resolve_payment_status($paid_amount, $advance_amount, $amount);
            $booking['payment_badge'] = strtolower(str_replace(' ', '-', $booking['payment_status']));
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
