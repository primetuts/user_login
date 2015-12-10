<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {
    public function index() {
        
        $user_id = $this->session->userdata('user_id');    
        $logged = "no";
        $this->load->model('login_model');
        $this->login_model->update_users_activity($user_id,$logged);
        //$this->login_model->update_session_end($user_id,$this->session->userdata('session_id'));
        $this->session->sess_destroy();
        redirect(base_url().'login');        
    }

}