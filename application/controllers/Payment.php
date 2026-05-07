<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends MY_Controller
{
    public function index()
    {
        redirect('dashboard');
    }

    public function pay($booking_id)
    {
        $customer_id = (int) $this->input->get('customer_id');
        if ($customer_id <= 0) {
            $customer_id = $this->get_active_customer_id();
        }
        $booking_id = (int) $booking_id;

        if ($customer_id <= 0 || !$this->customer_can_access_booking($booking_id, $customer_id)) {
            $this->session->set_flashdata('error', 'Please start your booking again.');
            redirect('dashboard');
        }

        $document_gate = $this->General_model->get_required_documents_status($customer_id);
        if ((int) $document_gate['missing_count'] > 0) {
            $this->session->set_flashdata('error', 'Upload both required documents before payment.');
            redirect('documents?booking_id=' . $booking_id . '&customer_id=' . $customer_id);
        }

        $this->set_public_booking_session($customer_id, $booking_id);
        $booking = $this->General_model->get_booking_for_flow($booking_id, $customer_id);

        $data['page_title'] = 'Advance Payment';
        $data['page_subtitle'] = 'Pay the advance amount and upload your receipt to complete the booking request.';
        $data['current_user'] = $this->current_user;
        $data['is_customer_logged_in'] = $this->is_logged_in() && $this->current_role() === 0;
        $data['current_step'] = 3;
        $data['booking'] = $booking;
        $data['payment_settings'] = $this->General_model->get_payment_settings();
        $data['existing_request'] = $this->General_model->get_payment_request_for_booking($booking_id, $customer_id);
        $data['cancel_url'] = base_url('bookings/cancel/' . $booking_id . '?customer_id=' . $customer_id);

        $this->render_customer_view('payment_pay', $data);
    }

    public function store()
    {
        $customer_id = (int) $this->input->post('customer_id');
        if ($customer_id <= 0) {
            $customer_id = $this->get_active_customer_id();
        }
        $booking_id = (int) $this->input->post('booking_id');
        $booking = $this->General_model->get_booking_for_flow($booking_id, $customer_id);

        if (empty($booking)) {
            $this->session->set_flashdata('error', 'Please start your booking again.');
            redirect('dashboard');
        }

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
            'file_name' => 'payment_' . $customer_id . '_' . $booking_id . '_' . time(),
        );

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('receipt_file')) {
            $this->session->set_flashdata('error', strip_tags($this->upload->display_errors('', '')));
            redirect('payments/pay/' . $booking_id . '?customer_id=' . $customer_id);
        }

        $advance_amount = isset($booking['advance_due']) && (float) $booking['advance_due'] > 0
            ? (float) $booking['advance_due']
            : (float) $booking['amount'];
        $upload_data = $this->upload->data();
        $existing_request = $this->General_model->get_payment_request_for_booking($booking_id, $customer_id);
        $payload = array(
            'booking_id' => $booking_id,
            'customer_id' => $customer_id,
            'payment_type' => 'advance',
            'amount' => $advance_amount,
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
                redirect('payments/pay/' . $booking_id . '?customer_id=' . $customer_id);
            }
        }

        $this->General_model->update('bookings', array('id' => $booking_id), array(
            'status' => 'pending',
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        $this->General_model->update('vehicles', array('id' => (int) $booking['vehicle_id']), array(
            'status' => 'booked',
        ));
        $this->clear_public_booking_session();
        $this->session->set_flashdata('swal', array(
            'icon' => 'success',
            'title' => 'Booking Request Submitted',
            'text' => 'Your booking request and payment receipt were submitted successfully. Admin will review them shortly.',
            'identity' => array(
                'Booking ID' => isset($booking['booking_code']) ? $booking['booking_code'] : ('#' . $booking_id),
                'Customer' => isset($booking['customer_name']) ? $booking['customer_name'] : '',
                'Mobile' => isset($booking['customer_phone']) ? $booking['customer_phone'] : '',
            ),
        ));
        redirect('dashboard');
    }
}
