<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends Customer_Controller
{
    public function index()
    {
        $data['page_title'] = 'My Payments';
        $data['page_subtitle'] = 'Track uploaded receipts, admin approval, and advance payment progress for each booking.';
        $data['current_user'] = $this->current_user;
        $data['payment_requests'] = $this->General_model->get_customer_payment_requests((int) $this->current_user['id']);
        $this->render_view('customer/payments_list', $data);
    }

    public function pay($booking_id)
    {
        $booking_id = (int) $booking_id;
        $booking = $this->General_model->get_row('bookings', array(
            'id' => $booking_id,
            'customer_id' => (int) $this->current_user['id'],
        ));

        if (empty($booking)) {
            show_404();
        }

        $data['page_title'] = 'Booking Payment';
        $data['page_subtitle'] = 'Choose advance or full payment, use the admin payment details below, and upload your receipt for approval.';
        $data['current_user'] = $this->current_user;
        $data['booking'] = $this->General_model->get_bookings(array(
            'bookings.id' => $booking_id,
            'bookings.customer_id' => (int) $this->current_user['id'],
        ));
        $data['booking'] = !empty($data['booking']) ? $data['booking'][0] : array();
        $data['payment_settings'] = $this->General_model->get_payment_settings();
        $data['existing_request'] = $this->General_model->get_payment_request_for_booking($booking_id, (int) $this->current_user['id']);

        $this->render_view('customer/payment_pay', $data);
    }

    public function store()
    {
        $booking_id = (int) $this->input->post('booking_id');
        $booking = $this->General_model->get_bookings(array(
            'bookings.id' => $booking_id,
            'bookings.customer_id' => (int) $this->current_user['id'],
        ));
        $booking = !empty($booking) ? $booking[0] : array();

        if (empty($booking)) {
            show_404();
        }

        $payment_type = strtolower(trim($this->input->post('payment_type', true)));
        if (!in_array($payment_type, array('advance', 'full'), true)) {
            $payment_type = 'advance';
        }

        $advance_amount = isset($booking['advance_due']) ? (float) $booking['advance_due'] : 0;
        $full_amount = isset($booking['amount']) ? (float) $booking['amount'] : 0;
        $payment_amount = $payment_type === 'full' ? $full_amount : $advance_amount;

        $upload_dir = FCPATH . 'uploads/payments/';
        if (!is_dir($upload_dir)) {
            @mkdir($upload_dir, 0777, true);
        }

        $config = array(
            'upload_path' => $upload_dir,
            'allowed_types' => 'jpg|jpeg|png|pdf|webp',
            'max_size' => 8192,
            'file_ext_tolower' => true,
            'remove_spaces' => true,
            'file_name' => 'payment_' . $this->current_user['id'] . '_' . $booking_id . '_' . time(),
        );

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('receipt_file')) {
            $this->session->set_flashdata('error', strip_tags($this->upload->display_errors('', '')));
            redirect('customer/payments/pay/' . $booking_id);
        }

        $upload_data = $this->upload->data();
        $existing_request = $this->General_model->get_payment_request_for_booking($booking_id, (int) $this->current_user['id']);
        $payload = array(
            'booking_id' => $booking_id,
            'customer_id' => (int) $this->current_user['id'],
            'payment_type' => $payment_type,
            'amount' => $payment_amount,
            'payment_mode' => trim($this->input->post('payment_mode', true)),
            'reference_no' => trim($this->input->post('reference_no', true)),
            'receipt_file_name' => $upload_data['file_name'],
            'receipt_path' => 'uploads/payments/' . $upload_data['file_name'],
            'customer_notes' => trim($this->input->post('customer_notes', true)),
            'admin_notes' => '',
            'status' => 'pending',
        );

        if (!empty($existing_request)) {
            $payload['approved_at'] = null;
            $payload['reviewed_by'] = 0;
            $this->General_model->update_payment_request((int) $existing_request['id'], $payload);
        } else {
            if ((int) $this->General_model->create_payment_request($payload) <= 0) {
                $this->session->set_flashdata('error', 'Payment request table is missing. Please ask admin to update the database first.');
                redirect('customer/payments/pay/' . $booking_id);
            }
        }

        $this->session->set_flashdata('success', 'Payment receipt uploaded successfully. It is now pending admin approval.');
        redirect('customer/payments');
    }
}
