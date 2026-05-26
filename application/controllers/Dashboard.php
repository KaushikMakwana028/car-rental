<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function index()
    {
        $data['page_title'] = '';
        $data['page_subtitle'] = '';
        $data['current_user'] = $this->current_user;
        $data['is_customer_logged_in'] = false;
        $data['hide_page_hero'] = true;

        $data['vehicles'] = $this->General_model->get_public_vehicles();

        $this->load->view('partials/header', $data);
        $this->load->view('home_view', $data);
        $this->load->view('partials/footer', $data);
    }
}
