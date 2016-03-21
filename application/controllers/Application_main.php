<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Application_main extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->loged_usser_only = true;
        $this->load->library('parser');
        $this->load->helper(array('form'));
    }

    public function set_body(&$data) {
        $this->load->model('user_model');
        $session_data = $this->session->userdata('logged_in');
        $user_id = $session_data['id'];
        $data_view['current_user'] = $this->user_model->get_by_id($user_id);
        $data_view['group_users'] = $this->user_model->get_group_users($data_view['current_user']['group_id']);

        $data['content'] = $this->load->view('application', $data_view, TRUE);
    }

}
