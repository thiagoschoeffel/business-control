<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Machine_stop extends CI_Controller
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

        $this->load->model('raw_material/machine_stop_model', 'machine_stop_model');
    }

    public function index()
    {
        if ($this->input->is_ajax_request()) {
            $response = [
                'find' => $this->machine_stop_model->find_all(),
                'data' => []
            ];

            if ($response['find']) {
                for ($i = 0; $i < count($response['find']); $i++)
                {
                    $options = [
                        'edit' => '<a title="Editar Registro" href="' . base_url('materia_prima/movimento/parada/frm/' . $response['find'][$i]['id']) . '" class="btn btn-sm btn-dark"><i class="fas fa-pencil-alt fa-fw"></i> Editar</a>',
                        'delete' => '<button title="Deletar Registro" type="button" class="btn btn-sm btn-danger j_app_open_delete_modal" data-toggle="modal" data-target="#j_app_modal_delete" data-register-id="' . $response['find'][$i]['id'] . '"><i class="fas fa-trash-alt fa-fw"></i> Deletar</button>'
                    ];

                    $response['find'][$i]['date_time_start'] = date('d/m/Y H:i', strtotime($response['find'][$i]['date_time_start']));
                    $response['find'][$i]['date_time_finish'] = date('d/m/Y H:i', strtotime($response['find'][$i]['date_time_finish']));
                    $response['find'][$i]['total_stop_time'] = date('H:i', strtotime($response['find'][$i]['total_stop_time']));

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
            'frame_title' => 'Parada de Máquina',
            'frame_time' => '',
            'next_link' => ''
        ];

        $this->load->view('template/header_html');
        $this->load->view('template/header', $header);
        $this->load->view('raw_material/machine_stop/list', $data);
        $this->load->view('template/footer');
        $this->load->view('template/footer_html');
    }

    public function form($id = null)
    {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('date_time_start', 'data/hora inicial', 'callback_valid_date_time_start');
            $this->form_validation->set_rules('date_time_finish', 'data/hora final', 'callback_valid_date_time_finish[' . $this->input->post('date_time_start') . ']');
            $this->form_validation->set_rules('machine', 'máquina', 'required');
            $this->form_validation->set_rules('reason', 'motivo', 'required');

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

        if ($id && !$this->machine_stop_model->find_by_id($id)) {
            $this->session->set_flashdata('notification', CONF_MESSAGE_UPDATE_INVALID);

            redirect('materia_prima/movimento/parada/lst');
        }

        $this->load->model('raw_material/machine_model', 'machine_model');
        $this->load->model('raw_material/reason_model', 'reason_model');

        if ($id) {
            $machine_stop = $this->machine_stop_model->find_by_id($id);
        } else {
            $machine_stop = [
                'id' => '',
                'date_time_start' => date('Y-m-d H:i:s'),
                'date_time_finish' => date('Y-m-d H:i:s'),
                'machine' => '',
                'reason' => '',
                'note' => ''
            ];
        }

        $header = [
            'countdown' => ''
        ];

        $data = [
            'frame_icon' => 'far fa-window-maximize',
            'frame_module' => 'Gestão Matéria-Prima &raquo Movimentos',
            'frame_title' => 'Parada de Máquina',
            'frame_time' => '',
            'next_link' => '',
            'machine_stop' => $machine_stop,
            'machines' => $this->machine_model->find_all(1),
            'reasons' => $this->reason_model->find_all('MACHINE STOP')
        ];

        $this->load->view('template/header_html');
        $this->load->view('template/header', $header);
        $this->load->view('raw_material/machine_stop/form', $data);
        $this->load->view('template/footer');
        $this->load->view('template/footer_html');
    }

    public function create()
    {
        if ($this->machine_stop_model->save()) {
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
        if ($this->machine_stop_model->save($id)) {
            $this->session->set_flashdata('notification', CONF_MESSAGE_UPDATE_SUCCESS);

            $response = [
                'redirect' => base_url('materia_prima/movimento/parada/lst')
            ];

            echo json_encode($response);
            return;
        } else {
            $this->session->set_flashdata('notification', CONF_MESSAGE_UPDATE_ERROR);

            $response = [
                'redirect' => base_url('materia_prima/movimento/parada/lst')
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

            if (!$this->machine_stop_model->find_by_id($this->input->post('id'))) {
                $response = [
                    'notification' => CONF_MESSAGE_DELETE_INVALID,
                    'result' => FALSE
                ];

                echo json_encode($response);
                return;
            }

            if ($this->machine_stop_model->destroy($this->input->post('id'))) {
                $this->session->set_flashdata('notification', CONF_MESSAGE_DELETE_SUCCESS);

                $response = [
                    'redirect' => base_url('materia_prima/movimento/parada/lst')
                ];

                echo json_encode($response);
                return;
            } else {
                $this->session->set_flashdata('notification', CONF_MESSAGE_DELETE_ERROR);

                $response = [
                    'redirect' => base_url('materia_prima/movimento/parada/lst')
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
