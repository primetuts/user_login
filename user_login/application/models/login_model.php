<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_model extends CI_Model {
    var $account_locked, $locked, $logged;

    function __construct() {
        parent::__construct();
        $this -> account_locked = 'locked';
        $this -> locked = 'yes';
        $this -> logged = "yes";

    }

    public function get_user($name, $password) {
        
        // fetch the username record from the databse users.
        $query = $this -> db -> get_where('users', array('username' => $name));

        // check if we have a record in the db
        if ($query -> num_rows() > 0) {

            //get the result as an array
            $query = $query -> row_array();

            // retrieve the userid, username , password, account status
            $account_status = $query['locked_status'];

            // check the account status
            if ($account_status === 'yes') {
                return $this -> account_locked;
            }
            // fetch the user_id, username and password
            $user_id = $query['id'];
            
            if (!$this -> session -> userdata('user_id')) {
                $this -> session -> set_userdata('user_id', $user_id);
            } 

            $user_name = $query['username'];
            $user_password = $query['password'];

            //hash the password
            $password = md5($password);

            // if passwords do not match insert a new record in the db sessions.
            if ($password != $user_password) {
                //return ($this -> create_session($session_id, $user_id));
                $session_id = $this -> session -> userdata('session_id');
                return ($this -> update_ci_session($session_id, $user_id));
            }

            // check if passwords do match, then set session and log the user.
            else if (($password === $user_password)) {
                $userdata = array('user_id' => $user_id, 'user_name' => $user_name);
                $this -> session -> set_userdata($userdata);
                $this -> update_users_activity($user_id, $this -> logged);
                //$this->update_session_start($user_id,$session_id);
                return true;
            }
        } else {
            return false;
        }
    }

    function update_ci_session($session_id, $user_id) {
            $attempt = $this->session->userdata['login_attempt'];
            if ($attempt == 0) {
                // update the current session login attempt
                $this->session->set_userdata('login_attempt',1);
                return false;

            } else if ($attempt > 0) {

                $attempt = $this->session->userdata['login_attempt'] + 1;
                $this->session->set_userdata('login_attempt',$attempt);
                
            }

            // check the number of attempts , if 3 return account locked, if not return false, 3 is the max attempts
            if ($attempt === 3) {
                $this -> lock_user_account($user_id);
                return $this -> account_locked;
            } else {
                return false;
            }
        }

    
    
    
    
    
    /*function update_ci_session($session_id, $user_id) {

        $query = $this -> db -> get_where('ci_sessions', array('user_id' => $user_id, 'session_id' => $session_id));
        if ($query -> num_rows() > 0) {

            $query = $query -> row_array();
            $attempt = $query['login_attempt'];
            if ($attempt == 0) {
                // update the current session login attempt
                $this -> db -> where('session_id', $session_id, 'AND', 'user_id', $user_id);
                $data = array('login_attempt' => 1);
                $this -> db -> update('ci_sessions', $data);
                return false;

            } else if ($attempt > 0) {

                $attempt = $query['login_attempt'] + 1;
                $this -> db -> where('session_id', $session_id, 'AND', 'user_id', $user_id);
                $data = array('login_attempt' => $attempt);
                $this -> db -> update('ci_sessions', $data);
            }

            // check the number of attempts , if 3 return account locked, if not return false, 3 is the max attempts
            if ($attempt === 3) {
                $this -> lock_user_account($user_id);
                return $this -> account_locked;
            } else {
                return false;
            }
        }

    }*/

    function lock_user_account($user_id) {
        // update the users account status to locked === yes
        $this -> db -> where('id', $user_id);
        $this -> db -> update('users', array('locked_status' => $this -> locked));
        $this -> session -> sess_destroy();

    }

    function update_users_activity($user_id, $logged) {
        $this -> db -> where('id', $user_id);
        $this -> db -> update('users', array('logged_in' => $logged));
    }

    function update_session_start($user_id, $session_id) {

        $session_start = time();
        $this -> db -> where('session_id', $session_id);
        $this -> db -> update('ci_sessions', array('session_start' => $session_start, 'user_id' => $user_id));
    }

    function update_session_end($user_id, $session_id) {

        $session_end = time();
        $this -> db -> where('session_id', $session_id);
        $this -> db -> update('ci_sessions', array('session_end' => $session_end, 'user_id' => $user_id));
    }

}

/* End of file login_model.php */
