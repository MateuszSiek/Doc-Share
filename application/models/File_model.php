<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class File_model extends CI_Model {

    function add_file($file_data) {
        $session_data = $this->session->userdata('logged_in');
        $user_id = $session_data["id"];
        
        $data = array(
            'filename' => $file_data['file_name'],
            'file_size' => $file_data['file_size']/1000,
            'title' => $file_data['file_title'],
            'file_type' => $file_data['file_type'],
            'group_id' => $file_data['group_id'],
            'user_id' => $user_id
        );

        $this->db->insert('files', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function delete_file($file_id) {
        $this->db->delete('files', array('id' => $file_id)); 
    }

    function get_files($file_id = null) {
        $session_data = $this->session->userdata('logged_in');
        $user_id = $session_data["id"];
        $this->db->from('files');
        $this->db->where('group_id', $session_data["group_id"]);
        if ($file_id) {
            $this->db->where('id', $file_id);
            $this->db->limit(1);
        }

        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->result();
        } else {
            return false;
        }
    }

}

?>