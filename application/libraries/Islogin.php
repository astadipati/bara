<?php

Class Islogin{
    protected $ci;

    function __construct(){
        $this->ci =& get_instance();
    }

    function data_login(){
        $this->ci->load->model('user_m');
        $user_id = $this->ci->session->userdata('userid');
        $user_data = $this->ci->user_m->get($user_id)->row();
        return $user_data;
    }

    public function count_item(){
        $this->ci->load->model('item_m');
        return $this->ci->item_m->get()->num_rows();
    }
    public function count_supplier(){
        $this->ci->load->model('supplier_m');
        return $this->ci->supplier_m->get()->num_rows();
    }
    public function count_customer(){
        $this->ci->load->model('customer_m');
        return $this->ci->customer_m->get()->num_rows();
    }
    public function count_user(){
        $this->ci->load->model('user_m');
        return $this->ci->user_m->get()->num_rows();
    }
}