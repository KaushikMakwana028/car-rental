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
        $vehicle = $this->General_model->get_row('vehicles', array('id' => $vehicle_id));
        $calculated_amount = !empty($vehicle) ? ((float) $vehicle['rate_per_day'] * $estimated_km) : 0;

        if ($customer_name === '' || $customer_phone === '') {
            $this->session->set_flashdata('error', 'Customer name and phone are required.');
            redirect('admin/bookings/create');
        }

        $customer_id = $this->resolve_customer_id($customer_name, $customer_phone, $customer_email);

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

        $this->General_model->create_booking($payload);
        $this->session->set_flashdata('success', 'Booking created successfully.');
        redirect('admin/bookings');
    }

    private function resolve_customer_id($full_name, $phone, $email = '')
    {
        $phone = trim($phone);
        $email = trim($email);

        if ($phone !== '') {
            $existing_customer = $this->General_model->get_row('users', array(
                'phone' => $phone,
                'role' => 0,
            ));

            if (!empty($existing_customer)) {
                return (int) $existing_customer['id'];
            }
        }

        if ($email !== '') {
            $existing_customer = $this->General_model->get_row('users', array(
                'email' => $email,
                'role' => 0,
            ));

            if (!empty($existing_customer)) {
                return (int) $existing_customer['id'];
            }
        }

        $final_email = $this->build_customer_email($email, $phone);
        $password_seed = bin2hex(random_bytes(8));

        return (int) $this->General_model->insert('users', array(
            'full_name' => $full_name,
            'email' => $final_email,
            'phone' => $phone,
            'password' => password_hash($password_seed, PASSWORD_DEFAULT),
            'role' => 0,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
    }

    private function build_customer_email($email = '', $phone = '')
    {
        $email = trim($email);
        if ($email !== '') {
            $existing_email = $this->General_model->get_row('users', array('email' => $email));
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
            $existing_generated = $this->General_model->get_row('users', array('email' => $generated_email));
        } while (!empty($existing_generated));

        return $generated_email;
    }
}
