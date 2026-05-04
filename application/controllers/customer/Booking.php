<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends Customer_Controller
{
    public function index()
    {
        $data['page_title'] = 'My Bookings';
        $data['current_user'] = $this->current_user;
        $data['bookings'] = $this->General_model->get_bookings(array('bookings.customer_id' => $this->current_user['id']));
        $this->load->view('customer/bookings_list', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Create Booking';
        $data['current_user'] = $this->current_user;
        $data['vehicles'] = $this->General_model->get_available_vehicles();
        $requested_vehicle_id = (int) $this->input->get('vehicle_id');
        $data['selected_vehicle_id'] = 0;

        if ($requested_vehicle_id > 0) {
            foreach ($data['vehicles'] as $vehicle) {
                if ((int) $vehicle['id'] === $requested_vehicle_id) {
                    $data['selected_vehicle_id'] = $requested_vehicle_id;
                    break;
                }
            }
        }

        $this->load->view('customer/bookings_create', $data);
    }

    public function store()
    {
        $vehicle_id = (int) $this->input->post('vehicle_id');
        $estimated_km = (int) $this->input->post('estimated_km');
        $vehicle = $this->General_model->get_row('vehicles', array('id' => $vehicle_id));
        $calculated_amount = !empty($vehicle) ? ((float) $vehicle['rate_per_day'] * $estimated_km) : 0;

        $payload = array(
            'customer_id' => (int) $this->current_user['id'],
            'vehicle_id' => $vehicle_id,
            'pickup_date' => $this->input->post('pickup_date', true),
            'return_date' => $this->input->post('return_date', true),
            'pickup_location' => trim($this->input->post('pickup_location', true)),
            'drop_location' => trim($this->input->post('drop_location', true)),
            'estimated_km' => $estimated_km,
            'amount' => $calculated_amount,
            'status' => 'pending',
        );

        $this->General_model->create_booking($payload);
        $this->session->set_flashdata('success', 'Booking request submitted.');
        redirect('customer/bookings');
    }
}
