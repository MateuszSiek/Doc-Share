<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $error = 1;
        $this->load->model('user_model');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $result = $this->user_model->login($email, $password);
        if ($result) {
            $this->login($result);
            $error = 0;
        }

        $stream = array(
            'error' => $error
        );
        echo json_encode($stream);
    }

    public function login($result) {
        $sess_array = array();
        foreach ($result as $row) {
            $sess_array = array(
                'id' => $row->id,
                'username' => $row->username
            );
            $this->session->set_userdata('logged_in', $sess_array);
        }
    }

    public function logout() {
        $this->session->unset_userdata('logged_in');
        session_destroy();
        redirect('', 'refresh');
    }

}
