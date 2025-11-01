<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Block_output extends CI_Controller
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

        $this->load->model('raw_material/block_output_model', 'block_output_model');
    }

    public function index()
    {
        $total_rows = $this->block_output_model->count_all();
        $pagination_config = [
            'base_url' => base_url('materia_prima/movimento/saida_bloco/lst'),
            'per_page' => 10,
            'num_links' => 5,
            'uri_segment' => 5,
            'total_rows' => $total_rows,
            'full_tag_open' => '<ul class="pagination pagination-sm mb-0 mt-4">',
            'full_tag_close' => '</ul>',
            'first_link' => '<i class="fas fa-angle-double-left"></i>',
            'last_link' => '<i class="fas fa-angle-double-right"></i>',
            'first_tag_open' => '<li class="page-item">',
            'first_tag_close' => '</li>',
            'prev_link' => '<i class="fas fa-angle-left"></i>',
            'prev_tag_open' => '<li class="page-item prev">',
            'prev_tag_close' => '</li>',
            'next_link' => '<i class="fas fa-angle-right"></i>',
            'next_tag_open' => '<li class="page-item">',
            'next_tag_close' => '</li>',
            'last_tag_open' => '<li class="page-item">',
            'last_tag_close' => '</li>',
            'cur_tag_open' => '<li class="page-item active"><a href="#" class="page-link">',
            'cur_tag_close' => '</a></li>',
            'num_tag_open' => '<li class="page-item">',
            'num_tag_close' => '</li>',
            'attributes' => ['class' => 'page-link']
        ];

        $this->load->library('pagination');
        $this->pagination->initialize($pagination_config);

        $pagination_offset = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;

        $header = [
            'countdown' => ''
        ];

        $this->load->model('raw_material/block_type_model', 'block_type_model');

        $data = [
            'frame_icon' => 'far fa-window-maximize',
            'frame_module' => 'Gestão Matéria-Prima &raquo Movimentos',
            'frame_title' => 'Saída de Blocos',
            'frame_time' => '',
            'next_link' => '',
            'block_types' => $this->block_type_model->find_all(),
            'blocks_output' => $this->block_output_model->find_all($pagination_config['per_page'], $pagination_offset),
            'pagination_links' => $this->pagination->create_links()
        ];

        $this->load->view('template/header_html');
        $this->load->view('template/header', $header);
        $this->load->view('raw_material/block_output/list', $data);
        $this->load->view('template/footer');
        $this->load->view('template/footer_html');
    }

    public function filter()
    {
        if (!$this->input->is_ajax_request()) {
            redirect('materia_prima/movimento/saida_bloco/lst');
        }

        $data = [
            'id' => $this->input->post('id'),
            'date_time_output_start' => $this->input->post('date_time_output_start'),
            'date_time_output_finish' => $this->input->post('date_time_output_finish'),
            'requisition' => $this->input->post('requisition'),
            'fabrication_order' => $this->input->post('fabrication_order'),
            'block_type' => $this->input->post('block_type'),
            'block_height' => $this->input->post('block_height')
        ];

        if (!empty($data['id'])) {
            $this->form_validation->set_rules('id', 'código', 'integer');
        }

        if (!empty($data['date_time_output_start']) || !empty($data['date_time_output_finish'])) {
            $this->form_validation->set_rules('date_time_output_start', 'data/hora inicial', 'callback_valid_date_time_output_start');
            $this->form_validation->set_rules('date_time_output_finish', 'data/hora final', 'callback_valid_date_time_output_finish[' . $data['date_time_output_start'] . ']');
        }

        if (!empty($data['requisition'])) {
            $this->form_validation->set_rules('requisition', 'requisição', 'integer');
        }

        if (!empty($data['fabrication_order'])) {
            $this->form_validation->set_rules('fabrication_order', 'ordem de fabricação', 'integer');
        }

        if (!empty($data['block_type'])) {
            $this->form_validation->set_rules('block_type', 'tipo de bloco', 'integer');
        }

        if (!empty($data['block_height'])) {
            $this->form_validation->set_rules('block_height', 'altura do bloco', 'integer');
        }

        if (
            !empty($data['id']) ||
            !empty($data['date_time_output_start']) ||
            !empty($data['date_time_output_finish']) ||
            !empty($data['requisition']) ||
            !empty($data['fabrication_order']) ||
            !empty($data['block_type']) ||
            !empty($data['block_height'])
        ) {
            if (!$this->form_validation->run()) {
                $response = [
                    'notification' => validation_message(validation_errors())
                ];

                echo json_encode($response);
                return;
            }
        }

        $this->session->set_userdata('list_block_output_filter_id', $data['id']);
        $this->session->set_userdata('list_block_output_filter_date_time_output_start', $data['date_time_output_start']);
        $this->session->set_userdata('list_block_output_filter_date_time_output_finish', $data['date_time_output_finish']);
        $this->session->set_userdata('list_block_output_filter_requisition', $data['requisition']);
        $this->session->set_userdata('list_block_output_filter_fabrication_order', $data['fabrication_order']);
        $this->session->set_userdata('list_block_output_filter_block_type', $data['block_type']);
        $this->session->set_userdata('list_block_output_filter_block_height', $data['block_height']);

        $response['redirect'] = base_url('materia_prima/movimento/saida_bloco/lst');

        echo json_encode($response);
        return;
    }

    public function get_available_blocks()
    {
        if (!$this->input->is_ajax_request()) {
            redirect('materia_prima/movimento/saida_bloco/frm');
        }

        $data = [
            'requisition' => $this->input->post('requisition')
        ];

        $response = $this->block_output_model->find_available($data['requisition']);

        echo json_encode($response);
        return;
    }

    public function form($id = null)
    {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('date_time_output', 'data/hora saída', 'callback_valid_date_time_output');

            if (!$id) {
                $this->form_validation->set_rules('requisition', 'requisição', 'required');
                $this->form_validation->set_rules('requisition_sequence[]', 'sequência requisição', 'required');
            }

            $this->form_validation->set_rules('fabrication_order', 'ordem de fabricação', 'required');

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

        if ($id && !$this->block_output_model->find_by_id($id)) {
            $this->session->set_flashdata('notification', CONF_MESSAGE_UPDATE_INVALID);

            redirect('materia_prima/movimento/saida_bloco/lst');
        }

        if ($id) {
            $block_output = $this->block_output_model->find_by_id($id);
        } else {
            $block_output = [
                'id' => '',
                'date_time_output' => date('Y-m-d H:i:s'),
                'requisition' => '',
                'fabrication_order' => '',
            ];
        }

        $header = [
            'countdown' => ''
        ];

        $data = [
            'frame_icon' => 'far fa-window-maximize',
            'frame_module' => 'Gestão Matéria-Prima &raquo Movimentos',
            'frame_title' => 'Saída de Blocos',
            'frame_time' => '',
            'next_link' => '',
            'block_output' => $block_output
        ];

        $this->load->view('template/header_html');
        $this->load->view('template/header', $header);
        $this->load->view('raw_material/block_output/form', $data);
        $this->load->view('template/footer');
        $this->load->view('template/footer_html');
    }

    public function create()
    {
        if ($this->block_output_model->save()) {
            $response = [
                'notification' => CONF_MESSAGE_INSERT_SUCCESS,
                'result' => true,

            ];
        } else {
            $response = [
                'notification' => CONF_MESSAGE_INSERT_ERROR,
                'result' => false
            ];
        }

        echo json_encode($response);
        return;
    }

    public function update($id)
    {
        if ($this->block_output_model->save($id)) {
            $this->session->set_flashdata('notification', CONF_MESSAGE_UPDATE_SUCCESS);

            $response = [
                'redirect' => base_url('materia_prima/movimento/saida_bloco/lst')
            ];

            echo json_encode($response);
            return;
        } else {
            $this->session->set_flashdata('notification', CONF_MESSAGE_UPDATE_ERROR);

            $response = [
                'redirect' => base_url('materia_prima/movimento/saida_bloco/lst')
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
                    'result' => false
                ];

                echo json_encode($response);
                return;
            }

            if (!$this->block_output_model->find_by_id($this->input->post('id'))) {
                $response = [
                    'notification' => CONF_MESSAGE_DELETE_INVALID,
                    'result' => false
                ];

                echo json_encode($response);
                return;
            }

            if ($this->block_output_model->destroy($this->input->post('id'))) {
                $this->session->set_flashdata('notification', CONF_MESSAGE_DELETE_SUCCESS);

                $response = [
                    'redirect' => base_url('materia_prima/movimento/saida_bloco/lst')
                ];

                echo json_encode($response);
                return;
            } else {
                $this->session->set_flashdata('notification', CONF_MESSAGE_DELETE_ERROR);

                $response = [
                    'redirect' => base_url('materia_prima/movimento/saida_bloco/lst')
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
            return false;
        } else {
            return true;
        }
    }

    public function valid_date_time_output_start($date_time_output)
    {
        $dts = DateTime::createFromFormat('d/m/Y H:i:s', $date_time_output);

        if (!$dts) {
            $this->form_validation->set_message('valid_date_time_output_start', 'O campo data/hora saída inicial é inválido, lembre-se de preencher a data/hora final e inicial');
            return false;
        } else {
            return true;
        }
    }

    public function valid_date_time_output_finish($date_time_finish, $date_time_start)
    {
        $dts = DateTime::createFromFormat('d/m/Y H:i:s', $date_time_start);
        $dtf = DateTime::createFromFormat('d/m/Y H:i:s', $date_time_finish);

        if (!$dtf) {
            $this->form_validation->set_message('valid_date_time_output_finish', 'O campo data/hora saída final é inválido, lembre-se de preencher a data/hora final e inicial');
            return false;
        } elseif ($dtf <= $dts) {
            $this->form_validation->set_message('valid_date_time_output_finish', 'A data/hora saída inicial não deve ser maior que a data/hora saída final.');
            return false;
        } else {
            return true;
        }
    }
}
