<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
        $data['vehicles'] = $this->General_model->get_public_vehicles();
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
        $booking_id     = (int) $this->input->post('booking_id');
        $customer_id    = (int) $this->input->post('customer_id');
        $vehicle_id     = (int) $this->input->post('vehicle_id');
        $booking_type   = $this->input->post('booking_type', true) === 'km' ? 'km' : 'hours';
        $estimated_km   = (int) $this->input->post('estimated_km');
        $hours_slot     = (int) $this->input->post('hours_slot');
        $requires_advance = $this->input->post('requires_advance') ? 1 : 0;
        $customer_name  = trim($this->input->post('customer_name', true));
        $customer_phone = $this->General_model->normalize_indian_phone($this->input->post('customer_phone', true));
        $pickup_time    = $this->General_model->normalize_time_value($this->input->post('pickup_time', true));
        $return_time    = $this->General_model->normalize_time_value($this->input->post('return_time', true));

        $vehicle = $this->General_model->get_row('vehicles', array('id' => $vehicle_id));

        if ($customer_name === '' || $customer_phone === '') {
            $this->session->set_flashdata('error', 'Customer name and mobile number are required.');
            redirect('bookings/create');
        }

        if (!$this->General_model->is_valid_indian_phone($customer_phone)) {
            $this->session->set_flashdata('error', 'Enter a valid 10-digit mobile number. You may start with +91.');
            redirect('bookings/create');
        }

        if (empty($vehicle)) {
            $this->session->set_flashdata('error', 'Please select an available car.');
            redirect('bookings/create');
        }

        if ($booking_type === 'km' && $estimated_km <= 0) {
            $this->session->set_flashdata('error', 'Please enter estimated kilometers for KM booking.');
            redirect('bookings/create');
        }

        if ($booking_type === 'hours' && !in_array($hours_slot, array(6, 12, 24), true)) {
            $this->session->set_flashdata('error', 'Please select a valid hour package.');
            redirect('bookings/create');
        }

        $pickup_date = $this->input->post('pickup_date', true);
        $return_date = $this->input->post('return_date', true);
        $is_booking_edit = $booking_id > 0 && $customer_id > 0
            && $this->customer_can_access_booking($booking_id, $customer_id);
        $conflict = $this->General_model->find_vehicle_booking_conflict(
            $vehicle_id,
            $pickup_date,
            $return_date,
            $is_booking_edit ? $booking_id : 0,
            $pickup_time,
            $return_time
        );

        if (!empty($conflict)) {
            $conflict_start = $this->General_model->format_booking_datetime_label(
                $conflict['pickup_date'],
                isset($conflict['pickup_time']) ? $conflict['pickup_time'] : null
            );
            $conflict_end = $this->General_model->format_booking_datetime_label(
                $conflict['return_date'],
                isset($conflict['return_time']) ? $conflict['return_time'] : null,
                true
            );
            $this->session->set_flashdata(
                'error',
                'This car is already booked from ' . $conflict_start .
                ' to ' . $conflict_end . '. Please choose another date/time or another car.'
            );
            redirect('bookings/create');
        }

        $calculated_amount = $this->General_model->calculate_booking_amount($vehicle, $booking_type, $estimated_km, $hours_slot, $pickup_date, $return_date, $pickup_time, $return_time);

        if ($is_booking_edit) {
            $this->General_model->update_user_profile($customer_id, array(
                'full_name' => $customer_name,
                'phone'     => $customer_phone,
            ));
        } else {
            $customer_id = (int) $this->General_model->resolve_customer_account($customer_name, $customer_phone);
        }

        $payload = array(
            'customer_id'      => $customer_id,
            'vehicle_id'       => $vehicle_id,
            'pickup_date'      => $pickup_date,
            'return_date'      => $return_date,
            'pickup_time'      => $pickup_time !== '' ? $pickup_time : null,
            'return_time'      => $return_time !== '' ? $return_time : null,
            'pickup_location'  => trim($this->input->post('pickup_location', true)),
            'drop_location'    => trim($this->input->post('drop_location', true)),
            'estimated_km'     => $booking_type === 'km' ? $estimated_km : 0,
            'booking_type'     => $booking_type,
            'hours_slot'       => $booking_type === 'hours' ? $hours_slot : 0,
            'requires_advance' => $requires_advance,
            'amount'           => $calculated_amount,
            'status'           => 'draft',
            '_skip_vehicle_booking' => true,
        );

        if ($is_booking_edit) {
            unset($payload['_skip_vehicle_booking']);
            $payload['updated_at'] = date('Y-m-d H:i:s');
            $this->General_model->update(
                'bookings',
                array('id' => $booking_id, 'customer_id' => $customer_id),
                $payload
            );
            $this->session->set_flashdata('success', 'Step 1 updated. Continue with document upload.');
        } else {
            $booking_id = (int) $this->General_model->create_booking($payload);
            $this->session->set_flashdata('success', 'Step 1 completed. Continue with document upload.');
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
