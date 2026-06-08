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
            'data' => $this->General_model->get_public_vehicles(),
        ));
    }

    public function check_vehicle_availability()
    {
        $vehicle_id = (int) $this->input->get('vehicle_id');
        $pickup_date = trim((string) $this->input->get('pickup_date', true));
        $return_date = trim((string) $this->input->get('return_date', true));
        $pickup_time = $this->General_model->normalize_time_value($this->input->get('pickup_time', true));
        $return_time = $this->General_model->normalize_time_value($this->input->get('return_time', true));
        $booking_id = (int) $this->input->get('booking_id');

        if ($vehicle_id <= 0) {
            return $this->respond(array(
                'status' => false,
                'available' => true,
                'message' => '',
            ), 200);
        }

        if ($pickup_date === '') {
            return $this->respond(array(
                'status' => true,
                'available' => true,
                'message' => '',
            ));
        }

        if ($return_date === '') {
            $return_date = $pickup_date;
        }

        $conflict = $this->General_model->find_vehicle_booking_conflict($vehicle_id, $pickup_date, $return_date, $booking_id, $pickup_time, $return_time);

        if (empty($conflict)) {
            return $this->respond(array(
                'status' => true,
                'available' => true,
                'message' => '',
            ));
        }

        $conflict_start = $this->General_model->format_booking_datetime_label(
            $conflict['pickup_date'],
            isset($conflict['pickup_time']) ? $conflict['pickup_time'] : null
        );
        $conflict_end = $this->General_model->format_booking_datetime_label(
            $conflict['return_date'],
            isset($conflict['return_time']) ? $conflict['return_time'] : null,
            true
        );

        return $this->respond(array(
            'status' => true,
            'available' => false,
            'message' => 'This car is already booked from ' . $conflict_start . ' to ' . $conflict_end . '. Please choose another date and time.',
            'conflict' => array(
                'pickup_date' => $conflict['pickup_date'],
                'return_date' => $conflict['return_date'],
                'pickup_time' => isset($conflict['pickup_time']) ? $conflict['pickup_time'] : null,
                'return_time' => isset($conflict['return_time']) ? $conflict['return_time'] : null,
            ),
        ));
    }

    public function create_booking()
    {
        $vehicle_id = (int) $this->input->post('vehicle_id');
        $booking_type = $this->input->post('booking_type', true) === 'km' ? 'km' : 'hours';
        $estimated_km = (int) $this->input->post('estimated_km');
        $hours_slot = (int) $this->input->post('hours_slot');
        $requires_advance = $this->input->post('requires_advance') ? 1 : 0;
        $pickup_time = $this->General_model->normalize_time_value($this->input->post('pickup_time', true));
        $return_time = $this->General_model->normalize_time_value($this->input->post('return_time', true));
        $vehicle = $this->General_model->get_row('vehicles', array('id' => $vehicle_id));

        if (empty($vehicle)) {
            return $this->respond(array(
                'status' => false,
                'message' => 'Invalid vehicle selected.',
            ), 422);
        }

        if ($booking_type === 'km' && $estimated_km <= 0) {
            return $this->respond(array(
                'status' => false,
                'message' => 'Estimated kilometers are required for KM booking.',
            ), 422);
        }

        if ($booking_type === 'hours' && !in_array($hours_slot, array(6, 12, 24), true)) {
            return $this->respond(array(
                'status' => false,
                'message' => 'A valid hour package is required for hour booking.',
            ), 422);
        }

        $pickup_date = $this->input->post('pickup_date', true);
        $return_date = $this->input->post('return_date', true);
        $conflict = $this->General_model->find_vehicle_booking_conflict($vehicle_id, $pickup_date, $return_date, 0, $pickup_time, $return_time);

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
            return $this->respond(array(
                'status' => false,
                'message' => 'This car is already booked from ' . $conflict_start . ' to ' . $conflict_end . '.',
            ), 422);
        }

        $calculated_amount = $this->General_model->calculate_booking_amount($vehicle, $booking_type, $estimated_km, $hours_slot, $pickup_date, $return_date, $pickup_time, $return_time);


        $payload = array(
            'customer_id' => (int) $this->input->post('customer_id'),
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
