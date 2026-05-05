<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function index()
    {
        $data['page_title'] = 'Home';
        $data['page_subtitle'] = 'Explore the fleet, compare vehicles, and move into booking with a cleaner premium customer experience.';
        $data['current_user'] = $this->current_user;
        $data['is_customer_logged_in'] = $this->is_logged_in() && $this->current_role() === 0;

        $data['vehicles'] = $this->General_model->get_available_vehicles();

        $this->load->view('customer/partials/header', $data);
        $this->load->view('customer/home_view', $data);
        $this->load->view('customer/partials/footer', $data);
    }
}
