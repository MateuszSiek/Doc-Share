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
        $data['content'] = $this->load->view('application', '', TRUE);
    }


}
