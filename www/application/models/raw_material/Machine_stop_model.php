<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Machine_stop_model extends CI_Model
{

    public function find_all()
    {
        $this->db->select('a.id, a.date_time_start, a.date_time_finish, TIMEDIFF(a.date_time_finish, a.date_time_start) as total_stop_time, b.name as machine_name, c.description as reason_description, a.note');
        $this->db->from('rwm_machine_stops a, rwm_machines b, rwm_reasons c');
        $this->db->where('a.machine = b.id');
        $this->db->where('a.reason = c.id');

        return $this->db->get()->result_array();
    }

    public function find_by_id($id)
    {
        $this->db->where('id', $id);

        return $this->db->get('rwm_machine_stops')->row_array();
    }

    public function save($id = null)
    {
        $machinhe_stop = [
            'date_time_start' => datetime_br_to_db($this->input->post('date_time_start')),
            'date_time_finish' => datetime_br_to_db($this->input->post('date_time_finish')),
            'machine' => $this->input->post('machine'),
            'reason' => $this->input->post('reason'),
            'note' => mb_strtoupper($this->input->post('note'), 'UTF-8')
        ];

        if ($id) {
            $this->db->where('id', $id);

            return $this->db->update('rwm_machine_stops', $machinhe_stop);
        } else {
            return $this->db->insert('rwm_machine_stops', $machinhe_stop);
        }
    }

    public function destroy($id)
    {
        $this->db->where('id', $id);

        return $this->db->delete('rwm_machine_stops');
    }

}
