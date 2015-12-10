<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_model extends CI_Model {
    
    public function get_users_login_log() {

        $query = $this -> db -> query("SELECT `user_id`,`username`,`ci_sessions`.`ip_address`,`session_start`,`ci_sessions`.`session_end`,`ci_sessions`.`login_attempt`    
                FROM users
                JOIN  `ci_calendar`.`ci_sessions` ON  `users`.`id` =  `ci_sessions`.`user_id` 
                
                ORDER BY  `session_start` DESC ");

        $query = $query -> result_array();
        return $query;

    }

    public function get_users() {

        $query = $this -> db -> query("SELECT  `id`,`username`, `locked_status` ,`logged_in` FROM users");

        $query = $query -> result_array();
        return $query;

    }

    public function get_locked_users() {

        $query = $this -> db -> query("SELECT  `id`,`username`, `locked_status` ,`logged_in` FROM users 
        WHERE `locked_status` = 'yes'");

        $query = $query -> result_array();
        return $query;

    }

    public function unlock_account($id) {
        $this -> db -> where('id', $id);
        $this -> db -> update('users', array('locked_status' => 'no'));
        redirect(base_url() . 'admin/locked');

    }
    
    
    function verify_captcha ($expiration){
        $expiration = time()- $expiration;
        $this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);
    }
}

/* End of file login_model.php */