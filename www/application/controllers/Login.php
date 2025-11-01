<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('login', 'usuario', 'required');
            $this->form_validation->set_rules('password', 'senha', 'required');

            if (!$this->form_validation->run()) {
                $response = [
                    'notification' => validation_message(validation_errors())
                ];

                echo json_encode($response);
                return;
            }

            $user = [
                'login' => $this->input->post('login'),
                'password' => $this->input->post('password')
            ];

            $login = $this->user_model->find_by_login($user['login']);

            if (!$login) {
                $response = [
                    'notification' => [
                        'type' => 'danger',
                        'message' => '<strong>Erro!</strong> O usuário informado é inválido.'
                    ]
                ];

                echo json_encode($response);
                return;
            }

            if (!$this->check_passowrd($user['password'], $login['password'])) {
                $response = [
                    'notification' => [
                        'type' => 'danger',
                        'message' => '<strong>Erro!</strong> A senha informado é inválida.'
                    ]
                ];

                echo json_encode($response);
                return;
            }

            unset($login['password']);

            $this->session->set_userdata('logged_user', $login);
            $this->session->set_userdata('menu_status', 'open');

            $this->user_model->set_last_login($login['id']);

            $this->session->set_flashdata('notification', CONF_MESSAGE_LOGIN);

            $response = [
                'redirect' => base_url('inicio')
            ];

            echo json_encode($response);
            return;
        }

        if ($this->session->userdata('logged_user')) {
            redirect('inicio');
        }

        $this->load->view('template/header_html');
        $this->load->view('template/login');
        $this->load->view('template/footer_html');
    }

    public function logout()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->session->userdata('logged_user')) {
                $this->session->unset_userdata('logged_user');

                $this->session->set_flashdata('notification', CONF_MESSAGE_LOGOUT);

                $response = [
                    'redirect' => base_url('login')
                ];

                echo json_encode($response);
                return;
            }

            redirect('login');
        }
    }

    public function modify_password()
    {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('new_password', 'nova senha', 'required');

            if (!$this->form_validation->run()) {
                $response = [
                    'notification' => validation_message(validation_errors())
                ];

                echo json_encode($response);
                return;
            }

            $new_passowrd = $this->input->post('new_password');

            if ($this->user_model->set_new_password($this->session->userdata('logged_user')['id'], $new_passowrd)) {
                $this->user_model->set_no_first_login($this->session->userdata('logged_user')['id']);

                $this->session->set_flashdata('notification', [
                    'type' => 'success',
                    'message' => '<strong>Sucesso!</strong> A nova senha foi cadastrada com sucesso. Você deve usá-la para acessar o sistema nas próximas vezes.'
                ]);

                $response = [
                    'redirect' => base_url('inicio')
                ];

                echo json_encode($response);
                return;
            } else {
                $response = [
                    'notification' => [
                        'type' => 'danger',
                        'message' => '<strong>Erro!</strong> Ocorreu um erro ao tentar gravar a nova senha, tente novamente.'
                    ]
                ];

                echo json_encode($response);
                return;
            }
        }

        if (!$this->user_model->get_first_login($this->session->userdata('logged_user')['id'])) {
            $this->session->set_flashdata('notification', [
                'type' => 'info',
                'message' => '<strong>Informação!</strong> Sua senha já foi alterada anteriormente, para alterar novamente solicite ao administrado do sistema.'
            ]);

            redirect('inicio');
        }

        $header = [
            'countdown' => ''
        ];

        $data = [
            'frame_icon' => 'far fa-window-maximize',
            'frame_module' => 'Gestão Usuários',
            'frame_title' => 'Alterar Senha',
            'frame_time' => '',
            'next_link' => ''
        ];

        $this->load->view('template/header_html');
        $this->load->view('template/header', $header);
        $this->load->view('template/modify_password', $data);
        $this->load->view('template/footer');
        $this->load->view('template/footer_html');
    }

    private function check_passowrd(string $user_passowrd, string $login_password)
    {
        if (password_verify($user_passowrd, $login_password)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
