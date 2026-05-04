<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends Admin_Controller
{
    public function index()
    {
        $data['page_title'] = 'Manage Bookings';
        $data['current_user'] = $this->current_user;
        $data['bookings'] = $this->General_model->get_bookings();
        $this->load->view('admin/bookings_list', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Create Booking';
        $data['current_user'] = $this->current_user;
        $data['customers'] = $this->General_model->get_all('users', array('role' => 0, 'status' => 1), 'full_name ASC');
        $data['vehicles'] = $this->General_model->get_available_vehicles();
        $this->load->view('admin/bookings_create', $data);
    }

    public function store()
    {
        $vehicle_id = (int) $this->input->post('vehicle_id');
        $estimated_km = (int) $this->input->post('estimated_km');
        $vehicle = $this->General_model->get_row('vehicles', array('id' => $vehicle_id));
        $calculated_amount = !empty($vehicle) ? ((float) $vehicle['rate_per_day'] * $estimated_km) : 0;

        $payload = array(
            'customer_id' => (int) $this->input->post('customer_id'),
            'vehicle_id' => $vehicle_id,
            'pickup_date' => $this->input->post('pickup_date', true),
            'return_date' => $this->input->post('return_date', true),
            'pickup_location' => trim($this->input->post('pickup_location', true)),
            'drop_location' => trim($this->input->post('drop_location', true)),
            'estimated_km' => $estimated_km,
            'amount' => $calculated_amount,
            'status' => $this->input->post('status', true) ?: 'pending',
        );

        $this->General_model->create_booking($payload);
        $this->session->set_flashdata('success', 'Booking created successfully.');
        redirect('admin/bookings');
    }
}
