<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Molded_refugee_model extends CI_Model
{

    public function find_all($molded)
    {
        $this->db->select('a.*, b.description');
        $this->db->from('rwm_molded_refugees a, rwm_reasons b');
        $this->db->where('molded', $molded);
        $this->db->where('a.reason = b.id');

        return $this->db->get()->result_array();
    }

    public function find_by_id($molded, $id)
    {
        $this->db->where('molded', $molded);
        $this->db->where('id', $id);

        return $this->db->get('rwm_molded_refugees')->row_array();
    }

    public function save($molded, $id = null)
    {
        $data['quantity'] = string_to_decimal($this->input->post('quantity'));
        $data['reason'] = $this->input->post('reason');

        if ($id) {
            $this->db->where('molded', $molded);
            $this->db->where('id', $id);

            return $this->db->update('rwm_molded_refugees', $data);
        } else {
            $data['molded'] = $molded;

            return $this->db->insert('rwm_molded_refugees', $data);
        }
    }

    public function destroy($molded, $id)
    {
        $this->db->where('molded', $molded);
        $this->db->where('id', $id);

        return $this->db->delete('rwm_molded_refugees');
    }

}
