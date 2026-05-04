<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends Admin_Controller
{
    public function index()
    {
        $data['page_title'] = 'Payments';
        $data['current_user'] = $this->current_user;
        $data['bookings'] = $this->General_model->get_bookings();
        $data['payment_summary'] = $this->General_model->get_payment_summary();
        $data['featured_booking'] = !empty($data['bookings']) ? $data['bookings'][0] : array();
        $data['featured_timeline'] = !empty($data['featured_booking'])
            ? $this->General_model->get_booking_payments((int) $data['featured_booking']['id'])
            : array();
        $this->load->view('admin/payments_list', $data);
    }

    public function store()
    {
        $payload = array(
            'booking_id' => (int) $this->input->post('booking_id'),
            'payment_type' => trim($this->input->post('payment_type', true)),
            'amount' => (float) $this->input->post('amount'),
            'payment_mode' => trim($this->input->post('payment_mode', true)),
            'reference_no' => trim($this->input->post('reference_no', true)),
            'notes' => trim($this->input->post('notes', true)),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        );

        $this->General_model->insert('payments', $payload);
        $this->session->set_flashdata('success', 'Payment recorded successfully.');
        redirect('admin/payments');
    }
}
