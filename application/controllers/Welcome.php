<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('logged_in')) {
            redirect('application_main', 'refresh');
        }
    }

    public function set_body(&$data) {
        $data['content'] = $this->load->view('main_page', '', TRUE);
    }

}
