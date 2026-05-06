<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
        $estimated_km = (int) $this->input->post('estimated_km');
        $customer_name = trim($this->input->post('customer_name', true));
        $customer_phone = trim($this->input->post('customer_phone', true));
        $customer_email = trim($this->input->post('customer_email', true));
        $aadhaar_number = trim($this->input->post('aadhaar_number', true));
        $driving_license_number = trim($this->input->post('driving_license_number', true));
        $documents_verified = $this->input->post('documents_verified') ? true : false;
        $vehicle = $this->General_model->get_row('vehicles', array('id' => $vehicle_id));
        $calculated_amount = !empty($vehicle) ? ((float) $vehicle['rate_per_day'] * $estimated_km) : 0;

        if ($customer_name === '' || $customer_phone === '') {
            $this->session->set_flashdata('error', 'Customer name and phone are required.');
            redirect('admin/bookings/create');
        }

        if ($documents_verified && ($aadhaar_number === '' || $driving_license_number === '')) {
            $this->session->set_flashdata('error', 'Enter Aadhaar number and driving license number when documents are marked as checked.');
            redirect('admin/bookings/create');
        }

        $customer_id = $this->General_model->resolve_customer_account($customer_name, $customer_phone, $customer_email);

        $payload = array(
            'customer_id' => $customer_id,
            'vehicle_id' => $vehicle_id,
            'pickup_date' => $this->input->post('pickup_date', true),
            'return_date' => $this->input->post('return_date', true),
            'pickup_location' => trim($this->input->post('pickup_location', true)),
            'drop_location' => trim($this->input->post('drop_location', true)),
            'estimated_km' => $estimated_km,
            'amount' => $calculated_amount,
            'status' => $this->input->post('status', true) ?: 'pending',
        );

        $booking_id = (int) $this->General_model->create_booking($payload);
        $this->General_model->sync_manual_booking_documents($customer_id, $booking_id, $aadhaar_number, $driving_license_number, $documents_verified);
        $this->session->set_flashdata('success', 'Booking created successfully.');
        redirect('admin/bookings');
    }
}
