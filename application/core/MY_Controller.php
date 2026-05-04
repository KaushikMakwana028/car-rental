<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    protected $current_user = array();

    public function __construct()
    {
        parent::__construct();
        $this->current_user = (array) $this->session->userdata('logged_in_user');

        if (!empty($this->current_user['id']) && isset($this->General_model)) {
            $fresh_user = $this->General_model->get_user_by_id((int) $this->current_user['id']);
            if (!empty($fresh_user)) {
                $this->current_user = $fresh_user;
                $this->session->set_userdata('logged_in_user', $fresh_user);
            }
        }

        $this->load->vars(array(
            'current_user' => $this->current_user,
        ));
    }

    protected function is_logged_in()
    {
        return !empty($this->current_user);
    }

    protected function current_role()
    {
        return isset($this->current_user['role']) ? (int) $this->current_user['role'] : -1;
    }
}

class Admin_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->is_logged_in() || $this->current_role() !== 1) {
            redirect('admin/login');
        }
    }
}

class Customer_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->is_logged_in() || $this->current_role() !== 0) {
            redirect('customer/login');
        }
    }
}
