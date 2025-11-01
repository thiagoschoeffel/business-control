<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reason_model extends CI_Model
{

    public function find_all($type = null)
    {
        if($type) {
            $this->db->where('type', $type);
        }

        return $this->db->get('rwm_reasons')->result_array();
    }

    public function find_by_id($id)
    {
        $this->db->where('id', $id);

        return $this->db->get('rwm_reasons')->row_array();
    }

    public function save($id = null)
    {
        $data = [
            'description' => $this->input->post('description')
        ];

        if($this->input->post('type') === 'MACHINE STOP' || $this->input->post('type') === 'MOLDED') {
            $data['type'] = $this->input->post('type');
        } else {
            $data['type'] = '';
        }

        if ($id) {
            $this->db->where('id', $id);

            return $this->db->update('rwm_reasons', $data);
        } else {
            return $this->db->insert('rwm_reasons', $data);
        }
    }

    public function destroy($id)
    {
        $this->db->where('id', $id);

        return $this->db->delete('rwm_reasons');
    }

}
