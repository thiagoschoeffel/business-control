<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Molded_output extends CI_Controller
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

        $this->load->model('raw_material/molded_output_model', 'molded_output_model');
    }

    public function index()
    {
        if ($this->input->is_ajax_request()) {
            $response = [
                'find' => $this->molded_output_model->find_all(),
                'data' => []
            ];

            if ($response['find']) {
                for ($i = 0; $i < count($response['find']); $i++)
                {
                    $options = [
                        'edit' => '<a title="Editar Registro" href="' . base_url('materia_prima/movimento/saida_moldado/frm/' . $response['find'][$i]['id']) . '" class="btn btn-sm btn-dark"><i class="fas fa-pencil-alt fa-fw"></i> Editar</a>',
                        'delete' => '<button title="Deletar Registro" type="button" class="btn btn-sm btn-danger j_app_open_delete_modal" data-toggle="modal" data-target="#j_app_modal_delete" data-register-id="' . $response['find'][$i]['id'] . '"><i class="fas fa-trash-alt fa-fw"></i> Deletar</button>'
                    ];

                    $response['find'][$i]['date_time_output'] = date('d/m/Y H:i', strtotime($response['find'][$i]['date_time_output']));
                    $response['find'][$i]['quantity_output'] = number_format($response['find'][$i]['quantity_output'], 3, ',', '.');

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
            'frame_module' => 'Gestão Matéria-Prima &raquo Movimentos',
            'frame_title' => 'Saída de Moldados',
            'frame_time' => '',
            'next_link' => ''
        ];

        $this->load->view('template/header_html');
        $this->load->view('template/header', $header);
        $this->load->view('raw_material/molded_output/list', $data);
        $this->load->view('template/footer');
        $this->load->view('template/footer_html');
    }

    public function form($id = null)
    {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('date_time_output', 'data/hora saída', 'callback_valid_date_time_output');
            $this->form_validation->set_rules('molded_type', 'tipo moldado', 'required');
            $this->form_validation->set_rules('quantity_output', 'quantidade saída', 'required');
            $this->form_validation->set_rules('fabrication_order', 'ordem de fabricação', 'required');
            $this->form_validation->set_rules('requisition_operators[]', 'operador requisição', 'required');
            $this->form_validation->set_rules('output_operators[]', 'operador retirada', 'required');

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

        if ($id && !$this->molded_output_model->find_by_id($id)) {
            $this->session->set_flashdata('notification', CONF_MESSAGE_UPDATE_INVALID);

            redirect('materia_prima/movimento/saida_bloco/lst');
        }

        $this->load->model('raw_material/molded_type_model', 'molded_type_model');
        $this->load->model('raw_material/operator_model', 'operator_model');

        if ($id) {
            $molded_output = $this->molded_output_model->find_by_id($id);
        } else {
            $molded_output = [
                'id' => '',
                'date_time_output' =>  date('Y-m-d H:i:s'),
                'molded_type' => '',
                'quantity_output' => '',
                'fabrication_order' => '',
                'requisition_operators' => '',
                'output_operators' => '',
            ];
        }

        $header = [
            'countdown' => ''
        ];

        $data = [
            'frame_icon' => 'far fa-window-maximize',
            'frame_module' => 'Gestão Matéria-Prima &raquo Movimentos',
            'frame_title' => 'Saída de Moldados',
            'frame_time' => '',
            'next_link' => '',
            'molded_types' => $this->molded_type_model->find_all(),
            'requisition_operators' => $this->operator_model->find_all(3),
            'output_operators' => $this->operator_model->find_all(3),
            'molded_output' => $molded_output
        ];

        $this->load->view('template/header_html');
        $this->load->view('template/header', $header);
        $this->load->view('raw_material/molded_output/form', $data);
        $this->load->view('template/footer');
        $this->load->view('template/footer_html');
    }

    public function create()
    {
        if ($this->molded_output_model->save()) {
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
        if ($this->molded_output_model->save($id)) {
            $this->session->set_flashdata('notification', CONF_MESSAGE_UPDATE_SUCCESS);

            $response = [
                'redirect' => base_url('materia_prima/movimento/saida_moldado/lst')
            ];

            echo json_encode($response);
            return;
        } else {
            $this->session->set_flashdata('notification', CONF_MESSAGE_UPDATE_ERROR);

            $response = [
                'redirect' => base_url('materia_prima/movimento/saida_moldado/lst')
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

            if (!$this->molded_output_model->find_by_id($this->input->post('id'))) {
                $response = [
                    'notification' => CONF_MESSAGE_DELETE_INVALID,
                    'result' => FALSE
                ];

                echo json_encode($response);
                return;
            }

            if ($this->molded_output_model->destroy($this->input->post('id'))) {
                $this->session->set_flashdata('notification', CONF_MESSAGE_DELETE_SUCCESS);

                $response = [
                    'redirect' => base_url('materia_prima/movimento/saida_moldado/lst')
                ];

                echo json_encode($response);
                return;
            } else {
                $this->session->set_flashdata('notification', CONF_MESSAGE_DELETE_ERROR);

                $response = [
                    'redirect' => base_url('materia_prima/movimento/saida_moldado/lst')
                ];

                echo json_encode($response);
                return;
            }

            return;
        }
    }

    public function valid_date_time_output($date_time_output)
    {
        $dts = DateTime::createFromFormat('d/m/Y H:i:s', $date_time_output);

        if (!$dts) {
            $this->form_validation->set_message('valid_date_time_output', CONF_MESSAGE_DATE_INVALID);
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
