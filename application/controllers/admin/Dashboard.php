<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller
{
    public function index()
    {
        $data['page_title'] = 'Admin Dashboard';
        $data['current_user'] = $this->current_user;
        $data['stats'] = $this->General_model->get_dashboard_counts('admin');
        $data['recent_bookings'] = array_slice($this->General_model->get_bookings(), 0, 5);
        $this->render_view('admin/dashboard', $data);
    }
}
