<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Molded_type_model extends CI_Model
{

    public function find_all()
    {
        return $this->db->get('rwm_molded_types')->result_array();
    }

    public function find_by_id($id)
    {
        $this->db->where('id', $id);

        return $this->db->get('rwm_molded_types')->row_array();
    }

    public function find_package_quantity($id)
    {
        $this->db->select('package_quantity');
        $this->db->from('rwm_molded_types');
        $this->db->where('id', $id);

        return $this->db->get()->row_array();
    }

    public function save($id = null)
    {
        $data = [
            'description' => $this->input->post('description'),
            'package_quantity' => string_to_decimal($this->input->post('package_quantity'))
        ];

        if ($id) {
            $this->db->where('id', $id);

            return $this->db->update('rwm_molded_types', $data);
        } else {
            return $this->db->insert('rwm_molded_types', $data);
        }
    }

    public function destroy($id)
    {
        $this->db->where('id', $id);

        return $this->db->delete('rwm_molded_types');
    }

}
