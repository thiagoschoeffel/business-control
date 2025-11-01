<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Block_inventory_model extends CI_Model
{

    public function find_all()
    {
        $this->db->select('a.*, b.description as block_type_description');
        $this->db->from('rwm_blocks_inventory a , rwm_block_types b');
        $this->db->where('a.block_type = b.id');

        return $this->db->get()->result_array();
    }

    public function find_by_id($id)
    {
        $this->db->where('id', $id);

        return $this->db->get('rwm_blocks_inventory')->row_array();
    }

    public function save($id = null)
    {
        $data = [
            'date_time_inventory' => datetime_br_to_db($this->input->post('date_time_inventory')),
            'block_type' => (int) $this->input->post('block_type'),
            'height' => (int) $this->input->post('height'),
            'quantity_inventory' => string_to_decimal($this->input->post('quantity_inventory')),
            'cubic_meters' => ((4020 / 1000) * (1020 / 1000) * ((int) $this->input->post('height') / 1000)) * string_to_decimal($this->input->post('quantity_inventory'))
        ];

        if ($id) {
            $this->db->where('id', $id);

            return $this->db->update('rwm_blocks_inventory', $data);
        } else {
            return $this->db->insert('rwm_blocks_inventory', $data);
        }
    }

    public function destroy($id)
    {
        $this->db->where('id', $id);

        return $this->db->delete('rwm_blocks_inventory');
    }

}
