<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sector extends CI_Controller
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

        $this->load->model('raw_material/sector_model', 'sector_model');
    }

    public function index()
    {
        if ($this->input->is_ajax_request()) {
            $response = [
                'find' => $this->sector_model->find_all(),
                'data' => []
            ];

            if ($response['find']) {
                for ($i = 0; $i < count($response['find']); $i++)
                {
                    $options = [
                        'edit' => '<a title="Editar Registro" href="' . base_url('materia_prima/cadastro/setor/frm/' . $response['find'][$i]['id']) . '" class="btn btn-sm btn-dark"><i class="fas fa-pencil-alt fa-fw"></i> Editar</a>',
                        'delete' => '<button title="Deletar Registro" type="button" class="btn btn-sm btn-danger j_app_open_delete_modal" data-toggle="modal" data-target="#j_app_modal_delete" data-register-id="' . $response['find'][$i]['id'] . '"><i class="fas fa-trash-alt fa-fw"></i> Deletar</button>'
                    ];

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
            'frame_module' => 'Gestão Matéria-Prima &raquo Cadastros',
            'frame_title' => 'Setores',
            'frame_time' => '',
            'next_link' => ''
        ];

        $this->load->view('template/header_html');
        $this->load->view('template/header', $header);
        $this->load->view('raw_material/sector/list', $data);
        $this->load->view('template/footer');
        $this->load->view('template/footer_html');
    }

    public function form($id = null)
    {
        $this->session->set_flashdata('notification', CONF_MESSAGE_UNAUTHORIZED);

        redirect('materia_prima/cadastro/setor/lst');

        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('name', 'nome', 'required');

            if (!$this->form_validation->run()) {
                $response = [
                    'notification' => validation_message(validation_errors())
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

        if ($id && !$this->sector_model->find_by_id($id)) {
            $this->session->set_flashdata('notification', CONF_MESSAGE_UPDATE_INVALID);

            redirect('materia_prima/cadastro/setor/lst');
        }

        if ($id) {
            $sector = $this->sector_model->find_by_id($id);
        } else {
            $sector = [
                'id' => '',
                'name' => ''
            ];
        }

        $header = [
            'countdown' => ''
        ];

        $data = [
            'frame_icon' => 'far fa-window-maximize',
            'frame_module' => 'Gestão Matéria-Prima &raquo Cadastros',
            'frame_title' => 'Setores',
            'frame_time' => '',
            'next_link' => '',
            'sector' => $sector
        ];

        $this->load->view('template/header_html');
        $this->load->view('template/header', $header);
        $this->load->view('raw_material/sector/form', $data);
        $this->load->view('template/footer');
        $this->load->view('template/footer_html');
    }

    public function create()
    {
        if ($this->sector_model->save()) {
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
        if ($this->sector_model->save($id)) {
            $this->session->set_flashdata('notification', CONF_MESSAGE_UPDATE_SUCCESS);

            $response = [
                'redirect' => base_url('materia_prima/cadastro/setor/lst')
            ];

            echo json_encode($response);
            return;
        } else {
            $this->session->set_flashdata('notification', CONF_MESSAGE_UPDATE_ERROR);

            $response = [
                'redirect' => base_url('materia_prima/cadastro/setor/lst')
            ];

            echo json_encode($response);
            return;
        }

        return;
    }

    public function delete()
    {
        if ($this->input->is_ajax_request()) {
            $response = [
                'notification' => CONF_MESSAGE_UNAUTHORIZED,
                'result' => FALSE
            ];

            echo json_encode($response);
            return;

            if (!$this->input->post('id')) {
                $response = [
                    'notification' => CONF_MESSAGE_DELETE_EMPTY,
                    'result' => FALSE
                ];

                echo json_encode($response);
                return;
            }

            if (!$this->sector_model->find_by_id($this->input->post('id'))) {
                $response = [
                    'notification' => CONF_MESSAGE_DELETE_INVALID,
                    'result' => FALSE
                ];

                echo json_encode($response);
                return;
            }

            if ($this->machine_model->destroy($this->input->post('id'))) {
                $this->session->set_flashdata('notification', CONF_MESSAGE_DELETE_SUCCESS);

                $response = [
                    'redirect' => base_url('materia_prima/cadastro/setor/lst')
                ];

                echo json_encode($response);
                return;
            } else {
                $this->session->set_flashdata('notification', CONF_MESSAGE_DELETE_ERROR);

                $response = [
                    'redirect' => base_url('materia_prima/cadastro/setor/lst')
                ];

                echo json_encode($response);
                return;
            }

            return;
        }
    }

}
