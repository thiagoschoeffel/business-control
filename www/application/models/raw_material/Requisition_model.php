<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Requisition_model extends CI_Model
{

    public function find_all()
    {
        $this->db->select('a.id, a.date_time_start, a.date_time_finish, a.record, b.description AS raw_material_description, a.quantity, a.quantity_considered, a.silos, a.operators, (SELECT COUNT(c.id) FROM rwm_blocks c WHERE a.id = c.requisition) AS block_count, (SELECT SUM(c.cubic_meters) FROM rwm_blocks c WHERE a.id = c.requisition) AS block_cubic_meters, (SELECT SUM(c.virgin_weight) FROM rwm_blocks c WHERE a.id = c.requisition) AS block_virgin_weight, (SELECT SUM(c.recycled_weight) FROM rwm_blocks c WHERE a.id = c.requisition) AS block_recycled_weight, (SELECT SUM(d.quantity) FROM rwm_moldeds d WHERE a.id = d.requisition) AS molded_quantity, (SELECT SUM(e.quantity) FROM rwm_moldeds d, rwm_molded_refugees e WHERE d.id = e.molded AND d.requisition = a.id) AS molded_refugee_quantity, (SELECT SUM(d.total_weight_considered) FROM rwm_moldeds d WHERE a.id = d.requisition) AS molded_total_weight_considered');
        $this->db->from('rwm_requisitions a, rwm_raw_materials b');
        $this->db->where('a.raw_material = b.id');

        return $this->db->get()->result_array();
    }

    public function find_by_id($id)
    {
        $this->db->select('a.id, a.date_time_start, a.date_time_finish, a.record, a.raw_material, b.description AS raw_material_description, a.quantity, a.quantity_considered, a.silos, a.operators, (SELECT COUNT(c.id) FROM rwm_blocks c WHERE a.id = c.requisition) AS block_count, (SELECT SUM(c.cubic_meters) FROM rwm_blocks c WHERE a.id = c.requisition) AS block_cubic_meters, (SELECT SUM(c.virgin_weight) FROM rwm_blocks c WHERE a.id = c.requisition) AS block_virgin_weight, (SELECT SUM(c.recycled_weight) FROM rwm_blocks c WHERE a.id = c.requisition) AS block_recycled_weight, (SELECT SUM(d.quantity) FROM rwm_moldeds d WHERE a.id = d.requisition) AS molded_quantity, (SELECT SUM(e.quantity) FROM rwm_moldeds d, rwm_molded_refugees e WHERE d.id = e.molded AND d.requisition = a.id) AS molded_refugee_quantity, (SELECT SUM(d.total_weight_considered) FROM rwm_moldeds d WHERE a.id = d.requisition) AS molded_total_weight_considered');
        $this->db->from('rwm_requisitions a, rwm_raw_materials b');
        $this->db->where('a.id', $id);
        $this->db->where('a.raw_material = b.id');

        return $this->db->get()->row_array();
    }

    public function save($id = null)
    {
        $data = [
            'date_time_start' => datetime_br_to_db($this->input->post('date_time_start')),
            'date_time_finish' => datetime_br_to_db($this->input->post('date_time_finish')),
            'record' => $this->input->post('record'),
            'raw_material' => $this->input->post('raw_material'),
            'quantity' => string_to_decimal($this->input->post('quantity')),
            'silos' => implode(', ', $this->input->post('silos[]')),
            'operators' => implode(', ', $this->input->post('operators[]'))
        ];

        $data['quantity_considered'] = $data['quantity'] - ($data['quantity'] * 0.05);

        if ($id) {
            $this->db->where('id', $id);

            return $this->db->update('rwm_requisitions', $data);
        } else {
            return $this->db->insert('rwm_requisitions', $data);
        }
    }

    public function destroy($id)
    {
        $this->db->where('id', $id);

        return $this->db->delete('rwm_requisitions');
    }
}
