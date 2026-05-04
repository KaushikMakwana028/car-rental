<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Customer_Controller
{
    public function index()
    {
        $data['page_title'] = 'Customer Dashboard';
        $data['current_user'] = $this->current_user;
        $data['stats'] = $this->General_model->get_dashboard_counts('customer', (int) $this->current_user['id']);
        $data['my_bookings'] = array_slice($this->General_model->get_bookings(array('bookings.customer_id' => $this->current_user['id'])), 0, 5);
        $data['vehicles'] = array_slice($this->General_model->get_available_vehicles(), 0, 6);
        $this->load->view('customer/dashboard', $data);
    }
}
