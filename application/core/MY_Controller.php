<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    protected $current_user = array();

    public function __construct()
    {
        parent::__construct();
        $this->current_user = (array) $this->session->userdata('logged_in_user');

        if (!empty($this->current_user['id']) && isset($this->General_model)) {
            $fresh_user = $this->General_model->get_user_by_id((int) $this->current_user['id']);
            if (!empty($fresh_user)) {
                $this->current_user = $fresh_user;
                $this->session->set_userdata('logged_in_user', $fresh_user);
            }
        }

        $this->load->vars(array(
            'current_user' => $this->current_user,
        ));
    }

    protected function is_logged_in()
    {
        return !empty($this->current_user);
    }

    protected function current_role()
    {
        return isset($this->current_user['role']) ? (int) $this->current_user['role'] : -1;
    }

    protected function current_request_url()
    {
        $path = uri_string();
        $url = $path === '' ? base_url() : site_url($path);
        $query_string = isset($_SERVER['QUERY_STRING']) ? trim((string) $_SERVER['QUERY_STRING']) : '';

        return $query_string !== '' ? $url . '?' . $query_string : $url;
    }

    protected function remember_customer_intended_url($url = null)
    {
        $target_url = $url ? $url : $this->current_request_url();
        $this->session->set_userdata('customer_intended_url', $target_url);
    }

    protected function consume_customer_intended_url($default = 'customer/dashboard')
    {
        $target_url = $this->session->userdata('customer_intended_url');
        $this->session->unset_userdata('customer_intended_url');

        return !empty($target_url) ? $target_url : site_url($default);
    }
}

class Admin_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->is_logged_in() || $this->current_role() !== 1) {
            redirect('admin/login');
        }
    }

    protected function render_view($view, $data = array())
    {
        $this->load->view('admin/partials/header', $data);
        $this->load->view($view, $data);
        $this->load->view('admin/partials/footer', $data);
    }
}

class Customer_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->is_logged_in() || $this->current_role() !== 0) {
            if ($this->input->method() === 'get') {
                $this->remember_customer_intended_url();
            }
            redirect('customer/login');
        }
    }

    protected function render_view($view, $data = array())
    {
        $this->load->view('customer/partials/header', $data);
        $this->load->view($view, $data);
        $this->load->view('customer/partials/footer', $data);
    }
}
