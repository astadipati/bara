<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function index()
	{
		$this->load->view('login/login');
	}

	public function process(){
        $post = $this->input->post(null, TRUE);
        
		if(isset($post['login'])){
            $userName = trim($this->input->post('username'));
			$password = trim($this->input->post('password'));
			$this->load->model('m_user');
			$q = $this->m_user->login($userName,$password);
			// $query = $this->user_m->login($post);
            
            echo "sampai sini";
            die();

			$h = $q->row_array();
			$kata_sandi = $h['password'];

			$cek = $this->arr2md5(array($password));

			if($cek==$kata_sandi && $cek<>''){
				// echo "Login sukses";
				$query = $q->result();
				$user = array(
					'userid'=>$query[0]->userid,
					'nama_user'=>$query[0]->fullname
				);
				redirect('dashboard');
			}else{
				echo "gagal";
			}
		// 	if($query->num_rows()>0){
		// 		// echo "Login sukses";
		// 		$row = $query->row();
		// 		$params = array(
		// 			'userid' => $row->userid,
		// 			'fullname' => $row->fullname
		// 		);
		// 		$this->session->set_userdata($params);
		// 		echo "<script>
		// 		alert('Login Sukses');
		// 		window.location='".site_url('dashboard')."';
		// 		</script>";
		// 		// echo $row->username;
		// 	}else{
		// 		echo "<script>
		// 		alert('Login gagal');
		// 		window.location='".site_url('auth')."';
		// 		</script>";			}
		}

	}
	function arr2md5($arrinput){
        $hasil='';
        foreach($arrinput as $val){
            if($hasil==''){
                $hasil=md5($val);
            }else{
                $code=md5($val);
                for($hit=0;$hit<min(array(strlen($code),strlen($hasil)));$hit++){
                    $hasil[$hit]=chr(ord($hasil[$hit])^ ord($code[$hit]));
                }
            }
        }
        return(md5($hasil));
    }
}

