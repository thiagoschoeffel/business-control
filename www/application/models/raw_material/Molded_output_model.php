<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Molded_output_model extends CI_Model
{

    public function find_all()
    {
        $this->db->select('a.*, b.description as molded_type_description');
        $this->db->from('rwm_moldeds_output a');
        $this->db->join('rwm_molded_types b', 'b.id = a.molded_type', 'left outer');

        return $this->db->get()->result_array();
    }

    public function find_by_id($id)
    {
        $this->db->where('id', $id);

        return $this->db->get('rwm_moldeds_output')->row_array();
    }

    public function save($id = null)
    {
        $data = [
            'date_time_output' => datetime_br_to_db($this->input->post('date_time_output')),
            'molded_type' => (int) $this->input->post('molded_type'),
            'quantity_output' => string_to_decimal($this->input->post('quantity_output')),
            'fabrication_order' => (int) $this->input->post('fabrication_order')
        ];

        $data['requisition_operators'] = implode(', ', $this->input->post('requisition_operators[]'));
        $data['output_operators'] = implode(', ', $this->input->post('output_operators[]'));

        if ($id) {
            $this->db->where('id', $id);

            return $this->db->update('rwm_moldeds_output', $data);
        } else {
            return $this->db->insert('rwm_moldeds_output', $data);
        }
    }

    public function destroy($id)
    {
        $this->db->where('id', $id);

        return $this->db->delete('rwm_moldeds_output');
    }

}
