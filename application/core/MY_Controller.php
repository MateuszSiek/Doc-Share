<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->loged_usser_only = false;
        $this->load->library('parser');
        $this->load->helper(array('form'));
    }

    public function index() {
        $this->load->library('parser');

        if ($this->loged_usser_only) {
            if ($this->session->userdata('logged_in')) {
                $session_data = $this->session->userdata('logged_in');
                $data['username'] = $session_data['username'];
            } else {
                redirect('', 'refresh');
            }
        }
        $this->set_head($data);
        $this->set_header($data);
        $this->set_body($data);
        $this->set_footer($data);

        $this->parser->parse('template', $data);
    }

    public function set_head(&$data) {
        $data['head'] = $this->load->view('head', '', TRUE);
    }

    public function set_header(&$data) {
        $view_data['user'] = $this->session->userdata;
        $data['header'] = $this->load->view('header', $view_data, TRUE);
    }

    public function set_body(&$data) {
        $data['content'] = '';
    }

    public function set_footer(&$data) {
        $data['footer'] = $this->load->view('footer', '', TRUE);
    }

}
