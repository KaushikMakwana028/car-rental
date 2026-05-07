<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    protected $current_user = array();
    protected $public_booking_session = array();

    public function __construct()
    {
        parent::__construct();
        $this->current_user = (array) $this->session->userdata('logged_in_user');
        $this->public_booking_session = (array) $this->session->userdata('public_booking_session');

        if (!empty($this->current_user['id']) && isset($this->General_model)) {
            $fresh_user = $this->General_model->get_user_by_id((int) $this->current_user['id']);
            if (!empty($fresh_user)) {
                $this->current_user = $fresh_user;
                $this->session->set_userdata('logged_in_user', $fresh_user);
            }
        }

        $public_contact = array();
        if (isset($this->General_model)) {
            $public_contact = $this->General_model->get_public_contact_details();
        }

        $this->load->vars(array(
            'current_user' => $this->current_user,
            'public_contact' => $public_contact,
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

    protected function consume_customer_intended_url($default = 'dashboard')
    {
        $target_url = $this->session->userdata('customer_intended_url');
        $this->session->unset_userdata('customer_intended_url');

        return !empty($target_url) ? $target_url : site_url($default);
    }

    protected function set_public_booking_session($customer_id, $booking_id)
    {
        $this->public_booking_session = array(
            'customer_id' => (int) $customer_id,
            'booking_id' => (int) $booking_id,
        );
        $this->session->set_userdata('public_booking_session', $this->public_booking_session);
    }

    protected function clear_public_booking_session()
    {
        $this->public_booking_session = array();
        $this->session->unset_userdata('public_booking_session');
    }

    protected function get_active_customer_id()
    {
        if ($this->is_logged_in() && $this->current_role() === 0) {
            return (int) $this->current_user['id'];
        }

        return !empty($this->public_booking_session['customer_id']) ? (int) $this->public_booking_session['customer_id'] : 0;
    }

    protected function get_active_booking_id()
    {
        return !empty($this->public_booking_session['booking_id']) ? (int) $this->public_booking_session['booking_id'] : 0;
    }

    protected function customer_can_access_booking($booking_id, $customer_id = 0)
    {
        $booking_id = (int) $booking_id;
        $customer_id = $customer_id > 0 ? (int) $customer_id : $this->get_active_customer_id();

        if ($booking_id <= 0 || $customer_id <= 0 || !isset($this->General_model)) {
            return false;
        }

        $booking = $this->General_model->get_row('bookings', array(
            'id' => $booking_id,
            'customer_id' => $customer_id,
        ));

        return !empty($booking);
    }

    protected function render_customer_view($view, $data = array())
    {
        $this->load->view('partials/header', $data);
        $this->load->view($view, $data);
        $this->load->view('partials/footer', $data);
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
            redirect('login');
        }
    }

    protected function render_view($view, $data = array())
    {
        $this->render_customer_view($view, $data);
    }
}
