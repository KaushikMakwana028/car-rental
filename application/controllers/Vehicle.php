<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle extends MY_Controller
{
    public function index()
    {
        redirect('dashboard');
    }

    public function create()
    {
        redirect('dashboard');
    }
}
