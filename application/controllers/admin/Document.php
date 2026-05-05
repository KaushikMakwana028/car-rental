<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document extends Admin_Controller
{
    public function index()
    {
        $data['page_title'] = 'Documents Review';
        $data['current_user'] = $this->current_user;
        $data['document_groups'] = $this->General_model->get_document_review_groups();
        $this->render_view('admin/documents_list', $data);
    }

    public function review($document_id)
    {
        $data['page_title'] = 'Review Document';
        $data['current_user'] = $this->current_user;
        $data['document'] = $this->General_model->get_admin_document_detail((int) $document_id);

        if (empty($data['document'])) {
            show_404();
        }

        $this->render_view('admin/document_review', $data);
    }

    public function update_status()
    {
        $document_id = (int) $this->input->post('document_id');
        $status = trim($this->input->post('status', true));
        $notes = trim($this->input->post('admin_notes', true));

        $this->General_model->update('documents', array('id' => $document_id), array(
            'status' => $status,
            'admin_notes' => $notes,
            'updated_at' => date('Y-m-d H:i:s'),
        ));

        $this->session->set_flashdata('success', 'Document status updated successfully.');
        redirect('admin/documents');
    }
}
