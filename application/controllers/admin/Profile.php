<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends Admin_Controller
{
    public function index()
    {
        $data['page_title'] = 'My Profile';
        $data['profile_user'] = $this->General_model->get_user_by_id((int) $this->current_user['id']);
        $this->load->view('admin/profile', $data);
    }

    public function update()
    {
        $user_id = (int) $this->current_user['id'];
        $profile_user = $this->General_model->get_user_by_id($user_id);

        if (empty($profile_user)) {
            show_404();
        }

        $email = trim($this->input->post('email', true));
        $existing_email = $this->db
            ->where('email', $email)
            ->where('id !=', $user_id)
            ->get('users')
            ->row_array();

        if (!empty($existing_email)) {
            $this->session->set_flashdata('error', 'That email address is already used by another account.');
            redirect('admin/profile');
            return;
        }

        $profile_image = !empty($profile_user['profile_image']) ? $profile_user['profile_image'] : null;
        if (!empty($_FILES['profile_image']['name'])) {
            $uploaded_path = $this->upload_profile_image();
            if ($uploaded_path === false) {
                redirect('admin/profile');
                return;
            }

            $profile_image = $uploaded_path;
        }

        $this->General_model->update_user_profile($user_id, array(
            'full_name' => trim($this->input->post('full_name', true)),
            'email' => $email,
            'phone' => trim($this->input->post('phone', true)),
            'profile_image' => $profile_image,
        ));

        $updated_user = $this->General_model->get_user_by_id($user_id);
        $this->session->set_userdata('logged_in_user', $updated_user);
        $this->session->set_flashdata('success', 'Profile updated successfully.');
        redirect('admin/profile');
    }

    public function password()
    {
        $user_id = (int) $this->current_user['id'];
        $current_password = (string) $this->input->post('current_password');
        $new_password = (string) $this->input->post('new_password');
        $confirm_password = (string) $this->input->post('confirm_password');

        if (!$this->General_model->verify_user_password($user_id, $current_password)) {
            $this->session->set_flashdata('error', 'Current password is incorrect.');
            redirect('admin/profile');
            return;
        }

        if (strlen($new_password) < 6) {
            $this->session->set_flashdata('error', 'New password must be at least 6 characters.');
            redirect('admin/profile');
            return;
        }

        if ($new_password !== $confirm_password) {
            $this->session->set_flashdata('error', 'New password and confirm password do not match.');
            redirect('admin/profile');
            return;
        }

        $this->General_model->update_user_password($user_id, $new_password);
        $this->session->set_flashdata('success', 'Password changed successfully.');
        redirect('admin/profile');
    }

    private function upload_profile_image()
    {
        $upload_dir = FCPATH . 'uploads/profiles/';

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

        if ($this->upload->do_upload('profile_image')) {
            $upload_data = $this->upload->data();
            return 'uploads/profiles/' . $upload_data['file_name'];
        }

        $this->session->set_flashdata('error', strip_tags($this->upload->display_errors('', '')));
        return false;
    }
}
