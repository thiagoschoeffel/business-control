<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
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

        $permissions = explode(',', $this->session->userdata('logged_user')['permissions']);
        $level = $this->module_model->find_by_name_class(get_class())['level_class'];

        if (!in_array($level, $permissions)) {
            $this->session->set_flashdata('notification', CONF_MESSAGE_UNAUTHORIZED);

            redirect('inicio');
        }
    }

    public function index()
    {
        if ($this->input->is_ajax_request()) {
            $response = [
                'find' => $this->user_model->find_all(),
                'data' => []
            ];

            if ($response['find']) {
                for ($i = 0; $i < count($response['find']); $i++)
                {
                    $options = [
                        'edit' => '<a title="Editar Registro" href="' . base_url('usuario/frm/' . $response['find'][$i]['id']) . '" class="btn btn-sm btn-dark"><i class="fas fa-pencil-alt fa-fw"></i> Editar</a>',
                        'delete' => '<button title="Deletar Registro" type="button" class="btn btn-sm btn-danger j_app_open_delete_modal" data-toggle="modal" data-target="#j_app_modal_delete" data-register-id="' . $response['find'][$i]['id'] . '"><i class="fas fa-trash-alt fa-fw"></i> Deletar</button>'
                    ];

                    $response['find'][$i]['first_access'] = ($response['find'][$i]['first_access'] === 'N') ? 'SIM' : 'NÃO';
                    $response['find'][$i]['last_access'] = ($response['find'][$i]['last_access'] == NULL) ? '' : date('d/m/Y H:i', strtotime($response['find'][$i]['last_access']));

                    $data = $response['find'][$i];

                    $response['data'][] = $options + $data;
                }
            }

            unset($response['find']);

            echo json_encode($response);
            return;
        }

        $header = [
            'countdown' => ''
        ];

        $data = [
            'frame_icon' => 'far fa-window-maximize',
            'frame_module' => 'Gestão Usuários',
            'frame_title' => 'Usuários',
            'frame_time' => '',
            'next_link' => ''
        ];

        $this->load->view('template/header_html');
        $this->load->view('template/header', $header);
        $this->load->view('user/list', $data);
        $this->load->view('template/footer');
        $this->load->view('template/footer_html');
    }

    public function form($id = null)
    {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('first_name', 'nome', 'required');
            $this->form_validation->set_rules('last_name', 'sobrenome', 'required');
            $this->form_validation->set_rules('email', 'e-mail', 'required|valid_email');
            $this->form_validation->set_rules('login', 'usuário', 'required|alpha|exact_length[3]');
            $this->form_validation->set_rules('first_access', 'já acessou', 'required|alpha|exact_length[1]|in_list[S,N]');

            if(!$id) {
                $this->form_validation->set_rules('password', 'senha', 'required');
            }

            if (!$this->form_validation->run()) {
                $response = [
                    'notification' => validation_message(validation_errors())
                ];

                echo json_encode($response);
                return;
            }

            $email_exists = $this->user_model->find_exist_email(strtolower($this->input->post('email')), ($id) ? $id : null);

            if($email_exists) {
                $response = [
                    'notification' => ['type' => 'warning', 'message' => '<strong>Atenção!</strong> O e-mail que você está tentando cadastrar já está em uso no sistema.'],
                    'result' => FALSE
                ];
    
                echo json_encode($response);
                return;
            }

            $login_exists = $this->user_model->find_exist_login(strtolower($this->input->post('login')), ($id) ? $id :  null);

            if($login_exists) {
                $response = [
                    'notification' => ['type' => 'warning', 'message' => '<strong>Atenção!</strong> O usuário que você está tentando cadastrar já está em uso no sistema.'],
                    'result' => FALSE
                ];
    
                echo json_encode($response);
                return;
            }

            if (!$id) {
                $this->create();
            } else {
                $this->update($id);
            }

            return;
        }

        if ($id && !$this->user_model->find_by_id($id)) {
            $this->session->set_flashdata('notification', CONF_MESSAGE_UPDATE_INVALID);

            redirect('usuario/lst');
        }

        $this->load->model('module_model', 'module_model');

        if ($id) {
            $user = $this->user_model->find_by_id($id);
        } else {
            $user = [
                'id' => '',
                'first_name' => '',
                'last_name' => '',
                'email' => '',
                'login' => '',
                'password' => '',
                'first_access' => 'S',
                'permissions' => ''
            ];
        }

        $header = [
            'countdown' => ''
        ];

        $data = [
            'frame_icon' => 'far fa-window-maximize',
            'frame_module' => 'Gestão Usuários',
            'frame_title' => 'Usuários',
            'frame_time' => '',
            'next_link' => '',
            'user' => $user,
            'modules' => $this->module_model->find_all()
        ];

        $this->load->view('template/header_html');
        $this->load->view('template/header', $header);
        $this->load->view('user/form', $data);
        $this->load->view('template/footer');
        $this->load->view('template/footer_html');
    }

    public function create()
    {
        if ($this->user_model->save()) {
            $response = [
                'notification' => CONF_MESSAGE_INSERT_SUCCESS,
                'result' => TRUE
            ];

            echo json_encode($response);
            return;
        } else {
            $response = [
                'notification' => CONF_MESSAGE_INSERT_ERROR,
                'result' => FALSE
            ];

            echo json_encode($response);
            return;
        }

        return;
    }

    public function update($id)
    {
        if ($this->user_model->save($id)) {
            $this->session->set_flashdata('notification', CONF_MESSAGE_UPDATE_SUCCESS);

            $response = [
                'redirect' => base_url('usuario/lst')
            ];

            echo json_encode($response);
            return;
        } else {
            $this->session->set_flashdata('notification', CONF_MESSAGE_UPDATE_ERROR);

            $response = [
                'redirect' => base_url('usuario/lst')
            ];

            echo json_encode($response);
            return;
        }

        return;
    }

    public function delete()
    {
        if ($this->input->is_ajax_request()) {
            if (!$this->input->post('id')) {
                $response = [
                    'notification' => CONF_MESSAGE_DELETE_EMPTY,
                    'result' => FALSE
                ];

                echo json_encode($response);
                return;
            }

            if (!$this->user_model->find_by_id($this->input->post('id'))) {
                $response = [
                    'notification' => CONF_MESSAGE_DELETE_INVALID,
                    'result' => FALSE
                ];

                echo json_encode($response);
                return;
            }

            if ($this->user_model->destroy($this->input->post('id'))) {
                $this->session->set_flashdata('notification', CONF_MESSAGE_DELETE_SUCCESS);

                $response = [
                    'redirect' => base_url('usuario/lst')
                ];

                echo json_encode($response);
                return;
            } else {
                $this->session->set_flashdata('notification', CONF_MESSAGE_DELETE_ERROR);

                $response = [
                    'redirect' => base_url('usuario/lst')
                ];

                echo json_encode($response);
                return;
            }

            return;
        }
    }

}
