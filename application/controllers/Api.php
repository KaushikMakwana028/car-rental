<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('General_model');
    }

    private function respond($payload, $status_code = 200)
    {
        return $this->output
            ->set_status_header($status_code)
            ->set_content_type('application/json')
            ->set_output(json_encode($payload));
    }

    public function admin_login()
    {
        return $this->handle_login(1);
    }

    public function customer_login()
    {
        return $this->handle_login(0);
    }

    public function admin_register()
    {
        return $this->handle_register(1);
    }

    public function customer_register()
    {
        return $this->handle_register(0);
    }

    public function vehicles()
    {
        return $this->respond(array(
            'status' => true,
            'data' => $this->General_model->get_available_vehicles(),
        ));
    }

    public function create_booking()
    {
        $vehicle_id = (int) $this->input->post('vehicle_id');
        $hours_slot = (int) $this->input->post('hours_slot');
        $vehicle = $this->General_model->get_row('vehicles', array('id' => $vehicle_id));
        
        $price_map = array(
            6  => !empty($vehicle) ? (float)$vehicle['price_6_hours'] : 0,
            12 => !empty($vehicle) ? (float)$vehicle['price_12_hours'] : 0,
            24 => !empty($vehicle) ? (float)$vehicle['price_24_hours'] : 0,
        );
        $calculated_amount = isset($price_map[$hours_slot]) ? $price_map[$hours_slot] : 0;

        $payload = array(
            'customer_id' => (int) $this->input->post('customer_id'),
            'vehicle_id' => $vehicle_id,
            'pickup_date' => $this->input->post('pickup_date', true),
            'return_date' => $this->input->post('return_date', true),
            'pickup_location' => trim($this->input->post('pickup_location', true)),
            'drop_location' => trim($this->input->post('drop_location', true)),
            'booking_type' => 'hours',
            'hours_slot' => $hours_slot,
            'amount' => $calculated_amount,
            'status' => $this->input->post('status', true) ?: 'pending',
        );

        $booking_id = $this->General_model->create_booking($payload);

        return $this->respond(array(
            'status' => true,
            'message' => 'Booking created successfully.',
            'booking_id' => $booking_id,
            'booking_code' => $this->General_model->format_booking_code($booking_id, date('Y-m-d H:i:s')),
            'calculated_amount' => $calculated_amount,
        ), 201);
    }

    public function dashboard()
    {
        $role = $this->input->get('role', true);
        $role = ($role === null || $role === '') ? 1 : (int) $role;
        $user_id = (int) $this->input->get('user_id');

        return $this->respond(array(
            'status' => true,
            'data' => $this->General_model->get_dashboard_counts($role, $user_id),
        ));
    }

    private function handle_login($role)
    {
        $email = trim($this->input->post('email', true));
        $password = $this->input->post('password', true);
        $user = $this->General_model->authenticate_user($email, $password, $role);

        if (empty($user)) {
            return $this->respond(array(
                'status' => false,
                'message' => 'Invalid login credentials.',
            ), 401);
        }

        return $this->respond(array(
            'status' => true,
            'message' => ($role === 1 ? 'Admin' : 'Customer') . ' login successful.',
            'data' => $user,
        ));
    }

    private function handle_register($role)
    {
        $payload = array(
            'full_name' => trim($this->input->post('full_name', true)),
            'email' => trim($this->input->post('email', true)),
            'phone' => trim($this->input->post('phone', true)),
            'password' => $this->input->post('password', true),
            'role' => (int) $role,
        );

        $result = $this->General_model->create_user($payload);
        if (!$result['status']) {
            return $this->respond($result, 422);
        }

        return $this->respond(array(
            'status' => true,
            'message' => ((int) $role === 1 ? 'Admin' : 'Customer') . ' registered successfully.',
            'user_id' => $result['user_id'],
        ), 201);
    }
}
