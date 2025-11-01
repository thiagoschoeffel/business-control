<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    public function find_all()
    {
        return $this->db->get('app_users')->result_array();
    }

    public function find_by_id($id)
    {
        $this->db->select('id, first_name, last_name, email, login, first_access, permissions');
        $this->db->where('id', $id);

        return $this->db->get('app_users')->row_array();
    }

    public function find_by_login(string $login)
    {
        $this->db->select('*');
        $this->db->from('app_users');
        $this->db->where('login', $login);

        return $this->db->get()->row_array();
    }

    public function find_exist_email($email, $id = null) {
        $this->db->where('email', $email);

        if($id) {
            $this->db->where('id !=', $id);
        }

        return $this->db->get('app_users')->row_array();
    }

    public function find_exist_login($login, $id = null) {
        $this->db->where('login', $login);

        if($id) {
            $this->db->where('id !=', $id);
        }

        return $this->db->get('app_users')->row_array();
    }

    public function get_first_login($id)
    {
        $this->db->select('1');
        $this->db->from('app_users');
        $this->db->where('first_access', 'S');
        $this->db->where('id', $id);

        return $this->db->get()->row_array();
    }

    public function set_no_first_login($id)
    {
        $this->db->set('first_access', 'N');
        $this->db->where('id', $id);

        $this->db->update('app_users');
    }

    public function set_last_login($id)
    {
        $this->db->set('last_access', date('Y-m-d H:i:s'));
        $this->db->where('id', $id);

        $this->db->update('app_users');
    }

    public function set_new_password($id, $new_password)
    {
        $crypt_password = password_hash($new_password, PASSWORD_BCRYPT);

        $this->db->set('password', $crypt_password);
        $this->db->where('id', $id);

        return $this->db->update('app_users');
    }

    public function save($id = null)
    {
        $data = [
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'email' => strtolower($this->input->post('email')),
            'login' => strtolower($this->input->post('login')),
            'first_access' => strtoupper($this->input->post('first_access'))
        ];

        if(!empty($this->input->post('password')) && $id) {
            $data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
        }

        $data['permissions'] = '';

        if($this->input->post('permissions[]')) {
            $data['permissions'] = implode(', ', $this->input->post('permissions[]'));
        }

        if ($id) {
            $this->db->where('id', $id);

            return $this->db->update('app_users', $data);
        } else {
            return $this->db->insert('app_users', $data);
        }
    }

    public function destroy($id)
    {
        $this->db->where('id', $id);

        return $this->db->delete('app_users');
    }

}
