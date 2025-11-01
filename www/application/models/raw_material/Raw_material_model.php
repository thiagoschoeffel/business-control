<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Raw_material_model extends CI_Model
{

    public function find_all()
    {
        return $this->db->get('rwm_raw_materials')->result_array();
    }

    public function find_by_id($id)
    {
        $this->db->where('id', $id);

        return $this->db->get('rwm_raw_materials')->row_array();
    }

    public function save($id = null)
    {
        $data = [
            'description' => $this->input->post('description'),
            'date_initial_inventory' => datetime_br_to_db($this->input->post('date_initial_inventory')),
            'quantity_initial_inventory' => string_to_decimal($this->input->post('quantity_initial_inventory'))
        ];

        if ($id) {
            $this->db->where('id', $id);

            return $this->db->update('rwm_raw_materials', $data);
        } else {
            return $this->db->insert('rwm_raw_materials', $data);
        }
    }

    public function destroy($id)
    {
        $this->db->where('id', $id);

        return $this->db->delete('rwm_raw_materials');
    }

}
