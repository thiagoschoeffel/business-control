<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Molded extends CI_Controller
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
    }

    public function index($requisition)
    {
        if ($this->input->is_ajax_request()) {
            $response = [
                'find' => $this->molded_model->find_all($requisition),
                'data' => []
            ];

            if ($response['find']) {
                for ($i = 0; $i < count($response['find']); $i++)
                {
                    $options = [
                        'edit' => '<a title="Editar Registro" href="' . base_url('materia_prima/movimento/apontamento/moldado/frm/' . $requisition . '/' . $response['find'][$i]['id']) . '" class="btn btn-sm btn-dark"><i class="fas fa-pencil-alt fa-fw"></i> Editar</a>',
                        'delete' => '<button title="Deletar Registro" type="button" class="btn btn-sm btn-danger j_app_open_delete_modal" data-toggle="modal" data-target="#j_app_modal_delete" data-register-requisition="' . $response['find'][$i]['requisition'] . '" data-register-id="' . $response['find'][$i]['id'] . '"><i class="fas fa-trash-alt fa-fw"></i> Deletar</button>',
                        'refugee' => '<a title="Gerenciar Refugos" href="' . base_url('materia_prima/movimento/apontamento/moldado/refugo/lst/' . $requisition . '/' . $response['find'][$i]['id']) . '" class="btn btn-sm btn-warning"><i class="fas fa-recycle fa-fw"></i> Refugos</a>',
                    ];

                    $response['find'][$i]['date_time_start'] = date('d/m/Y H:i', strtotime($response['find'][$i]['date_time_start']));
                    $response['find'][$i]['date_time_finish'] = date('d/m/Y H:i', strtotime($response['find'][$i]['date_time_finish']));
                    $response['find'][$i]['quantity'] = number_format($response['find'][$i]['quantity'], 2, ',', '.');
                    $response['find'][$i]['package_weight'] = number_format($response['find'][$i]['package_weight'], 2, ',', '.');
                    $response['find'][$i]['weight_considered_unit'] = number_format($response['find'][$i]['weight_considered_unit'], 2, ',', '.');
                    $response['find'][$i]['total_weight_considered'] = number_format($response['find'][$i]['total_weight_considered'], 2, ',', '.');
                    $response['find'][$i]['molded_refugee_quantity'] = number_format($response['find'][$i]['molded_refugee_quantity'], 2, ',', '.');

                    $data = $response['find'][$i];

                    $response['data'][] = $options + $data;
                }
            }

            unset($response['find']);

            echo json_encode($response);
            return;
        }

        if ($requisition && !$this->requisition_model->find_by_id($requisition)) {
            $this->session->set_flashdata('notification', CONF_MESSAGE_UPDATE_INVALID);

            redirect('materia_prima/movimento/apontamento/lst');
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
            'requisition' => $this->requisition_model->find_by_id($requisition)
        ];

        $data['requisition']['block_count'] = number_format($data['requisition']['block_count'], 2, ',', '.');
        $data['requisition']['block_cubic_meters'] = number_format($data['requisition']['block_cubic_meters'], 4, ',', '.');
        $data['requisition']['block_virgin_weight'] = number_format($data['requisition']['block_virgin_weight'], 2, ',', '.');
        $data['requisition']['block_recycled_weight'] = number_format($data['requisition']['block_recycled_weight'], 2, ',', '.');
        $data['requisition']['molded_quantity'] = number_format($data['requisition']['molded_quantity'], 2, ',', '.');
        $data['requisition']['molded_refugee_quantity'] = number_format($data['requisition']['molded_refugee_quantity'], 2, ',', '.');
        $data['requisition']['molded_total_weight_considered'] = number_format($data['requisition']['molded_total_weight_considered'], 2, ',', '.');

        $this->load->view('template/header_html');
        $this->load->view('template/header', $header);
        $this->load->view('raw_material/molded/list', $data);
        $this->load->view('template/footer');
        $this->load->view('template/footer_html');
    }

    public function form($requisition, $id = null)
    {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('date_time_start', 'data/hora inicial', 'callback_valid_date_time_start');
            $this->form_validation->set_rules('date_time_finish', 'data/hora final', 'callback_valid_date_time_finish[' . $this->input->post('date_time_start') . ']');
            $this->form_validation->set_rules('record', 'ficha', 'required');
            $this->form_validation->set_rules('quantity', 'quantidade', 'required');
            $this->form_validation->set_rules('package_weight', 'peso médio do pacote', 'required');
            $this->form_validation->set_rules('silos[]', 'silos', 'required');
            $this->form_validation->set_rules('operators[]', 'operadores', 'required');

            if (!$this->form_validation->run()) {
                $response = [
                    'notification' => validation_message(validation_errors())
                ];

                echo json_encode($response);
                return;
            }

            if (!$id) {
                $this->create($requisition);
            } else {
                $this->update($requisition, $id);
            }

            return;
        }

        if ($id && !$this->molded_model->find_by_id($requisition, $id)) {
            $this->session->set_flashdata('notification', CONF_MESSAGE_UPDATE_INVALID);

            redirect('materia_prima/movimento/apontamento/moldado/lst/' . $requisition);
        }

        $this->load->model('raw_material/molded_type_model', 'molded_type_model');
        $this->load->model('raw_material/silo_model', 'silo_model');
        $this->load->model('raw_material/operator_model', 'operator_model');

        if ($id) {
            $molded = $this->molded_model->find_by_id($requisition, $id);
        } else {
            $molded = [
                'requisition' => $requisition,
                'id' => '',
                'molded_type' => '',
                'date_time_start' => date('Y-m-d H:i:s'),
                'date_time_finish' => date('Y-m-d H:i:s'),
                'record' => '',
                'quantity' => '',
                'package_weight' => '',
                'silos' => '',
                'operators' => ''
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
            'molded' => $molded,
            'molded_types' => $this->molded_type_model->find_all(),
            'silos' => $this->silo_model->find_all(),
            'operators' => $this->operator_model->find_all(1)
        ];

        $this->load->view('template/header_html');
        $this->load->view('template/header', $header);
        $this->load->view('raw_material/molded/form', $data);
        $this->load->view('template/footer');
        $this->load->view('template/footer_html');
    }

    public function create($requisition)
    {
        if ($this->molded_model->save($requisition)) {
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

    public function update($requisition, $id)
    {
        if ($this->molded_model->save($requisition, $id)) {
            $this->session->set_flashdata('notification', CONF_MESSAGE_UPDATE_SUCCESS);

            $response = [
                'redirect' => base_url('materia_prima/movimento/apontamento/moldado/lst/' . $requisition)
            ];

            echo json_encode($response);
            return;
        } else {
            $this->session->set_flashdata('notification', CONF_MESSAGE_UPDATE_ERROR);

            $response = [
                'redirect' => base_url('materia_prima/movimento/apontamento/moldado/lst/' . $requisition)
            ];

            echo json_encode($response);
            return;
        }

        return;
    }

    public function delete()
    {
        if ($this->input->is_ajax_request()) {
            if (!$this->input->post('requisition') && !$this->input->post('id')) {
                $response = [
                    'notification' => CONF_MESSAGE_DELETE_EMPTY,
                    'result' => FALSE
                ];

                echo json_encode($response);
                return;
            }

            if (!$this->molded_model->find_by_id($this->input->post('requisition'), $this->input->post('id'))) {
                $response = [
                    'notification' => CONF_MESSAGE_DELETE_INVALID,
                    'result' => FALSE
                ];

                echo json_encode($response);
                return;
            }

            if ($this->molded_model->destroy($this->input->post('requisition'), $this->input->post('id'))) {
                $this->session->set_flashdata('notification', CONF_MESSAGE_DELETE_SUCCESS);

                $response = [
                    'redirect' => base_url('materia_prima/movimento/apontamento/moldado/lst/' . $this->input->post('requisition'))
                ];

                echo json_encode($response);
                return;
            } else {
                $this->session->set_flashdata('notification', CONF_MESSAGE_DELETE_ERROR);

                $response = [
                    'redirect' => base_url('materia_prima/movimento/apontamento/moldado/lst/' . $this->input->post('requisition'))
                ];

                echo json_encode($response);
                return;
            }

            return;
        }
    }

    public function valid_date_time_start($date_time_start)
    {
        $dts = DateTime::createFromFormat('d/m/Y H:i:s', $date_time_start);

        if (!$dts) {
            $this->form_validation->set_message('valid_date_time_start', CONF_MESSAGE_DATE_INVALID);
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function valid_date_time_finish($date_time_finish, $date_time_start)
    {
        $dts = DateTime::createFromFormat('d/m/Y H:i:s', $date_time_start);
        $dtf = DateTime::createFromFormat('d/m/Y H:i:s', $date_time_finish);

        if (!$dtf) {
            $this->form_validation->set_message('valid_date_time_finish', CONF_MESSAGE_DATE_INVALID);
            return FALSE;
        } else if ($dtf <= $dts) {
            $this->form_validation->set_message('valid_date_time_finish', CONF_MESSAGE_DATE_INVALID_COMPARE);
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
