<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Module_model extends CI_Model
{

    public function find_all()
    {
        return $this->db->get('app_modules')->result_array();
    }

    public function find_by_id($id)
    {
        $this->db->where('id', $id);

        return $this->db->get('app_modules')->row_array();
    }

    public function find_by_name_class($name_class)
    {
        $this->db->select('level_class');
        $this->db->where('name_class', $name_class);

        return $this->db->get('app_modules')->row_array();
    }
    
}
