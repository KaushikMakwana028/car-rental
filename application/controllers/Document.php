<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document extends MY_Controller
{
    public function index()
    {
        $customer_id = (int) $this->input->get('customer_id');
        if ($customer_id <= 0) {
            $customer_id = $this->get_active_customer_id();
        }
        $booking_id = (int) $this->input->get('booking_id');

        if ($booking_id <= 0) {
            $booking_id = $this->get_active_booking_id();
        }

        if ($customer_id <= 0 || !$this->customer_can_access_booking($booking_id, $customer_id)) {
            $this->session->set_flashdata('error', 'Please start your booking again.');
            redirect('dashboard');
        }

        $this->set_public_booking_session($customer_id, $booking_id);
        $booking = $this->General_model->get_bookings(array(
            'bookings.id' => $booking_id,
            'bookings.customer_id' => $customer_id,
        ));
        $booking = !empty($booking) ? $booking[0] : array();

        $documents = $this->General_model->get_customer_documents_matrix($customer_id);
        $document_map = array();
        foreach ($documents as $document) {
            $document_map[$document['document_type']] = $document;
        }

        $data['page_title'] = 'Upload Documents';
        $data['page_subtitle'] = 'Upload Aadhaar Card and Driving License files before moving to the advance payment step.';
        $data['current_user'] = $this->current_user;
        $data['is_customer_logged_in'] = $this->is_logged_in() && $this->current_role() === 0;
        $data['current_step'] = 2;
        $data['booking'] = $booking;
        $data['documents'] = $documents;
        $data['document_map'] = $document_map;
        $data['required_types'] = $this->General_model->get_document_types();
        $data['can_continue_to_payment'] = $this->can_continue_to_payment($customer_id);
        $this->render_customer_view('documents_list', $data);
    }

    public function delete($document_id = 0)
    {
        $customer_id = (int) $this->input->get('customer_id');
        if ($customer_id <= 0) {
            $customer_id = $this->get_active_customer_id();
        }
        $document_id = (int) $document_id;
        $document = $this->General_model->get_row('documents', array(
            'id' => $document_id,
            'customer_id' => $customer_id,
        ));

        if (empty($document)) {
            $this->session->set_flashdata('error', 'Document not found.');
            redirect('documents');
        }

        if (!empty($document['file_path'])) {
            $absolute_path = FCPATH . ltrim(str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $document['file_path']), DIRECTORY_SEPARATOR);
            if (is_file($absolute_path)) {
                @unlink($absolute_path);
            }
        }

        $this->General_model->delete('documents', array('id' => $document_id, 'customer_id' => $customer_id));
        $this->session->set_flashdata('success', 'Document deleted successfully.');
        $redirect_booking_id = !empty($document['booking_id']) ? (int) $document['booking_id'] : $this->get_active_booking_id();
        redirect('documents?booking_id=' . $redirect_booking_id . '&customer_id=' . $customer_id);
    }

    public function store()
    {
        $customer_id = (int) $this->input->post('customer_id');
        if ($customer_id <= 0) {
            $customer_id = $this->get_active_customer_id();
        }
        $booking_id = (int) $this->input->post('booking_id');
        if ($booking_id <= 0) {
            $booking_id = $this->get_active_booking_id();
        }

        if ($customer_id <= 0 || !$this->customer_can_access_booking($booking_id, $customer_id)) {
            $this->session->set_flashdata('error', 'Please start your booking again.');
            redirect('dashboard');
        }

        $upload_dir = FCPATH . 'uploads/documents/';
        if (!is_dir($upload_dir)) {
            @mkdir($upload_dir, 0777, true);
        }

        $required_uploads = array(
            'aadhaar_file' => 'Aadhaar Card',
            'driving_license_file' => 'Driving License',
        );
        $uploaded_any = false;

        foreach ($required_uploads as $field_name => $document_type) {
            if (empty($_FILES[$field_name]['name'])) {
                $this->session->set_flashdata('error', 'Please upload both Aadhaar Card and Driving License.');
                redirect('documents?booking_id=' . $booking_id . '&customer_id=' . $customer_id);
            }

            $upload_data = $this->upload_document_file($upload_dir, $field_name, $customer_id, $document_type);
            if ($upload_data === false) {
                redirect('documents?booking_id=' . $booking_id . '&customer_id=' . $customer_id);
            }

            $uploaded_any = true;
            $payload = array(
                'customer_id' => $customer_id,
                'booking_id' => $booking_id,
                'document_type' => $document_type,
                'file_name' => $upload_data['file_name'],
                'file_path' => 'uploads/documents/' . $upload_data['file_name'],
                'status' => 'pending',
                'admin_notes' => '',
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $existing = $this->General_model->get_row('documents', array(
                'customer_id' => $customer_id,
                'document_type' => $document_type,
            ));

            if (!empty($existing)) {
                $payload['created_at'] = !empty($existing['created_at']) ? $existing['created_at'] : date('Y-m-d H:i:s');
                $this->General_model->update('documents', array('id' => (int) $existing['id']), $payload);
            } else {
                $payload['created_at'] = date('Y-m-d H:i:s');
                $this->General_model->insert('documents', $payload);
            }
        }

        if (!$uploaded_any) {
            $this->session->set_flashdata('error', 'Please upload required documents.');
            redirect('documents?booking_id=' . $booking_id . '&customer_id=' . $customer_id);
        }

        $this->session->set_flashdata('success', 'Documents uploaded successfully. Please complete payment now.');
        redirect('payments/pay/' . $booking_id . '?customer_id=' . $customer_id);
    }

    private function can_continue_to_payment($customer_id)
    {
        $summary = $this->General_model->get_required_documents_status((int) $customer_id);
        return (int) $summary['missing_count'] === 0 && (int) $summary['rejected_count'] === 0;
    }

    private function upload_document_file($upload_dir, $field_name, $customer_id, $document_type)
    {
        $file_key = preg_replace('/[^a-z0-9]+/i', '_', strtolower($document_type));
        $config = array(
            'upload_path' => $upload_dir,
            'allowed_types' => 'jpg|jpeg|png|pdf',
            'max_size' => 4096,
            'file_ext_tolower' => true,
            'remove_spaces' => true,
            'file_name' => 'doc_' . $customer_id . '_' . $file_key . '_' . time(),
        );

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($field_name)) {
            $this->session->set_flashdata('error', strip_tags($this->upload->display_errors('', '')));
            return false;
        }

        return $this->upload->data();
    }
}
