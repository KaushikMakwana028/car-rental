<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends Customer_Controller
{
    public function index()
    {
        $data['page_title'] = 'My Bookings';
        $data['page_subtitle'] = 'Track every ride request, payment update, and approval status from one polished bookings overview.';
        $data['current_user'] = $this->current_user;
        $data['bookings'] = $this->General_model->get_bookings(array('bookings.customer_id' => $this->current_user['id']));
        $this->render_view('customer/bookings_list', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Create Booking';
        $data['page_subtitle'] = 'Submit your trip requirements with confidence using a clearer form and automatic amount preview.';
        $data['current_user'] = $this->current_user;
        $data['vehicles'] = $this->General_model->get_available_vehicles();
        $data['document_gate'] = $this->General_model->get_required_documents_status((int) $this->current_user['id']);
        $requested_vehicle_id = (int) $this->input->get('vehicle_id');
        $data['selected_vehicle_id'] = 0;

        if ($requested_vehicle_id > 0) {
            foreach ($data['vehicles'] as $vehicle) {
                if ((int) $vehicle['id'] === $requested_vehicle_id) {
                    $data['selected_vehicle_id'] = $requested_vehicle_id;
                    break;
                }
            }
        }

        $this->render_view('customer/bookings_create', $data);
    }

    public function store()
    {
        $document_gate = $this->General_model->get_required_documents_status((int) $this->current_user['id']);
        if (empty($document_gate['is_ready'])) {
            $message_parts = array('Booking is locked until admin approves all required documents.');

            if (!empty($document_gate['missing_documents'])) {
                $message_parts[] = 'Upload: ' . implode(', ', $document_gate['missing_documents']) . '.';
            }

            if (!empty($document_gate['pending_documents'])) {
                $message_parts[] = 'Waiting for approval: ' . implode(', ', $document_gate['pending_documents']) . '.';
            }

            if (!empty($document_gate['rejected_documents'])) {
                $message_parts[] = 'Please re-upload: ' . implode(', ', $document_gate['rejected_documents']) . '.';
            }

            $message = implode(' ', $message_parts);
            $this->session->set_flashdata('error', $message);
            redirect('customer/documents');
        }

        $vehicle_id = (int) $this->input->post('vehicle_id');
        $estimated_km = (int) $this->input->post('estimated_km');
        $vehicle = $this->General_model->get_row('vehicles', array('id' => $vehicle_id));
        $calculated_amount = !empty($vehicle) ? ((float) $vehicle['rate_per_day'] * $estimated_km) : 0;

        $payload = array(
            'customer_id' => (int) $this->current_user['id'],
            'vehicle_id' => $vehicle_id,
            'pickup_date' => $this->input->post('pickup_date', true),
            'return_date' => $this->input->post('return_date', true),
            'pickup_location' => trim($this->input->post('pickup_location', true)),
            'drop_location' => trim($this->input->post('drop_location', true)),
            'estimated_km' => $estimated_km,
            'amount' => $calculated_amount,
            'status' => 'pending',
        );

        $booking_id = (int) $this->General_model->create_booking($payload);
        $this->session->set_flashdata('success', 'Booking request submitted. Please upload your advance payment receipt now.');
        redirect('customer/payments/pay/' . $booking_id);
    }
}
