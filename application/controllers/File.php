<?php

if (!class_exists('S3'))
    require_once('S3.php');

class File extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('file_model');
        if (!defined('awsAccessKey'))
            define('awsAccessKey', 'AKIAIIREHW7YTVJ6HCWQ');
        if (!defined('awsSecretKey'))
            define('awsSecretKey', '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');

        $this->s3 = new S3(awsAccessKey, awsSecretKey);
        $s3 = new S3(awsAccessKey, awsSecretKey);
    }

    public function do_upload() {
        if (isset($_FILES['userfile'])) {
            //AWS access info


            $file_temp_name = $_FILES['userfile']['tmp_name'];

            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'pdf|docx|latex';

            $file_title = $_FILES['userfile']['name'];
            $file_name = date('Ymd_His');
            $ext = pathinfo($file_title, PATHINFO_EXTENSION);

            $keys = array_merge(range(0, 9), range('a', 'z'));
            for ($i = 0; $i < 10; $i++) {
                $file_name .= $keys[array_rand($keys)];
            }
            $file_name.='.' . $ext;

            $stream = array();

            if (!$this->s3->putObjectFile($file_temp_name, "doc-share-bucket", $file_name, S3::ACL_PUBLIC_READ)) {
                $stream['error_msg'] = $this->upload->display_errors();
                $error = 1;
            } else {
//                $s3->putObjectFile($file_name, $bucket, $uri);


                $session_data = $this->session->userdata('logged_in');

                $data = array(
                    'filename' => $file_name,
                    'file_size' => $_FILES['userfile']['size'] / 1000,
                    'title' => $file_title,
                    'file_type' => $ext,
                    'group_id' => $session_data['group_id'],
                    'user_id' => $session_data["id"]
                );

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
            if ($this->s3->deleteObject("doc-share-bucket", $file[0]->filename)) {
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
            $data = file_get_contents("https://s3-eu-west-1.amazonaws.com/doc-share-bucket/" . $file[0]->filename); // Read the file's contents
           
            $name = $file[0]->title;
            force_download($name, $data);
        } else {
            echo 'file not found!';
        }
    }

}

?>