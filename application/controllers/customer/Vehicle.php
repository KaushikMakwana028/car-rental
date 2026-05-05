<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle extends Customer_Controller
{
    public function index()
    {
        $data['page_title'] = 'Available Vehicles';
        $data['page_subtitle'] = 'Compare the active fleet with stronger visuals, clearer pricing, and direct access to the booking form.';
        $data['current_user'] = $this->current_user;
        $data['vehicles'] = $this->General_model->get_available_vehicles();
        $data['document_gate'] = $this->General_model->get_required_documents_status((int) $this->current_user['id']);
        $this->render_view('customer/vehicles_list', $data);
    }

    public function create()
    {
        redirect('customer/bookings/create');
    }
}
