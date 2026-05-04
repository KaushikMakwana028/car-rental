<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends Admin_Controller
{
    public function index()
    {
        $data['page_title'] = 'Customers';
        $data['current_user'] = $this->current_user;
        $data['customers'] = $this->General_model->get_customers_overview();
        $this->load->view('admin/customers_list', $data);
    }
}
