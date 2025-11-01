<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sector_model extends CI_Model
{

    public function find_all()
    {
        return $this->db->get('rwm_sectors')->result_array();
    }

    public function find_by_id($id)
    {
        $this->db->where('id', $id);

        return $this->db->get('rwm_sectors')->row_array();
    }

    public function save($id = null)
    {
        $data = [
            'name' => $this->input->post('name')
        ];

        if ($id) {
            $this->db->where('id', $id);

            return $this->db->update('rwm_sectors', $data);
        } else {
            return $this->db->insert('rwm_sectors', $data);
        }
    }

    public function destroy($id)
    {
        $this->db->where('id', $id);

        return $this->db->delete('rwm_sectors');
    }

}
