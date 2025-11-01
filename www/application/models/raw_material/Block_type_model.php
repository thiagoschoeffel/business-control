<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Block_type_model extends CI_Model
{

    public function find_all()
    {
        return $this->db->get('rwm_block_types')->result_array();
    }

    public function find_by_id($id)
    {
        $this->db->where('id', $id);

        return $this->db->get('rwm_block_types')->row_array();
    }

    public function save($id = null)
    {
        $data = [
            'description' => $this->input->post('description'),
            'raw_material_percent' => string_to_decimal($this->input->post('raw_material_percent'))
        ];

        if ($id) {
            $this->db->where('id', $id);

            return $this->db->update('rwm_block_types', $data);
        } else {
            return $this->db->insert('rwm_block_types', $data);
        }
    }

    public function destroy($id)
    {
        $this->db->where('id', $id);

        return $this->db->delete('rwm_block_types');
    }

}
