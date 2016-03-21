<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function remove($user_id) {
        $error = 1;

        $user_to_romove = $this->user_model->get_by_id($user_id);
        $session_data = $this->session->userdata('logged_in');
        $is_admin = $session_data['rights'] == 'admin';
        $group_id = $session_data['group_id'];

        if ($user_to_romove['group_id'] == $group_id && $is_admin) {
            $error = 0;
            $this->user_model->remove_user($user_id);
        }

        $response = array(
            'error' => $error
        );

        echo json_encode($response, JSON_PRETTY_PRINT);
    }

    public function add_user() {
        $stream['error'] = 0;
        $data = $_POST;
        $login = $_POST['username'];
        $email = $_POST['email'];
        $email_domain = explode('@', $email)[1];
        $result = $this->user_model->find_user($login, $email);
        $session_data = $this->session->userdata('logged_in');
        $is_admin = $session_data['rights'] == 'admin';
        $group_id = $session_data['group_id'];

        if (!$is_admin) {
            $stream['error'] = 1;
            $stream['msg'] = 'No rights';
        } else if ($result) {
            if (!$result[0]['active']) {
                $this->user_model->activate_and_add($result[0]['id'], $group_id, $login);
            } else {
                $stream['error'] = 1;
                $stream['msg'] = 'User associated with this email or login already bellongs to a group';
            }
        } else if ($email_domain != 'gmail.com') {
            $stream['error'] = 1;
            $stream['msg'] = 'Please use gmail.com domain';
        } else {
            $keys = array_merge(range(0, 9), range('a', 'z'));
            $password = '';
            $code = '';
            for ($i = 0; $i < 20; $i++) {
                $code .= $keys[array_rand($keys)];
            }
            for ($i = 0; $i < 10; $i++) {
                $password .= $keys[array_rand($keys)];
            }
//            $data['rights'] = 'user';
            $data['group_id'] = $group_id;
            $data['password'] = $password;
            unset($data['password_repeat']);

            if (!$this->send_email($data)) {
                $stream['error'] = 1;
                $stream['msg'] = 'Something went wrong while sending an email. Try again or use different email(maybe one with gmail domain)';
            } else {
                $this->user_model->add_new_user($data);
            }
        }

        echo json_encode($stream);
    }

    private function send_email($data) {
//        $username = $data['username'];
//        $code = $data['verification_code'];
//        $email = $data['email'];
//
//        $subject = 'Verify Your Email Address';
//        $message = 'Dear ' . $username . ',<br /><br />'
//                . 'Please click on the below activation link to verify your email address.<br /><br /> '
//                . base_url() . 'register/verify/' . $username . '/' . $code
//                . '<br /><br /><br />Thanks<br />MGraph Team';
//
//
//        //configure email settings
//        $this->load->library('email');
//        $this->email->set_newline("\r\n");
//        $this->email->from('cranfieldmgraph@gmail', 'MGraph');
//        $this->email->to($email);
//        $this->email->subject($subject);
//        $this->email->message($message);
//        $success = $this->email->send();
//
//        return $success;
        return true;
    }

}
