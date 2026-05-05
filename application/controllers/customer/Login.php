<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller
{
    public function index()
    {
        if ($this->is_logged_in() && $this->current_role() === 0) {
            redirect($this->consume_customer_intended_url());
        }

        if ($this->input->method() === 'post') {
            $login_id = trim($this->input->post('login_id', true));
            $password = $this->input->post('password', true);

            $user = $this->General_model->authenticate_user($login_id, $password, 0);
            if (!empty($user)) {
                $this->session->set_userdata('logged_in_user', $user);
                redirect($this->consume_customer_intended_url());
            }

            $this->session->set_flashdata('error', 'Invalid user login details.');
            redirect('customer/login');
        }

        $this->load->view('customer/login');
    }

    public function register()
    {
        if ($this->input->method() === 'post') {
            $payload = array(
                'full_name' => trim($this->input->post('full_name', true)),
                'email' => trim($this->input->post('email', true)),
                'phone' => trim($this->input->post('phone', true)),
                'password' => $this->input->post('password', true),
                'role' => 0,
            );

            $result = $this->General_model->create_user($payload);
            if ($result['status']) {
                $this->session->set_flashdata('success', 'User account created. Please login.');
                redirect('customer/login');
            }

            $this->session->set_flashdata('error', $result['message']);
            redirect('register');
        }

        $this->load->view('customer/register');
    }

    public function logout()
    {
        $this->session->unset_userdata('logged_in_user');
        $this->session->unset_userdata('customer_intended_url');
        $this->session->set_flashdata('success', 'User logged out successfully.');
        redirect('customer/dashboard');
    }
}
