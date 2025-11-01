<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
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

        $this->load->model('raw_material/dashboard_model', 'dashboard_model');
    }

    public function index()
    {
        if ($this->input->is_ajax_request()) {
            $response = [];

            $this->form_validation->set_rules('filter_date_time_finish', 'data/hora final', 'callback_valid_filter_date_time_finish[' . $this->input->post('filter_date_time_start') . ']');

            if (!$this->form_validation->run()) {
                $response = [
                    'notification' => validation_message(validation_errors())
                ];

                echo json_encode($response);
                return;
            }

            //Paradas de Máquina
            $response['resume_stop_machine'] = $this->dashboard_model->resume_stop_machine();

            // Requisições de Matéria-Prima
            $response['resume_requisition'] = $this->dashboard_model->resume_requisition();
            $response['resume_requisition']['requisition_quantity'] = decimal_format($response['resume_requisition']['requisition_quantity'], 2, 'kg');
            $response['resume_requisition']['requisition_quantity_considered'] = decimal_format($response['resume_requisition']['requisition_quantity_considered'], 2, 'kg');

            //Produção de Blocos
            $response['resume_block'] = $this->dashboard_model->resume_block();
            $response['resume_block']['block_count'] = decimal_format($response['resume_block']['block_count'], 2, 'und');
            $response['resume_block']['block_cubic_meters'] = decimal_format($response['resume_block']['block_cubic_meters'], 4, 'm³');
            $response['resume_block']['block_virgin_weight'] = decimal_format($response['resume_block']['block_virgin_weight'], 2, 'kg');
            $response['resume_block']['block_recycled_weight'] = decimal_format($response['resume_block']['block_recycled_weight'], 2, 'kg');

            // Produção de Moldados
            $response['resume_molded'] = $this->dashboard_model->resume_molded();
            $response['resume_molded'] += $this->dashboard_model->resume_moldeds_refugee();
            if ($response['resume_molded']['molded_quantity'] > 0) {
                $response['resume_molded']['molded_total_cubic_meters'] = $response['resume_molded']['molded_quantity'] * 0.02975;
            } else {
                $response['resume_molded']['molded_total_cubic_meters'] = 0;
            }

            // Paradas de Máquina -> Máquina/Quantidade
            $response['chart_machine_stops_by_machine_count']['data'] = [];
            $chart_machine_stops_by_machine_count = $this->dashboard_model->chart_machine_stops_by_machine();
            if ($chart_machine_stops_by_machine_count) {
                foreach ($chart_machine_stops_by_machine_count as $key => $value) {
                    $response['chart_machine_stops_by_machine_count']['data'][] = ['name' => $value['machine_description'], 'y' => (float) $value["machine_stop_count"]];
                }
            }

            // Paradas de Máquina -> Máquina/Tempo
            $response['chart_machine_stops_by_machine_time']['data'] = [];
            $chart_machine_stops_by_machine_time = $this->dashboard_model->chart_machine_stops_by_machine();
            if ($chart_machine_stops_by_machine_time) {
                foreach ($chart_machine_stops_by_machine_time as $key => $value) {
                    $response['chart_machine_stops_by_machine_time']['data'][] = ['name' => $value['machine_description'], 'y' => (float) $value["machine_stop_time"]];
                }
            }

            // Requisições de Matéria-Prima -> Tipo/Quantidade
            $response['chart_requisition_by_raw_material_count']['data'] = [];
            $chart_requisition_by_raw_material_count = $this->dashboard_model->chart_requisition_by_raw_material();
            if ($chart_requisition_by_raw_material_count) {
                foreach ($chart_requisition_by_raw_material_count as $key => $value) {
                    $response['chart_requisition_by_raw_material_count']['data'][] = ['name' => $value['requisition_description'], 'y' => (float) $value["requisition_quantity"]];
                }
            }

            // Requisições de Matéria-Prima -> Data/Quantidade
            $response['chart_requisition_by_date_time_start']['data']['categories'] = [];
            $response['chart_requisition_by_date_time_start']['data']['series'] = [];
            $chart_requisition_by_date_time_start = $this->dashboard_model->chart_requisition_by_date_time_start();
            if ($chart_requisition_by_date_time_start) {
                foreach ($chart_requisition_by_date_time_start as $key => $value) {
                    $response['chart_requisition_by_date_time_start']['data']['categories'][] = $value['requisition_date_time_start'];
                    $response['chart_requisition_by_date_time_start']['data']['series'][] = ['y' => (float) $value["requisition_quantity"]];
                }
            }

            // Produção de Blocos -> Data/Quantidade Produzida
            $response['chart_block_by_date_time_start']['data']['categories'] = [];
            $response['chart_block_by_date_time_start']['data']['series'] = [];
            $chart_block_by_date_time_start = $this->dashboard_model->chart_block_by_date_time_start();
            if ($chart_block_by_date_time_start) {
                foreach ($chart_block_by_date_time_start as $key => $value) {
                    $response['chart_block_by_date_time_start']['data']['categories'][] = $value['block_date_time_start'];
                    $response['chart_block_by_date_time_start']['data']['series'][] = ['y' => (float) $value["block_count"]];
                }
            }

            // Produção de Blocos
            $response['table_block_production_by_type'] = $this->dashboard_model->table_block_production_by_type();
            if ($response['table_block_production_by_type']) {
                foreach ($response['table_block_production_by_type'] as $key => $value) {
                    $response['table_block_production_by_type'][$key]['block_height'] = decimal_format($response['table_block_production_by_type'][$key]['block_height'], 2, '');
                    $response['table_block_production_by_type'][$key]['block_quantity'] = decimal_format($response['table_block_production_by_type'][$key]['block_quantity'], 2, '');
                    $response['table_block_production_by_type'][$key]['block_cubic_meters'] = decimal_format($response['table_block_production_by_type'][$key]['block_cubic_meters'], 4, '');
                    $response['table_block_production_by_type'][$key]['block_virgin_weight'] = decimal_format($response['table_block_production_by_type'][$key]['block_virgin_weight'], 2, '');
                    $response['table_block_production_by_type'][$key]['block_recycled_weight'] = decimal_format($response['table_block_production_by_type'][$key]['block_recycled_weight'], 2, '');
                }
            }

            // Saída de Blocos
            $response['table_block_output_by_type'] = $this->dashboard_model->table_block_output_by_type();
            if ($response['table_block_output_by_type']) {
                foreach ($response['table_block_output_by_type'] as $key => $value) {
                    $response['table_block_output_by_type'][$key]['block_height'] = decimal_format($response['table_block_output_by_type'][$key]['block_height'], 2, '');
                    $response['table_block_output_by_type'][$key]['block_quantity'] = decimal_format($response['table_block_output_by_type'][$key]['block_quantity'], 2, '');
                    $response['table_block_output_by_type'][$key]['block_cubic_meters'] = decimal_format($response['table_block_output_by_type'][$key]['block_cubic_meters'], 4, '');
                    $response['table_block_output_by_type'][$key]['block_virgin_weight'] = decimal_format($response['table_block_output_by_type'][$key]['block_virgin_weight'], 2, '');
                    $response['table_block_output_by_type'][$key]['block_recycled_weight'] = decimal_format($response['table_block_output_by_type'][$key]['block_recycled_weight'], 2, '');
                }
            }

            // Produção de Moldados -> Data/Produzido/Refugado
            $response['chart_molded_by_date_time_start']['data']['categories'] = [];
            $response['chart_molded_by_date_time_start']['data']['series']['production'] = [];
            $response['chart_molded_by_date_time_start']['data']['series']['refugee'] = [];

            $chart_molded_by_date_time_start_production = $this->dashboard_model->chart_molded_by_date_time_start_production();
            $chart_molded_by_date_time_start_refugee = $this->dashboard_model->chart_molded_by_date_time_start_refugee();

            if ($chart_molded_by_date_time_start_production) {
                foreach ($chart_molded_by_date_time_start_production as $key => $value) {
                    $response['chart_molded_by_date_time_start']['data']['categories'][] = $value['molded_date_time_start'];
                    $response['chart_molded_by_date_time_start']['data']['series']['production'][] = ['y' => (float) $value["molded_quantity"]];
                    $response['chart_molded_by_date_time_start']['data']['series']['refugee'][] = ['y' => (float) 0];
                }
            }

            if ($chart_molded_by_date_time_start_refugee) {
                for ($i = 0; $i < count($response['chart_molded_by_date_time_start']['data']['categories']); $i++) {
                    for ($j = 0; $j < count($chart_molded_by_date_time_start_refugee); $j++) {
                        if ($response['chart_molded_by_date_time_start']['data']['categories'][$i] == $chart_molded_by_date_time_start_refugee[$j]['molded_date_time_start']) {
                            $response['chart_molded_by_date_time_start']['data']['series']['refugee'][$i]['y'] = (float) $chart_molded_by_date_time_start_refugee[$j]['molded_refugee_quantity'];
                        }
                    }
                }
            }

            // Ranking de Refugos dos Moldados -> Motivo/Quantidade
            $response['ranking_molded_refugee_by_reason'] = $this->dashboard_model->ranking_molded_refugee_by_reason();
            if ($response['ranking_molded_refugee_by_reason']) {
                foreach ($response['ranking_molded_refugee_by_reason'] as $key => $value) {
                    $response['ranking_molded_refugee_by_reason'][$key]['reason_description'] = (strlen($response['ranking_molded_refugee_by_reason'][$key]['reason_description']) > 20) ? substr($response['ranking_molded_refugee_by_reason'][$key]['reason_description'], 0, 20) . '...' : $response['ranking_molded_refugee_by_reason'][$key]['reason_description'];
                    $response['ranking_molded_refugee_by_reason'][$key]['molded_refugee_quantity'] = decimal_format($response['ranking_molded_refugee_by_reason'][$key]['molded_refugee_quantity'], 2, 'und');
                }
            }

            // Aproveitamento da Produção dos Moldados -> Aproveitamento/Perca
            if ($response['resume_molded']['molded_quantity'] > 0) {
                $response['exploitation_molded_miss'] = ($response['resume_molded']['molded_refugee_quantity'] * 100) / $response['resume_molded']['molded_quantity'];
                $response['exploitation_molded_use'] = 100 - $response['exploitation_molded_miss'];
            } else {
                $response['exploitation_molded_miss'] = 0;
                $response['exploitation_molded_use'] = 0;
            }

            $response['resume_molded']['molded_quantity'] = decimal_format($response['resume_molded']['molded_quantity'], 2, 'und');
            $response['resume_molded']['molded_refugee_quantity'] = decimal_format($response['resume_molded']['molded_refugee_quantity'], 2, 'und');
            $response['resume_molded']['molded_total_cubic_meters'] = decimal_format($response['resume_molded']['molded_total_cubic_meters'], 4, 'm³');
            $response['resume_molded']['molded_total_weight_considered'] = decimal_format($response['resume_molded']['molded_total_weight_considered'], 2, 'kg');
            $response['exploitation_molded_miss'] = decimal_format($response['exploitation_molded_miss'], 2, '%');
            $response['exploitation_molded_use'] = decimal_format($response['exploitation_molded_use'], 2, '%');

            // Estoque de Matéria-Prima -> Tipo/Peso
            $response['table_stock_by_raw_material_type'] = $this->dashboard_model->table_stock_by_raw_material_type();

            if ($response['table_stock_by_raw_material_type']) {
                $total_inventory = 0;
                $total_balance = 0;
                $total_requisition = 0;
                $total_entrance = 0;

                foreach ($response['table_stock_by_raw_material_type'] as $key => $value) {
                    $response['table_stock_by_raw_material_type']['lines'][$key]['description'] = $response['table_stock_by_raw_material_type'][$key]['description'];
                    $response['table_stock_by_raw_material_type']['lines'][$key]['quantity_initial_inventory'] = ($response['table_stock_by_raw_material_type'][$key]['f1'] + $response['table_stock_by_raw_material_type'][$key]['f2']) - $response['table_stock_by_raw_material_type'][$key]['f3'];
                    $response['table_stock_by_raw_material_type']['lines'][$key]['quantity_balance'] = ($response['table_stock_by_raw_material_type']['lines'][$key]['quantity_initial_inventory'] + $response['table_stock_by_raw_material_type'][$key]['quantity_entrance']) - $response['table_stock_by_raw_material_type'][$key]['quantity_requisition'];

                    $total_inventory += $response['table_stock_by_raw_material_type']['lines'][$key]['quantity_initial_inventory'];
                    $total_balance += $response['table_stock_by_raw_material_type'][$key]['quantity_entrance'];
                    $total_requisition += $response['table_stock_by_raw_material_type'][$key]['quantity_requisition'];
                    $total_entrance += $response['table_stock_by_raw_material_type']['lines'][$key]['quantity_balance'];

                    $response['table_stock_by_raw_material_type']['lines'][$key]['quantity_initial_inventory'] = decimal_format($response['table_stock_by_raw_material_type']['lines'][$key]['quantity_initial_inventory'], 2, '');
                    $response['table_stock_by_raw_material_type']['lines'][$key]['quantity_entrance'] = decimal_format($response['table_stock_by_raw_material_type'][$key]['quantity_entrance'], 2, '');
                    $response['table_stock_by_raw_material_type']['lines'][$key]['quantity_requisition'] = decimal_format($response['table_stock_by_raw_material_type'][$key]['quantity_requisition'], 2, '');
                    $response['table_stock_by_raw_material_type']['lines'][$key]['quantity_balance'] = decimal_format($response['table_stock_by_raw_material_type']['lines'][$key]['quantity_balance'], 2, '');

                    if ($response['table_stock_by_raw_material_type']['lines'][$key]['quantity_initial_inventory'] == 0 && $response['table_stock_by_raw_material_type'][$key]['quantity_entrance'] == 0 && $response['table_stock_by_raw_material_type'][$key]['quantity_requisition'] == 0 && $response['table_stock_by_raw_material_type']['lines'][$key]['quantity_balance'] == 0) {
                        unset($response['table_stock_by_raw_material_type']['lines'][$key]);
                    }

                    unset($response['table_stock_by_raw_material_type'][$key]);
                }

                $response['table_stock_by_raw_material_type']['total_inventory'] = decimal_format($total_inventory, 2, '');
                $response['table_stock_by_raw_material_type']['total_balance'] = decimal_format($total_balance, 2, '');
                $response['table_stock_by_raw_material_type']['total_requisition'] =  decimal_format($total_requisition, 2, '');
                $response['table_stock_by_raw_material_type']['total_entrance'] = decimal_format($total_entrance, 2, '');
            }

            // Estoque de Blocos -> Tipo/Altura
            $response['blocks_balance'] = $this->dashboard_model->table_stock_by_block();

            if ($response['blocks_balance']) {
                foreach ($response['blocks_balance'] as $key => $value) {
                    $response['blocks_balance'][$key]['block_height'] = decimal_format($response['blocks_balance'][$key]['block_height'], 0, '');
                    $response['blocks_balance'][$key]['block_quantity_initial_inventory'] = decimal_format($response['blocks_balance'][$key]['block_quantity_initial_inventory'], 0, '');
                    $response['blocks_balance'][$key]['block_quantity_production'] = decimal_format($response['blocks_balance'][$key]['block_quantity_production'], 0, '');
                    $response['blocks_balance'][$key]['block_quantity_output'] = decimal_format($response['blocks_balance'][$key]['block_quantity_output'], 0, '');
                    $response['blocks_balance'][$key]['block_quantity_balance'] = decimal_format($response['blocks_balance'][$key]['block_quantity_balance'], 0, '');
                    $response['blocks_balance'][$key]['block_cubic_meters_balance'] = decimal_format($response['blocks_balance'][$key]['block_cubic_meters_balance'], 4, '');
                }
            }

            // Estoque de Moldados -> Tipo/Quantidade
            $molded_prodution = $this->dashboard_model->table_stock_by_raw_moldeds_production();
            $molded_output = $this->dashboard_model->table_stock_by_raw_moldeds_output();
            $molded_balance = [];

            for ($i = 0; $i < count($molded_prodution); $i++) {
                $molded_balance[] = [
                    'molded_description' => $molded_prodution[$i]['molded_description'],
                    'molded_quantity' => $molded_prodution[$i]['molded_quantity'],
                    'molded_package_quantity' => $molded_prodution[$i]['molded_package_quantity']
                ];
            }

            for ($i = 0; $i < count($molded_output); $i++) {
                for ($j = 0; $j < count($molded_balance); $j++) {
                    if (
                        $molded_output[$i]['molded_description'] == $molded_balance[$j]['molded_description']

                    ) {
                        $molded_balance[$j]['molded_quantity'] = $molded_balance[$j]['molded_quantity'] - $molded_output[$i]['molded_quantity'];
                    }
                }
            }

            $response['molded_balance'] = $molded_balance;
            if ($response['molded_balance']) {
                foreach ($response['molded_balance'] as $key => $value) {

                    $response['molded_balance'][$key]['molded_quantity'] = decimal_format($response['molded_balance'][$key]['molded_quantity'], 3, '');
                }
            }

            // Return
            echo json_encode($response);
            return;
        }

        $header = [
            'countdown' => ''
        ];

        $data = [
            'frame_icon' => 'far fa-window-maximize',
            'frame_module' => 'Gestão de Matéria-Prima',
            'frame_title' => 'Dashboard',
            'frame_time' => '',
            'next_link' => ''
        ];

        $this->load->view('template/header_html');
        $this->load->view('template/header', $header);
        $this->load->view('raw_material/dashboard', $data);
        $this->load->view('template/footer');
        $this->load->view('template/footer_html');
    }

    public function valid_filter_date_time_start($date_time_start)
    {
        $dts = DateTime::createFromFormat('d/m/Y H:i:s', $date_time_start);

        if (!$dts) {
            $this->form_validation->set_message('valid_filter_date_time_start', CONF_MESSAGE_DATE_INVALID);
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function valid_filter_date_time_finish($date_time_finish, $date_time_start)
    {
        $dts = DateTime::createFromFormat('d/m/Y H:i:s', $date_time_start);
        $dtf = DateTime::createFromFormat('d/m/Y H:i:s', $date_time_finish);

        if (!$dtf) {
            $this->form_validation->set_message('valid_filter_date_time_finish', CONF_MESSAGE_DATE_INVALID);
            return FALSE;
        } else if ($dtf <= $dts) {
            $this->form_validation->set_message('valid_filter_date_time_finish', CONF_MESSAGE_DATE_INVALID_COMPARE);
            return FALSE;
        } else {
            return TRUE;
        }
    }
}
