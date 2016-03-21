<?php

class File extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('file_model');
    }

    public function do_upload() {
        if (isset($_FILES['userfile'])) {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'pdf|docx|latex';

            $file_title = $_FILES['userfile']['name'];
            $file_name = date('Ymd_His');

            $keys = array_merge(range(0, 9), range('a', 'z'));
            for ($i = 0; $i < 10; $i++) {
                $file_name .= $keys[array_rand($keys)];
            }
            $config['file_name'] = $file_name;
            $config['overwrite'] = false;

            $this->load->library('upload', $config);

            $stream = array();
            if (!$this->upload->do_upload('userfile')) {
                $stream['error_msg'] = $this->upload->display_errors();
                $error = 1;
            } else {
                $session_data = $this->session->userdata('logged_in');
                
                $data = $this->upload->data();
                $data['file_title'] = $file_title;
                $data['file_type'] = $data['file_ext'];
                $data['group_id'] = $session_data['group_id'];

                $file_id = $this->file_model->add_file($data);
                $stream['file_id'] = $file_id;

                $error = 0;
            }
        } else {
            $error = 1;
            $stream['error_msg'] = 'Something went wrong. Make sure you upload appropriate file';
        }
        $stream['error'] = $error;
        echo json_encode($stream);
    }

    public function remove_file($file_id) {
        $this->load->model('file_model');
        $this->load->helper("file");
        $upload_path = $this->config->item('upload_path');
        $error = 1;
        $file = $this->file_model->get_files($file_id);

        if ($file) {
            if (unlink($upload_path . $file[0]->filename)) {
                foreach (glob($upload_path . explode('.', $file[0]->filename)[0] . '*') as $filename) {
                    unlink($filename);
                }
                $this->file_model->delete_file($file_id);
                $error = 0;
            }
        }

        $response = array(
            'error' => $error
        );

        echo json_encode($response, JSON_PRETTY_PRINT);
    }

    public function download_file($file_id) {
        $this->load->model('file_model');
        $this->load->helper("file");
        $upload_path = $this->config->item('upload_path');
        $error = 1;
        $file = $this->file_model->get_files($file_id);

        $this->load->helper('download');

        if ($file) {
            $data = file_get_contents($upload_path . $file[0]->filename); // Read the file's contents
            $name = $file[0]->title;
            force_download($name, $data);
        } else {
            echo 'file not found!';
        }
    }

}

?>