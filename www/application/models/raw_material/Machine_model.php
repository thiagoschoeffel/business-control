<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Machine_model extends CI_Model
{

    public function find_all($sector = null)
    {
        $this->db->select('a.*, b.name as sector_name');
        $this->db->from('rwm_machines a, rwm_sectors b');
        $this->db->where('a.sector = b.id');

        if($sector) {
            $this->db->where('b.id', $sector);
        }

        return $this->db->get()->result_array();
    }

    public function find_by_id($id)
    {
        $this->db->where('id', $id);

        return $this->db->get('rwm_machines')->row_array();
    }

    public function save($id = null)
    {
        $data = [
            'sector' => $this->input->post('sector'),
            'name' => $this->input->post('name')
        ];

        if ($id) {
            $this->db->where('id', $id);

            return $this->db->update('rwm_machines', $data);
        } else {
            return $this->db->insert('rwm_machines', $data);
        }
    }

    public function destroy($id)
    {
        $this->db->where('id', $id);

        return $this->db->delete('rwm_machines');
    }

}
