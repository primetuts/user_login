<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {
    public function index() {

        // our form validation and custom error messages
        $this -> form_validation -> set_rules('user_name', 'Username', 'strip_tags|trim|required|xss_clean');
        $this -> form_validation -> set_rules('password', 'Password', 'required');

        if ($this -> form_validation -> run() === false) {

            $data['title'] = "Login Page";
            $this -> load -> view('header_view', $data);
            $this -> load -> view('login_view');
            $this -> load -> view('footer_view');

        } else {

            $name = $this -> input -> post('user_name');
            $password = $this -> input -> post('password');
            //load model
            $this -> load -> model('login_model');
            // calling the function in our login model
            $result = $this -> login_model -> get_user($name, $password);
            // check if the response is true
            if ($result === true) {
                redirect(base_url() . 'admin');
            } else {
                if ($result === false) {
                    $data['error_message'] = "The username or password you entered is incorrect";
                    $data['title'] = "Login Page";
                    $this -> load -> view('header_view', $data);
                    $this -> load -> view('login_view', $data);
                    $this -> load -> view('footer_view');

                } else if ($result === 'locked') {
                    $data['error_message'] = "Your account has been locked <a href=" . base_url() . 'unlock_account' . "> Unlock your account</a>";
                    $data['disabled'] = "disabled";
                    $data['signin'] = anchor('logout', 'Sign in with a different name');
                    $data['title'] = "Login Page";
                    $this -> load -> view('header_view', $data);
                    $this -> load -> view('login_view', $data);
                    $this -> load -> view('footer_view');

                }
            }

        }

    }

}

/* End of file */

