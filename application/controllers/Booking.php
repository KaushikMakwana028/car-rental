<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends MY_Controller
{
    public function index()
    {
        redirect('dashboard');
    }

    public function create()
    {
        $data['page_title'] = 'Book a Car';
        $data['page_subtitle'] = 'Enter your name and mobile number, choose your trip details, and continue to document upload.';
        $data['current_user'] = $this->current_user;
        $data['is_customer_logged_in'] = $this->is_logged_in() && $this->current_role() === 0;
        $data['current_step'] = 1;
        $data['vehicles'] = $this->General_model->get_available_vehicles();
        $requested_vehicle_id = (int) $this->input->get('vehicle_id');
        $requested_booking_id = (int) $this->input->get('booking_id');
        $requested_customer_id = (int) $this->input->get('customer_id');
        $data['selected_vehicle_id'] = 0;
        $data['booking_edit'] = array();

        if ($requested_vehicle_id > 0) {
            foreach ($data['vehicles'] as $vehicle) {
                if ((int) $vehicle['id'] === $requested_vehicle_id) {
                    $data['selected_vehicle_id'] = $requested_vehicle_id;
                    break;
                }
            }
        }

        if ($requested_booking_id > 0 && $requested_customer_id > 0 && $this->customer_can_access_booking($requested_booking_id, $requested_customer_id)) {
            $booking = $this->General_model->get_booking_for_flow($requested_booking_id, $requested_customer_id);
            if (!empty($booking)) {
                $data['booking_edit'] = $booking;
                $data['selected_vehicle_id'] = (int) $booking['vehicle_id'];
                $this->set_public_booking_session($requested_customer_id, $requested_booking_id);
            }
        }

        $this->render_customer_view('bookings_create', $data);
    }

    public function store()
    {
        $booking_id = (int) $this->input->post('booking_id');
        $customer_id = (int) $this->input->post('customer_id');
        $vehicle_id = (int) $this->input->post('vehicle_id');
        $estimated_km = (int) $this->input->post('estimated_km');
        $customer_name = trim($this->input->post('customer_name', true));
        $customer_phone = trim($this->input->post('customer_phone', true));
        $vehicle = $this->General_model->get_row('vehicles', array('id' => $vehicle_id));

        if ($customer_name === '' || $customer_phone === '') {
            $this->session->set_flashdata('error', 'Customer name and mobile number are required.');
            redirect('bookings/create');
        }

        if (empty($vehicle)) {
            $this->session->set_flashdata('error', 'Please select an available car.');
            redirect('bookings/create');
        }

        $calculated_amount = (float) $vehicle['rate_per_day'] * $estimated_km;
        $is_booking_edit = $booking_id > 0 && $customer_id > 0 && $this->customer_can_access_booking($booking_id, $customer_id);

        if ($is_booking_edit) {
            $this->General_model->update_user_profile($customer_id, array(
                'full_name' => $customer_name,
                'phone' => $customer_phone,
            ));
        } else {
            $customer_id = (int) $this->General_model->resolve_customer_account($customer_name, $customer_phone);
        }

        $payload = array(
            'customer_id' => $customer_id,
            'vehicle_id' => $vehicle_id,
            'pickup_date' => $this->input->post('pickup_date', true),
            'return_date' => $this->input->post('return_date', true),
            'pickup_location' => trim($this->input->post('pickup_location', true)),
            'drop_location' => trim($this->input->post('drop_location', true)),
            'estimated_km' => $estimated_km,
            'amount' => $calculated_amount,
            'status' => 'draft',
            '_skip_vehicle_booking' => true,
        );

        if ($is_booking_edit) {
            unset($payload['_skip_vehicle_booking']);
            $payload['updated_at'] = date('Y-m-d H:i:s');
            $this->General_model->update('bookings', array('id' => $booking_id, 'customer_id' => $customer_id), $payload);
            $this->session->set_flashdata('success', 'Step 1 updated successfully. Continue with document upload.');
        } else {
            $booking_id = (int) $this->General_model->create_booking($payload);
            $this->session->set_flashdata('success', 'Step 1 completed successfully. Your booking details were saved. Continue with document upload.');
        }

        $this->set_public_booking_session($customer_id, $booking_id);
        redirect('documents?booking_id=' . $booking_id . '&customer_id=' . $customer_id);
    }

    public function cancel($booking_id = 0)
    {
        $booking_id = (int) $booking_id;
        $customer_id = (int) $this->input->get('customer_id');
        if ($customer_id <= 0) {
            $customer_id = $this->get_active_customer_id();
        }

        if ($booking_id <= 0 || $customer_id <= 0 || !$this->customer_can_access_booking($booking_id, $customer_id)) {
            $this->session->set_flashdata('error', 'Booking was not found or it is already closed.');
            redirect('dashboard');
        }

        $booking = $this->General_model->get_booking_for_flow($booking_id, $customer_id);
        if (empty($booking)) {
            $this->clear_public_booking_session();
            $this->session->set_flashdata('error', 'Booking was not found or it is already closed.');
            redirect('dashboard');
        }

        if ($booking['status'] !== 'draft') {
            $this->session->set_flashdata('error', 'Only incomplete bookings can be cancelled from this flow.');
            redirect('dashboard');
        }

        $this->General_model->purge_draft_booking($booking_id, $customer_id);
        $this->clear_public_booking_session();
        $this->session->set_flashdata('success', 'Incomplete booking cancelled successfully.');
        redirect('dashboard');
    }
}
