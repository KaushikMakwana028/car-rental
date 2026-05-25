<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends Admin_Controller
{
   public function index()
{
    $data['page_title'] = 'Customers';
    $data['current_user'] = $this->current_user;
    $data['customers'] = $this->General_model->get_customers_overview();

    foreach ($data['customers'] as &$customer) {
        $customer['detail'] = $this->General_model->get_customer_activity_detail((int) $customer['id']);
        
        // ADD THIS: Get payment summary
        $payment_summary = $this->General_model->get_customer_payment_summary((int) $customer['id']);
        $customer['total_amount'] = $payment_summary['total_amount'];
        $customer['paid_amount'] = $payment_summary['paid_amount'];
        $customer['pending_amount'] = $payment_summary['pending_amount'];
    }
    unset($customer);

    $this->render_view('admin/customers_list', $data);
}

    public function delete($customer_id)
    {
        if ($this->input->method() !== 'post') {
            show_404();
        }

        $customer_id = (int) $customer_id;

        if ($customer_id <= 0) {
            $this->session->set_flashdata('error', 'Invalid customer.');
            redirect('admin/customers');
            return;
        }

        // Check if customer has bookings
        $booking_count = $this->General_model->count_rows('bookings', array('customer_id' => $customer_id));

        if ($booking_count > 0) {
            $this->session->set_flashdata('error', 'This customer has ' . $booking_count . ' booking(s) and cannot be deleted. Delete their bookings first.');
            redirect('admin/customers');
            return;
        }

        // Delete documents files from disk first
        $documents = $this->db->where('customer_id', $customer_id)->get('documents')->result_array();
        foreach ($documents as $doc) {
            if (!empty($doc['file_path'])) {
                $full_path = FCPATH . $doc['file_path'];
                if (file_exists($full_path)) {
                    @unlink($full_path);
                }
            }
        }

        // Delete document records
        $this->db->where('customer_id', $customer_id)->delete('documents');

        // Delete the user/customer account — use your actual table name
        $this->db->where('id', $customer_id)->delete('users');

        $this->session->set_flashdata('success', 'Customer deleted successfully.');
        redirect('admin/customers');
    }
}
