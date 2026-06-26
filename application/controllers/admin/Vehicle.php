<?php
defined('BASEPATH') or exit('No direct script access allowed');

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

        $rate_per_km = (float) $this->input->post('rate_per_km');
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

            $rate_per_km < 0 ||
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
            'rate_per_day' => $rate_per_km,
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
    public function get_collection_summary()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $vehicle_id = (int) $this->input->post('vehicle_id');
        $year = $this->input->post('year') ? (int) $this->input->post('year') : (int) date('Y');
        $month = $this->input->post('month') ? (int) $this->input->post('month') : (int) date('m');

        if ($vehicle_id <= 0) {
            echo json_encode(array('success' => false, 'message' => 'Invalid vehicle ID'));
            return;
        }

        $vehicle = $this->General_model->get_row('vehicles', array('id' => $vehicle_id));

        if (empty($vehicle)) {
            echo json_encode(array('success' => false, 'message' => 'Vehicle not found'));
            return;
        }

        $summary = $this->General_model->get_vehicle_collection_summary($vehicle_id, $year, $month);

        $expense_summary = $this->General_model->get_vehicle_expense_summary($vehicle_id, $year, $month);

        echo json_encode(array(
            'success' => true,
            'data' => array(
                'vehicle_name'     => $vehicle['name'],
                'registration_no'  => $vehicle['registration_no'],
                'total_amount'     => $summary['total_amount'],
                'received_amount'  => $summary['received_amount'],
                'pending_amount'   => $summary['pending_amount'],
                'total_bookings'   => $summary['total_bookings'],
                'year'             => $year,
                'month'            => $month,
                'total_expenses'   => $expense_summary['total'],
                'expense_count'    => $expense_summary['count'],
                'expenses'         => $expense_summary['expenses'],
                'net_collection'   => max(0, $summary['received_amount'] - $expense_summary['total']),
            )
        ));
    }
    public function collection()
    {
        // echo " where we can stay as the ";
    }

    public function add_expense()
    {
        $this->output->set_content_type('application/json');

        if (!$this->input->is_ajax_request()) {
            echo json_encode(array('success' => false, 'message' => 'Invalid request.'));
            return;
        }

        $vehicle_id   = (int) $this->input->post('vehicle_id');
        $expense_name = trim($this->input->post('expense_name', true));
        $amount       = (float) $this->input->post('amount');
        $expense_date = trim($this->input->post('expense_date', true));
        $notes        = trim($this->input->post('notes', true));

        if ($vehicle_id <= 0 || $expense_name === '' || $amount <= 0) {
            echo json_encode(array('success' => false, 'message' => 'Vehicle, expense name and amount are required.'));
            return;
        }

        $vehicle = $this->General_model->get_row('vehicles', array('id' => $vehicle_id));
        if (empty($vehicle)) {
            echo json_encode(array('success' => false, 'message' => 'Vehicle not found.'));
            return;
        }

        if ($expense_date === '') {
            $expense_date = date('Y-m-d');
        }

        $id = $this->General_model->add_vehicle_expense($vehicle_id, $expense_name, $amount, $expense_date, $notes);
        echo json_encode(array('success' => $id > 0, 'message' => $id > 0 ? 'Expense added.' : 'Failed to add expense.', 'id' => $id));
    }

    public function delete_expense()
    {
        $this->output->set_content_type('application/json');

        if (!$this->input->is_ajax_request()) {
            echo json_encode(array('success' => false, 'message' => 'Invalid request.'));
            return;
        }

        $expense_id = (int) $this->input->post('expense_id');
        $vehicle_id = (int) $this->input->post('vehicle_id');

        if ($expense_id <= 0 || $vehicle_id <= 0) {
            echo json_encode(array('success' => false, 'message' => 'Invalid request.'));
            return;
        }

        $deleted = $this->General_model->delete_vehicle_expense($expense_id, $vehicle_id);
        echo json_encode(array('success' => (bool) $deleted, 'message' => $deleted ? 'Expense deleted.' : 'Failed to delete.'));
    }

    public function get_expenses()
    {
        $this->output->set_content_type('application/json');

        if (!$this->input->is_ajax_request()) {
            echo json_encode(array('success' => false, 'message' => 'Invalid request.'));
            return;
        }

        $vehicle_id = (int) $this->input->post('vehicle_id');
        $year       = $this->input->post('year')  ? (int) $this->input->post('year')  : null;
        $month      = $this->input->post('month') ? (int) $this->input->post('month') : null;

        if ($vehicle_id <= 0) {
            echo json_encode(array('success' => false, 'message' => 'Invalid vehicle.'));
            return;
        }

        $summary = $this->General_model->get_vehicle_expense_summary($vehicle_id, $year, $month);
        echo json_encode(array('success' => true, 'data' => $summary));
    }
}
