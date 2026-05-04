<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller
{
    public function index()
    {
        if ($this->is_logged_in() && $this->current_role() === 1) {
            redirect('admin/dashboard');
        }

        if ($this->input->method() === 'post') {
            $login_id = trim($this->input->post('login_id', true));
            $password = $this->input->post('password', true);

            $user = $this->General_model->authenticate_user($login_id, $password, 1);
            if (!empty($user)) {
                $this->session->set_userdata('logged_in_user', $user);
                redirect('admin/dashboard');
            }

            $this->session->set_flashdata('error', 'Invalid admin login details.');
            redirect('admin');
        }

        $this->load->view('admin/login');
    }

    public function logout()
    {
        $this->session->unset_userdata('logged_in_user');
        $this->session->set_flashdata('success', 'Admin logged out successfully.');
        redirect('admin');
    }
}
