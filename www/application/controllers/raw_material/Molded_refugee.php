<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Molded_refugee extends CI_Controller
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

        $this->load->model('raw_material/requisition_model', 'requisition_model');
        $this->load->model('raw_material/molded_model', 'molded_model');
        $this->load->model('raw_material/molded_refugee_model', 'molded_refugee_model');
    }

    public function index($requisition, $molded)
    {
        if ($this->input->is_ajax_request()) {
            $response = [
                'find' => $this->molded_refugee_model->find_all($molded),
                'data' => []
            ];

            if ($response['find']) {
                for ($i = 0; $i < count($response['find']); $i++)
                {
                    $options = [
                        'edit' => '<a title="Editar Registro" href="' . base_url('materia_prima/movimento/apontamento/moldado/refugo/frm/' . $requisition . '/' . $molded . '/' . $response['find'][$i]['id']) . '" class="btn btn-sm btn-dark"><i class="fas fa-pencil-alt fa-fw"></i> Editar</a>',
                        'delete' => '<button title="Deletar Registro" type="button" class="btn btn-sm btn-danger j_app_open_delete_modal" data-toggle="modal" data-target="#j_app_modal_delete" data-register-molded="' . $response['find'][$i]['molded'] . '" data-register-id="' . $response['find'][$i]['id'] . '"><i class="fas fa-trash-alt fa-fw"></i> Deletar</button>'
                    ];

                    $response['find'][$i]['quantity'] = number_format($response['find'][$i]['quantity'], 2, ',', '.');

                    $data = $response['find'][$i];

                    $response['data'][] = $options + $data;
                }
            }

            unset($response['find']);

            echo json_encode($response);
            return;
        }

        if ($molded && !$this->molded_model->find_by_id($requisition, $molded)) {
            $this->session->set_flashdata('notification', CONF_MESSAGE_UPDATE_INVALID);

            redirect('materia_prima/movimento/apontamento/moldado/lst/' . $requisition);
        }

        $header = [
            'countdown' => ''
        ];

        $data = [
            'frame_icon' => 'far fa-window-maximize',
            'frame_module' => 'Gestão Matéria-Prima &raquo Movimentos',
            'frame_title' => 'Apontamento de Produção',
            'frame_time' => '',
            'next_link' => '',
            'molded' => $this->molded_model->find_by_id($requisition, $molded)
        ];

        $this->load->view('template/header_html');
        $this->load->view('template/header', $header);
        $this->load->view('raw_material/molded_refugee/list', $data);
        $this->load->view('template/footer');
        $this->load->view('template/footer_html');
    }

    public function form($requisition, $molded, $id = null)
    {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('quantity', 'quantidade', 'required');
            $this->form_validation->set_rules('reason', 'reason', 'required');

            if (!$this->form_validation->run()) {
                $response = [
                    'notification' => validation_message(validation_errors())
                ];

                echo json_encode($response);
                return;
            }

            if (!$id) {
                $this->create($molded);
            } else {
                $this->update($requisition, $molded, $id);
            }

            return;
        }

        if ($id && !$this->molded_refugee_model->find_by_id($molded, $id)) {
            $this->session->set_flashdata('notification', CONF_MESSAGE_UPDATE_INVALID);

            redirect('materia_prima/movimento/apontamento/moldado/lst/' . $requisition);
        }

        $this->load->model('raw_material/reason_model', 'reason_model');

        if ($id) {
            $molded_refugee = $this->molded_refugee_model->find_by_id($molded, $id);
        } else {
            $molded_refugee = [
                'requisition' => $requisition,
                'molded' => $molded,
                'id' => '',
                'quantity' => '',
                'reason' => ''
            ];
        }

        $header = [
            'countdown' => ''
        ];

        $data = [
            'frame_icon' => 'far fa-window-maximize',
            'frame_module' => 'Gestão Matéria-Prima &raquo Movimentos',
            'frame_title' => 'Apontamento de Produção',
            'frame_time' => '',
            'next_link' => '',
            'molded' => $this->molded_model->find_by_id($requisition, $molded),
            'molded_refugee' => $molded_refugee,
            'reasons' => $this->reason_model->find_all('MOLDED')
        ];

        $this->load->view('template/header_html');
        $this->load->view('template/header', $header);
        $this->load->view('raw_material/molded_refugee/form', $data);
        $this->load->view('template/footer');
        $this->load->view('template/footer_html');
    }

    public function create($molded)
    {
        if ($this->molded_refugee_model->save($molded)) {
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

    public function update($requisition, $molded, $id)
    {
        if ($this->molded_refugee_model->save($requisition, $molded, $id)) {
            $this->session->set_flashdata('notification', CONF_MESSAGE_UPDATE_SUCCESS);

            $response = [
                'redirect' => base_url('materia_prima/movimento/apontamento/moldado/refugo/lst/' . $requisition . '/' . $molded)
            ];

            echo json_encode($response);
            return;
        } else {
            $this->session->set_flashdata('notification', CONF_MESSAGE_UPDATE_ERROR);

            $response = [
                'redirect' => base_url('materia_prima/movimento/apontamento/moldado/refugo/lst/' . $requisition . '/' . $molded)
            ];

            echo json_encode($response);
            return;
        }

        return;
    }

    public function delete()
    {
        if ($this->input->is_ajax_request()) {
            if (!$this->input->post('molded') && !$this->input->post('id')) {
                $response = [
                    'notification' => CONF_MESSAGE_DELETE_EMPTY,
                    'result' => FALSE
                ];

                echo json_encode($response);
                return;
            }

            if (!$this->molded_refugee_model->find_by_id($this->input->post('molded'), $this->input->post('id'))) {
                $response = [
                    'notification' => CONF_MESSAGE_DELETE_INVALID,
                    'result' => FALSE
                ];

                echo json_encode($response);
                return;
            }

            if ($this->molded_refugee_model->destroy($this->input->post('molded'), $this->input->post('id'))) {
                $this->session->set_flashdata('notification', CONF_MESSAGE_DELETE_SUCCESS);

                $response = [
                    'redirect' => base_url('materia_prima/movimento/apontamento/moldado/refugo/lst/' . $this->input->post('requisition') . '/' . $this->input->post('molded'))
                ];

                echo json_encode($response);
                return;
            } else {
                $this->session->set_flashdata('notification', CONF_MESSAGE_DELETE_ERROR);

                $response = [
                    'redirect' => base_url('materia_prima/movimento/apontamento/moldado/refugo/lst/' . $this->input->post('requisition') . '/' . $this->input->post('molded'))
                ];

                echo json_encode($response);
                return;
            }

            return;
        }
    }

}
