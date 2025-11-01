<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Block_output_model extends CI_Model
{
    public function count_all()
    {
        $this->db->from('rwm_blocks_output a, rwm_blocks b, rwm_block_types c');
        $this->db->where('a.requisition = b.requisition and a.requisition_sequence = b.requisition_sequence');
        $this->db->where('b.block_type = c.id');
        $this->db->join('rwm_machines d', 'd.id = a.machine', 'left outer');

        if (!empty($this->session->userdata('list_block_output_filter_id'))) {
            $this->db->where('a.id', $this->session->userdata('list_block_output_filter_id'));
        }

        if (!empty($this->session->userdata('list_block_output_filter_date_time_output_start')) && !empty($this->session->userdata('list_block_output_filter_date_time_output_finish'))) {
            $this->db->where('a.date_time_output >=', datetime_br_to_db($this->session->userdata('list_block_output_filter_date_time_output_start')));
            $this->db->where('a.date_time_output <=', datetime_br_to_db($this->session->userdata('list_block_output_filter_date_time_output_finish')));
        }

        if (!empty($this->session->userdata('list_block_output_filter_requisition'))) {
            $this->db->where('a.requisition', $this->session->userdata('list_block_output_filter_requisition'));
        }

        if (!empty($this->session->userdata('list_block_output_filter_fabrication_order'))) {
            $this->db->where('a.fabrication_order', $this->session->userdata('list_block_output_filter_fabrication_order'));
        }

        if (!empty($this->session->userdata('list_block_output_filter_block_type'))) {
            $this->db->where('c.id', $this->session->userdata('list_block_output_filter_block_type'));
        }

        if (!empty($this->session->userdata('list_block_output_filter_block_height'))) {
            $this->db->where('b.height', $this->session->userdata('list_block_output_filter_block_height'));
        }

        return $this->db->count_all_results();
    }

    public function find_all($limit = null, $offset = null)
    {
        $this->db->select('a.*, b.weight, b.density, b.length, b.width, b.height, b.cubic_meters, c.description as block_type_description');
        $this->db->from('rwm_blocks_output a, rwm_blocks b, rwm_block_types c');
        $this->db->where('a.requisition = b.requisition and a.requisition_sequence = b.requisition_sequence');
        $this->db->where('b.block_type = c.id');
        $this->db->join('rwm_machines d', 'd.id = a.machine', 'left outer');

        if (!empty($this->session->userdata('list_block_output_filter_id'))) {
            $this->db->where('a.id', $this->session->userdata('list_block_output_filter_id'));
        }

        if (!empty($this->session->userdata('list_block_output_filter_date_time_output_start')) && !empty($this->session->userdata('list_block_output_filter_date_time_output_finish'))) {
            $this->db->where('a.date_time_output >=', datetime_br_to_db($this->session->userdata('list_block_output_filter_date_time_output_start')));
            $this->db->where('a.date_time_output <=', datetime_br_to_db($this->session->userdata('list_block_output_filter_date_time_output_finish')));
        }

        if (!empty($this->session->userdata('list_block_output_filter_requisition'))) {
            $this->db->where('a.requisition', $this->session->userdata('list_block_output_filter_requisition'));
        }

        if (!empty($this->session->userdata('list_block_output_filter_fabrication_order'))) {
            $this->db->where('a.fabrication_order', $this->session->userdata('list_block_output_filter_fabrication_order'));
        }

        if (!empty($this->session->userdata('list_block_output_filter_block_type'))) {
            $this->db->where('c.id', $this->session->userdata('list_block_output_filter_block_type'));
        }

        if (!empty($this->session->userdata('list_block_output_filter_block_height'))) {
            $this->db->where('b.height', $this->session->userdata('list_block_output_filter_block_height'));
        }

        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        $this->db->order_by('a.date_time_output', 'DESC');

        return $this->db->get()->result_array();
    }

    public function find_by_id($id)
    {
        $this->db->where('id', $id);

        return $this->db->get('rwm_blocks_output')->row_array();
    }

    public function find_available($requisition)
    {
        $this->db->select('a.requisition_sequence, a.weight, a.density, a.length, a.width, a.height, a.cubic_meters, c.description as block_type_description');
        $this->db->from('rwm_blocks a, rwm_block_types c');
        $this->db->join('rwm_blocks_output b', 'a.requisition = b.requisition AND a.requisition_sequence = b.requisition_sequence', 'LEFT OUTER');
        $this->db->where('a.block_type = c.id');
        $this->db->where('a.requisition', $requisition);
        $this->db->where('b.id IS NULL');

        $this->db->order_by('a.requisition_sequence', 'ASC');

        return $this->db->get()->result_array();
    }

    public function save($id = null)
    {
        $data = [
            'date_time_output' => datetime_br_to_db($this->input->post('date_time_output')),
            'machine' => 0,
            'fabrication_order' => (int) $this->input->post('fabrication_order'),
            'requisition_operators' => '',
            'output_operators' => ''
        ];

        if (!$id) {
            $data['requisition'] = (int) $this->input->post('requisition');

            $this->db->trans_start();

            foreach ($this->input->post('requisition_sequence') as $requisition_sequence) {
                $data['requisition_sequence'] = '';
                $data['requisition_sequence'] = $requisition_sequence;

                $this->db->insert('rwm_blocks_output', $data);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === false) {
                return false;
            }

            return true;
        } else {
            $this->db->where('id', $id);

            return $this->db->update('rwm_blocks_output', $data);
        }
    }

    public function destroy($id)
    {
        $this->db->where('id', $id);

        return $this->db->delete('rwm_blocks_output');
    }
}
