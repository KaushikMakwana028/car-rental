<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller
{
    public function index()
    {
        redirect('customer/dashboard');
    }

    public function register()
    {
        redirect('customer/dashboard');
    }

    public function logout()
    {
        $this->session->unset_userdata('logged_in_user');
        $this->session->unset_userdata('customer_intended_url');
        $this->session->set_flashdata('success', 'User logged out successfully.');
        redirect('customer/dashboard');
    }
}
