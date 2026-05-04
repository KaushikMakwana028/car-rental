<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle extends Customer_Controller
{
    public function index()
    {
        $data['page_title'] = 'Available Vehicles';
        $data['current_user'] = $this->current_user;
        $data['vehicles'] = $this->General_model->get_available_vehicles();
        $this->load->view('customer/vehicles_list', $data);
    }

    public function create()
    {
        redirect('customer/bookings/create');
    }
}
