<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Molded_model extends CI_Model
{

    public function find_all($requisition)
    {
        $this->db->select('a.*, (SELECT SUM(b.quantity) FROM rwm_molded_refugees b WHERE a.id = b.molded) AS molded_refugee_quantity, c.description as molded_type_description');
        $this->db->from('rwm_moldeds a, rwm_molded_types c');
        $this->db->where('a.requisition', $requisition);
        $this->db->where('a.molded_type = c.id');

        return $this->db->get()->result_array();
    }

    public function find_by_id($requisition, $id)
    {
        $this->db->select('*');
        $this->db->from('rwm_moldeds');
        $this->db->where('requisition', $requisition);
        $this->db->where('id', $id);

        return $this->db->get()->row_array();
    }

    public function save($requisition, $id = null)
    {
        $data['molded_type'] = $this->input->post('molded_type');

        $this->load->model('raw_material/molded_type_model', 'molded_type_model');
        $package_quantity = $this->molded_type_model->find_package_quantity($data['molded_type'])['package_quantity'];

        $data['date_time_start'] = datetime_br_to_db($this->input->post('date_time_start'));
        $data['date_time_finish'] = datetime_br_to_db($this->input->post('date_time_finish'));
        $data['record'] = $this->input->post('record');
        $data['quantity'] = string_to_decimal($this->input->post('quantity'));
        $data['package_weight'] = string_to_decimal($this->input->post('package_weight'));
        $data['weight_considered_unit'] = ($data['package_weight'] / (int) $package_quantity) - (($data['package_weight'] / (int) $package_quantity) * 0.42);
        $data['total_weight_considered'] = $data['quantity'] * $data['weight_considered_unit'];
        $data['silos'] = implode(', ', $this->input->post('silos[]'));
        $data['operators'] = implode(', ', $this->input->post('operators[]'));

        if ($requisition && $id) {
            $this->db->where('requisition', $requisition);
            $this->db->where('id', $id);

            return $this->db->update('rwm_moldeds', $data);
        } else {
            $data['requisition'] = $requisition;

            return $this->db->insert('rwm_moldeds', $data);
        }
    }

    public function destroy($requisition, $id)
    {
        $this->db->where('requisition', $requisition);
        $this->db->where('id', $id);

        return $this->db->delete('rwm_moldeds');
    }

}
