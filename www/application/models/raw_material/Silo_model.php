<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Silo_model extends CI_Model
{

    public function find_all()
    {
        return $this->db->get('rwm_silos')->result_array();
    }

    public function find_by_id($id)
    {
        $this->db->where('id', $id);

        return $this->db->get('rwm_silos')->row_array();
    }

    public function save($id = null)
    {
        $data = [
            'description' => $this->input->post('description')
        ];

        if ($id) {
            $this->db->where('id', $id);

            return $this->db->update('rwm_silos', $data);
        } else {
            return $this->db->insert('rwm_silos', $data);
        }
    }

    public function destroy($id)
    {
        $this->db->where('id', $id);

        return $this->db->delete('rwm_silos');
    }

}
