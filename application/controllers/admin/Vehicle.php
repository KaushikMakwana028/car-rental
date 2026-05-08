<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle extends Admin_Controller
{
    public function index()
    {
        $data['page_title'] = 'Manage Vehicles';
        $data['current_user'] = $this->current_user;
        $vehicles = $this->General_model->get_vehicles_with_live_status();

        usort($vehicles, function ($left, $right) {
            $priority = array(
                'booked' => 0,
                'available' => 1,
                'service' => 2,
            );

            $left_status = isset($left['status']) ? $left['status'] : '';
            $right_status = isset($right['status']) ? $right['status'] : '';
            $left_rank = isset($priority[$left_status]) ? $priority[$left_status] : 99;
            $right_rank = isset($priority[$right_status]) ? $priority[$right_status] : 99;

            if ($left_rank === $right_rank) {
                return (int) $right['id'] - (int) $left['id'];
            }

            return $left_rank - $right_rank;
        });

        $data['vehicles'] = $vehicles;
        $this->render_view('admin/vehicles_list', $data);
    }

    public function create()
    {
        redirect('admin/vehicles');
    }

    public function store()
    {
        $payload = $this->build_vehicle_payload();
        if ($payload === false) {
            return;
        }

        $payload['created_at'] = date('Y-m-d H:i:s');
        $payload['updated_at'] = date('Y-m-d H:i:s');

        $this->General_model->insert('vehicles', $payload);
        $this->session->set_flashdata('success', 'Vehicle added successfully.');
        redirect('admin/vehicles');
    }

    public function update($vehicle_id)
    {
        $vehicle = $this->General_model->get_row('vehicles', array('id' => (int) $vehicle_id));
        if (empty($vehicle)) {
            show_404();
        }

        $payload = $this->build_vehicle_payload($vehicle);
        if ($payload === false) {
            return;
        }

        $payload['updated_at'] = date('Y-m-d H:i:s');

        $this->General_model->update('vehicles', array('id' => (int) $vehicle_id), $payload);
        $this->session->set_flashdata('success', 'Vehicle updated successfully.');
        redirect('admin/vehicles');
    }

    public function delete($vehicle_id)
    {
        $vehicle_id = (int) $vehicle_id;
        $vehicle = $this->General_model->get_row('vehicles', array('id' => $vehicle_id));

        if (empty($vehicle)) {
            show_404();
        }

        if ($this->General_model->count_rows('bookings', array('vehicle_id' => $vehicle_id)) > 0) {
            $this->session->set_flashdata('error', 'This vehicle already has booking records, so it cannot be deleted.');
            redirect('admin/vehicles');
            return;
        }

        $this->General_model->delete('vehicles', array('id' => $vehicle_id));
        $this->session->set_flashdata('success', 'Vehicle deleted successfully.');
        redirect('admin/vehicles');
    }

    private function build_vehicle_payload($existing_vehicle = array())
    {
        $name = trim($this->input->post('name', true));
        $registration_no = trim($this->input->post('registration_no', true));
        $vehicle_type = trim($this->input->post('vehicle_type', true));
        $fuel_type = trim($this->input->post('fuel_type', true));
        $seats = (int) $this->input->post('seats');

        $price_6_hours = (float) $this->input->post('price_6_hours');
        $price_12_hours = (float) $this->input->post('price_12_hours');
        $price_24_hours = (float) $this->input->post('price_24_hours');
        $extra_hour_charge = (float) $this->input->post('extra_hour_charge');
        $advance_amount = (float) $this->input->post('advance_amount');
        $status = $this->input->post('status', true) ?: 'available';

        if (
            $name === '' ||
            $registration_no === '' ||
            $vehicle_type === '' ||
            $fuel_type === '' ||
            $seats <= 0 ||

            $price_6_hours < 0 ||
            $price_12_hours < 0 ||
            $price_24_hours < 0 ||
            $extra_hour_charge < 0 ||
            $advance_amount < 0
        ) {
            $this->session->set_flashdata('error', 'Please fill all vehicle fields correctly before saving.');
            redirect('admin/vehicles');
            return false;
        }

        $duplicate_query = $this->db->where('registration_no', $registration_no);
        if (!empty($existing_vehicle['id'])) {
            $duplicate_query->where('id !=', (int) $existing_vehicle['id']);
        }

        $duplicate_vehicle = $duplicate_query->get('vehicles')->row_array();
        if (!empty($duplicate_vehicle)) {
            $this->session->set_flashdata('error', 'That registration number already exists for another vehicle.');
            redirect('admin/vehicles');
            return false;
        }

        $image_path = !empty($existing_vehicle['image']) ? $existing_vehicle['image'] : null;

        if (!empty($_FILES['vehicle_image']['name'])) {
            $uploaded_path = $this->upload_vehicle_image();
            if ($uploaded_path === false) {
                redirect('admin/vehicles');
                return false;
            }

            $image_path = $uploaded_path;
        }

        return array(
            'name' => $name,
            'registration_no' => $registration_no,
            'vehicle_type' => $vehicle_type,
            'fuel_type' => $fuel_type,
            'seats' => $seats,
            'rate_per_day' => 0,
            'price_6_hours' => $price_6_hours,
            'price_12_hours' => $price_12_hours,
            'price_24_hours' => $price_24_hours,
            'extra_hour_charge' => $extra_hour_charge,
            'image' => $image_path,
            'advance_amount' => $advance_amount,
            'status' => $status,
        );
    }

    private function upload_vehicle_image()
    {
        $upload_dir = FCPATH . 'uploads/vehicles/';

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $config = array(
            'upload_path' => $upload_dir,
            'allowed_types' => 'jpg|jpeg|png|webp',
            'max_size' => 4096,
            'encrypt_name' => true,
        );

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('vehicle_image')) {
            $upload_data = $this->upload->data();
            return 'uploads/vehicles/' . $upload_data['file_name'];
        }

        $this->session->set_flashdata('error', strip_tags($this->upload->display_errors('', '')));
        return false;
    }
}
