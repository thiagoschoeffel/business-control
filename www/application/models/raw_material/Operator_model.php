<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Operator_model extends CI_Model
{

    public function find_all($sector = null)
    {
        $this->db->select('a.*, b.name as sector_name');
        $this->db->from('rwm_operators a, rwm_sectors b');
        $this->db->where('a.sector = b.id');
 	$this->db->order_by('name');

        if($sector) {
            $this->db->where('b.id', $sector);
        }

        return $this->db->get()->result_array();
    }

    public function find_by_id($id)
    {
        $this->db->where('id', $id);

        return $this->db->get('rwm_operators')->row_array();
    }

    public function save($id = null)
    {
        $data = [
            'sector' => $this->input->post('sector'),
            'name' => $this->input->post('name')
        ];

        if ($id) {
            $this->db->where('id', $id);

            return $this->db->update('rwm_operators', $data);
        } else {
            return $this->db->insert('rwm_operators', $data);
        }
    }

    public function destroy($id)
    {
        $this->db->where('id', $id);

        return $this->db->delete('rwm_operators');
    }

}
