<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Raw_material_entrance_model extends CI_Model
{

    public function find_all()
    {
        $this->db->select('a.id, a.date_time_entrance, a.invoice, b.description AS raw_material_description, a.quantity');
        $this->db->from('rwm_raw_material_entrances a, rwm_raw_materials b');
        $this->db->where('a.raw_material = b.id');

        return $this->db->get()->result_array();
    }

    public function find_by_id($id)
    {
        $this->db->select('a.id, a.date_time_entrance, a.invoice, a.raw_material, b.description AS raw_material_description, a.quantity');
        $this->db->from('rwm_raw_material_entrances a, rwm_raw_materials b');
        $this->db->where('a.id', $id);
        $this->db->where('a.raw_material = b.id');

        return $this->db->get()->row_array();
    }

    public function save($id = null)
    {
        $raw_material_entrance = [
            'date_time_entrance' => datetime_br_to_db($this->input->post('date_time_entrance')),
            'invoice' => $this->input->post('invoice'),
            'raw_material' => $this->input->post('raw_material'),
            'quantity' => string_to_decimal($this->input->post('quantity'))
        ];

        if ($id) {
            $this->db->where('id', $id);

            return $this->db->update('rwm_raw_material_entrances', $raw_material_entrance);
        } else {
            return $this->db->insert('rwm_raw_material_entrances', $raw_material_entrance);
        }
    }

    public function destroy($id)
    {
        $this->db->where('id', $id);

        return $this->db->delete('rwm_raw_material_entrances');
    }

}
