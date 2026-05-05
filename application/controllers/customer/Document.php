<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document extends Customer_Controller
{
    public function index()
    {
        $data['page_title'] = 'My Documents';
        $data['page_subtitle'] = 'Upload verification files, review document status, and keep your booking profile ready for approval.';
        $data['current_user'] = $this->current_user;
        $data['bookings'] = $this->General_model->get_bookings(array('bookings.customer_id' => $this->current_user['id']));
        $data['documents'] = $this->General_model->get_customer_documents_matrix((int) $this->current_user['id']);
        $data['document_progress'] = $this->General_model->get_customer_documents_progress((int) $this->current_user['id']);
        $data['document_gate'] = $this->General_model->get_required_documents_status((int) $this->current_user['id']);
        $this->render_view('customer/documents_list', $data);
    }

    public function delete($document_id = 0)
    {
        $document_id = (int) $document_id;
        $document = $this->General_model->get_row('documents', array(
            'id' => $document_id,
            'customer_id' => (int) $this->current_user['id'],
        ));

        if (empty($document)) {
            $this->session->set_flashdata('error', 'Document not found.');
            redirect('customer/documents');
        }

        if (!empty($document['file_path'])) {
            $absolute_path = FCPATH . ltrim(str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $document['file_path']), DIRECTORY_SEPARATOR);
            if (is_file($absolute_path)) {
                @unlink($absolute_path);
            }
        }

        $this->General_model->delete('documents', array('id' => $document_id, 'customer_id' => (int) $this->current_user['id']));
        $this->session->set_flashdata('success', 'Document deleted successfully.');
        redirect('customer/documents');
    }

    public function store()
    {
        $upload_dir = FCPATH . 'uploads/documents/';
        if (!is_dir($upload_dir)) {
            @mkdir($upload_dir, 0777, true);
        }

        $document_type = trim($this->input->post('document_type', true));
        $file_key = preg_replace('/[^a-z0-9]+/i', '_', strtolower($document_type));

        $config = array(
            'upload_path' => $upload_dir,
            'allowed_types' => 'jpg|jpeg|png|pdf',
            'max_size' => 4096,
            'file_ext_tolower' => true,
            'remove_spaces' => true,
            'file_name' => 'doc_' . $this->current_user['id'] . '_' . $file_key . '_' . time(),
        );

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('document_file')) {
            $this->session->set_flashdata('error', strip_tags($this->upload->display_errors('', '')));
            redirect('customer/documents');
        }

        $upload_data = $this->upload->data();
        $booking_id = (int) $this->input->post('booking_id');
        if ($booking_id <= 0) {
            $booking_id = null;
        }

        $payload = array(
            'customer_id' => (int) $this->current_user['id'],
            'booking_id' => $booking_id,
            'document_type' => $document_type,
            'file_name' => $upload_data['file_name'],
            'file_path' => 'uploads/documents/' . $upload_data['file_name'],
            'status' => 'pending',
            'admin_notes' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        );

        $existing = $this->General_model->get_row('documents', array(
            'customer_id' => (int) $this->current_user['id'],
            'document_type' => $document_type,
        ));

        if (!empty($existing)) {
            $this->General_model->update('documents', array('id' => $existing['id']), $payload);
        } else {
            $this->General_model->insert('documents', $payload);
        }

        $this->session->set_flashdata('success', 'Document uploaded successfully and sent for review.');
        redirect('customer/documents');
    }
}
