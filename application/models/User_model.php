<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model {

    function login($email, $password) {
        $this->db->select('id, username, password, rights, group_id');
        $this->db->from('users');
        $this->db->where('email', $email);
        $this->db->where('active', 1);
        $this->db->where('password', MD5($password));
        $this->db->limit(1);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    function add_new_user($data) {
        $data['password'] = MD5($data['password']);
        $this->db->insert('users', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function remove_user($user_id) {
        $this->db->where('id', $user_id);
        $this->db->update('users', array('active' => 0));
    }

    function verify_user($login, $code) {
        $user = $this->find_user($login);

        if (!empty($user)) {
            if ($user[0]->verification_code == $code) {
                $this->db->where('username', $login);
                $this->db->where('verification_code', $code);
                $this->db->update('users', array('active' => 1));
                return true;
            }
        }
        return false;
    }

    function get_by_id($user_id) {
        $this->db->select('id, username, rights, email, group_id');
        $this->db->from('users');
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result_array()[0];
    }

    function get_group_users($group_id) {
        $this->db->select('id, username, rights, email');
        $this->db->from('users');
        $this->db->where('group_id', $group_id);
        $this->db->where('active', 1);

        $query = $this->db->get();
        return $query->result_array();
    }

    function activate_and_add($user_id, $group_id, $login) {
        $this->db->where('id', $user_id);
        $this->db->update('users', array('active' => 1, 'group_id'=>$group_id, 'username'=>$login));
    }

    function find_user($login, $email) {
        $this->db->select();
        $this->db->from('users');
        
        $this->db->where('email', $email);
        $this->db->or_where('username', $login); 

        $query = $this->db->get();
        return $query->result_array();
    }

}

?>