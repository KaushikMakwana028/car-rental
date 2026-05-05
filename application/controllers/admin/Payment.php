<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends Admin_Controller
{
    public function index()
    {
        $data['page_title'] = 'Payment Requests';
        $data['current_user'] = $this->current_user;
        $data['payment_requests'] = $this->General_model->get_admin_payment_requests();
        $data['payment_request_counts'] = $this->General_model->get_payment_request_counts();
        $data['payment_settings'] = $this->General_model->get_payment_settings();
        $this->render_view('admin/payment_requests', $data);
    }

    public function settings()
    {
        $data['page_title'] = 'Payment Details';
        $data['current_user'] = $this->current_user;
        $data['payment_settings'] = $this->General_model->get_payment_settings();
        $this->render_view('admin/payment_settings', $data);
    }

    public function save_settings()
    {
        $existing = $this->General_model->get_payment_settings();
        $qr_path = !empty($existing['qr_image']) ? $existing['qr_image'] : '';

        if (!empty($_FILES['qr_image']['name'])) {
            $upload_dir = FCPATH . 'uploads/payment-settings/';
            if (!is_dir($upload_dir)) {
                @mkdir($upload_dir, 0777, true);
            }

            $config = array(
                'upload_path' => $upload_dir,
                'allowed_types' => 'jpg|jpeg|png|webp',
                'max_size' => 4096,
                'file_ext_tolower' => true,
                'remove_spaces' => true,
                'file_name' => 'payment_qr_' . time(),
            );

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('qr_image')) {
                $this->session->set_flashdata('error', strip_tags($this->upload->display_errors('', '')));
                redirect('admin/payments/settings');
            }

            $upload_data = $this->upload->data();
            $qr_path = 'uploads/payment-settings/' . $upload_data['file_name'];
        }

        $payload = array(
            'account_holder' => trim($this->input->post('account_holder', true)),
            'bank_name' => trim($this->input->post('bank_name', true)),
            'account_number' => trim($this->input->post('account_number', true)),
            'ifsc_code' => trim($this->input->post('ifsc_code', true)),
            'branch_name' => trim($this->input->post('branch_name', true)),
            'upi_id' => trim($this->input->post('upi_id', true)),
            'qr_image' => $qr_path,
            'payment_instructions' => trim($this->input->post('payment_instructions', true)),
        );

        if ($this->General_model->save_payment_settings($payload) === false) {
            $this->session->set_flashdata('error', 'Payment settings table is missing. Please run the database query first.');
            redirect('admin/payments/settings');
        }

        $this->session->set_flashdata('success', 'Payment details updated successfully.');
        redirect('admin/payments/settings');
    }

    public function approve($request_id)
    {
        $request = $this->General_model->get_payment_request_by_id((int) $request_id);
        if (empty($request)) {
            show_404();
        }

        if ($request['status'] !== 'approved') {
            $payload = array(
                'booking_id' => (int) $request['booking_id'],
                'payment_type' => !empty($request['payment_type']) ? $request['payment_type'] : 'advance',
                'amount' => (float) $request['amount'],
                'payment_mode' => !empty($request['payment_mode']) ? $request['payment_mode'] : 'UPI',
                'reference_no' => !empty($request['reference_no']) ? $request['reference_no'] : '',
                'notes' => 'Customer receipt approved by admin.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            if ($this->db->table_exists('payments') && $this->db->field_exists('payment_request_id', 'payments')) {
                $existing_payment = $this->General_model->get_row('payments', array('payment_request_id' => (int) $request['id']));
                if (empty($existing_payment)) {
                    $payload['payment_request_id'] = (int) $request['id'];
                    $this->General_model->insert('payments', $payload);
                    $this->General_model->sync_booking_status_from_payment((int) $request['booking_id']);
                }
            } elseif ($this->db->table_exists('payments')) {
                $this->General_model->insert('payments', $payload);
                $this->General_model->sync_booking_status_from_payment((int) $request['booking_id']);
            }
        }

        $this->General_model->update_payment_request((int) $request['id'], array(
            'status' => 'approved',
            'admin_notes' => trim($this->input->post('admin_notes', true)),
            'reviewed_by' => (int) $this->current_user['id'],
            'approved_at' => date('Y-m-d H:i:s'),
        ));

        $this->session->set_flashdata('success', 'Payment request approved successfully.');
        redirect('admin/payments/requests');
    }

    public function reject($request_id)
    {
        $request = $this->General_model->get_payment_request_by_id((int) $request_id);
        if (empty($request)) {
            show_404();
        }

        $this->General_model->update_payment_request((int) $request['id'], array(
            'status' => 'rejected',
            'admin_notes' => trim($this->input->post('admin_notes', true)),
            'reviewed_by' => (int) $this->current_user['id'],
            'approved_at' => null,
        ));

        $this->session->set_flashdata('success', 'Payment request rejected.');
        redirect('admin/payments/requests');
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
        $this->General_model->sync_booking_status_from_payment((int) $payload['booking_id']);
        $this->session->set_flashdata('success', 'Payment recorded successfully.');

        $redirect_to = trim($this->input->post('redirect_to', true));
        if ($redirect_to === 'admin/bookings') {
            redirect('admin/bookings');
        }

        redirect('admin/payments/requests');
    }
}
