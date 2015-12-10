<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller {
        var $session_destroy;
    function __construct() {
        parent::__construct();
        $this -> jquery -> script(base_url() . 'js/jquery/jquery.js', TRUE);
        $this -> load -> model('admin_model');
        
    }
    public function index() {

        if (!$this -> session -> userdata('user_id')) {
            redirect(base_url() . 'login');

        } else {
            
            $data['user_sessions'] = $this -> admin_model -> get_users_login_log();
            $data['title'] = "Admin Page";
            
            $data['welcome'] = "Welcone back " . ucfirst($this -> session -> userdata('user_name'));
            $this -> load -> view('admin_header', $data);
            $this -> load -> view('admin_nav');
            $this -> load -> view('footer_view');

        }
    }

    public function logout() {
        $user_id = $this->session->userdata('user_id');    
        $logged = "no";
        $this->load->model('login_model');
        $this->login_model->update_users_activity($user_id,$logged);
        $this->session->sess_destroy();
        redirect(base_url().'login');
       
    }

    public function users() {
        if (!$this -> session -> userdata('user_id')) {
            redirect(base_url() . 'login');

        } else {
            
            $data['users'] = $this -> admin_model -> get_users();
            $data['title'] = "Admin Page";
            $data['welcome'] = "Welcone back " . ucfirst($this -> session -> userdata('user_name'));
            $data['view_title'] = "list of Users";
            $this -> load -> view('admin_header', $data);
            $this -> load -> view('admin_nav');
            $this -> load -> view('admin_view',$data);
            $this -> load -> view('footer_view');
        }
    }
     public function sessions() {
        if (!$this -> session -> userdata('user_id')) {
            redirect(base_url() . 'login');

        } else {
           
            $data['user_sessions'] = $this -> admin_model -> get_users_login_log();
            $data['title'] = "Admin Page";
            $data['welcome'] = "Welcone back " . ucfirst($this -> session -> userdata('user_name'));
            $this -> load -> view('admin_header', $data);
            $this -> load -> view('admin_nav');
            $this -> load -> view('admin_view', $data);
            $this -> load -> view('footer_view');
        }
    }
     public function locked() {
        if (!$this -> session -> userdata('user_id')) {
            redirect(base_url() . 'login');

        } else {
          
            $data['locked_users'] = $this -> admin_model -> get_locked_users();
            $data['title'] = "Admin Page";
            $data['welcome'] = "Welcone back " . ucfirst($this -> session -> userdata('user_name'));
            $this -> load -> view('admin_header', $data);
            $this -> load -> view('admin_nav');
            $this -> load -> view('admin_view', $data);
            $this -> load -> view('footer_view');
        }
    }
     function unlock(){
        $user_id = $this->uri->segment(3, 0);
        $this->load->model('admin_model');
        $this->admin_model->unlock_account($user_id); 
     }
    function blog(){
        redirect('http://phpfaculte.blogspot.com');
    } 
    function home (){
        echo "Welcome to php faculte.org home page";
    }
    function about (){
        echo "Free php video tutorials";
    }
    

}
/* End of file  */