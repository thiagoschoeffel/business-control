<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Block_model extends CI_Model
{

    public function find_all($requisition)
    {
        $this->db->select('a.*, b.description as block_type_description');
        $this->db->from('rwm_blocks a, rwm_block_types b');
        $this->db->where('requisition', $requisition);
        $this->db->where('a.block_type = b.id');

        return $this->db->get()->result_array();
    }

    public function find_by_id($requisition, $id)
    {
        $this->db->where('requisition', $requisition);
        $this->db->where('id', $id);

        return $this->db->get('rwm_blocks')->row_array();
    }

    public function find_by_requisition_sequence($requisition, $requisition_sequence)
    {
        $this->db->where('requisition', $requisition);
        $this->db->where('requisition_sequence', $requisition_sequence);

        return $this->db->get('rwm_blocks')->row_array();
    }

    public function save($requisition, $id = null)
    {
        $this->load->model('raw_material/block_type_model', 'block_type_model');
        $this->load->model('raw_material/raw_material_model', 'raw_material_model');
        $this->load->model('raw_material/requisition_model', 'requisition_model');
        $raw_material_percent = $this->block_type_model->find_by_id($this->input->post('block_type'))['raw_material_percent'];

        $data['date_time_start'] = datetime_br_to_db($this->input->post('date_time_start'));
        $data['date_time_finish'] = datetime_br_to_db($this->input->post('date_time_finish'));
        $data['record'] = $this->input->post('record');
        $data['weight'] = string_to_decimal($this->input->post('weight'));
        $data['virgin_weight'] = $data['weight'] * ($raw_material_percent / 100);
        $data['recycled_weight'] = $data['weight'] - ($data['weight'] * ($raw_material_percent / 100));
        $data['block_type'] = $this->input->post('block_type');
        $data['raw_material_percent'] = $raw_material_percent;
        $data['length'] = 4020;
        $data['width'] = 1020;
        $data['height'] = (int) $this->input->post('height');
        $data['cubic_meters'] = ($data['length'] / 1000) * ($data['width'] / 1000) * ($data['height'] / 1000);
        $data['density'] = $data['weight'] / $data['cubic_meters'];
        $data['silos'] = implode(', ', $this->input->post('silos[]'));
        $data['operators'] = implode(', ', $this->input->post('operators[]'));

        if ($requisition && $id) {
            $this->db->where('requisition', $requisition);
            $this->db->where('id', $id);

            return $this->db->update('rwm_blocks', $data);
        } else {
            $data['requisition'] = $requisition;
            $data['requisition_sequence'] = (int) $this->find_max_sequence($requisition)['requisition_sequence'] + 1;

            return $this->db->insert('rwm_blocks', $data);
        }
    }

    public function destroy($requisition, $id)
    {
        $this->db->where('requisition', $requisition);
        $this->db->where('id', $id);

        return $this->db->delete('rwm_blocks');
    }

    private function find_max_sequence($requisition)
    {
        $this->db->select('IFNULL(MAX(requisition_sequence), 0) AS requisition_sequence');
        $this->db->where('requisition', $requisition);

        return $this->db->get('rwm_blocks')->row_array();
    }
}
