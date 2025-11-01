<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Web extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_user')) {
            $this->session->set_flashdata('notification', CONF_MESSAGE_UNLOGGED);

            redirect('login');
        }

        if ($this->user_model->get_first_login($this->session->userdata('logged_user')['id'])) {
            $this->session->set_flashdata('notification', CONF_MESSAGE_FIRST_ACCESS);

            redirect('alterar_senha');
        }
    }

    public function index()
    {
        $this->load->view('template/header_html');
        $this->load->view('template/header');
        $this->load->view('template/home');
        $this->load->view('template/footer');
        $this->load->view('template/footer_html');
    }

    public function menu_status()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->session->userdata('menu_status') == 'open') {
                $this->session->set_userdata('menu_status', 'close');
            } else {
                $this->session->set_userdata('menu_status', 'open');
            }
        }
    }

}
