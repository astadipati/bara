<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model {
    public function processLogin($userName=NULL, $password){
        $hasil=$this->db->query("SELECT * from v_users where username='$userName'");
        // $query = $this->db->get();
        return $hasil;
    }
    public function get($id = null){
        $this->db->from ('v_users');
        if($id != null) {
            $this->db->where('userid', $id);
        }
        $query = $this->db->get();
        return $query;
    }
    
}