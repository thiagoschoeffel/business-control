<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{

    private $filter_date_time_start;
    private $filter_date_time_finish;

    public function __construct()
    {
        parent::__construct();
    }

    private function setFilter()
    {
        $this->filter_date_time_start = datetime_br_to_db($this->input->post('filter_date_time_start'));
        $this->filter_date_time_finish = datetime_br_to_db($this->input->post('filter_date_time_finish'));
    }

    public function resume_stop_machine()
    {
        $this->setFilter();

        $this->db->select('COUNT(a.id) AS machine_stop_count, SUM(TIMESTAMPDIFF(SECOND, a.date_time_start, a.date_time_finish)) AS machine_stop_time');
        $this->db->from('rwm_machine_stops a');
        $this->db->where("a.date_time_start BETWEEN '" . $this->filter_date_time_start . "' AND '" . $this->filter_date_time_finish . "'");

        return $this->db->get()->row_array();
    }

    public function resume_requisition()
    {
        $this->setFilter();

        $this->db->select('SUM(a.quantity) AS requisition_quantity, SUM(a.quantity_considered) AS requisition_quantity_considered');
        $this->db->from('rwm_requisitions a');
        $this->db->where("a.date_time_start BETWEEN '" . $this->filter_date_time_start . "' AND '" . $this->filter_date_time_finish . "'");

        return $this->db->get()->row_array();
    }

    public function resume_block()
    {
        $this->setFilter();

        $this->db->select('COUNT(a.id) AS block_count, SUM(a.cubic_meters) AS block_cubic_meters, SUM(a.virgin_weight) AS block_virgin_weight, SUM(a.recycled_weight) AS block_recycled_weight');
        $this->db->from('rwm_blocks a');
        $this->db->where("a.date_time_start BETWEEN '" . $this->filter_date_time_start . "' AND '" . $this->filter_date_time_finish . "'");

        return $this->db->get()->row_array();
    }

    public function resume_molded()
    {
        $this->setFilter();

        $this->db->select("SUM(a.quantity) AS molded_quantity, SUM(a.total_weight_considered) AS molded_total_weight_considered");
        $this->db->from('rwm_moldeds a');
        $this->db->where("a.date_time_start BETWEEN '" . $this->filter_date_time_start . "' AND '" . $this->filter_date_time_finish . "'");

        return $this->db->get()->row_array();
    }

    public function resume_moldeds_refugee()
    {
        $this->setFilter();

        $this->db->select("SUM(a.quantity) AS molded_refugee_quantity");
        $this->db->from('rwm_molded_refugees a, rwm_moldeds b');
        $this->db->where('a.molded = b.id');
        $this->db->where("b.date_time_start BETWEEN '" . $this->filter_date_time_start . "' AND '" . $this->filter_date_time_finish . "'");

        return $this->db->get()->row_array();
    }

    public function chart_machine_stops_by_machine()
    {
        $this->setFilter();

        $this->db->select('b.name AS machine_description, COUNT(a.id) AS machine_stop_count, SUM(TIMESTAMPDIFF(SECOND, a.date_time_start, a.date_time_finish)) AS machine_stop_time');
        $this->db->from('rwm_machine_stops a');
        $this->db->join('rwm_machines b', 'b.id = a.machine');
        $this->db->where("a.date_time_start BETWEEN '" . $this->filter_date_time_start . "' AND '" . $this->filter_date_time_finish . "'");
        $this->db->group_by('machine_description');

        return $this->db->get()->result_array();
    }

    public function chart_requisition_by_raw_material()
    {
        $this->setFilter();

        $this->db->select('b.description AS requisition_description, SUM(a.quantity) AS requisition_quantity, SUM(a.quantity_considered) AS requisition_quantity_considered');
        $this->db->from('rwm_requisitions a, rwm_raw_materials b');
        $this->db->where('a.raw_material = b.id');
        $this->db->where("a.date_time_start BETWEEN '" . $this->filter_date_time_start . "' AND '" . $this->filter_date_time_finish . "'");
        $this->db->group_by('requisition_description');

        return $this->db->get()->result_array();
    }

    public function chart_requisition_by_date_time_start()
    {
        $this->setFilter();

        $this->db->select("DATE_FORMAT(a.date_time_start, '%d/%m/%Y') AS requisition_date_time_start, SUM(a.quantity) AS requisition_quantity, SUM(a.quantity_considered) AS requisition_quantity_considered");
        $this->db->from('rwm_requisitions a');
        $this->db->where("a.date_time_start BETWEEN '" . $this->filter_date_time_start . "' AND '" . $this->filter_date_time_finish . "'");
        $this->db->group_by('requisition_date_time_start');
        $this->db->order_by('requisition_date_time_start', 'DESC');

        return $this->db->get()->result_array();
    }

    public function chart_block_by_date_time_start()
    {
        $this->setFilter();

        $this->db->select("DATE_FORMAT(a.date_time_start, '%d/%m/%Y') AS block_date_time_start, COUNT(a.id) AS block_count");
        $this->db->from('rwm_blocks a');
        $this->db->where("a.date_time_start BETWEEN '" . $this->filter_date_time_start . "' AND '" . $this->filter_date_time_finish . "'");
        $this->db->group_by('block_date_time_start');
        $this->db->order_by('block_date_time_start', 'DESC');

        return $this->db->get()->result_array();
    }

    public function table_block_production_by_type()
    {
        $this->setFilter();

        $this->db->select("b.description AS block_description, a.height AS block_height, COUNT(a.id) AS block_quantity, SUM(a.cubic_meters) AS block_cubic_meters, SUM(a.virgin_weight) AS block_virgin_weight, SUM(a.recycled_weight) AS block_recycled_weight");
        $this->db->from('rwm_blocks a, rwm_block_types b');
        $this->db->where('a.block_type = b.id');
        $this->db->where("a.date_time_start BETWEEN '" . $this->filter_date_time_start . "' AND '" . $this->filter_date_time_finish . "'");
        $this->db->group_by('block_description, block_height');
        $this->db->order_by('block_description, block_height');

        return $this->db->get()->result_array();
    }

    public function table_block_output_by_type()
    {
        $this->setFilter();

        $this->db->select("b.description AS block_description, a.height AS block_height, COUNT(a.id) AS block_quantity, SUM(a.cubic_meters) AS block_cubic_meters, SUM(a.virgin_weight) AS block_virgin_weight, SUM(a.recycled_weight) AS block_recycled_weight");
        $this->db->from('rwm_blocks a, rwm_block_types b, rwm_blocks_output c');
        $this->db->where('a.block_type = b.id');
        $this->db->where('a.requisition = c.requisition');
        $this->db->where('a.requisition_sequence = c.requisition_sequence');
        $this->db->where("c.date_time_output BETWEEN '" . $this->filter_date_time_start . "' AND '" . $this->filter_date_time_finish . "'");
        $this->db->group_by('block_description, block_height');
        $this->db->order_by('block_description, block_height');

        return $this->db->get()->result_array();
    }

    public function chart_molded_by_date_time_start_production()
    {
        $this->setFilter();

        $this->db->select("DATE_FORMAT(a.date_time_start, '%d/%m/%Y') AS molded_date_time_start, SUM(a.quantity) AS molded_quantity");
        $this->db->from('rwm_moldeds a');
        $this->db->where("a.date_time_start BETWEEN '" . $this->filter_date_time_start . "' AND '" . $this->filter_date_time_finish . "'");
        $this->db->group_by('molded_date_time_start');

        return $this->db->get()->result_array();
    }

    public function chart_molded_by_date_time_start_refugee()
    {
        $this->setFilter();

        $this->db->select("DATE_FORMAT(b.date_time_start, '%d/%m/%Y') AS molded_date_time_start, SUM(a.quantity) AS molded_refugee_quantity");
        $this->db->from('rwm_molded_refugees a');
        $this->db->join('rwm_moldeds b', 'b.id = a.molded', 'inner');
        $this->db->where("b.date_time_start BETWEEN '" . $this->filter_date_time_start . "' AND '" . $this->filter_date_time_finish . "'");
        $this->db->group_by('molded_date_time_start');

        return $this->db->get()->result_array();
    }

    public function ranking_molded_refugee_by_reason()
    {
        $this->setFilter();

        $this->db->select("b.description AS reason_description, SUM(c.quantity) AS molded_refugee_quantity");
        $this->db->from('rwm_moldeds a, rwm_reasons b');
        $this->db->join('rwm_molded_refugees c', 'a.id = c.molded', 'left outer');
        $this->db->where('c.reason = b.id');
        $this->db->where("a.date_time_start BETWEEN '" . $this->filter_date_time_start . "' AND '" . $this->filter_date_time_finish . "'");
        $this->db->group_by('reason_description');
        $this->db->order_by('molded_refugee_quantity', 'DESC');
        $this->db->limit(3);

        return $this->db->get()->result_array();
    }

    public function table_stock_by_raw_material_type()
    {
        $this->setFilter();

        $this->db->select("a.description, (select b.quantity_initial_inventory from rwm_raw_materials b where b.id = a.id and b.date_initial_inventory < '" . $this->filter_date_time_start . "') as f1, (select sum(c.quantity) from rwm_raw_material_entrances c where c.raw_material = a.id and c.date_time_entrance < '" . $this->filter_date_time_start . "') as f2, (select sum(d.quantity) from rwm_requisitions d where d.raw_material = a.id and d.date_time_start < '" . $this->filter_date_time_start . "') as f3, (select sum(e.quantity) from rwm_raw_material_entrances e where e.raw_material = a.id and e.date_time_entrance between '" . $this->filter_date_time_start . "' and '" . $this->filter_date_time_finish . "') as quantity_entrance, (select sum(f.quantity) from rwm_requisitions f where f.raw_material = a.id and f.date_time_start between '" . $this->filter_date_time_start . "' and '" . $this->filter_date_time_finish . "') as quantity_requisition");
        $this->db->from('rwm_raw_materials a');
        $this->db->group_by('a.description, f1, f2, f3, quantity_entrance, quantity_requisition');
        $this->db->order_by('a.description');

        return $this->db->get()->result_array();
    }

    public function table_stock_by_block()
    {
        $this->setFilter();
        $fs = $this->filter_date_time_start;
        $fe = $this->filter_date_time_finish;

        $inner = "
          SELECT
            t.description AS block_description,
            b.height AS block_height,
    
            /* Inicial (und) */
            COALESCE((
              SELECT bi.quantity_inventory
              FROM rwm_blocks_inventory AS bi
              WHERE bi.block_type = b.block_type
                AND bi.height = b.height
                AND bi.date_time_inventory < '{$fs}'
              ORDER BY bi.date_time_inventory DESC
              LIMIT 1
            ), 0) AS block_quantity_initial_inventory,
    
            /* Produção (und) */
            COALESCE((
              SELECT COUNT(*)
              FROM rwm_blocks AS pr
              WHERE pr.block_type = b.block_type
                AND pr.height = b.height
                AND pr.date_time_finish BETWEEN '{$fs}' AND '{$fe}'
            ), 0) AS block_quantity_production,
    
            /* Saída (und) */
            COALESCE((
              SELECT COUNT(*)
              FROM rwm_blocks_output AS o
              JOIN rwm_blocks AS pr2 
                ON pr2.requisition = o.requisition
               AND pr2.requisition_sequence = o.requisition_sequence
              WHERE pr2.block_type = b.block_type
                AND pr2.height = b.height
                AND o.date_time_output BETWEEN '{$fs}' AND '{$fe}'
            ), 0) AS block_quantity_output,
    
            /* Saldo (und) */
            (
              /* inicial */  COALESCE((
                SELECT bi.quantity_inventory
                FROM rwm_blocks_inventory AS bi
                WHERE bi.block_type = b.block_type
                  AND bi.height = b.height
                  AND bi.date_time_inventory < '{$fs}'
                ORDER BY bi.date_time_inventory DESC
                LIMIT 1
              ), 0)
              + /* produção */ COALESCE((
                SELECT COUNT(*) 
                FROM rwm_blocks AS pr3
                WHERE pr3.block_type = b.block_type
                  AND pr3.height = b.height
                  AND pr3.date_time_finish BETWEEN '{$fs}' AND '{$fe}'
              ), 0)
              - /* saída */    COALESCE((
                SELECT COUNT(*)
                FROM rwm_blocks_output AS o2
                JOIN rwm_blocks AS pr4
                  ON pr4.requisition = o2.requisition
                 AND pr4.requisition_sequence = o2.requisition_sequence
                WHERE pr4.block_type = b.block_type
                  AND pr4.height = b.height
                  AND o2.date_time_output BETWEEN '{$fs}' AND '{$fe}'
              ), 0)
            ) AS block_quantity_balance,
    
            /* Saldo em m³ */
            (
              /* inicial m3 */ COALESCE((
                SELECT bi.cubic_meters
                FROM rwm_blocks_inventory AS bi
                WHERE bi.block_type = b.block_type
                  AND bi.height = b.height
                  AND bi.date_time_inventory < '{$fs}'
                ORDER BY bi.date_time_inventory DESC
                LIMIT 1
              ), 0)
              + /* produção m3 */ COALESCE((
                SELECT SUM(pr5.cubic_meters)
                FROM rwm_blocks AS pr5
                WHERE pr5.block_type = b.block_type
                  AND pr5.height = b.height
                  AND pr5.date_time_finish BETWEEN '{$fs}' AND '{$fe}'
              ), 0)
              - /* saída m3 */      COALESCE((
                SELECT SUM(pr6.cubic_meters)
                FROM rwm_blocks_output AS o3
                JOIN rwm_blocks AS pr6
                  ON pr6.requisition = o3.requisition
                 AND pr6.requisition_sequence = o3.requisition_sequence
                WHERE pr6.block_type = b.block_type
                  AND pr6.height = b.height
                  AND o3.date_time_output BETWEEN '{$fs}' AND '{$fe}'
              ), 0)
            ) AS block_cubic_meters_balance
    
          FROM (
            /* união de todas as combinações existentes */
            SELECT block_type, height FROM rwm_blocks_inventory
            UNION
            SELECT block_type, height FROM rwm_blocks
            UNION
            SELECT pr.block_type, pr.height
            FROM rwm_blocks_output AS o
            JOIN rwm_blocks AS pr
              ON pr.requisition = o.requisition
             AND pr.requisition_sequence = o.requisition_sequence
          ) AS b
    
          JOIN rwm_block_types AS t
            ON t.id = b.block_type
        ";

        $sql = "
          SELECT *
          FROM ({$inner}) AS main
          WHERE main.block_quantity_balance <> 0
          ORDER BY main.block_description, main.block_height
        ";

        return $this->db->query($sql)->result_array();
    }

    public function table_stock_by_raw_moldeds_production()
    {
        $this->setFilter();

        $this->db->select(" b.description AS molded_description, b.package_quantity AS molded_package_quantity, SUM(a.quantity) AS molded_quantity");
        $this->db->from(' rwm_moldeds a, rwm_molded_types b ');
        $this->db->where("a.molded_type = b.id");
        $this->db->where("a.date_time_start <='" . $this->filter_date_time_finish . "'");
        $this->db->group_by('molded_description,molded_package_quantity');
        $this->db->order_by('molded_description,molded_package_quantity');

        return $this->db->get()->result_array();
    }

    public function table_stock_by_raw_moldeds_output()
    {
        $this->setFilter();

        $this->db->select("b.description AS molded_description, sum(a.quantity_output) AS molded_quantity ");
        $this->db->from(' rwm_moldeds_output a, rwm_molded_types b ');
        $this->db->where("a.molded_type = b.id");
        $this->db->where("a.date_time_output <= '" . $this->filter_date_time_finish . "'");
        $this->db->group_by('molded_description');
        $this->db->order_by('molded_description');


        return $this->db->get()->result_array();
    }
}
