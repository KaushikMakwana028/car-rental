<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Booking extends Admin_Controller
{
    public function index()
    {
        $data['page_title'] = 'Manage Bookings';
        $data['current_user'] = $this->current_user;
        $data['bookings'] = $this->General_model->get_bookings();
        $this->render_view('admin/bookings_list', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Create Booking';
        $data['current_user'] = $this->current_user;
        $data['vehicles'] = $this->General_model->get_available_vehicles();
        $this->render_view('admin/bookings_create', $data);
    }


    public function store()
    {
        $vehicle_id = (int) $this->input->post('vehicle_id');
        $booking_type = $this->input->post('booking_type', true) === 'km' ? 'km' : 'hours';
        $estimated_km = (int) $this->input->post('estimated_km');
        $hours_slot = (int) $this->input->post('hours_slot');
        $requires_advance = $this->input->post('requires_advance') ? 1 : 0;
        $customer_name = trim($this->input->post('customer_name', true));
        $customer_phone = trim($this->input->post('customer_phone', true));
        $customer_email = trim($this->input->post('customer_email', true));
        $aadhaar_number = trim($this->input->post('aadhaar_number', true));
        $driving_license_number = trim($this->input->post('driving_license_number', true));
        $documents_verified = $this->input->post('documents_verified') ? true : false;
        $pickup_time = $this->General_model->normalize_time_value($this->input->post('pickup_time', true));
        $return_time = $this->General_model->normalize_time_value($this->input->post('return_time', true));
        $vehicle = $this->General_model->get_row('vehicles', array('id' => $vehicle_id));

        if ($customer_name === '' || $customer_phone === '') {
            $this->session->set_flashdata('error', 'Customer name and phone are required.');
            redirect('admin/bookings/create');
        }

        if ($documents_verified && ($aadhaar_number === '' || $driving_license_number === '')) {
            $this->session->set_flashdata('error', 'Enter Aadhaar and driving license number when documents are marked as checked.');
            redirect('admin/bookings/create');
        }

        if (empty($vehicle)) {
            $this->session->set_flashdata('error', 'Please select a valid vehicle.');
            redirect('admin/bookings/create');
        }

        if ($booking_type === 'km' && $estimated_km <= 0) {
            $this->session->set_flashdata('error', 'Please enter estimated kilometers for KM booking.');
            redirect('admin/bookings/create');
        }

        if ($booking_type === 'hours' && !in_array($hours_slot, array(6, 12, 24), true)) {
            $this->session->set_flashdata('error', 'Please select a valid hour package.');
            redirect('admin/bookings/create');
        }

        $pickup_date = $this->input->post('pickup_date', true);
        $return_date = $this->input->post('return_date', true);
        $calculated_amount = $this->General_model->calculate_booking_amount($vehicle, $booking_type, $estimated_km, $hours_slot, $pickup_date, $return_date, $pickup_time, $return_time);

        // Get custom amount from form (user can override the calculated amount)
        $custom_amount = (float) $this->input->post('amount');
        $final_amount = $custom_amount > 0 ? $custom_amount : $calculated_amount;

        // Get individual expenses
        $fuel_expense = (float) $this->input->post('fuel_expense') ?: 0.00;
        $toll_expense = (float) $this->input->post('toll_expense') ?: 0.00;
        $driver_expense = (float) $this->input->post('driver_expense') ?: 0.00;
        $parking_expense = (float) $this->input->post('parking_expense') ?: 0.00;

        // Calculate total expenses
        $total_expenses = $fuel_expense + $toll_expense + $driver_expense + $parking_expense;

        // Calculate net amount (amount - expenses)
        $net_amount = max(0, $final_amount - $total_expenses);

        $customer_id = $this->General_model->resolve_customer_account($customer_name, $customer_phone, $customer_email);

        $payload = array(
            'customer_id' => $customer_id,
            'vehicle_id' => $vehicle_id,
            'pickup_date' => $pickup_date,
            'return_date' => $return_date,
            'pickup_time' => $pickup_time !== '' ? $pickup_time : null,
            'return_time' => $return_time !== '' ? $return_time : null,
            'pickup_location' => trim($this->input->post('pickup_location', true)),
            'drop_location' => trim($this->input->post('drop_location', true)),
            'estimated_km' => $booking_type === 'km' ? $estimated_km : 0,
            'booking_type' => $booking_type,
            'hours_slot' => $booking_type === 'hours' ? $hours_slot : 0,
            'requires_advance' => $requires_advance,
            'amount' => $final_amount,
            'fuel_expense' => $fuel_expense,
            'toll_expense' => $toll_expense,
            'driver_expense' => $driver_expense,
            'parking_expense' => $parking_expense,
            'total_expenses' => $total_expenses,
            'net_amount' => $net_amount,
            'other_expenses' => (float) $this->input->post('other_expenses') ?: 0.00,
            'status' => $this->input->post('status', true) ?: 'pending',
        );
        $booking_id = (int) $this->General_model->create_booking($payload);
        $this->General_model->sync_manual_booking_documents($customer_id, $booking_id, $aadhaar_number, $driving_license_number, $documents_verified);
        $this->session->set_flashdata('success', 'Booking created successfully.');
        redirect('admin/bookings');
    }

    public function photos($booking_id)
    {
        $booking = $this->General_model->get_bookings(array('bookings.id' => (int) $booking_id));
        if (empty($booking)) {
            show_404();
        }

        $data['page_title'] = 'Booking Photos';
        $data['current_user'] = $this->current_user;
        $data['booking'] = $booking[0];
        $data['booking_photos'] = $this->General_model->get_booking_photos((int) $booking_id);
        $data['booking_photo_table_ready'] = $this->db->table_exists('booking_vehicle_photos');
        $this->render_view('admin/booking_photos', $data);
    }

    public function upload_photos($booking_id)
    {
        $booking_id = (int) $booking_id;
        $booking = $this->General_model->get_bookings(array('bookings.id' => $booking_id));
        if (empty($booking)) {
            show_404();
        }

        if (!$this->db->table_exists('booking_vehicle_photos')) {
            $this->session->set_flashdata('error', 'Booking photo table is missing. Please run the provided database query first.');
            redirect('admin/bookings/photos/' . $booking_id);
        }

        if (empty($_FILES['booking_photos']['name']) || empty($_FILES['booking_photos']['name'][0])) {
            $this->session->set_flashdata('error', 'Please choose at least one car photo to upload.');
            redirect('admin/bookings/photos/' . $booking_id);
        }

        $upload_dir = FCPATH . 'uploads/booking-photos/' . $booking_id . '/';
        if (!is_dir($upload_dir)) {
            @mkdir($upload_dir, 0777, true);
        }

        $allowed_extensions = array('jpg', 'jpeg', 'png', 'webp');
        $note = trim($this->input->post('note', true));
        $uploaded_count = 0;

        foreach ($_FILES['booking_photos']['name'] as $index => $original_name) {
            if (!isset($_FILES['booking_photos']['error'][$index]) || $_FILES['booking_photos']['error'][$index] !== UPLOAD_ERR_OK) {
                continue;
            }

            $extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
            if (!in_array($extension, $allowed_extensions, true)) {
                continue;
            }

            $file_name = 'booking_' . $booking_id . '_' . time() . '_' . $index . '.' . $extension;
            $target_path = $upload_dir . $file_name;

            if (!move_uploaded_file($_FILES['booking_photos']['tmp_name'][$index], $target_path)) {
                continue;
            }

            $this->General_model->create_booking_photo(array(
                'booking_id' => $booking_id,
                'file_name' => $original_name,
                'file_path' => 'uploads/booking-photos/' . $booking_id . '/' . $file_name,
                'note' => $note,
                'uploaded_by' => isset($this->current_user['id']) ? (int) $this->current_user['id'] : 0,
            ));
            $uploaded_count++;
        }

        if ($uploaded_count <= 0) {
            $this->session->set_flashdata('error', 'No valid image was uploaded. Please use JPG, JPEG, PNG, or WEBP files.');
            redirect('admin/bookings/photos/' . $booking_id);
        }

        $this->session->set_flashdata('success', $uploaded_count . ' car photo(s) uploaded successfully.');
        redirect('admin/bookings/photos/' . $booking_id);
    }

    public function delete($booking_id)
    {
        $booking_id = (int) $booking_id;
        $booking = $this->General_model->get_bookings(array('bookings.id' => $booking_id));

        if (empty($booking)) {
            show_404();
        }

        // Delete related payments first
        $this->General_model->delete('payments', array('booking_id' => $booking_id));

        // Delete booking photos records
        $this->General_model->delete('booking_vehicle_photos', array('booking_id' => $booking_id));

        // Delete the booking itself
        $this->General_model->delete('bookings', array('id' => $booking_id));

        $this->session->set_flashdata('success', 'Booking deleted successfully.');
        redirect('admin/bookings');
    }


    public function edit($booking_id)
    {
        $booking_id = (int) $booking_id;
        $bookings = $this->General_model->get_bookings(array('bookings.id' => $booking_id));

        if (empty($bookings)) {
            show_404();
        }

        $data['page_title'] = 'Edit Booking';
        $data['current_user'] = $this->current_user;
        $data['booking'] = $bookings[0];
        $data['vehicles'] = $this->General_model->get_vehicles_for_edit();

        $this->render_view('admin/bookings_edit', $data);
    }
    public function update($booking_id)
    {
        $booking_id = (int) $booking_id;
        $bookings = $this->General_model->get_bookings(array('bookings.id' => $booking_id));

        if (empty($bookings)) {
            // echo "h";
            // die;
            show_404();
        }

        $vehicle_id = (int) $this->input->post('vehicle_id');
        $booking_type = $this->input->post('booking_type', true) === 'km' ? 'km' : 'hours';
        $estimated_km = (int) $this->input->post('estimated_km');
        $hours_slot = (int) $this->input->post('hours_slot');
        $requires_advance = $this->input->post('requires_advance') ? 1 : 0;
        $customer_name = trim($this->input->post('customer_name', true));
        $customer_phone = trim($this->input->post('customer_phone', true));
        $customer_email = trim($this->input->post('customer_email', true));
        $aadhaar_number = trim($this->input->post('aadhaar_number', true));
        $driving_license_number = trim($this->input->post('driving_license_number', true));
        $documents_verified = $this->input->post('documents_verified') ? true : false;
        $pickup_time = $this->General_model->normalize_time_value($this->input->post('pickup_time', true));
        $return_time = $this->General_model->normalize_time_value($this->input->post('return_time', true));
        $vehicle = $this->General_model->get_row('vehicles', array('id' => $vehicle_id));

        if ($customer_name === '' || $customer_phone === '') {
            $this->session->set_flashdata('error', 'Customer name and phone are required.');
            redirect('admin/booking/edit/' . $booking_id);
        }

        if ($documents_verified && ($aadhaar_number === '' || $driving_license_number === '')) {
            $this->session->set_flashdata('error', 'Enter Aadhaar and driving license number when documents are marked as checked.');
            redirect('admin/booking/edit/' . $booking_id);
        }

        if (empty($vehicle)) {
            $this->session->set_flashdata('error', 'Please select a valid vehicle.');
            redirect('admin/booking/edit/' . $booking_id);
        }
        // echo $booking_type;
        // echo $estimated_km;
        // die;
        if ($booking_type === 'km' && $estimated_km <= 0) {
            $this->session->set_flashdata('error', 'Please enter estimated kilometers for KM booking.');
            redirect('admin/booking/edit/' . $booking_id);
        }

        if ($booking_type === 'hours' && !in_array($hours_slot, array(6, 12, 24), true)) {
            $this->session->set_flashdata('error', 'Please select a valid hour package.');
            redirect('admin/booking/edit/' . $booking_id);
        }

        $pickup_date = $this->input->post('pickup_date', true);
        $return_date = $this->input->post('return_date', true);
        $calculated_amount = $this->General_model->calculate_booking_amount($vehicle, $booking_type, $estimated_km, $hours_slot, $pickup_date, $return_date, $pickup_time, $return_time);

        // Get custom amount from form (user can override the calculated amount)
        $custom_amount = (float) $this->input->post('amount');
        $final_amount = $custom_amount > 0 ? $custom_amount : $calculated_amount;

        // Get individual expenses
        $fuel_expense = (float) $this->input->post('fuel_expense') ?: 0.00;
        $toll_expense = (float) $this->input->post('toll_expense') ?: 0.00;
        $driver_expense = (float) $this->input->post('driver_expense') ?: 0.00;
        $parking_expense = (float) $this->input->post('parking_expense') ?: 0.00;

        // Calculate total expenses
        $total_expenses = $fuel_expense + $toll_expense + $driver_expense + $parking_expense;

        // Calculate net amount (amount - expenses)
        $net_amount = max(0, $final_amount - $total_expenses);

        $customer_id = $this->General_model->resolve_customer_account($customer_name, $customer_phone, $customer_email);

        $payload = array(
            'customer_id' => $customer_id,
            'vehicle_id' => $vehicle_id,
            'pickup_date' => $pickup_date,
            'return_date' => $return_date,
            'pickup_time' => $pickup_time !== '' ? $pickup_time : null,
            'return_time' => $return_time !== '' ? $return_time : null,
            'pickup_location' => trim($this->input->post('pickup_location', true)),
            'drop_location' => trim($this->input->post('drop_location', true)),
            'estimated_km' => $booking_type === 'km' ? $estimated_km : 0,
            'booking_type' => $booking_type,
            'hours_slot' => $booking_type === 'hours' ? $hours_slot : 0,
            'requires_advance' => $requires_advance,
            'amount' => $final_amount,
            'fuel_expense' => $fuel_expense,
            'toll_expense' => $toll_expense,
            'driver_expense' => $driver_expense,
            'parking_expense' => $parking_expense,
            'total_expenses' => $total_expenses,
            'net_amount' => $net_amount,
            'other_expenses' => (float) $this->input->post('other_expenses') ?: 0.00,
            'status' => $this->input->post('status', true) ?: 'pending',
        );
        $this->General_model->update('bookings', array('id' => $booking_id), $payload);
        $this->General_model->sync_manual_booking_documents($customer_id, $booking_id, $aadhaar_number, $driving_license_number, $documents_verified);
        $this->session->set_flashdata('success', 'Booking updated successfully.');
        redirect('admin/booking');
    }

    public function lookup_customer()
    {
        // Accept both GET and POST
        $this->output->enable_profiler(FALSE);
        $this->output->set_content_type('application/json');

        $phone = trim($this->input->get_post('phone', true));

        if ($phone === '') {
            $this->output->set_output(json_encode(['found' => false]));
            return;
        }

        $customer = $this->db
            ->where('phone', $phone)
            ->get('customers')
            ->row_array();

        if (empty($customer)) {
            $this->output->set_output(json_encode(['found' => false]));
            return;
        }

        $aadhaar  = '';
        $license  = '';
        $verified = 0;
        $has_document_images = false;

        if ($this->db->table_exists('customer_documents')) {
            $doc = $this->db
                ->where('customer_id', $customer['id'])
                ->order_by('id', 'DESC')
                ->limit(1)
                ->get('customer_documents')
                ->row_array();

            if (!empty($doc)) {
                $aadhaar  = $doc['aadhaar_number']         ?? ($doc['aadhaar']  ?? '');
                $license  = $doc['driving_license_number'] ?? ($doc['license_number'] ?? ($doc['license'] ?? ''));
                $verified = !empty($doc['is_verified'])    ? 1 : (!empty($doc['verified']) ? 1 : 0);

                $image_fields = [
                    'aadhaar_image',
                    'license_image',
                    'aadhaar_front',
                    'aadhaar_back',
                    'license_front',
                    'license_back',
                    'document_image',
                    'file_path',
                    'image_path'
                ];
                foreach ($image_fields as $field) {
                    if (!empty($doc[$field])) {
                        $has_document_images = true;
                        break;
                    }
                }
            }
        }

        if ($aadhaar === '') $aadhaar = $customer['aadhaar_number'] ?? ($customer['aadhaar'] ?? '');
        if ($license === '') $license = $customer['driving_license_number'] ?? ($customer['license_number'] ?? '');

        $this->output->set_output(json_encode([
            'found'                  => true,
            'customer_name'          => $customer['name']  ?? '',
            'customer_email'         => $customer['email'] ?? '',
            'aadhaar_number'         => $aadhaar,
            'driving_license_number' => $license,
            'documents_verified'     => $verified,
            'has_document_images'    => $has_document_images,
            'customer_id'            => $customer['id'],
        ]));
    }
}
