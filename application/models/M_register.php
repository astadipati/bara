<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Register_model extends CI_Model
{
	function processLogin($userName = NULL, $password)
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$q = $this
			->dbsipp
			->query("SELECT userid, fullname, username as nama_user , password as kata_sandi, code_activation, group_name, group_id, jurusita_id FROM v_users where username='$userName'");
		return $q;
	}
	function sequrity()
	{
		$userName = $this
			->session
			->userdata('userid');
		if (empty($userName))
		{
			$this
				->session
				->sess_destroy();
			redirect('login');
		}
	}
	function get_data($table, $jenisdb)
	{
		if ($jenisdb == "dbsipp")
		{
			$this->dbsipp = $this
				->load
				->database("dbsipp", true);
			$query = $this
				->dbsipp
				->get($table);
		}
		else
		{
			$query = $this
				->db
				->get($table);
		}

		return $query->result();
	}
	function validasi_data()
	{
		$sql = "SELECT *, convert_tanggal_indonesia(tanggal) as tanggal_indonesia FROM register_validasi ORDER BY tanggal DESC";
		$query = $this
			->db
			->query($sql);
		return $query->result();
	}
	function validasi_data_json()
	{
		$sql = " SELECT convert_tanggal_indonesia(tanggal) as Tanggal, validator_nama AS Validator, validator_jabatan AS Jabatan FROM register_validasi ORDER BY tanggal DESC";
		$query = $this
			->db
			->query($sql);
		return $query->result();
	}
	function get_data_where_sipp($table, $kolom, $isi)
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$q = $this
			->dbsipp
			->query("SELECT * FROM " . $table . " WHERE " . $kolom . "='" . $isi . "'");
		foreach ($q->result_array() as $d)
		{
		}
		return $d;
	}
	function get_data_where($whereconditon, $table, $jenisdb)
	{
		if ($jenisdb == "dbsipp")
		{
			//echo $whereconditon;exit;
			$this->dbsipp = $this
				->load
				->database("dbsipp", true);
			$this
				->dbsipp
				->where($whereconditon);
			$query = $this
				->dbsipp
				->get($table);
			foreach ($query->result_array() as $d)
			{
			}
			return $d;

		}
		else
		{
			$this
				->db
				->where($whereconditon);
			$query = $this
				->db
				->get($table);
			foreach ($query->result_array() as $d)
			{
			}
			return $d;
		}

	}
	function get_data_where1($whereconditon, $table, $jenisdb)
	{
		if ($jenisdb == "dbsipp")
		{
			//echo $whereconditon;exit;
			$this->dbsipp = $this
				->load
				->database("dbsipp", true);
			$this
				->dbsipp
				->where($whereconditon);
			$query = $this
				->dbsipp
				->get($table);

		}
		else
		{
			$this
				->db
				->where($whereconditon);
			$query = $this
				->db
				->get($table);
		}
		return $query->result();
	}
	function get_data_where_kosong($whereconditon, $table, $jenisdb)
	{
		if ($jenisdb == "dbsipp")
		{
			//echo $whereconditon;exit;
			$this->dbsipp = $this
				->load
				->database("dbsipp", true);
			$this
				->dbsipp
				->where($whereconditon);
			$query = $this
				->dbsipp
				->get($table);
			return $query;

		}
		else
		{
			$this
				->db
				->where($whereconditon);
			$query = $this
				->db
				->get($table);

			return $query->result_array();
		}
	}
	function insert_data($tableName, $data)
	{
		$res = $this
			->db
			->insert($tableName, $data);
		return $res;
	}
	function insert_validasi_harian($tableSelect, $select, $field, $where, $tableTujuan)
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$this
			->dbsipp
			->select($select);
		$this
			->dbsipp
			->from($tableSelect);
		$this
			->dbsipp
			->where($field, $where);
		$query = $this
			->dbsipp
			->get();
		//echo 'tanggal'.$tanggal;
		echo 'jumlah' . $query->num_rows();
		//exit;
		if ($query->num_rows())
		{
			$new_data = $query->result_array();
			$this
				->db
				->insert_batch($tableTujuan, $new_data);
			//
			/*foreach ($new_data as $row => $data_baru)
			{
				//echo $data_baru;
					$this->db->insert($tableTujuan, $data_baru);
			} */
		}
	}
	function update_data($whereconditon, $tableName, $data)
	{
		$this
			->db
			->where($whereconditon);
		$res = $this
			->db
			->update($tableName, $data);
		return $res;
	}
	function update_data_sipp($whereconditon, $tableName, $data)
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$this
			->dbsipp
			->where($whereconditon);
		$res = $this
			->dbsipp
			->update($tableName, $data);
		return $res;
	}
	function delete_data($whereconditon, $tableName)
	{
		$this
			->db
			->where($whereconditon);
		$res = $this
			->db
			->delete($tableName);
		return $res;
	}
	function sys_config()
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$q = $this
			->dbsipp
			->query("SELECT id, value FROM sys_config where (id>=61 AND		id<=73) OR (id>=93 AND		id<=100) or id=76 or id=80 or id=82");
		$data = array();
		foreach ($q->result_array() as $d)
		{
			if ($d['id'] == 61)
			{
				$data['KodePN'] = $d['value'];
			}
			else if ($d['id'] == 62)
			{
				$data['NamaPN'] = $d['value'];
			}
			else if ($d['id'] == 63)
			{
				$data['AlamatPN'] = $d['value'];
			}
			else if ($d['id'] == 64)
			{
				$data['KetuaPNNama'] = $d['value'];
			}
			else if ($d['id'] == 65)
			{
				$data['KetuaPNNIP'] = $d['value'];
			}
			else if ($d['id'] == 66)
			{
				$data['WakilKetuaPNNama'] = $d['value'];
			}
			else if ($d['id'] == 67)
			{
				$data['WakilKetuaPNNIP'] = $d['value'];
			}
			else if ($d['id'] == 68)
			{
				$data['PanSekNama'] = $d['value'];
			}
			else if ($d['id'] == 69)
			{
				$data['PanSekNIP'] = $d['value'];
			}
			else if ($d['id'] == 70)
			{
				$data['WaPanNama'] = $d['value'];
			}
			else if ($d['id'] == 71)
			{
				$data['WaPanNIP'] = $d['value'];
			}
			else if ($d['id'] == 72)
			{
				$data['WaSekNama'] = $d['value'];
			}
			else if ($d['id'] == 73)
			{
				$data['WaSekNIP'] = $d['value'];
			}
			else if ($d['id'] == 76)
			{
				$data['NamaPT'] = $d['value'];
			}
			else if ($d['id'] == 80)
			{
				$data['app_version'] = $d['value'];
			}
			else if ($d['id'] == 82)
			{
				$data['id_satker'] = $d['value'];
			}
			else if ($d['id'] == 93)
			{
				$data['PlhKetua'] = $d['value'];
			}
			else if ($d['id'] == 94)
			{
				$data['PlhKetuaNip'] = $d['value'];
			}
			else if ($d['id'] == 95)
			{
				$data['PlhPanitera'] = $d['value'];
			}
			else if ($d['id'] == 96)
			{
				$data['PlhPaniteraNip'] = $d['value'];
			}
			else if ($d['id'] == 97)
			{
				$data['PltKetua'] = $d['value'];
			}
			else if ($d['id'] == 98)
			{
				$data['PltKetuaNip'] = $d['value'];
			}
			else if ($d['id'] == 99)
			{
				$data['PltPanitera'] = $d['value'];
			}
			else if ($d['id'] == 100)
			{
				$data['PltPaniteraNip'] = $d['value'];
			}
		}
		return $data;
	}
	function sebutan_pihak($nomor_perkara)
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$q = $this
			->dbsipp
			->query("SELECT jenis_perkara_id, alur_perkara_id FROM perkara WHERE nomor_perkara='$nomor_perkara'");
		$datanya = array();
		foreach ($q->result_array() as $d)
		{
			$datanya['alur_perkara_id']=$d['alur_perkara_id'];
			$datanya['jenis_perkara_id']=$d['jenis_perkara_id'];
		}	
		
		return $datanya;
	}
	function sys_config2()
	{
		$q = $this
			->db
			->query("SELECT * FROM sys_config where hidden = '0'");
		$data = array();
		foreach ($q->result_array() as $d)
		{
			$kd = $d['kd'];
			$data[$kd] = $d['value'];
		}
		return $data;
	}

	///////////////=============register manual===================//
	function data_json_perkara_penyitaan($noperk, $tingkat)
	{
		$this->dbsipp = $this->load->database("dbsipp", true);
		if ($tingkat == "perkara")
		{
			$sql = "SELECT nomor_perkara
				FROM perkara
				where SUBSTRING_INDEX(nomor_perkara,'/',1) = '$noperk' order by perkara_id DESC ";
		}
		else if ($tingkat == "perkara_eksekusi")
		{
			$sql = "SELECT nomor_register_eksekusi AS nomor_perkara
				FROM ".$tingkat."
				where nomor_register_eksekusi like '%$noperk%'  ";
		}
		else if ($tingkat == "perkara_eksekusi_ht")
		{
			$sql = "SELECT eksekusi_nomor_perkara AS nomor_perkara
				FROM ".$tingkat."
				where eksekusi_nomor_perkara like '%$noperk%'  ";
		}else
		{
			$sql = "SELECT  nomor_perkara_pn AS nomor_perkara
				FROM ".$tingkat."
				where nomor_perkara_pn  like '%$noperk%'  ";
		}
	 
		$q = $this
			->dbsipp
			->query($sql);
		$data = array();
		foreach ($q->result_array() as $d)
		{
			$temp = $d['nomor_perkara'];
			array_push($data, $temp);
		}

		return $data;
	}
	function data_json_informasi_perkara_penyitaan($noperk, $tingkat)
	{
		$this->dbsipp = $this->load->database("dbsipp", true);
		if ($tingkat == "perkara")
		{
			$sql = "SELECT 
					'' AS nama_js
					,'' AS jenis_penyitaan_nama
					,'' AS tanggal_penetapan_sita
					,(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(b.nama, ', sebagai #sebutan_pihak1# ',bulan_romawi(b.urutan) ) SEPARATOR ';<br>' ),
							CONCAT(b.nama,  ', sebagai #sebutan_pihak1#;' ))
							AS DATA
							FROM perkara_pihak1 b 
							WHERE b.perkara_id = perkara.`perkara_id` ) AS identitas_p
					,(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(b.nama, ', sebagai #sebutan_pihak2# ',bulan_romawi(b.urutan) ) SEPARATOR ';<br>' ),
							CONCAT(b.nama, ', sebagai #sebutan_pihak2#;' ))
							AS DATA
							FROM perkara_pihak2 b
							WHERE b.perkara_id = perkara.`perkara_id` ) AS identitas_t
					,pengacara_pihak1 AS kuasa_p
					,pengacara_pihak2 AS kuasa_t
					
				FROM perkara
				where nomor_perkara= '$noperk'";
		}
		else if ($tingkat == "perkara_eksekusi")
		{
			$sql = "SELECT 

					jurusita_nama AS nama_js
					,'' AS jenis_penyitaan_nama
					,penetapan_sita_eksekusi AS tanggal_penetapan_sita
					,(SELECT
						IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(pihak_nama, ', sebagai Pemohon Eksekusi ' ) SEPARATOR ';<br> ' ),

							CONCAT(pihak_nama,' sebagai Pemohon Eksekusi;' ))
							AS DATA
						FROM
							perkara_eksekusi_detil b 
						WHERE b.perkara_id = perkara_eksekusi.perkara_id AND status_pihak_id=1)	AS identitas_p
					,(SELECT
						IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(pihak_nama, ', sebagai Termohon Eksekusi ' ) SEPARATOR '' ),

							CONCAT(pihak_nama,' sebagai Pemohon Eksekusi;' ))
							AS DATA
						FROM
							perkara_eksekusi_detil b 
						WHERE b.perkara_id = perkara_eksekusi.perkara_id AND status_pihak_id=2)	AS identitas_t
					,(SELECT pemohon_nama FROM perkara_eksekusi_detil where perkara_id=perkara_eksekusi.perkara_id AND status_pihak_id=1 AND pihak_diwakili='Y' LIMIT 1) as kuasa_p	
					,(SELECT pemohon_nama FROM perkara_eksekusi_detil where perkara_id=perkara_eksekusi.perkara_id AND status_pihak_id=2 AND pihak_diwakili='Y' LIMIT 1) as kuasa_t	
				FROM ".$tingkat."
				where nomor_register_eksekusi = '$noperk'  ";
		}
		else if ($tingkat == "perkara_eksekusi_ht")
		{
			$sql = "SELECT 

					jurusita_nama AS nama_js
					,jenis_ht_text AS jenis_penyitaan_nama
					,penetapan_sita_eksekusi AS tanggal_penetapan_sita
					,(SELECT
						IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(pihak_nama, ', sebagai Pemohon Eksekusi ' ) SEPARATOR '\\r' ),

							CONCAT(pihak_nama,' sebagai Pemohon Eksekusi;' ))
							AS DATA
						FROM
							perkara_eksekusi_detil_ht b 
						WHERE b.ht_id = perkara_eksekusi_ht.ht_id AND status_pihak_id=1)	AS identitas_p
					,(SELECT
						IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(pihak_nama, ', sebagai Termohon Eksekusi ' ) SEPARATOR '\\r' ),

							CONCAT(pihak_nama,' sebagai Pemohon Eksekusi;' ))
							AS DATA
						FROM
							perkara_eksekusi_detil_ht b 
						WHERE b.ht_id = perkara_eksekusi_ht.ht_id AND status_pihak_id=2)	AS identitas_t
					,(SELECT pemohon_nama FROM perkara_eksekusi_detil_ht where ht_id=perkara_eksekusi_ht.ht_id AND status_pihak_id=1 AND pihak_diwakili='Y' LIMIT 1) as kuasa_p	
					,(SELECT pemohon_nama FROM perkara_eksekusi_detil_ht where ht_id=perkara_eksekusi_ht.ht_id AND status_pihak_id=2 AND pihak_diwakili='Y' LIMIT 1) as kuasa_t	
						

				FROM ".$tingkat."
				where eksekusi_nomor_perkara = '$noperk'  ";
		}else
		{
			$sql = "SELECT  

					'' AS nama_js
					,'' AS jenis_penyitaan_nama
					,'' AS tanggal_penetapan_sita
					,(SELECT
						IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(pihak_nama, ', sebagai ',status_pihak_text ) SEPARATOR '\\r' ),

							CONCAT(pihak_nama,' sebagai ',status_pihak_text ))
							AS DATA
						FROM
							".$tingkat."_detil b 
						WHERE b.perkara_id = ".$tingkat.".perkara_id AND (status_pihak_id=1 OR status_pihak_id=2) )	AS identitas_p
					,(SELECT
						IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(pihak_nama, ', sebagai ',status_pihak_text ) SEPARATOR '\\r' ),

							CONCAT(pihak_nama,' sebagai ',status_pihak_text ))
							AS DATA
						FROM
							".$tingkat."_detil b 
						WHERE b.perkara_id = ".$tingkat.".perkara_id AND (status_pihak_id=4 OR status_pihak_id=5))	AS identitas_t
					,(SELECT pemohon_nama FROM ".$tingkat."_detil where perkara_id=".$tingkat.".perkara_id AND status_pihak_id=1 AND pihak_diwakili='Y' LIMIT 1) as kuasa_p	
					,(SELECT pemohon_nama FROM ".$tingkat."_detil where perkara_id=".$tingkat.".perkara_id AND status_pihak_id=2 AND pihak_diwakili='Y' LIMIT 1) as kuasa_t	
				FROM ".$tingkat."
				where nomor_perkara_pn  = '$noperk'  ";
		}
	 
		$q = $this
			->dbsipp
			->query($sql);
		return $q->result();
	}
	function data_json_perkara($noperk, $jenis_register)
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		if ($jenis_register == 1)
		{
			$sql = "SELECT nomor_perkara
				FROM perkara
				where SUBSTRING_INDEX(nomor_perkara,'/',1) = '$noperk' AND alur_perkara_id=16 order by perkara_id DESC ";
		}
		else if ($jenis_register == 2)
		{
			$sql = "SELECT nomor_perkara
				FROM perkara
				where SUBSTRING_INDEX(nomor_perkara,'/',1) = '$noperk' AND alur_perkara_id=15 order by perkara_id DESC ";
		}
		else if ($jenis_register == 3)
		{
			$sql = "SELECT nomor_perkara_pn as nomor_perkara
				FROM perkara_banding
				where nomor_perkara_pn like '$noperk%'";
		}
		else if ($jenis_register == 4)
		{
			$sql = "SELECT nomor_perkara_pn as nomor_perkara
				FROM perkara_kasasi
				where nomor_perkara_pn like '$noperk%'";
		}
		else if ($jenis_register == 5)
		{
			$sql = "SELECT nomor_perkara_pn as nomor_perkara
				FROM perkara_pk
				where nomor_perkara_pn like '$noperk%'";
		}
		else if ($jenis_register == 8)
		{
			$sql = "SELECT b.nomor_perkara from perkara_pengacara as a
				left join perkara as b on b.perkara_id=a.perkara_id
				where SUBSTRING_INDEX(b.nomor_perkara,'/',1) = '$noperk'
				order by a.id DESC
				";
		}
		else if ($jenis_register == 9 or $jenis_register == 6 or $jenis_register == 7 or $jenis_register == 15)
		{
			$sql = "SELECT nomor_register_eksekusi as nomor_perkara
				FROM perkara_eksekusi
				where nomor_register_eksekusi like '$noperk%'
				UNION
				SELECT eksekusi_nomor_perkara as nomor_perkara
				FROM perkara_eksekusi_ht
				where eksekusi_nomor_perkara like '$noperk%'
				";
		}
		else if ($jenis_register == 10)
		{
			$sql = "SELECT nomor_perkara
				FROM perkara_akta_cerai
				LEFT JOIN perkara ON perkara.perkara_id=perkara_akta_cerai.perkara_id
				where SUBSTRING_INDEX(nomor_perkara,'/',1) = '$noperk' AND perkara_akta_cerai.nomor_akta_cerai IS NOT NULL";
		}
		else if ($jenis_register == 11)
		{
			$sql = "SELECT nomor_perkara
				FROM perkara
				where nomor_perkara like '$noperk%' AND alur_perkara_id=122 ORDER BY perkara_id DESC";
		}
		else if ($jenis_register == 12)
		{
			$sql = "SELECT nomor_perkara
				FROM perkara
				where nomor_perkara like '$noperk%' AND jenis_perkara_id=371 ORDER BY perkara_id DESC";
		}
		else if ($jenis_register == 13)
		{
			$sql = "SELECT nomor_perkara
				FROM perkara
				where nomor_perkara like '$noperk%' AND jenis_perkara_id=370";
		}
		else if ($jenis_register == 16)
		{
			$sql = "SELECT b.nomor_perkara from perkara_mediasi as a
				left join perkara as b on b.perkara_id=a.perkara_id
				where SUBSTRING_INDEX(b.nomor_perkara,'/',1) = '$noperk'
				order by a.mediasi_id DESC
				";
		}
		else
		{
			exit;
		}
		$q = $this
			->dbsipp
			->query($sql);
		$data = array();
		foreach ($q->result_array() as $d)
		{
			$temp = $d['nomor_perkara'];
			array_push($data, $temp);
		}

		return $data;
	}
	function register_2($tahun, $bulan, $tahapan=0, $perkara_id='')
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		if ($tahapan == 1)
		{
			$sql_tahapan = " AND perkara_putusan.perkara_id IS NULL ";
		}
		else if ($tahapan == 15)
		{
			$sql_tahapan = " AND perkara_putusan.perkara_id IS NOT NULL ";
		}
		else
		{
			$sql_tahapan = " ";
		}
		if ($bulan == 0)
		{
			$sql_waktu = " YEAR(perkara.tanggal_pendaftaran)=$tahun ";
		}
		else
		{
			$sql_waktu = " YEAR(perkara.tanggal_pendaftaran)=$tahun AND MONTH(perkara.tanggal_pendaftaran)=$bulan ";
		}

		if($perkara_id<>'')
		{
			$sql_waktu=" perkara.perkara_id=$perkara_id ";
			
		}
		$q = $this
			->dbsipp
			->query("
					SELECT
						perkara.perkara_id
						,perkara.nomor_urut_perkara
						,perkara.nomor_urut_register
						,perkara.nomor_perkara
						,perkara.jenis_perkara_id
						,perkara.jenis_perkara_nama
						,convert_tanggal_indonesia(perkara.tanggal_pendaftaran) AS tanggal_pendaftaran_indonesia
						,(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',f.nama, ', tempat kediaman di ', d.alamat, ', sebagai #sebutan_pihak1# ',bulan_romawi(b.urutan) ) SEPARATOR ';<br>' ),
							CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',f.nama, ', tempat kediaman di ', d.alamat, ', sebagai #sebutan_pihak1#;' ))
							AS DATA
							FROM perkara_pihak1 b
							JOIN perkara a ON a.perkara_id = b.perkara_id
 							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
							LEFT JOIN tingkat_pendidikan f ON d.pendidikan_id = f.id
							WHERE a.perkara_id = perkara.`perkara_id` ) AS identitas_p
						,(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',f.nama, ', tempat kediaman di ', d.alamat, ', sebagai #sebutan_pihak2# ',bulan_romawi(b.urutan) ) SEPARATOR ';<br>' ),
							CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',f.nama, ', tempat kediaman di ', d.alamat, ', sebagai #sebutan_pihak2#;' ))
							AS DATA
							FROM perkara_pihak2 b
							JOIN perkara a ON a.perkara_id = b.perkara_id
 							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
							LEFT JOIN tingkat_pendidikan f ON d.pendidikan_id = f.id
							WHERE a.perkara_id = perkara.`perkara_id` ) AS identitas_t
						,(select GROUP_CONCAT(CONCAT(case when pihak_ke =1 then '#sebutan_pihak1#' else '#sebutan_pihak2#' END,'<br>B. '
							 ,convert_tanggal_indonesia(tanggal_kuasa)
							 ,'<br>C. '
							 ,nama,'')SEPARATOR '<br><br>') 
							from perkara_pengacara WHERE perkara_id=perkara.perkara_id 
							 
							) AS tgl_nama_kuasa 
						,perkara.petitum
						,perkara.jenis_perkara_text
						,convert_tanggal_indonesia(perkara_penetapan.penetapan_hari_sidang) as phs
						,convert_tanggal_indonesia(perkara_penetapan.sidang_pertama) as sidangpertama
						,convert_tanggal_indonesia(perkara_putusan.tanggal_putusan) as tanggalputusan
						,convert_tanggal_indonesia(perkara_putusan.tanggal_bht) as tanggalbht
						,convert_tanggal_indonesia(perkara_putusan.tanggal_minutasi) as tanggalminutasi
						,convert_tanggal_indonesia(perkara_verzet.tanggal_pendaftaran_verzet) as tanggalpendaftaranverzet
						,convert_tanggal_indonesia(perkara_verzet.tanggal_penetapan_sidang_verzet) as tanggalpenetapansidangverzet
						,convert_tanggal_indonesia(perkara_verzet.tanggal_sidang_pertama_verzet) as tanggalsidangpertamaverzet
						,convert_tanggal_indonesia(perkara_verzet.putusan_verzet) as putusanverzet
						,convert_tanggal_indonesia(perkara_verzet.tanggal_bht) as tanggalbhtverzet
						,perkara_verzet.amar_putusan_verzet
						,perkara_putusan.amar_putusan
						,perkara_penetapan.sidang_pertama
						,(SELECT group_concat(CONCAT('<li>',convert_tanggal_indonesia(tanggal_sidang),'<br>',agenda,'</li>')separator '')
								as penundaan_sidang FROM perkara_jadwal_sidang WHERE perkara_id=perkara.perkara_id AND ditunda='Y' AND keberatan='T' AND ikrar_talak='T' AND tanggal_sidang > 'perkara_penetapan.sidang_pertama' AND urutan<>1) as penundaan_sidang
						,(SELECT group_concat(CONCAT('<ol><li>',convert_tanggal_indonesia(tanggal_sidang),'<br>',agenda,'</li></ol>')separator '')
								as penundaan_sidang FROM perkara_jadwal_sidang WHERE perkara_id=perkara.perkara_id AND verzet='Y' AND ditunda='Y' AND tanggal_sidang > 'perkara_verzet.tanggal_sidang_pertama_verzet') as penundaan_sidang_verzet
						,(SELECT group_concat(CONCAT('<p>#sebutan_pihak',pihak,'# - ',convert_tanggal_indonesia(tanggal_pemberitahuan_putusan),'</p>')separator '<br>')
								as pemberitahuan_isi_putusan FROM perkara_putusan_pemberitahuan_putusan WHERE perkara_id=perkara.perkara_id AND tanggal_pemberitahuan_putusan IS NOT NULL) as pemberitahuan_isi_putusan

						,perkara_akta_cerai.nomor_akta_cerai
						,convert_tanggal_indonesia(perkara_akta_cerai.tgl_akta_cerai) as tglaktacerai
						,perkara_akta_cerai.no_seri_akta_cerai
						,convert_tanggal_indonesia(perkara_ikrar_talak.tanggal_penetapan_sidang_ikrar) AS tanggal_penetapan_sidang_ikrar
						,convert_tanggal_indonesia(perkara_ikrar_talak.penetapan_majelis_hakim) AS penetapan_majelis_hakim_ikrar
						,convert_tanggal_indonesia(perkara_ikrar_talak.tanggal_sidang_pertama) AS tanggal_sidang_pertama_ikrar
						,convert_tanggal_indonesia(perkara_ikrar_talak.tgl_ikrar_talak) AS tgl_ikrar_talak
						,perkara_ikrar_talak.amar_ikrar_talak

						,convert_tanggal_indonesia(perkara_banding.permohonan_banding) AS permohonan_banding
						,convert_tanggal_indonesia(perkara_banding.pemberitahuan_permohonan_banding) AS pemberitahuan_permohonan_banding
						,convert_tanggal_indonesia(perkara_banding.penerimaan_memori_banding) AS penerimaan_memori_banding
						,convert_tanggal_indonesia(perkara_banding.penyerahan_memori_banding) AS penyerahan_memori_banding
						,convert_tanggal_indonesia(perkara_banding.penerimaan_kontra_banding) AS penerimaan_kontra_banding
						,convert_tanggal_indonesia(perkara_banding.penyerahan_kontra_banding) AS penyerahan_kontra_banding
						,convert_tanggal_indonesia(perkara_banding.pelaksanaan_inzage) AS pelaksanaan_inzage
						,convert_tanggal_indonesia(perkara_banding.pengiriman_berkas_banding) AS pengiriman_berkas_banding
						,perkara_banding.nomor_surat_pengiriman_berkas_banding 
						,convert_tanggal_indonesia(perkara_banding.penerimaan_kembali_berkas_banding) AS penerimaan_kembali_berkas_banding
						,convert_tanggal_indonesia(perkara_banding.pemberitahuan_putusan_banding) AS pemberitahuan_putusan_banding
						,convert_tanggal_indonesia(perkara_banding.putusan_banding) AS putusan_banding
						,perkara_banding.nomor_putusan_banding
						,perkara_banding.amar_putusan_banding

						,convert_tanggal_indonesia(perkara_kasasi.permohonan_kasasi) AS permohonan_kasasi
						,convert_tanggal_indonesia(perkara_kasasi.pemberitahuan_kasasi) AS pemberitahuan_kasasi
						,convert_tanggal_indonesia(perkara_kasasi.penerimaan_memori_kasasi) AS penerimaan_memori_kasasi
						,convert_tanggal_indonesia(perkara_kasasi.penyerahan_memori_kasasi	) AS penyerahan_memori_kasasi	
						,convert_tanggal_indonesia(perkara_kasasi.penerimaan_kontra_kasasi	) AS penerimaan_kontra_kasasi	
						,convert_tanggal_indonesia(perkara_kasasi.penyerahan_kontra_kasasi	) AS penyerahan_kontra_kasasi	
						,convert_tanggal_indonesia(perkara_kasasi.pelaksanaan_inzage_kasasi) AS pelaksanaan_inzage_kasasi		
						,convert_tanggal_indonesia(perkara_kasasi.pengiriman_berkas_kasasi) AS pengiriman_berkas_kasasi		
						,convert_tanggal_indonesia(perkara_kasasi.penerimaan_berkas_kasasi) AS penerimaan_berkas_kasasi		
						,convert_tanggal_indonesia(perkara_kasasi.pemberitahuan_putusan_kasasi) AS pemberitahuan_putusan_kasasi		
						,convert_tanggal_indonesia(perkara_kasasi.putusan_kasasi) AS putusan_kasasi
						,perkara_kasasi.nomor_putusan_kasasi
						,perkara_kasasi.amar_putusan_kasasi	

						,convert_tanggal_indonesia(perkara_pk.permohonan_pk) AS permohonan_pk	
						,convert_tanggal_indonesia(perkara_pk.pemberitahuan_pk) AS pemberitahuan_pk	
						,convert_tanggal_indonesia(perkara_pk.penerimaan_memori_pk) AS penerimaan_memori_pk	
						,convert_tanggal_indonesia(perkara_pk.penyerahan_memori_pk) AS penyerahan_memori_pk	
						,convert_tanggal_indonesia(perkara_pk.penerimaan_kontra_pk) AS penerimaan_kontra_pk	
						,convert_tanggal_indonesia(perkara_pk.penyerahan_kontra_pk) AS penyerahan_kontra_pk	
						,convert_tanggal_indonesia(perkara_pk.pengiriman_berkas_pk) AS pengiriman_berkas_pk	
						,convert_tanggal_indonesia(perkara_pk.penerimaan_berkas_pk) AS penerimaan_berkas_pk	
						,convert_tanggal_indonesia(perkara_pk.tanggal_penyumpahan) AS tanggal_penyumpahan_novum
						,perkara_pk.nomor_perkara_pk
						,convert_tanggal_indonesia(perkara_pk.putusan_pk) AS putusan_pk	
						,perkara_pk.amar_putusan_pk
						,convert_tanggal_indonesia(perkara_pk.pemberitahuan_putusan_pk) AS pemberitahuan_putusan_pk

						,convert_tanggal_indonesia(perkara_eksekusi.permohonan_eksekusi) AS permohonan_eksekusi	
						,convert_tanggal_indonesia(perkara_eksekusi.pelaksanaan_teguran_eksekusi) AS pelaksanaan_teguran_eksekusi	
						,convert_tanggal_indonesia(perkara_eksekusi.penetapan_teguran_eksekusi) AS penetapan_teguran_eksekusi	
						,convert_tanggal_indonesia(perkara_eksekusi.pelaksanaan_sita_eksekusi) AS pelaksanaan_sita_eksekusi	
						,convert_tanggal_indonesia(med.penetapan_penunjukan_mediator) AS penetapan_penunjukan_mediator	
						,convert_tanggal_indonesia(med.tgl_laporan_mediator) AS tgl_laporan_mediator	
						,med.hasil_mediasi as hasil_mediasi
						,med.nama_gelar as nama_gelar_mediator
						,med.no_sertifikasi as no_sertifikasi
						,med.tgl_sertifikasi as tgl_sertifikasi
						,(select group_concat(concat(pihak_asal_text,' : ',convert_tanggal_indonesia(pemohon_tanggal_surat)) SEPARATOR '<br>') from perkara_banding_detil where pihak_diwakili='Y' and perkara_id=perkara.perkara_id) as tanggal_kuasa_banding						
						,(select group_concat(concat(pihak_asal_text,' : ',pemohon_nama) SEPARATOR '<br>') from perkara_banding_detil where pihak_diwakili='Y' and perkara_id=perkara.perkara_id) as nama_kuasa_banding
						,(select group_concat(concat(pihak_asal_text,' : ',convert_tanggal_indonesia(pemohon_tanggal_surat)) SEPARATOR '<br>') from perkara_kasasi_detil where pihak_diwakili='Y' and perkara_id=perkara.perkara_id) as tanggal_kuasa_kasasi		
						,(select group_concat(concat(pihak_asal_text,' : ',pemohon_nama) SEPARATOR '<br>') from perkara_kasasi_detil where pihak_diwakili='Y' and perkara_id=perkara.perkara_id) as nama_kuasa_kasasi

						,(select group_concat(concat(pihak_asal_text,' : ',convert_tanggal_indonesia(pemohon_tanggal_surat)) SEPARATOR '<br>') from perkara_pk_detil where pihak_diwakili='Y' and perkara_id=perkara.perkara_id) as tanggal_kuasa_pk
						,(select group_concat(concat(pihak_asal_text,' : ',pemohon_nama) SEPARATOR '<br>') from perkara_pk_detil where pihak_diwakili='Y' and perkara_id=perkara.perkara_id) as nama_kuasa_pk

						FROM
							perkara
						LEFT JOIN perkara_putusan ON perkara_putusan.perkara_id=perkara.perkara_id
						LEFT JOIN perkara_penetapan ON perkara_penetapan.perkara_id=perkara.perkara_id
						LEFT JOIN perkara_verzet ON perkara_verzet.perkara_id=perkara.perkara_id
						LEFT JOIN perkara_akta_cerai ON perkara_akta_cerai.perkara_id=perkara.perkara_id
						LEFT JOIN perkara_ikrar_talak ON perkara_ikrar_talak.perkara_id=perkara.perkara_id
						LEFT JOIN perkara_banding ON perkara_banding.perkara_id=perkara.perkara_id
						LEFT JOIN perkara_kasasi ON perkara_kasasi.perkara_id=perkara.perkara_id
						LEFT JOIN perkara_pk ON perkara_pk.perkara_id=perkara.perkara_id
						LEFT JOIN perkara_eksekusi ON perkara_eksekusi.perkara_id=perkara.perkara_id
						LEFT JOIN (SELECT perkara_id, hasil_mediasi, tgl_laporan_mediator, penetapan_penunjukan_mediator,nama_gelar,no_sertifikasi,tgl_sertifikasi from perkara_mediasi left join mediator on mediator.id=perkara_mediasi.mediator_id) AS med ON med.perkara_id=perkara.perkara_id


						WHERE $sql_waktu AND perkara.alur_perkara_id=15 $sql_tahapan ORDER BY perkara.perkara_id ASC
			");

		return $q->result();
	}
	function register_1($tahun, $bulan, $tahapan=0, $perkara_id='')
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		if ($tahapan == 1)
		{
			$sql_tahapan = " AND perkara_putusan.perkara_id IS NULL ";
		}
		else if ($tahapan == 15)
		{
			$sql_tahapan = " AND perkara_putusan.perkara_id IS NOT NULL ";
		}
		else
		{
			$sql_tahapan = " ";
		}
		if ($bulan == 0)
		{
			$sql_waktu = " YEAR(perkara.tanggal_pendaftaran)=$tahun ";
		}
		else
		{
			$sql_waktu = " YEAR(perkara.tanggal_pendaftaran)=$tahun AND MONTH(perkara.tanggal_pendaftaran)=$bulan ";
		}
		if($perkara_id<>'')
		{
			$sql_waktu=" perkara.perkara_id=$perkara_id ";
			
		}
		$q = $this->dbsipp->query("
					SELECT
						perkara.perkara_id
						,perkara.nomor_urut_perkara
						,perkara.nomor_urut_register
						,perkara.nomor_perkara
						,perkara.jenis_perkara_id
						,perkara.jenis_perkara_nama
						,convert_tanggal_indonesia(perkara.tanggal_pendaftaran) AS tanggal_pendaftaran_indonesia
						,(select group_concat(concat(status_pihak_text,' : ',pemohon_nama) SEPARATOR '<br>') from perkara_kasasi_detil where pihak_diwakili='Y' and perkara_id=perkara.perkara_id) as nama_kuasa_kasasi 
						,(select group_concat(concat(status_pihak_text,' : ',convert_tanggal_indonesia(pemohon_tanggal_surat)) SEPARATOR '<br>') from perkara_kasasi_detil where pihak_diwakili='Y' and perkara_id=perkara.perkara_id) as tanggal_kuasa_kasasi	
						,(select GROUP_CONCAT(CONCAT(case when pihak_ke =1 then '#sebutan_pihak1#' else '#sebutan_pihak2#' END,'<br>B. '
							 ,convert_tanggal_indonesia(tanggal_kuasa)
							 ,'<br>C. '
							 ,nama,'')SEPARATOR '<br><br>') 
							from perkara_pengacara WHERE perkara_id=perkara.perkara_id 
							 
							) AS tgl_nama_kuasa 
						,(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',f.nama, ', tempat kediaman di ', d.alamat, ', sebagai #sebutan_pihak1# ',bulan_romawi(b.urutan) ) SEPARATOR ';<br>' ),
							CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',f.nama, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon;' ))
							AS DATA
							FROM perkara_pihak1 b
							JOIN perkara a ON a.perkara_id = b.perkara_id
							LEFT JOIN perkara_pengacara c ON a.perkara_id = c.perkara_id AND b.pihak_id = c.pihak_id
							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
							LEFT JOIN tingkat_pendidikan f ON d.pendidikan_id = f.id
							WHERE a.perkara_id = perkara.`perkara_id` ) AS identitas_p
						,(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',f.nama, ', tempat kediaman di ', d.alamat, ', sebagai #sebutan_pihak2# ',bulan_romawi(b.urutan) ) SEPARATOR ';<br>' ),
							CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',f.nama, ', tempat kediaman di ', d.alamat, ', sebagai Termohon;' ))
							AS DATA
							FROM perkara_pihak2 b
							JOIN perkara a ON a.perkara_id = b.perkara_id
							LEFT JOIN perkara_pengacara c ON a.perkara_id = c.perkara_id AND b.pihak_id = c.pihak_id
							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
							LEFT JOIN tingkat_pendidikan f ON d.pendidikan_id = f.id
							WHERE a.perkara_id = perkara.`perkara_id` ) AS identitas_t

						,perkara.petitum
						,perkara.jenis_perkara_text
						,convert_tanggal_indonesia(perkara_penetapan.penetapan_hari_sidang) as phs
						,convert_tanggal_indonesia(perkara_penetapan.sidang_pertama) as sidangpertama
						,convert_tanggal_indonesia(perkara_putusan.tanggal_putusan) as tanggalputusan
						,convert_tanggal_indonesia(perkara_putusan.tanggal_bht) as tanggalbht
						,convert_tanggal_indonesia(perkara_putusan.tanggal_minutasi) as tanggalminutasi

						,perkara_putusan.amar_putusan
						,perkara_penetapan.sidang_pertama
						,(SELECT group_concat(CONCAT('<ol><li>',convert_tanggal_indonesia(tanggal_sidang),'</li><li>',alasan_ditunda,'</li></ol>')separator '')
								as penundaan_sidang FROM perkara_jadwal_sidang WHERE perkara_id=perkara.perkara_id AND ditunda='Y' AND tanggal_sidang <> 'perkara_penetapan.sidang_pertama' AND verzet='T' AND urutan<>1) as penundaan_sidang
						,(SELECT group_concat(CONCAT('<ol><li>',convert_tanggal_indonesia(tanggal_sidang),'<br>',alasan_ditunda,'</li></ol>')separator '')
								as penundaan_sidang FROM perkara_jadwal_sidang WHERE perkara_id=perkara.perkara_id AND verzet='Y' AND ditunda='Y' AND tanggal_sidang >= 'perkara_verzet.tanggal_sidang_pertama_verzet') as penundaan_sidang_verzet
						,(SELECT group_concat(CONCAT('<p>#sebutan_pihak',pihak,'# - ',convert_tanggal_indonesia(tanggal_pemberitahuan_putusan),'</p>')separator '<br>')
								as pemberitahuan_isi_putusan FROM perkara_putusan_pemberitahuan_putusan WHERE perkara_id=perkara.perkara_id AND tanggal_pemberitahuan_putusan IS NOT NULL) as pemberitahuan_isi_putusan
						

						,convert_tanggal_indonesia(perkara_kasasi.permohonan_kasasi) AS permohonan_kasasi
						,convert_tanggal_indonesia(perkara_kasasi.pemberitahuan_kasasi) AS pemberitahuan_kasasi
						,convert_tanggal_indonesia(perkara_kasasi.penerimaan_memori_kasasi) AS penerimaan_memori_kasasi
						,convert_tanggal_indonesia(perkara_kasasi.penyerahan_memori_kasasi	) AS penyerahan_memori_kasasi	
						,convert_tanggal_indonesia(perkara_kasasi.penerimaan_kontra_kasasi	) AS penerimaan_kontra_kasasi	
						,convert_tanggal_indonesia(perkara_kasasi.penyerahan_kontra_kasasi	) AS penyerahan_kontra_kasasi	
						,convert_tanggal_indonesia(perkara_kasasi.pelaksanaan_inzage_kasasi) AS pelaksanaan_inzage_kasasi		
						,convert_tanggal_indonesia(perkara_kasasi.pengiriman_berkas_kasasi) AS pengiriman_berkas_kasasi		
						,convert_tanggal_indonesia(perkara_kasasi.penerimaan_berkas_kasasi) AS penerimaan_berkas_kasasi		
						,convert_tanggal_indonesia(perkara_kasasi.pemberitahuan_putusan_kasasi) AS pemberitahuan_putusan_kasasi		
						,convert_tanggal_indonesia(perkara_kasasi.putusan_kasasi) AS putusan_kasasi
						,perkara_kasasi.nomor_putusan_kasasi
						,perkara_kasasi.amar_putusan_kasasi			


						FROM
							perkara
						LEFT JOIN perkara_putusan ON perkara_putusan.perkara_id=perkara.perkara_id
						LEFT JOIN perkara_penetapan ON perkara_penetapan.perkara_id=perkara.perkara_id
						LEFT JOIN perkara_kasasi ON perkara_kasasi.perkara_id=perkara.perkara_id

						WHERE $sql_waktu AND perkara.alur_perkara_id=16 $sql_tahapan ORDER BY perkara.perkara_id ASC
			");

		return $q->result();
	}
	///ardan
	function register_3($tahun, $bulan, $tahapan, $perkara_id='')
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		if ($bulan == 0)
		{
			$sql_waktu = " YEAR(v_perkara_banding.permohonan_banding)=$tahun ";
		}
		else
		{
			$sql_waktu = " YEAR(v_perkara_banding.permohonan_banding)=$tahun AND MONTH(v_perkara_banding.permohonan_banding)=$bulan ";
		}

		if($perkara_id<>'')
		{
			$sql_waktu=" v_perkara_banding.perkara_id=$perkara_id ";
			
		}
		$q = $this
			->dbsipp
			->query("
						SELECT 
						v_perkara_banding.*
						,convert_tanggal_indonesia(v_perkara_banding.permohonan_banding) as permohonan_banding 
						,convert_tanggal_indonesia(v_perkara_banding.putusan_pn) as putusan_pn 
						,convert_tanggal_indonesia(v_perkara_banding.pemberitahuan_putusan_pn) as pemberitahuan_putusan_pn 
						,convert_tanggal_indonesia(v_perkara_banding.pemberitahuan_permohonan_banding) as pemberitahuan_permohonan_banding 
						,convert_tanggal_indonesia(v_perkara_banding.penerimaan_memori_banding) as penerimaan_memori_banding 
						,convert_tanggal_indonesia(v_perkara_banding.penyerahan_memori_banding) as penyerahan_memori_banding 
						,convert_tanggal_indonesia(v_perkara_banding.penerimaan_kontra_banding) as penerimaan_kontra_banding 
						,convert_tanggal_indonesia(v_perkara_banding.minutasi_banding) as minutasi_banding 
						,convert_tanggal_indonesia(v_perkara_banding.pelaksanaan_inzage) as pelaksanaan_inzage
						,convert_tanggal_indonesia(v_perkara_banding.pengiriman_berkas_banding) as pengiriman_berkas_banding
						,convert_tanggal_indonesia(v_perkara_banding.putusan_banding) as putusan_banding
						,convert_tanggal_indonesia(v_perkara_banding.pemberitahuan_putusan_banding) as pemberitahuan_putusan_banding
						,convert_tanggal_indonesia(v_perkara_banding.penerimaan_kembali_berkas_banding) as penerimaan_kembali_berkas_banding
						,perkara.jenis_perkara_nama
						,perkara_pengacara.nama
						,convert_tanggal_indonesia(perkara_pengacara.tanggal_kuasa) as tanggal_kuasa
						,
						CONCAT(
						CASE WHEN v_perkara_banding.pihak_pembanding=1 OR v_perkara_banding.pihak_pembanding=4 
						THEN
							(SELECT 
									IF(COUNT(b.pihak_id)>1,
									GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Pembanding ',bulan_romawi(b.urutan) ) SEPARATOR '; <br><br> ' ),
									CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', sebagai Pembanding;' ))
									AS DATA
									FROM perkara_pihak1 b 
									JOIN perkara a ON a.perkara_id = b.perkara_id
									JOIN pihak d ON b.pihak_id = d.id
									JOIN agama e ON d.agama_id = e.id
									WHERE b.perkara_id = v_perkara_banding.`perkara_id` )
						ELSE 
							(SELECT 
									IF(COUNT(b.pihak_id)>1,
									GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END
									, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Pembanding ',bulan_romawi(b.urutan) ) SEPARATOR '; <br> ' ),
									CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',

									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END


									, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Pembanding;' ))
									AS DATA
									FROM perkara_pihak2 b 
									JOIN perkara a ON a.perkara_id = b.perkara_id
									JOIN pihak d ON b.pihak_id = d.id
									JOIN agama e ON d.agama_id = e.id
									WHERE b.perkara_id = v_perkara_banding.`perkara_id` ) 

						END , '<br>',
						CASE WHEN v_perkara_banding.pihak_pembanding=2 OR v_perkara_banding.pihak_pembanding=5
						THEN
							(SELECT 
									IF(COUNT(b.pihak_id)>1,
									CONCAT('<center>Melawan</center><br>',
									GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Terbanding ',bulan_romawi(b.urutan) ) SEPARATOR '; <br><br> ' )),
									CONCAT('<br><center>Melawan</center><br>',d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', sebagai Terbanding;' ))
									AS DATA
									FROM perkara_pihak1 b 
									JOIN perkara a ON a.perkara_id = b.perkara_id
									JOIN pihak d ON b.pihak_id = d.id
									JOIN agama e ON d.agama_id = e.id
									WHERE b.perkara_id = v_perkara_banding.`perkara_id` )
						ELSE 
							(SELECT 
									IF(COUNT(b.pihak_id)>1,
									GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END
									, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Pembanding ',bulan_romawi(b.urutan) ) SEPARATOR '; <br> ' ),
									CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',

									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END


									, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Terbanding;' ))
									AS DATA
									FROM perkara_pihak2 b 
									JOIN perkara a ON a.perkara_id = b.perkara_id
									JOIN pihak d ON b.pihak_id = d.id
									JOIN agama e ON d.agama_id = e.id
									WHERE b.perkara_id = v_perkara_banding.`perkara_id` ) 

						END 
						)
						AS pemohon_banding
						,perkara.jenis_perkara_nama
						,perkara_penetapan.panitera_pengganti_text
						,CONCAT(perkara_penetapan.majelis_hakim_text,'<br>',perkara_penetapan.panitera_pengganti_text) AS majelis_hakim_nama
						,(select group_concat(concat(status_pihak_text,' : ',convert_tanggal_indonesia(pemohon_tanggal_surat)) SEPARATOR '<br>') from perkara_banding_detil where pihak_diwakili='Y' and perkara_id=perkara.perkara_id) as tanggal_kuasa_banding						
						,(select group_concat(concat(status_pihak_text,' : ',pemohon_nama) SEPARATOR '<br>') from perkara_banding_detil where pihak_diwakili='Y' and perkara_id=perkara.perkara_id) as nama_kuasa_banding

				FROM v_perkara_banding 
				LEFT JOIN perkara ON perkara.perkara_id=v_perkara_banding.perkara_id 
				LEFT JOIN perkara_penetapan ON perkara_penetapan.perkara_id=v_perkara_banding.perkara_id 
				LEFT JOIN perkara_pengacara ON perkara_pengacara.perkara_id=v_perkara_banding.perkara_id 
				WHERE $sql_waktu
				GROUP BY v_perkara_banding.perkara_id
				ORDER BY v_perkara_banding.permohonan_banding
						
			");

		return $q->result();
	}
	function register_4($tahun, $bulan, $tahapan, $perkara_id='')
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		if ($bulan == 0)
		{
			$sql_waktu = " YEAR(perkara_kasasi.permohonan_kasasi)=$tahun ";
		}
		else
		{
			$sql_waktu = " YEAR(perkara_kasasi.permohonan_kasasi)=$tahun AND MONTH(perkara_kasasi.permohonan_kasasi)=$bulan ";
		}
		if($perkara_id<>'')
		{
			$sql_waktu=" perkara_kasasi.perkara_id=$perkara_id ";
			
		}
		$q = $this
			->dbsipp
			->query("
						SELECT
						perkara.nomor_perkara
						,perkara_kasasi.*
						,convert_tanggal_indonesia(perkara_kasasi.permohonan_kasasi) as permohonan_kasasi
						,convert_tanggal_indonesia(perkara_kasasi.putusan_pn) as putusan_pn
						,convert_tanggal_indonesia(perkara_kasasi.pemberitahuan_putusan_pn) as pemberitahuan_putusan_pn
						,convert_tanggal_indonesia(perkara_kasasi.pemberitahuan_kasasi) as pemberitahuan_kasasi
						,convert_tanggal_indonesia(perkara_kasasi.penerimaan_memori_kasasi) as penerimaan_memori_kasasi
						,convert_tanggal_indonesia(perkara_kasasi.penyerahan_memori_kasasi) as penyerahan_memori_kasasi
						,convert_tanggal_indonesia(perkara_kasasi.penerimaan_kontra_kasasi) as penerimaan_kontra_kasasi
						,convert_tanggal_indonesia(perkara_kasasi.pengiriman_berkas_kasasi) as pengiriman_berkas_kasasi
						,convert_tanggal_indonesia(perkara_kasasi.penerimaan_berkas_kasasi) as penerimaan_berkas_kasasi
						,convert_tanggal_indonesia(perkara_kasasi.putusan_kasasi) as putusan_kasasi
						,convert_tanggal_indonesia(perkara_kasasi.pemberitahuan_putusan_kasasi) as pemberitahuan_putusan_kasasi
						,CASE WHEN perkara_kasasi.pihak_pemohon_kasasi=1 OR perkara_kasasi.pihak_pemohon_kasasi=4 
						THEN
							(SELECT 
									IF(COUNT(b.pihak_id)>1,
									GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon Kasasi ',bulan_romawi(b.urutan) ) SEPARATOR '; <br><br> ' ),
									CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon Kasasi;' ))
									AS DATA
									FROM perkara_pihak1 b 
									JOIN perkara a ON a.perkara_id = b.perkara_id
									JOIN pihak d ON b.pihak_id = d.id
									JOIN agama e ON d.agama_id = e.id
									WHERE b.perkara_id = perkara_kasasi.`perkara_id` )
						ELSE 
							(SELECT 
									IF(COUNT(b.pihak_id)>1,
									GROUP_CONCAT(CONCAT('<br>',d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END
									, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon Kasasi ',bulan_romawi(b.urutan) ) SEPARATOR '; <br><br> ' ),
									CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',

									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END


									, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon Kasasi;' ))
									AS DATA
									FROM perkara_pihak2 b 
									JOIN perkara a ON a.perkara_id = b.perkara_id
									JOIN pihak d ON b.pihak_id = d.id
									JOIN agama e ON d.agama_id = e.id
									WHERE b.perkara_id = perkara_kasasi.`perkara_id` ) 

						END AS pemohon_kasasi
						,CASE WHEN perkara_kasasi.pihak_pemohon_kasasi=1 OR perkara_kasasi.pihak_pemohon_kasasi=4
						THEN
							(SELECT 
									IF(COUNT(b.pihak_id)>1,
									GROUP_CONCAT(CONCAT('<br><br>',d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END
									, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai #sebutan_pihak2# ',bulan_romawi(b.urutan) ) SEPARATOR ';<br>' ),
									CONCAT('<br>',d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',

									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END


									, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Termohon Kasasi;' ))
									AS DATA
									FROM perkara_pihak2 b 
									JOIN perkara a ON a.perkara_id = b.perkara_id
									JOIN pihak d ON b.pihak_id = d.id
									JOIN agama e ON d.agama_id = e.id
									WHERE b.perkara_id = perkara_kasasi.`perkara_id` ) 
						ELSE 
							(SELECT 
									IF(COUNT(b.pihak_id)>1,
									GROUP_CONCAT(CONCAT('<br>',d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai #sebutan_pihak1# ',bulan_romawi(b.urutan) ) SEPARATOR ';<br>' ),
									CONCAT('<br><center>Melawan</center><br>',d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', sebagai Termohon Kasasi;' ))
									AS DATA
									FROM perkara_pihak1 b 
									JOIN perkara a ON a.perkara_id = b.perkara_id
									JOIN pihak d ON b.pihak_id = d.id
									JOIN agama e ON d.agama_id = e.id
									WHERE b.perkara_id = perkara_kasasi.`perkara_id` )

						END AS termohon_kasasi
						,(select group_concat(concat(status_pihak_text,' : ',convert_tanggal_indonesia(pemohon_tanggal_surat)) SEPARATOR '<br>') from perkara_kasasi_detil where pihak_diwakili='Y' and perkara_id=perkara.perkara_id) as tanggal_kuasa_kasasi						
						,(select group_concat(concat(status_pihak_text,' : ',pemohon_nama) SEPARATOR '<br>') from perkara_kasasi_detil where pihak_diwakili='Y' and perkara_id=perkara.perkara_id) as nama_kuasa_kasasi
						,perkara.jenis_perkara_nama
						,perkara_penetapan.panitera_pengganti_text
						,CONCAT(perkara_penetapan.majelis_hakim_text,'<br>',perkara_penetapan.panitera_pengganti_text) AS majelis_hakim_nama
						,perkara_banding.nomor_perkara_banding
						,convert_tanggal_indonesia(perkara_banding.putusan_banding) AS putusan_banding
						,convert_tanggal_indonesia(perkara_banding.pemberitahuan_putusan_banding) AS pemberitahuan_putusan_banding
						,convert_tanggal_indonesia(perkara_putusan.pemberitahuan_putusan) AS pemberitahuan_putusan

				FROM perkara_kasasi
				LEFT JOIN perkara ON perkara.perkara_id=perkara_kasasi.perkara_id 
				LEFT JOIN perkara_penetapan ON perkara_penetapan.perkara_id=perkara_kasasi.perkara_id 
				LEFT JOIN perkara_pengacara ON perkara_pengacara.perkara_id=perkara_kasasi.perkara_id 
				LEFT JOIN perkara_banding ON perkara_banding.perkara_id=perkara_kasasi.perkara_id 
				LEFT JOIN perkara_putusan ON perkara_putusan.perkara_id=perkara_kasasi.perkara_id 
				WHERE $sql_waktu
				GROUP BY perkara_kasasi.perkara_id
				ORDER BY perkara_kasasi.permohonan_kasasi
			");

		return $q->result();
	}
	function register_5($tahun, $bulan, $tahapan, $perkara_id='')
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		if ($bulan == 0)
		{
			$sql_waktu = " YEAR(perkara_pk.permohonan_pk)=$tahun ";
		}
		else
		{
			$sql_waktu = " YEAR(perkara_pk.permohonan_pk)=$tahun AND MONTH(perkara_pk.permohonan_pk)=$bulan ";
		}
		if($perkara_id<>'')
		{
			$sql_waktu=" perkara_pk.perkara_id=$perkara_id ";
		}
		$q = $this
			->dbsipp
			->query("SELECT 
							perkara_pk.*
							,perkara_pengacara.nama 
							,convert_tanggal_indonesia(perkara_pk.permohonan_pk) as permohonan_pk
							,convert_tanggal_indonesia(perkara_putusan.tanggal_bht) as tanggal_bht
							,convert_tanggal_indonesia(perkara_pk.pemberitahuan_pk) as pemberitahuan_pk
							,convert_tanggal_indonesia(perkara_pk.penerimaan_memori_pk) as penerimaan_memori_pk
							,convert_tanggal_indonesia(perkara_pk.pengiriman_berkas_pk) as pengiriman_berkas_pk
							,convert_tanggal_indonesia(perkara_pk.penerimaan_berkas_pk) as penerimaan_berkas_pk
							,convert_tanggal_indonesia(perkara_pk.putusan_pk) as putusan_pk
							,convert_tanggal_indonesia(perkara_pk.pemberitahuan_putusan_pk) as pemberitahuan_putusan_pk
							,CASE WHEN perkara_pk.pihak_pemohon_pk=1 OR perkara_pk.pihak_pemohon_pk=4 
							THEN
								(SELECT 
										IF(COUNT(b.pihak_id)>1,
										GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
											CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon PK ',bulan_romawi(b.urutan) ) SEPARATOR '; <br><br> ' ),
										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
											CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon Peninjauan Kembali;' ))
										AS DATA
										FROM perkara_pihak1 b 
										JOIN perkara a ON a.perkara_id = b.perkara_id
										JOIN pihak d ON b.pihak_id = d.id
										JOIN agama e ON d.agama_id = e.id
										WHERE b.perkara_id = perkara_pk.`perkara_id` )
							ELSE 
								(SELECT 
										IF(COUNT(b.pihak_id)>1,
										GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
											CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END
										, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon Peninjauan Kembali ',bulan_romawi(b.urutan) ) SEPARATOR '; <br><br> ' ),
										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',

										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END


										, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon Peninjauan Kembali;' ))
										AS DATA
										FROM perkara_pihak2 b 
										JOIN perkara a ON a.perkara_id = b.perkara_id
										JOIN pihak d ON b.pihak_id = d.id
										JOIN agama e ON d.agama_id = e.id
										WHERE b.perkara_id = perkara_pk.`perkara_id` ) 

							END AS pemohon_pk
							,CASE WHEN perkara_pk.pihak_pemohon_pk=1 OR perkara_pk.pihak_pemohon_pk=4
							THEN
								(SELECT 
										IF(COUNT(b.pihak_id)>1,
										GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
											CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END
										, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Termohon Peninjauan Kembali ',bulan_romawi(b.urutan) ) SEPARATOR '; <br><br> ' ),
										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',

										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END


										, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Termohon Peninjauan Kembali;' ))
										AS DATA
										FROM perkara_pihak2 b 
										JOIN perkara a ON a.perkara_id = b.perkara_id
										JOIN pihak d ON b.pihak_id = d.id
										JOIN agama e ON d.agama_id = e.id
										WHERE b.perkara_id = perkara_pk.`perkara_id` ) 
							ELSE 
								(SELECT 
										IF(COUNT(b.pihak_id)>1,
										GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
											CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon PK ',bulan_romawi(b.urutan) ) SEPARATOR '; <br><br> ' ),
										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
											CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', sebagai Termohon PK;' ))
										AS DATA
										FROM perkara_pihak1 b 
										JOIN perkara a ON a.perkara_id = b.perkara_id
										JOIN pihak d ON b.pihak_id = d.id
										JOIN agama e ON d.agama_id = e.id
										WHERE b.perkara_id = perkara_pk.`perkara_id` )

							END AS termohon_pk 
							,perkara_kasasi.nomor_putusan_kasasi
							,convert_tanggal_indonesia(perkara_kasasi.pemberitahuan_putusan_kasasi) AS pemberitahuan_putusan_kasasi
							,perkara_banding.nomor_putusan_banding
							,(select group_concat(convert_tanggal_indonesia(pemohon_tanggal_surat) SEPARATOR '<br>') from perkara_pk_detil where pihak_diwakili='Y' and perkara_id=perkara_pk.perkara_id AND status_pihak_id=1) as tanggal_kuasa_pk
							,(select group_concat(pemohon_nama SEPARATOR '<br>') from perkara_pk_detil where pihak_diwakili='Y' and perkara_id=perkara_pk.perkara_id AND status_pihak_id=1) as nama_kuasa_pk
							,(select group_concat(convert_tanggal_indonesia(pemohon_tanggal_surat) SEPARATOR '<br>') from perkara_pk_detil where pihak_diwakili='Y' and perkara_id=perkara_pk.perkara_id AND status_pihak_id=4) as tanggal_kuasa_pk_t
							,(select group_concat(pemohon_nama SEPARATOR '<br>') from perkara_pk_detil where pihak_diwakili='Y' and perkara_id=perkara_pk.perkara_id AND status_pihak_id=4) as nama_kuasa_pk_t

					FROM perkara_pk 
					LEFT JOIN perkara_pengacara ON perkara_pengacara.perkara_id=perkara_pk.perkara_id 
					LEFT JOIN perkara_putusan ON perkara_putusan.perkara_id=perkara_pk.perkara_id 
					LEFT JOIN perkara_kasasi ON perkara_kasasi.perkara_id=perkara_pk.perkara_id 
					LEFT JOIN perkara_banding ON perkara_banding.perkara_id=perkara_pk.perkara_id 
					WHERE $sql_waktu
					GROUP BY perkara_pk.perkara_id
					ORDER BY perkara_pk.permohonan_pk
				");

		return $q->result();
	}
	///ardan
	function register_6_7($tahun, $bulan, $tahapan, $perkara_id='',$jenis_penyitaan_id=1)
	{
		if ($bulan == 0)
		{
			$sql_waktu = " YEAR(tanggal_penetapan_sita)=$tahun  AND jenis_penyitaan_id=$jenis_penyitaan_id";
		}
		else
		{
			$sql_waktu = " YEAR(tanggal_penetapan_sita)=$tahun AND MONTH(tanggal_penetapan_sita)=$bulan AND jenis_penyitaan_id=$jenis_penyitaan_id";
		}
		if($perkara_id<>'')
		{
			$sql_waktu=" id=$perkara_id ";
		}
		$q = $this
			->db
			->query("SELECT register_penyitaan.*
				, convert_tanggal_indonesia(tanggal_penetapan_sita) AS tanggal_penetapan_sita
				, convert_tanggal_indonesia(tanggal_pelaksanaan_sita) AS tanggal_pelaksanaan_sita 
				, convert_tanggal_indonesia(tanggal_pendaftaran_penyitaan) AS tanggal_pendaftaran_penyitaan

				FROM register_penyitaan WHERE $sql_waktu ORDER BY id ASC
				");

		return $q->result();
	}
	function register_7($tahun, $bulan, $tahapan, $perkara_id='')
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
	}
	//ardan
	function register_8($tahun, $bulan, $tahapan)
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		if ($bulan == 0)
		{
			$sql_waktu = " YEAR(perkara_pengacara.aktif_mulai)=$tahun ";
			$sql_waktu_banding = " YEAR(perkara_banding_detil.diinput_tanggal)=$tahun ";
			$sql_waktu_kasasi = " YEAR(perkara_kasasi_detil.diinput_tanggal)=$tahun ";
			$sql_waktu_pk = " YEAR(perkara_pk_detil.diinput_tanggal)=$tahun ";
			$sql_waktu_eksekusi = " YEAR(perkara_eksekusi_detil.diinput_tanggal)=$tahun ";
			$sql_waktu_eksekusi_ht = " YEAR(perkara_eksekusi_detil_ht.diinput_tanggal)=$tahun ";
		}
		else
		{
			$sql_waktu = " YEAR(perkara_pengacara.aktif_mulai)=$tahun AND MONTH(perkara_pengacara.aktif_mulai)=$bulan ";
			$sql_waktu_banding = " YEAR(perkara_banding_detil.diinput_tanggal)=$tahun AND MONTH(perkara_banding_detil.diinput_tanggal)=$bulan ";
			$sql_waktu_kasasi = " YEAR(perkara_kasasi_detil.diinput_tanggal)=$tahun AND MONTH(perkara_kasasi_detil.diinput_tanggal)=$bulan ";
			$sql_waktu_pk = " YEAR(perkara_pk_detil.diinput_tanggal)=$tahun AND MONTH(perkara_pk_detil.diinput_tanggal)=$bulan ";
			$sql_waktu_eksekusi = " YEAR(perkara_eksekusi_detil.diinput_tanggal)=$tahun AND MONTH(perkara_eksekusi.diinput_tanggal)=$bulan ";
			$sql_waktu_eksekusi_ht = " YEAR(perkara_eksekusi_detil_ht.diinput_tanggal)=$tahun AND MONTH(perkara_eksekusi_ht.diinput_tanggal)=$bulan ";
			
		}
		$sql="SELECT 
						convert_tanggal_indonesia(LEFT(perkara_pengacara.aktif_mulai,10)) as tgl
						,perkara_pengacara.nomor_kuasa as nomor_kuasa
						,pihak.nama as nama_p
						,perkara_pengacara.nama as nama
						,(select pekerjaan from pihak where id=perkara_pengacara.pengacara_id) as pekerjaan
						,perkara.nomor_perkara as nomor_perkara
						,convert_tanggal_indonesia(perkara_pengacara.tanggal_kuasa) as tanggal_kuasa 
						,0 as pengacara
						,perkara_pengacara.aktif_mulai AS waktune
						,'' AS keterangan
					FROM perkara_pengacara
					LEFT JOIN pihak ON pihak.id=perkara_pengacara.pihak_id
					LEFT JOIN perkara ON perkara.perkara_id=perkara_pengacara.perkara_id
					WHERE $sql_waktu
					GROUP BY perkara_pengacara.nomor_kuasa
					UNION 
					SELECT 
						convert_tanggal_indonesia(LEFT(perkara_banding_detil.diinput_tanggal,10)) as tgl
						,perkara_banding_detil.pemohon_nomor_surat AS nomor_kuasa
						,perkara_banding_detil.pihak_nama as nama_p
						,perkara_banding_detil.pemohon_nama as nama 
						,perkara_banding_detil.pemohon_pekerjaan as pekerjaan 
 						,perkara_banding.nomor_perkara_pn as nomor_perkara
						,convert_tanggal_indonesia(perkara_banding_detil.pemohon_tanggal_surat) as tanggal_kuasa 
						,0 as pengacara 
						,perkara_banding_detil.diinput_tanggal AS waktune
						,'Banding' AS keterangan
					FROM perkara_banding_detil
					LEFT JOIN perkara_banding ON perkara_banding.perkara_id=perkara_banding_detil.perkara_id
					WHERE $sql_waktu_banding
					AND perkara_banding_detil.pihak_diwakili='Y'
					UNION 
					SELECT 
						convert_tanggal_indonesia(LEFT(perkara_kasasi_detil.diinput_tanggal,10)) as tgl
						,perkara_kasasi_detil.pemohon_nomor_surat AS nomor_kuasa
						,perkara_kasasi_detil.pihak_nama as nama_p
						,perkara_kasasi_detil.pemohon_nama as nama 
						,perkara_kasasi_detil.pemohon_pekerjaan as pekerjaan 
 						,perkara_kasasi.nomor_perkara_pn as nomor_perkara
						,convert_tanggal_indonesia(perkara_kasasi_detil.pemohon_tanggal_surat) as tanggal_kuasa 
						,0 as pengacara 
						,perkara_kasasi_detil.diinput_tanggal AS waktune
						,'Kasasi' AS keterangan
					FROM perkara_kasasi_detil
					LEFT JOIN perkara_kasasi ON perkara_kasasi.perkara_id=perkara_kasasi_detil.perkara_id
					WHERE $sql_waktu_kasasi
					AND perkara_kasasi_detil.pihak_diwakili='Y'

					UNION 
					SELECT 
						convert_tanggal_indonesia(LEFT(perkara_eksekusi_detil.diinput_tanggal,10)) as tgl
						,perkara_eksekusi_detil.pemohon_nomor_surat AS nomor_kuasa
						,perkara_eksekusi_detil.pihak_nama as nama_p
						,perkara_eksekusi_detil.pemohon_nama as nama 
						,perkara_eksekusi_detil.pemohon_pekerjaan as pekerjaan 
 						,perkara_eksekusi.nomor_perkara_pn as nomor_perkara
						,convert_tanggal_indonesia(perkara_eksekusi_detil.pemohon_tanggal_surat) as tanggal_kuasa 
						,0 as pengacara 
						,perkara_eksekusi_detil.diinput_tanggal AS waktune
						,'Eksekusi' AS keterangan
					FROM perkara_eksekusi_detil
					LEFT JOIN perkara_eksekusi ON perkara_eksekusi.perkara_id=perkara_eksekusi_detil.perkara_id 
					WHERE $sql_waktu_eksekusi
					AND perkara_eksekusi_detil.pihak_diwakili='Y'

					UNION 
					SELECT 
						convert_tanggal_indonesia(LEFT(perkara_eksekusi_detil_ht.diinput_tanggal,10)) as tgl
						,perkara_eksekusi_detil_ht.pemohon_nomor_surat AS nomor_kuasa
						,perkara_eksekusi_detil_ht.pihak_nama as nama_p
						,perkara_eksekusi_detil_ht.pemohon_nama as nama 
						,perkara_eksekusi_detil_ht.pemohon_pekerjaan as pekerjaan 
 						,perkara_eksekusi_ht.nomor_perkara_pn as nomor_perkara
						,convert_tanggal_indonesia(perkara_eksekusi_detil_ht.pemohon_tanggal_surat) as tanggal_kuasa 
						,0 as pengacara 
						,perkara_eksekusi_detil_ht.diinput_tanggal AS waktune
						,'Eksekusi Hak Tanggungan' AS keterangan
					FROM perkara_eksekusi_detil_ht
					LEFT JOIN perkara_eksekusi_ht ON perkara_eksekusi_ht.ht_id=perkara_eksekusi_detil_ht.ht_id 
					WHERE $sql_waktu_eksekusi_ht
					AND perkara_eksekusi_detil_ht.pihak_diwakili='Y'


					
					GROUP BY nomor_kuasa, nomor_perkara
					ORDER by waktune ASC, nomor_kuasa ASC
				";

			$q = $this
				->dbsipp
				->query($sql);	
			//echo $sql;exit;
		return $q->result();
	}
	function register_9($tahun, $bulan, $tahapan,$perkara_id='')
	{

		if ($bulan == 0)
		{
			$sql_waktu = " WHERE YEAR(permohonan_eksekusi)=$tahun ";
		}
		else
		{
			$sql_waktu = " WHERE YEAR(permohonan_eksekusi)=$tahun AND MONTH(permohonan_eksekusi)=$bulan ";
		}

		
		if($tahun=="00000")
		{
				$sql_waktu="  ";
			$sql_nomor_eksekusi = "   ";
			$sql_nomor_eksekusi_ht = "   ";
		}
		if($perkara_id<>'')
		{

			$sql_waktu="  ";
			$sql_nomor_eksekusi = " WHERE nomor_register_eksekusi='$perkara_id' ";
			$sql_nomor_eksekusi_ht = " WHERE eksekusi_nomor_perkara='$perkara_id' ";
			
		}
		//	echo $tahun. "<br><br>Tekan Kene";echo $sql_waktu.'<br>'.$sql_nomor_eksekusi.'<br>'.$sql_nomor_eksekusi_ht;exit;

		$sql = "SELECT 
					CASE 
						WHEN
							(SELECT pihak_diwakili FROM perkara_eksekusi_detil where perkara_id=perkara_eksekusi.perkara_id AND status_pihak_id=1 AND pihak_diwakili='Y' LIMIT 1)='Y'
						THEN
							CONCAT(
								(
									SELECT 
										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', bertindak untuk dan atas nama ' ) 
									FROM
										perkara_eksekusi_detil b
										JOIN pihak d ON b.pemohon_id = d.id
										JOIN agama e ON d.agama_id = e.id
									WHERE b.perkara_id = perkara_eksekusi.perkara_id AND status_pihak_id=1 LIMIT 1
								)
								,
								(SELECT
									IF(COUNT(b.pihak_id)>1,
										GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat ) SEPARATOR '; <br> ' ),

										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat ))
										AS DATA
									FROM
										perkara_eksekusi_detil b
										JOIN pihak d ON b.pihak_id = d.id
										JOIN agama e ON d.agama_id = e.id
									WHERE b.perkara_id = perkara_eksekusi.perkara_id AND status_pihak_id=1)
									,' sebagai Pemohon Eksekusi'
									)
						ELSE
							(SELECT
								IF(COUNT(b.pihak_id)>1,
									GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pendidikan ',
									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon Eksekusi ' ) SEPARATOR '; <br> ' ),

									CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon Eksekusi;' ))
									AS DATA
								FROM
									perkara_eksekusi_detil b
									JOIN pihak d ON b.pihak_id = d.id
									JOIN agama e ON d.agama_id = e.id
								WHERE b.perkara_id = perkara_eksekusi.perkara_id AND status_pihak_id=1)	
						END 
					 AS identitas_p
			, 
					CASE 
						WHEN
							(SELECT pihak_diwakili FROM perkara_eksekusi_detil where perkara_id=perkara_eksekusi.perkara_id AND status_pihak_id=2 AND pihak_diwakili='Y' LIMIT 1)='Y'
						THEN
							CONCAT(
								(
									SELECT 
										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', bertindak untuk dan atas nama ' ) 
									FROM
										perkara_eksekusi_detil b
										JOIN pihak d ON b.pemohon_id = d.id
										JOIN agama e ON d.agama_id = e.id
									WHERE b.perkara_id = perkara_eksekusi.perkara_id AND status_pihak_id=2 LIMIT 1
								)
								,
								(SELECT
									IF(COUNT(b.pihak_id)>1,
										GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat ) SEPARATOR '; <br> ' ),

										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat ))
										
									FROM
										perkara_eksekusi_detil b
										JOIN pihak d ON b.pihak_id = d.id
										JOIN agama e ON d.agama_id = e.id
									WHERE b.perkara_id = perkara_eksekusi.perkara_id AND status_pihak_id=2)
									,' sebagai Termohon Eksekusi'
									)
						ELSE
							(SELECT
								IF(COUNT(b.pihak_id)>1,
									GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pendidikan ',
									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', Termohon Pemohon Eksekusi ' ) SEPARATOR '; <br> ' ),

									CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', sebagai Termohon Eksekusi;' ))
									AS DATA
								FROM
									perkara_eksekusi_detil b
									JOIN pihak d ON b.pihak_id = d.id
									JOIN agama e ON d.agama_id = e.id
								WHERE b.perkara_id = perkara_eksekusi.perkara_id AND status_pihak_id=2)	
						END 
					 AS identitas_t	 		 
			,nomor_urut_perkara_eksekusi
			,nomor_register_eksekusi AS nomor_register_eksekusi
			,permohonan_eksekusi AS tgl_daftar
			,convert_tanggal_indonesia(permohonan_eksekusi) AS permohonan_eksekusi
			,'-' AS jenis_ht_text
			,nomor_perkara_pn
			,convert_tanggal_indonesia(putusan_pn) AS putusan_pn
			,nomor_perkara_banding
			,convert_tanggal_indonesia(putusan_banding) AS putusan_banding
			,nomor_perkara_kasasi
			,convert_tanggal_indonesia(putusan_kasasi) AS putusan_kasasi
			,nomor_perkara_pk
			,convert_tanggal_indonesia(putusan_pk) AS putusan_pk
			,eksekusi_amar_putusan
			,convert_tanggal_indonesia(penetapan_teguran_eksekusi) AS penetapan_teguran_eksekusi
			,convert_tanggal_indonesia(pelaksanaan_teguran_eksekusi) AS pelaksanaan_teguran_eksekusi 
			,convert_tanggal_indonesia(pelaksanaan_eksekusi_rill) AS pelaksanaan_eksekusi_rill
			,'-' AS pendaftaran_sita 
			,convert_tanggal_indonesia(penetapan_sita_eksekusi) AS penetapan_sita_eksekusi
			,convert_tanggal_indonesia(pelaksanaan_sita_eksekusi) AS pelaksanaan_sita_eksekusi 
			,convert_tanggal_indonesia(penetapan_perintah_eksekusi_lelang) AS penetapan_perintah_eksekusi_lelang
			,convert_tanggal_indonesia(pelaksanaan_eksekusi_lelang) AS pelaksanaan_eksekusi_lelang
			,convert_tanggal_indonesia(penyerahan_hasil_lelang) AS penyerahan_hasil_lelang
			,'-' AS permohonan_pengosongan
			,'-' AS penetapan_pengosongan
			,'-' AS pelaksanaan_pengosongan
			,'-' AS penetapan_perintah_eksekusi_lelang_ht
			,'-' AS pelaksanaan_eksekusi_lelang_ht
			,'-' AS pendaftaran_sita_ht
			,'-' AS penetapan_perintah_eksekusi_lelang_ht
			,'-' AS pelaksanaan_eksekusi_lelang_ht
			,'-' AS penyerahan_hasil_lelang_ht
			,'-' AS pengangkatan_sita
			,nomor_penetapan_teguran_eksekusi
			,nomor_penetapan_sita_eksekusi
			,pemohon_eksekusi

			FROM perkara_eksekusi  " . $sql_waktu . " ".$sql_nomor_eksekusi. "
			UNION
			SELECT
			 
					CASE 
						WHEN
							(SELECT pihak_diwakili FROM perkara_eksekusi_detil_ht where ht_id=perkara_eksekusi_ht.ht_id AND status_pihak_id=1 AND pihak_diwakili='Y' LIMIT 1)='Y'
						THEN
							CONCAT(
								(
									SELECT 
										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', bertindak untuk dan atas nama ' ) 
									FROM
										perkara_eksekusi_detil_ht b
										JOIN pihak d ON b.pemohon_id = d.id
										JOIN agama e ON d.agama_id = e.id
									WHERE b.ht_id = perkara_eksekusi_ht.ht_id AND status_pihak_id=1 LIMIT 1
								)
								,
								(SELECT
									IF(COUNT(b.pihak_id)>1,
										GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat ) SEPARATOR '; <br> ' ),

										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat ))
										AS DATA
									FROM
										perkara_eksekusi_detil_ht b
										JOIN pihak d ON b.pihak_id = d.id
										JOIN agama e ON d.agama_id = e.id
									WHERE b.ht_id= perkara_eksekusi_ht.ht_id AND status_pihak_id=1)
									,' sebagai Pemohon Eksekusi'
									)
						ELSE
							(SELECT
								IF(COUNT(b.pihak_id)>1,
									GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pendidikan ',
									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon Eksekusi ' ) SEPARATOR '; <br> ' ),

									CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon Eksekusi;' ))
									AS DATA
								FROM
									perkara_eksekusi_detil_ht b
									JOIN pihak d ON b.pihak_id = d.id
									JOIN agama e ON d.agama_id = e.id
								WHERE b.ht_id = perkara_eksekusi_ht.ht_id AND status_pihak_id=1)	
						END 
					 AS identitas_p
			, 
					CASE 
						WHEN
							(SELECT pihak_diwakili FROM perkara_eksekusi_detil_ht where ht_id=perkara_eksekusi_ht.ht_id AND status_pihak_id=2 AND pihak_diwakili='Y' LIMIT 1)='Y'
						THEN
							CONCAT(
								(
									SELECT 
										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', bertindak untuk dan atas nama ' ) 
									FROM
										perkara_eksekusi_detil_ht b
										JOIN pihak d ON b.pemohon_id = d.id
										JOIN agama e ON d.agama_id = e.id
									WHERE b.ht_id= perkara_eksekusi_ht.ht_id AND status_pihak_id=2 LIMIT 1
								)
								,
								(SELECT
									IF(COUNT(b.pihak_id)>1,
										GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat ) SEPARATOR '; <br> ' ),

										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat ))
										
									FROM
										perkara_eksekusi_detil_ht b
										JOIN pihak d ON b.pihak_id = d.id
										JOIN agama e ON d.agama_id = e.id
									WHERE b.ht_id = perkara_eksekusi_ht.ht_id AND status_pihak_id=2)
									,' sebagai Termohon Eksekusi'
									)
						ELSE
							(SELECT
								IF(COUNT(b.pihak_id)>1,
									GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pendidikan ',
									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', Termohon Eksekusi ' ) SEPARATOR '; <br> ' ),

									CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', sebagai Termohon Eksekusi;' ))
									AS DATA
								FROM
									perkara_eksekusi_detil_ht b
									JOIN pihak d ON b.pihak_id = d.id
									JOIN agama e ON d.agama_id = e.id
								WHERE b.ht_id = perkara_eksekusi_ht.ht_id AND status_pihak_id=2)	
						END 
					 AS identitas_t	
			,nomor_urut_perkara_eksekusi		 
			,eksekusi_nomor_perkara AS nomor_register_eksekusi
			,permohonan_eksekusi AS tgl_daftar 
			,convert_tanggal_indonesia(permohonan_eksekusi) AS permohonan_eksekusi
			,jenis_ht_text
			,nomor_perkara_pn
			,convert_tanggal_indonesia(putusan_pn) AS putusan_pn
			,nomor_perkara_banding
			,convert_tanggal_indonesia(putusan_banding) AS putusan_banding
			,nomor_perkara_kasasi
			,convert_tanggal_indonesia(putusan_kasasi) AS putusan_kasasi
			,nomor_perkara_pk
			,convert_tanggal_indonesia(putusan_pk) AS putusan_pk
			,eksekusi_amar_putusan
			,convert_tanggal_indonesia(penetapan_teguran_eksekusi) AS penetapan_teguran_eksekusi
			,convert_tanggal_indonesia(pelaksanaan_teguran_eksekusi) AS pelaksanaan_teguran_eksekusi 
			,convert_tanggal_indonesia(pelaksanaan_eksekusi_rill) AS pelaksanaan_eksekusi_rill
			,'-' AS pendaftaran_sita 
			,convert_tanggal_indonesia(penetapan_sita_eksekusi) AS penetapan_sita_eksekusi
			,convert_tanggal_indonesia(pelaksanaan_sita_eksekusi) AS pelaksanaan_sita_eksekusi 
			,'-' AS penetapan_perintah_eksekusi_lelang
			,'-' AS pelaksanaan_eksekusi_lelang
			,'-' AS penyerahan_hasil_lelang
			,'-' AS permohonan_pengosongan
			,'-' AS penetapan_pengosongan
			,'-' AS pelaksanaan_pengosongan
			,convert_tanggal_indonesia(penetapan_perintah_eksekusi_lelang) AS penetapan_perintah_eksekusi_lelang_ht
			,convert_tanggal_indonesia(pelaksanaan_eksekusi_lelang) AS pelaksanaan_eksekusi_lelang_ht
			,'-' AS pendaftaran_sita_ht
			,convert_tanggal_indonesia(penetapan_perintah_eksekusi_lelang) AS penetapan_perintah_eksekusi_lelang_ht
			,convert_tanggal_indonesia(pelaksanaan_eksekusi_lelang) AS pelaksanaan_eksekusi_lelang_ht
			,convert_tanggal_indonesia(penyerahan_hasil_lelang) AS penyerahan_hasil_lelang_ht
			,'-' AS pengangkatan_sita
			,nomor_penetapan_teguran_eksekusi
			,nomor_penetapan_sita_eksekusi
			,(SELECT concat('-',group_concat(if((status_pihak_id = 1),pihak_nama,NULL) separator '<br/>-')) FROM perkara_eksekusi_detil_ht WHERE ht_id=perkara_eksekusi_ht.ht_id group by ht_id) AS pemohon_eksekusi

			FROM perkara_eksekusi_ht  " . $sql_waktu . " ".$sql_nomor_eksekusi_ht. "

			ORDER BY tgl_daftar ASC, nomor_urut_perkara_eksekusi ASC
			";
		//	echo $sql;exit;
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$this
			->dbsipp
			->query('SET SESSION group_concat_max_len=100000');

		$q = $this
			->dbsipp
			->query($sql);
		return $q->result();
	}
	//ardan
	function register_11($tahun, $bulan, $tahapan, $perkara_id)
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		if ($tahapan == 1)
		{
			$sql_tahapan = " AND perkara_putusan.perkara_id IS NULL ";
		}
		else if ($tahapan == 15)
		{
			$sql_tahapan = " AND perkara_putusan.perkara_id IS NOT NULL ";
		}
		else
		{
			$sql_tahapan = " ";
		}
		if ($bulan == 0)
		{
			$sql_waktu = " YEAR(perkara.tanggal_pendaftaran)=$tahun ";
		}
		else
		{
			$sql_waktu = " YEAR(perkara.tanggal_pendaftaran)=$tahun AND MONTH(perkara.tanggal_pendaftaran)=$bulan ";
		}

		if($perkara_id<>'')
		{
			$sql_waktu=" perkara.perkara_id=$perkara_id ";
		}
		$sql="SELECT
					perkara.perkara_id
					,perkara.nomor_urut_register
					,perkara.nomor_perkara
					,perkara.tanggal_pendaftaran
					,(SELECT 
						GROUP_CONCAT(CONCAT('<p>',convert_tanggal_indonesia(tanggal_sidang),'<br>',alasan_ditunda,'') SEPARATOR '<br><br>') 
						 FROM perkara_jadwal_sidang WHERE perkara_id= perkara.perkara_id AND urutan<>1 AND ikrar_talak='T' AND verzet='T' AND ditunda='Y') AS tundaan
					,convert_tanggal_indonesia(perkara.tanggal_surat) AS tanggal_surat
					,perkara.dakwaan

					,convert_tanggal_indonesia(perkara_penetapan.penetapan_hari_sidang) AS penetapan_hari_sidang
					,convert_tanggal_indonesia(perkara_penetapan.sidang_pertama) AS sidang_pertama
					,convert_tanggal_indonesia(perkara_penetapan.penetapan_majelis_hakim) AS penetapan_majelis_hakim
					,perkara_penetapan.majelis_hakim_text
					,perkara_penetapan.panitera_pengganti_text


					,convert_tanggal_indonesia(perkara_putusan.tanggal_putusan) AS tanggal_putusan
					,perkara_putusan.pemberitahuan_putusan
					,perkara_putusan.amar_putusan
					,convert_tanggal_indonesia(perkara_putusan.tanggal_minutasi) AS tanggal_minutasi
					,convert_tanggal_indonesia(perkara_penuntutan.tanggal_penuntutan) AS tanggal_penuntutan
					,perkara_penuntutan.isi_penuntutan 

				
					,perkara.jenis_perkara_nama
					,(SELECT convert_tanggal_indonesia(tanggal_kirim_salinan_putusan) FROM perkara_putusan_pemberitahuan_putusan where perkara_id=perkara.perkara_id AND pihak=2 LIMIT 1) as tanggal_kirim_salinan_putusan
					,(SELECT convert_tanggal_indonesia(tanggal_menerima_putusan) FROM perkara_putusan_pemberitahuan_putusan where perkara_id=perkara.perkara_id AND pihak=2 LIMIT 1) as tanggal_menerima_putusan
					,(SELECT convert_tanggal_indonesia(tanggal_kirim_salinan_putusan) FROM perkara_putusan_pemberitahuan_putusan where perkara_id=perkara.perkara_id AND pihak=1 LIMIT 1) as tanggal_kirim_ke_jaksa
					,(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(
								d.nama
								,', umur '
								,get_umur(d.tanggal_lahir,a.tanggal_pendaftaran)
								,' tahun, Tanggal Lahir ' 
								,convert_tanggal_indonesia(d.tanggal_lahir) 
								,', Jenis Kelamin '
								,CASE WHEN d.jenis_kelamin='P' THEN 'Perempuan' ELSE 'Laki-laki' END
								,', Kebangsaan '
								,CASE WHEN d.warga_negara_id>1 THEN (SELECT nama from negara WHERE id=d.warga_negara_id) ELSE '' END
								,', Tempat Tinggal '
								, d.alamat,', Agama '
								,e.nama 
								,', pekerjaan '
								,d.pekerjaan 
								,', sebagai Terdakwa '
								,bulan_romawi(b.urutan) ) SEPARATOR '; \\\\par ' ),
							CONCAT(
								d.nama
								,', umur '
								,get_umur(d.tanggal_lahir,a.tanggal_pendaftaran)
								,' tahun, Tanggal Lahir ' 
								,convert_tanggal_indonesia(d.tanggal_lahir) 
								,', Jenis Kelamin '
								,CASE WHEN d.jenis_kelamin='P' THEN 'Perempuan' ELSE 'Laki-laki' END
								,', Kebangsaan '
								,CASE WHEN d.warga_negara_id>1 THEN (SELECT nama from negara WHERE id=d.warga_negara_id) ELSE '' END
								,', Tempat Tinggal '
								, d.alamat,', Agama '
								,e.nama 
								,', pekerjaan '
								,d.pekerjaan 
								,', sebagai Terdakwa;' ))
							AS DATA
							FROM perkara_pihak2 b
							JOIN perkara a ON a.perkara_id = b.perkara_id
 							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
 							WHERE b.perkara_id = perkara.`perkara_id` ) AS identitas_terdakwa

					,(SELECT convert_tanggal_indonesia(tanggal_surat) FROM penahanan_terdakwa WHERE perkara_id=perkara.perkara_id AND jenis_penahanan_id=35 LIMIT 1) AS penahanan_penyidik
					,(SELECT convert_tanggal_indonesia(tanggal_surat) FROM penahanan_terdakwa WHERE perkara_id=perkara.perkara_id AND jenis_penahanan_id=38 LIMIT 1) AS penahanan_pu
					,(SELECT convert_tanggal_indonesia(tanggal_surat) FROM penahanan_terdakwa WHERE perkara_id=perkara.perkara_id AND jenis_penahanan_id=41 LIMIT 1) AS penahanan_ms
					,(SELECT convert_tanggal_indonesia(tanggal_surat) FROM penahanan_terdakwa WHERE perkara_id=perkara.perkara_id AND jenis_penahanan_id=44 LIMIT 1) AS penahanan_msa
					,(SELECT convert_tanggal_indonesia(tanggal_surat) FROM penahanan_terdakwa WHERE perkara_id=perkara.perkara_id AND jenis_penahanan_id=47 LIMIT 1) AS penahanan_ma
					,(SELECT GROUP_CONCAT(CONCAT(convert_tanggal_indonesia(permohonan_banding),' \\\\tab ', pemohon_nama)SEPARATOR ' \\\\par ') from perkara_banding_detil where perkara_id=perkara.perkara_id AND permohonan_banding IS NOT NULL) AS permohonan_banding
					,(SELECT GROUP_CONCAT(CONCAT(convert_tanggal_indonesia(pemberitahuan_permohonan_banding),' \\\\tab ', pemohon_nama)SEPARATOR ' \\\\par ') from perkara_banding_detil where perkara_id=perkara.perkara_id AND permohonan_banding IS NOT NULL AND pemberitahuan_permohonan_banding IS NOT NULL) AS pemberitahuan_permohonan_banding
					,(SELECT GROUP_CONCAT(CONCAT(convert_tanggal_indonesia(penerimaan_memori_banding),' \\\\tab ', pemohon_nama)SEPARATOR ' \\\\par ') from perkara_banding_detil where perkara_id=perkara.perkara_id AND permohonan_banding IS NOT NULL AND penerimaan_memori_banding IS NOT NULL) AS penerimaan_memori_banding
					,(SELECT GROUP_CONCAT(CONCAT(convert_tanggal_indonesia(penyerahan_memori_banding),' \\\\tab ', pemohon_nama)SEPARATOR ' \\\\par ') from perkara_banding_detil where perkara_id=perkara.perkara_id AND permohonan_banding IS NOT NULL AND penyerahan_memori_banding IS NOT NULL) AS penyerahan_memori_banding
					,(SELECT GROUP_CONCAT(CONCAT(convert_tanggal_indonesia(penerimaan_kontra_banding),' \\\\tab ', pemohon_nama)SEPARATOR ' \\\\par ') from perkara_banding_detil where perkara_id=perkara.perkara_id AND permohonan_banding IS NOT NULL AND penerimaan_kontra_banding IS NOT NULL) AS penerimaan_kontra_banding
					,(SELECT GROUP_CONCAT(CONCAT(convert_tanggal_indonesia(penyerahan_kontra_banding),' \\\\tab ', pemohon_nama)SEPARATOR ' \\\\par ') from perkara_banding_detil where perkara_id=perkara.perkara_id AND permohonan_banding IS NOT NULL AND penyerahan_kontra_banding IS NOT NULL) AS penyerahan_kontra_banding
					,(SELECT GROUP_CONCAT(CONCAT(convert_tanggal_indonesia(pelaksanaan_inzage),' \\\\tab ', pemohon_nama)SEPARATOR ' \\\\par ') from perkara_banding_detil where perkara_id=perkara.perkara_id AND permohonan_banding IS NOT NULL AND pelaksanaan_inzage IS NOT NULL) AS pelaksanaan_inzage
					,(SELECT CONCAT(convert_tanggal_indonesia(pengiriman_berkas_banding),' \\\\par ', nomor_surat_pengiriman_berkas_banding) from perkara_banding where perkara_id=perkara.perkara_id ) AS tanggal_nomor_kirim
					,(SELECT penerimaan_kembali_berkas_banding from perkara_banding where perkara_id=perkara.perkara_id ) AS penerimaan_kembali_berkas_banding
				FROM 	perkara

				LEFT JOIN	perkara_penetapan	ON	perkara_penetapan.perkara_id=perkara.perkara_id

				LEFT JOIN	perkara_putusan		ON	perkara_putusan.perkara_id=perkara.perkara_id
				LEFT JOIN	perkara_penuntutan		ON	perkara_penuntutan.perkara_id=perkara.perkara_id
				LEFT JOIN	perkara_putusan_terdakwa		ON	perkara_putusan_terdakwa.perkara_id=perkara.perkara_id
				WHERE $sql_waktu AND alur_perkara_id=122
				";
		$this
			->dbsipp
			->query('SET SESSION group_concat_max_len=100000');

		$q = $this
			->dbsipp
			->query($sql);
		return $q->result();		
	}
	function register_12($tahun, $bulan, $tahapan, $perkara_id='')
	{
		
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		if ($tahapan == 1)
		{
			$sql_tahapan = " AND perkara_putusan.perkara_id IS NULL ";
			$tambahan=" AND ";
		}
		else if ($tahapan == 16)
		{
			$sql_tahapan = " AND perkara_putusan.perkara_id IS NOT NULL ";
			$tambahan=" AND ";
		}
		else
		{
			$sql_tahapan = " ";
			$tambahan=" AND ";
		}
		if ($bulan == 0)
		{
			$sql_waktu = "  YEAR(perkara.tanggal_pendaftaran)=$tahun ";
			$tambahan=" AND ";
		}
		else
		{
			$sql_waktu = " YEAR(perkara.tanggal_pendaftaran)=$tahun AND MONTH(perkara.tanggal_pendaftaran)=$bulan ";
			$tambahan=" AND ";
		}

		if($tahun=='00000')
		{
			$sql_waktu="  ";
			$sql_tahapan = "   ";
			$tambahan="";
		}
		
		if($perkara_id<>'')
		{
			$sql_waktu=" perkara.perkara_id=$perkara_id ";
			$tambahan=" AND ";
		}
		$q = $this
			->dbsipp
			->query("
					SELECT 
						perkara.perkara_id 
						,perkara.nomor_urut_perkara 
						,perkara.nomor_urut_register
						,perkara.nomor_perkara AS kolom_1
						,convert_tanggal_indonesia(perkara.tanggal_pendaftaran) AS kolom_3
						,'' AS kolom_4
						,(SELECT 
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(d.nama, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon ',bulan_romawi(b.urutan) ) SEPARATOR ';<br>' ),
							CONCAT(d.nama, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon;' ))
							AS DATA
							FROM perkara_pihak1 b 
							JOIN perkara a ON a.perkara_id = b.perkara_id
							LEFT JOIN perkara_pengacara c ON a.perkara_id = c.perkara_id AND b.pihak_id = c.pihak_id
							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
							LEFT JOIN tingkat_pendidikan f ON d.pendidikan_id = f.id
							WHERE a.perkara_id = perkara.`perkara_id` ) AS kolom_2 
						 
						,concat(convert_tanggal_indonesia(perkara_putusan.tanggal_putusan),'<br>',perkara_putusan.amar_putusan) AS kolom_5 
						,concat(convert_tanggal_indonesia(perkara_putusan.tanggal_putusan),'<br>',perkara.nomor_perkara,'<br>',perkara_putusan.amar_putusan) AS kolom_5a 
						,concat(convert_tanggal_indonesia(perkara_putusan.tanggal_putusan),'<br>',perkara_putusan.amar_putusan) AS kolom_5 
						,'' AS kolom_6
						 FROM
							perkara 
						LEFT JOIN perkara_putusan ON perkara_putusan.perkara_id=perkara.perkara_id
						 
						 WHERE $sql_waktu $sql_tahapan $tambahan jenis_perkara_id=371 ORDER BY perkara.perkara_id DESC");

		return $q->result();
	}

	function register_13($tahun, $bulan, $tahapan,$perkara_id='')
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		if ($tahapan == 1)
		{
			$sql_tahapan = " AND perkara_putusan.perkara_id IS NULL ";
		}
		else if ($tahapan == 15)
		{
			$sql_tahapan = " AND perkara_putusan.perkara_id IS NOT NULL ";
		}
		else
		{
			$sql_tahapan = " ";
		}
		if ($bulan == 0)
		{
			$sql_waktu = " YEAR(perkara.tanggal_pendaftaran)=$tahun ";
		}
		else
		{
			$sql_waktu = " YEAR(perkara.tanggal_pendaftaran)=$tahun AND MONTH(perkara.tanggal_pendaftaran)=$bulan ";
		}

		if($perkara_id<>'')
		{
			$sql_waktu=" perkara.perkara_id=$perkara_id ";
		}
		$q = $this
			->dbsipp
			->query("
					SELECT
						perkara.perkara_id
						,perkara.nomor_urut_perkara
						,perkara.nomor_urut_register
						,perkara.nomor_perkara
						,perkara.jenis_perkara_id
						,perkara.jenis_perkara_nama
						,convert_tanggal_indonesia(med.penetapan_penunjukan_mediator) AS penetapan_penunjukan_mediator	
						,(select GROUP_CONCAT(CONCAT(case when pihak_ke =1 then '#sebutan_pihak1#' else '#sebutan_pihak2#' END,'<br>B. '
							 ,convert_tanggal_indonesia(tanggal_kuasa)
							 ,'<br>C. '
							 ,nama,'')SEPARATOR '<br><br>') 
							from perkara_pengacara WHERE perkara_id=perkara.perkara_id 
							 
							) AS tgl_nama_kuasa 
						,convert_tanggal_indonesia(perkara.tanggal_pendaftaran) AS tanggal_pendaftaran_indonesia
						,(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',f.nama, ', tempat kediaman di ', d.alamat, ', sebagai #sebutan_pihak1# ',bulan_romawi(b.urutan) ) SEPARATOR ';<br>' ),
							CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',f.nama, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon;' ))
							AS DATA
							FROM perkara_pihak1 b
							JOIN perkara a ON a.perkara_id = b.perkara_id
							LEFT JOIN perkara_pengacara c ON a.perkara_id = c.perkara_id AND b.pihak_id = c.pihak_id
							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
							LEFT JOIN tingkat_pendidikan f ON d.pendidikan_id = f.id
							WHERE a.perkara_id = perkara.`perkara_id` ) AS identitas_p
						,(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',f.nama, ', tempat kediaman di ', d.alamat, ', sebagai #sebutan_pihak2# ',bulan_romawi(b.urutan) ) SEPARATOR ';<br>' ),
							CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',f.nama, ', tempat kediaman di ', d.alamat, ', sebagai Termohon;' ))
							AS DATA
							FROM perkara_pihak2 b
							JOIN perkara a ON a.perkara_id = b.perkara_id
							LEFT JOIN perkara_pengacara c ON a.perkara_id = c.perkara_id AND b.pihak_id = c.pihak_id
							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
							LEFT JOIN tingkat_pendidikan f ON d.pendidikan_id = f.id
							WHERE a.perkara_id = perkara.`perkara_id` ) AS identitas_t

						,perkara.petitum
						,perkara.jenis_perkara_text
						,convert_tanggal_indonesia(perkara_penetapan.penetapan_hari_sidang) as phs
						,convert_tanggal_indonesia(perkara_penetapan.sidang_pertama) as sidangpertama
						,convert_tanggal_indonesia(perkara_putusan.tanggal_putusan) as tanggalputusan
						,convert_tanggal_indonesia(perkara_putusan.tanggal_bht) as tanggalbht
						,convert_tanggal_indonesia(perkara_putusan.tanggal_minutasi) as tanggalminutasi

						,perkara_putusan.amar_putusan
						,perkara_penetapan.sidang_pertama
						,(SELECT 
								group_concat(CONCAT('<tr><td valign=top style=border:none>-</td><td valign=top style=border:none>',DATE_FORMAT(tanggal_sidang,'%d-%m-%Y'),'</td><td valign=top style=border:none>',agenda,'</td></tr>')separator '') 
								as penundaan_sidang FROM perkara_jadwal_sidang WHERE perkara_id=perkara.perkara_id AND ditunda='Y' AND tanggal_sidang <> 'perkara_penetapan.sidang_pertama') as penundaan_sidang
						,(SELECT group_concat(CONCAT('<ol><li>',convert_tanggal_indonesia(tanggal_sidang),'<br>',alasan_ditunda,'</li></ol>')separator '')
								as penundaan_sidang FROM perkara_jadwal_sidang WHERE perkara_id=perkara.perkara_id AND verzet='Y' AND ditunda='Y' AND tanggal_sidang >= 'perkara_verzet.tanggal_sidang_pertama_verzet') as penundaan_sidang_verzet
						,(SELECT group_concat(CONCAT('<p>#sebutan_pihak',pihak,'# - ',convert_tanggal_indonesia(tanggal_pemberitahuan_putusan),'</p>')separator '<br>')
								as pemberitahuan_isi_putusan FROM perkara_putusan_pemberitahuan_putusan WHERE perkara_id=perkara.perkara_id AND tanggal_pemberitahuan_putusan IS NOT NULL) as pemberitahuan_isi_putusan
						

						,convert_tanggal_indonesia(perkara_kasasi.permohonan_kasasi) AS permohonan_kasasi
						,convert_tanggal_indonesia(perkara_kasasi.pemberitahuan_kasasi) AS pemberitahuan_kasasi
						,convert_tanggal_indonesia(perkara_kasasi.penerimaan_memori_kasasi) AS penerimaan_memori_kasasi
						,convert_tanggal_indonesia(perkara_kasasi.penyerahan_memori_kasasi	) AS penyerahan_memori_kasasi	
						,convert_tanggal_indonesia(perkara_kasasi.penerimaan_kontra_kasasi	) AS penerimaan_kontra_kasasi	
						,convert_tanggal_indonesia(perkara_kasasi.penyerahan_kontra_kasasi	) AS penyerahan_kontra_kasasi	
						,convert_tanggal_indonesia(perkara_kasasi.pelaksanaan_inzage_kasasi) AS pelaksanaan_inzage_kasasi		
						,convert_tanggal_indonesia(perkara_kasasi.pengiriman_berkas_kasasi) AS pengiriman_berkas_kasasi		
						,convert_tanggal_indonesia(perkara_kasasi.penerimaan_berkas_kasasi) AS penerimaan_berkas_kasasi		
						,convert_tanggal_indonesia(perkara_kasasi.pemberitahuan_putusan_kasasi) AS pemberitahuan_putusan_kasasi		
						,convert_tanggal_indonesia(perkara_kasasi.putusan_kasasi) AS putusan_kasasi
						,perkara_kasasi.nomor_putusan_kasasi
						,perkara_kasasi.amar_putusan_kasasi	

						,convert_tanggal_indonesia(med.penetapan_penunjukan_mediator) AS penetapan_penunjukan_mediator	
						,convert_tanggal_indonesia(med.tgl_laporan_mediator) AS tgl_laporan_mediator	
						,med.hasil_mediasi as hasil_mediasi
						,med.nama_gelar as nama_gelar_mediator
						,med.no_sertifikasi as no_sertifikasi
						,med.tgl_sertifikasi as tgl_sertifikasi		

						,convert_tanggal_indonesia(perkara_verzet.tanggal_pendaftaran_verzet) as tanggalpendaftaranverzet
						,convert_tanggal_indonesia(perkara_verzet.tanggal_penetapan_sidang_verzet) as tanggalpenetapansidangverzet
						,convert_tanggal_indonesia(perkara_verzet.tanggal_sidang_pertama_verzet) as tanggalsidangpertamaverzet
						,convert_tanggal_indonesia(perkara_verzet.putusan_verzet) as putusanverzet
						,convert_tanggal_indonesia(perkara_verzet.tanggal_bht) as tanggalbhtverzet
						,perkara_verzet.amar_putusan_verzet

						,convert_tanggal_indonesia(perkara_banding.permohonan_banding) AS permohonan_banding
						,convert_tanggal_indonesia(perkara_banding.pemberitahuan_permohonan_banding) AS pemberitahuan_permohonan_banding
						,convert_tanggal_indonesia(perkara_banding.penerimaan_memori_banding) AS penerimaan_memori_banding
						,convert_tanggal_indonesia(perkara_banding.penyerahan_memori_banding) AS penyerahan_memori_banding
						,convert_tanggal_indonesia(perkara_banding.penerimaan_kontra_banding) AS penerimaan_kontra_banding
						,convert_tanggal_indonesia(perkara_banding.penyerahan_kontra_banding) AS penyerahan_kontra_banding
						,convert_tanggal_indonesia(perkara_banding.pelaksanaan_inzage) AS pelaksanaan_inzage
						,convert_tanggal_indonesia(perkara_banding.pengiriman_berkas_banding) AS pengiriman_berkas_banding
						,perkara_banding.nomor_surat_pengiriman_berkas_banding 
						,convert_tanggal_indonesia(perkara_banding.penerimaan_kembali_berkas_banding) AS penerimaan_kembali_berkas_banding
						,convert_tanggal_indonesia(perkara_banding.pemberitahuan_putusan_banding) AS pemberitahuan_putusan_banding
						,convert_tanggal_indonesia(perkara_banding.putusan_banding) AS putusan_banding
						,perkara_banding.nomor_putusan_banding
						,perkara_banding.amar_putusan_banding

						,convert_tanggal_indonesia(perkara_kasasi.permohonan_kasasi) AS permohonan_kasasi
						,convert_tanggal_indonesia(perkara_kasasi.pemberitahuan_kasasi) AS pemberitahuan_kasasi
						,convert_tanggal_indonesia(perkara_kasasi.penerimaan_memori_kasasi) AS penerimaan_memori_kasasi
						,convert_tanggal_indonesia(perkara_kasasi.penyerahan_memori_kasasi	) AS penyerahan_memori_kasasi	
						,convert_tanggal_indonesia(perkara_kasasi.penerimaan_kontra_kasasi	) AS penerimaan_kontra_kasasi	
						,convert_tanggal_indonesia(perkara_kasasi.penyerahan_kontra_kasasi	) AS penyerahan_kontra_kasasi	
						,convert_tanggal_indonesia(perkara_kasasi.pelaksanaan_inzage_kasasi) AS pelaksanaan_inzage_kasasi		
						,convert_tanggal_indonesia(perkara_kasasi.pengiriman_berkas_kasasi) AS pengiriman_berkas_kasasi		
						,convert_tanggal_indonesia(perkara_kasasi.penerimaan_berkas_kasasi) AS penerimaan_berkas_kasasi		
						,convert_tanggal_indonesia(perkara_kasasi.pemberitahuan_putusan_kasasi) AS pemberitahuan_putusan_kasasi		
						,convert_tanggal_indonesia(perkara_kasasi.putusan_kasasi) AS putusan_kasasi
						,perkara_kasasi.nomor_putusan_kasasi
						,perkara_kasasi.amar_putusan_kasasi	

						,convert_tanggal_indonesia(perkara_pk.permohonan_pk) AS permohonan_pk	
						,convert_tanggal_indonesia(perkara_pk.pemberitahuan_pk) AS pemberitahuan_pk	
						,convert_tanggal_indonesia(perkara_pk.penerimaan_memori_pk) AS penerimaan_memori_pk	
						,convert_tanggal_indonesia(perkara_pk.penyerahan_memori_pk) AS penyerahan_memori_pk	
						,convert_tanggal_indonesia(perkara_pk.penerimaan_kontra_pk) AS penerimaan_kontra_pk	
						,convert_tanggal_indonesia(perkara_pk.penyerahan_kontra_pk) AS penyerahan_kontra_pk	
						,convert_tanggal_indonesia(perkara_pk.pengiriman_berkas_pk) AS pengiriman_berkas_pk	
						,convert_tanggal_indonesia(perkara_pk.penerimaan_berkas_pk) AS penerimaan_berkas_pk	
						,convert_tanggal_indonesia(perkara_pk.tanggal_penyumpahan) AS tanggal_penyumpahan_novum
						,perkara_pk.nomor_perkara_pk
						,convert_tanggal_indonesia(perkara_pk.putusan_pk) AS putusan_pk	
						,perkara_pk.amar_putusan_pk
						,convert_tanggal_indonesia(perkara_pk.pemberitahuan_putusan_pk) AS pemberitahuan_putusan_pk


						,convert_tanggal_indonesia(perkara_eksekusi.permohonan_eksekusi) AS permohonan_eksekusi	
						,convert_tanggal_indonesia(perkara_eksekusi.pelaksanaan_teguran_eksekusi) AS pelaksanaan_teguran_eksekusi	
						,convert_tanggal_indonesia(perkara_eksekusi.penetapan_teguran_eksekusi) AS penetapan_teguran_eksekusi	
						,convert_tanggal_indonesia(perkara_eksekusi.pelaksanaan_sita_eksekusi) AS pelaksanaan_sita_eksekusi	

						,(select group_concat(concat(pihak_asal_text,' : ',convert_tanggal_indonesia(pemohon_tanggal_surat)) SEPARATOR '<br>') from perkara_banding_detil where pihak_diwakili='Y' and perkara_id=perkara.perkara_id) as tanggal_kuasa_banding						
						,(select group_concat(concat(pihak_asal_text,' : ',pemohon_nama) SEPARATOR '<br>') from perkara_banding_detil where pihak_diwakili='Y' and perkara_id=perkara.perkara_id) as nama_kuasa_banding
						,(select group_concat(concat(pihak_asal_text,' : ',convert_tanggal_indonesia(pemohon_tanggal_surat)) SEPARATOR '<br>') from perkara_kasasi_detil where pihak_diwakili='Y' and perkara_id=perkara.perkara_id) as tanggal_kuasa_kasasi		
						,(select group_concat(concat(pihak_asal_text,' : ',pemohon_nama) SEPARATOR '<br>') from perkara_kasasi_detil where pihak_diwakili='Y' and perkara_id=perkara.perkara_id) as nama_kuasa_kasasi

						,(select group_concat(concat(pihak_asal_text,' : ',convert_tanggal_indonesia(pemohon_tanggal_surat)) SEPARATOR '<br>') from perkara_pk_detil where pihak_diwakili='Y' and perkara_id=perkara.perkara_id) as tanggal_kuasa_pk
						,(select group_concat(concat(pihak_asal_text,' : ',pemohon_nama) SEPARATOR '<br>') from perkara_pk_detil where pihak_diwakili='Y' and perkara_id=perkara.perkara_id) as nama_kuasa_pk

						FROM
							perkara
						LEFT JOIN perkara_putusan ON perkara_putusan.perkara_id=perkara.perkara_id
						LEFT JOIN perkara_penetapan ON perkara_penetapan.perkara_id=perkara.perkara_id
						LEFT JOIN perkara_kasasi ON perkara_kasasi.perkara_id=perkara.perkara_id

						LEFT JOIN perkara_banding ON perkara_banding.perkara_id=perkara.perkara_id
 						LEFT JOIN perkara_pk ON perkara_pk.perkara_id=perkara.perkara_id
						LEFT JOIN perkara_verzet ON perkara_verzet.perkara_id=perkara.perkara_id
						
						LEFT JOIN perkara_eksekusi ON perkara_eksekusi.perkara_id=perkara.perkara_id
						LEFT JOIN (SELECT perkara_id, hasil_mediasi, tgl_laporan_mediator, penetapan_penunjukan_mediator,nama_gelar,no_sertifikasi,tgl_sertifikasi from perkara_mediasi left join mediator on mediator.id=perkara_mediasi.mediator_id) AS med ON med.perkara_id=perkara.perkara_id

						WHERE $sql_waktu AND perkara.jenis_perkara_id=370 $sql_tahapan ORDER BY perkara.perkara_id ASC
			");

		return $q->result();
	}
	function register_14($tahun, $bulan, $tahapan, $perkara_id='')
	{
		if ($bulan == 0)
		{
			$sql_waktu = " YEAR(tanggal_pendaftaran)=$tahun ";
		}
		else
		{
			$sql_waktu = " YEAR(tanggal_pendaftaran)=$tahun AND MONTH(tanggal_pendaftaran)=$bulan ";
		}

		if($perkara_id<>'')
		{
			$sql_waktu=" id=$perkara_id ";
		}
		$q = $this
			->db
			->query("
					SELECT 
						id,
						urutan,
						nomor_permohonan,
						convert_tanggal_indonesia(tanggal_pendaftaran) AS tanggal_pendaftaran,
						nama_pemohon,
						keterangan_singkat_isi_permohonan,
						convert_tanggal_indonesia(tanggal_penetapan_hakim) AS tanggal_penetapan_hakim,
						nama_hakim,
						nama_panitera,
						convert_tanggal_indonesia(tanggal_pelaksanaan) AS tanggal_pelaksanaan,
						keterangan_singkat_isi_permohonan,(tempat_pelaksanaan) AS tempat_pelaksanaan,
						convert_tanggal_indonesia(tanggal_penetapan) AS tanggal_penetapan,
						isi_penetapan,
						keterangan
	
						FROM
						register_permohonan_penetapan_ikrh
						
						WHERE $sql_waktu ORDER BY tanggal_pendaftaran ASC, urutan ASC");

		return $q->result();
	}
	function register_15($tahun, $bulan, $tahapan)
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
	}

	///ardan
	function register_16($tahun, $bulan, $tahapan,$perkara_id='')
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		 
		$sql_tahapan = " ";

		if ($bulan == 0)
		{
			$sql_waktu = "WHERE YEAR(penetapan_penunjukan_mediator)=$tahun ";
		}
		else
		{
			$sql_waktu = "WHERE YEAR(penetapan_penunjukan_mediator)=$tahun AND MONTH(penetapan_penunjukan_mediator)=$bulan ";
		}

		
		if($perkara_id<>'')
		{
			$sql_waktu="WHERE medi.perkara_id=$perkara_id ";
		}
		 
		$sql="SELECT 				'' AS urut,
									medi.mediasi_id,
									penetapan_penunjukan_mediator,
									data_mediasi1.*,
									data_mediasi2.*,
									
									DATE_FORMAT(med_b.tgl_permohonan_banding,'%d-%m-%Y') 		AS permohonan_banding,
									med_b.nomor_perkara_banding 					AS nomor_perkara_banding,
									DATE_FORMAT(med_b.tgl_kesepakatan_perdamaian_b,'%d-%m-%Y') 	AS tgl_kesepakatan_perdamaian_b,
									DATE_FORMAT(med_b.tgl_pengajuan_kesepakatan_b,'%d-%m-%Y') 	AS tgl_pengajuan_kesepakatan_b,
									med_b.mediator_b 						AS mediator_b,
									med_b.isi_kesekapatan_perdamaian_b 				AS isi_kesekapatan_perdamaian_b,	
									DATE_FORMAT(med_b.tgl_pemberitahuan_ke_ptma_b,'%d-%m-%Y') 	AS tgl_pemberitahuan_ke_ptma_b,
									DATE_FORMAT(med_b.akta_perdamaian_b,'%d-%m-%Y') 		AS akta_perdamaian_b,
									med_b.isi_akta_perdamaian 					AS isi_akta_perdamaian,
									
									DATE_FORMAT(med_k.tgl_permohonan_kasasi,'%d-%m-%Y') 		AS permohonan_kasasi,
									med_k.nomor_perkara_kasasi 					AS nomor_perkara_kasasi,
									DATE_FORMAT(med_k.tgl_kesepakatan_perdamaian_k,'%d-%m-%Y') 	AS tgl_kesepakatan_perdamaian_k,
									DATE_FORMAT(med_k.tgl_pengajuan_kesepakatan_k,'%d-%m-%Y') 	AS tgl_pengajuan_kesepakatan_k,
									med_k.mediator_k 						AS mediator_k,
									med_k.isi_kesekapatan_perdamaian_k 				AS isi_kesekapatan_perdamaian_k,
									DATE_FORMAT(med_k.tgl_pengajuan_kesepakatan_k,'%d-%m-%Y') 	AS tgl_pengajuan_kesepakatan_k,
									DATE_FORMAT(med_k.tgl_pemberitahuan_ke_ptma_k,'%d-%m-%Y') 	AS tgl_pemberitahuan_ke_ptma_k,
									DATE_FORMAT(med_k.akta_perdamaian_k,'%d-%m-%Y') 		AS akta_perdamaian_k,
									med_k.isi_akta_perdamaian_k 					AS isi_akta_perdamaian,
									
									DATE_FORMAT(med_pk.tgl_permohonan_pk,'%d-%m-%Y') 		AS permohonan_pk,
									med_pk.nomor_perkara_pk 					AS nomor_perkara_pk,
									DATE_FORMAT(med_pk.tgl_kesepakatan_perdamaian_pk,'%d-%m-%Y') 	AS tgl_kesepakatan_perdamaian_pk,
									DATE_FORMAT(med_pk.tgl_pengajuan_kesepakatan_pk,'%d-%m-%Y') 	AS tgl_pengajuan_kesepakatan_pk,
									med_pk.mediator_pk 						AS mediator_pk,
									med_pk.isi_kesekapatan_perdamaian_pk 				AS isi_kesekapatan_perdamaian_pk,
									DATE_FORMAT(med_pk.tgl_pengajuan_kesepakatan_pk,'%d-%m-%Y') 	AS tgl_pengajuan_kesepakatan_pk,
									DATE_FORMAT(med_pk.tgl_pemberitahuan_ke_ptma_pk,'%d-%m-%Y') 	AS tgl_pemberitahuan_ke_ptma_pk,
									DATE_FORMAT(med_pk.akta_perdamaian_pk,'%d-%m-%Y') 		AS akta_perdamaian_pk,
									med_pk.isi_akta_perdamaian_pk 					AS isi_akta_perdamaian,
									
									DATE_FORMAT(med_ek.tgl_permohonan_ek,'%d-%m-%Y')		AS tgl_permohonan_ek,
									DATE_FORMAT(med_ek.penetapan_teguran_ek,'%d-%m-%Y')		AS penetapan_teguran_ek,
									DATE_FORMAT(med_ek.teguran_ek,'%d-%m-%Y')			AS teguran_ek,
									DATE_FORMAT(med_ek.penetapan_sita_ek,'%d-%m-%Y')		AS penetapan_sita_ek,
									med_ek.nomor_penetapan_sita_ek					AS nomor_penetapan_sita_ek,
									DATE_FORMAT(med_ek.pelaksanaan_sita_ek,'%d-%m-%Y') 		AS pelaksanaan_sita_ek,
									DATE_FORMAT(med_ek.penetapan_ek,'%d-%m-%Y')			AS penetapan_ek,
									DATE_FORMAT(med_ek.pelaksanaan_ek,'%d-%m-%Y') 			AS pelaksanaan_ek

										
								FROM perkara_mediasi AS medi
								LEFT JOIN (
									SELECT 
										p.perkara_id 						AS perkara_id,
										p.nomor_perkara 					AS nomor_perkara,
										p.jenis_perkara_nama 					AS jenis_perkara,	
										pm.penetapan_penunjukan_mediator 			AS tgl_penunjukan_mediator,
										dphk1.data_pihak1 					AS data_pihak1,
										dpphk1.data_pengacara_pihak1 				AS pengacara_pihak1,
										dphk2.data_pihak2 					AS data_pihak2,
										dpphk2.data_pengacara_pihak2 				AS pengacara_pihak2,
										pnt.majelis_hakim_nama 					AS majelis_hakim,
										pnt.panitera_pengganti_text 				AS panitera_pengganti,
										convert_tanggal_indonesia(pm.penetapan_penunjukan_mediator) 	AS penunjukan_mediator,
										med.data_mediator 					AS mediator,
										pjmi.jadwal_mediasi 					AS jadwal_mediasi,
										convert_tanggal_indonesia(pm.tgl_laporan_mediator) 	AS tgl_laporan_mediator,
										IF(pm.hasil_mediasi='Y','Berhasil',
										IF(pm.hasil_mediasi='S','Berhasil Sebagian',
										IF(pm.hasil_mediasi='T','Tidak Berhasil',
										IF(pm.hasil_mediasi='D','Tidak Dapat Dilaksanakan',
										'')))) AS hasil_mediasi,
										IF((pm.hasil_mediasi='Y' OR pm.hasil_mediasi='S') AND akta_perdamaian IS NOT NULL,DATE_FORMAT(akta_perdamaian,'%d-%m-%Y'),
										(SELECT DATE_FORMAT(tanggal_putusan,'%d-%m-%Y') FROM perkara_putusan WHERE perkara_id=pm.perkara_id)) AS tanggal_akta_or_cabut,
										IF(pm.hasil_mediasi='Y' OR pm.hasil_mediasi='S',pm.isi_akta_perdamaian,'') 				AS isi_akta_perdamaian
										
									FROM perkara_mediasi AS pm
									LEFT JOIN (SELECT perkara_id,nomor_perkara,jenis_perkara_nama FROM perkara) AS p ON pm.perkara_id=p.perkara_id
									LEFT JOIN (
										SELECT 
											pp1.perkara_id,GROUP_CONCAT(CONCAT('- ',CONCAT(phk.nama,',',phk.jenis_kelamin,',',phk.tempat_lahir,',',DATE_FORMAT(phk.tanggal_lahir,'%d-%m-%Y'),',',phk.alamat))SEPARATOR ',<br>') AS data_pihak1
										FROM perkara_pihak1 AS pp1
										LEFT JOIN pihak AS phk ON pp1.pihak_id=phk.id GROUP BY pp1.perkara_id
									) AS dphk1 ON pm.perkara_id=dphk1.perkara_id
									LEFT JOIN (
										SELECT 
											ppp1.perkara_id,GROUP_CONCAT(CONCAT('- ',CONCAT(ppp1.nama,',',ppp1.alamat))SEPARATOR ',<br>') AS data_pengacara_pihak1
										FROM (SELECT * FROM perkara_pengacara WHERE pihak_ke=1 GROUP BY perkara_id,pengacara_id) AS ppp1 GROUP BY ppp1.perkara_id
									) AS dpphk1 ON pm.perkara_id=dpphk1.perkara_id

									LEFT JOIN (
										SELECT 
											pp2.perkara_id,GROUP_CONCAT(CONCAT('- ',CONCAT(phk.nama,',',phk.jenis_kelamin,',',phk.tempat_lahir,',',DATE_FORMAT(phk.tanggal_lahir,'%d-%m-%Y'),',',phk.alamat))SEPARATOR ',<br>') AS data_pihak2
										FROM perkara_pihak2 AS pp2
										LEFT JOIN pihak AS phk ON pp2.pihak_id=phk.id GROUP BY pp2.perkara_id
									) AS dphk2 ON pm.perkara_id=dphk2.perkara_id
									LEFT JOIN (
										SELECT 
											ppp2.perkara_id,GROUP_CONCAT(CONCAT('- ',CONCAT(ppp2.nama,',',ppp2.alamat))SEPARATOR ',<br>') AS data_pengacara_pihak2
										FROM (SELECT * FROM perkara_pengacara WHERE pihak_ke=2 GROUP BY perkara_id,pengacara_id) AS ppp2 GROUP BY ppp2.perkara_id
									) AS dpphk2 ON pm.perkara_id=dpphk2.perkara_id
									LEFT JOIN (SELECT perkara_id,majelis_hakim_nama,majelis_hakim_text,panitera_pengganti_text FROM perkara_penetapan) AS pnt ON pm.perkara_id=pnt.perkara_id
									LEFT JOIN (
										SELECT 
											mediator.perkara_id,GROUP_CONCAT(CONCAT('- ',CONCAT(mediator.nama_mediator,',',mediator.status_mediator))SEPARATOR ',<br>') AS data_mediator
										FROM (SELECT perkara_id,nama_mediator,status_mediator FROM perkara_mediator) AS mediator GROUP BY mediator.perkara_id
									) AS med ON pm.perkara_id=med.perkara_id
									LEFT JOIN (
										SELECT 
											pjm.mediasi_id,GROUP_CONCAT(CONCAT('- ',CONCAT(convert_tanggal_indonesia(pjm.tanggal_mediasi)))SEPARATOR ',<br>') AS jadwal_mediasi
										FROM (SELECT mediasi_id,tanggal_mediasi FROM perkara_jadwal_mediasi) AS pjm GROUP BY pjm.mediasi_id
									) AS pjmi ON pm.mediasi_id=pjmi.mediasi_id
									WHERE pm.jenis_mediasi=1
								) AS data_mediasi1 ON medi.perkara_id=data_mediasi1.perkara_id
								LEFT JOIN (
									SELECT 
										pm.perkara_id 				AS perkara_id,
										convert_tanggal_indonesia(pm.penetapan_penunjukan_mediator) 	AS tanggal_penunjukan_mediator2,
										med.data_mediator 			AS mediator2,
										convert_tanggal_indonesia(pm.tgl_laporan_mediator) 		AS tgl_laporan_mediator2,
										IF(pm.hasil_mediasi='Y','Berhasil',
										IF(pm.hasil_mediasi='S','Berhasil Sebagian',
										IF(pm.hasil_mediasi='T','Tidak Berhasil',
										IF(pm.hasil_mediasi='D','Tidak Dapat Dilaksanakan',
										'-')))) 				AS hasil_mediasi2,
										IF((pm.hasil_mediasi='Y' OR pm.hasil_mediasi='S') AND akta_perdamaian IS NOT NULL,akta_perdamaian,
										(SELECT tanggal_putusan FROM perkara_putusan WHERE perkara_id=pm.perkara_id)) AS tanggal_akta_or_cabut2,
										pm.isi_akta_perdamaian 			AS isi_akta_perdamaian2
									FROM perkara_mediasi AS pm 
									LEFT JOIN (
										SELECT 
											mediator.perkara_id,GROUP_CONCAT(CONCAT('- ',CONCAT(mediator.nama_mediator,',',mediator.status_mediator))SEPARATOR ',<br>') AS data_mediator
										FROM (SELECT perkara_id,nama_mediator,status_mediator FROM perkara_mediator) AS mediator GROUP BY mediator.perkara_id
									) AS med ON pm.perkara_id=med.perkara_id
									WHERE pm.jenis_mediasi=2
								) AS data_mediasi2 ON medi.perkara_id=data_mediasi2.perkara_id
								LEFT JOIN (
									SELECT 
										pb.`permohonan_banding` 		AS tgl_permohonan_banding,
										pb.`nomor_perkara_banding` 		AS nomor_perkara_banding,
										pmb.mediasi_id 				AS mediasi_id_b,
										pmb.perkara_id				AS perkara_id_b,
										pmb.`tgl_kesepakatan_perdamaian` 	AS tgl_kesepakatan_perdamaian_b,
										pmb.`tgl_pengajuan_kesepakatan` 	AS tgl_pengajuan_kesepakatan_b,
										medb.data_mediator 			AS mediator_b,
										pmb.`isi_kesepakatan_perdamaian` 	AS isi_kesekapatan_perdamaian_b,
										IF(pmb.akta_perdamaian IS NULL,pb.putusan_banding,pmb.`akta_perdamaian`) AS akta_perdamaian_b,
										pmb.tgl_pemberitahuan_ke_ptma 		AS tgl_pemberitahuan_ke_ptma_b,
										IF(pmb.`isi_akta_perdamaian` IS NULL,pb.amar_putusan_banding,pmb.isi_akta_perdamaian) 		AS isi_akta_perdamaian
									FROM perkara_mediasi AS pmb 
									LEFT JOIN perkara_banding AS pb ON pb.`perkara_id`=pmb.`perkara_id`
									LEFT JOIN (	
										SELECT 
											mediator.perkara_id,GROUP_CONCAT(CONCAT('- ',CONCAT('1. ',mediator.nama_mediator,'<br>2. ,',IF(mediator.`bersertifikat`='Y','Bersertifikat','Tidak Bersertifikat'),'<br>3. ,',mediator.`lembaga_sertifikasi`,'<br>4. ,',mediator.`no_sertifikasi`,'dan ',DATE_FORMAT(mediator.`tgl_sertifikasi`,'%d-%m-%Y')))SEPARATOR ',<br>') AS data_mediator
										FROM (SELECT pmm.perkara_id,pmm.nama_mediator,pmm.status_mediator,mm.bersertifikat,mm.lembaga_sertifikasi,mm.no_sertifikasi,DATE_FORMAT(mm.tgl_sertifikasi,'%d-%m-%Y') AS tgl_sertifikasi 
										 FROM perkara_mediator AS pmm
										 LEFT JOIN mediator AS mm ON pmm.`mediator_id`=mm.id) AS mediator GROUP BY mediator.perkara_id
									) AS medb ON pmb.perkara_id=medb.perkara_id	
									WHERE tahapan_id=20) AS med_b ON medi.perkara_id=med_b.perkara_id_b
									
								LEFT JOIN (
									SELECT 
										pb.`permohonan_kasasi` 			AS tgl_permohonan_kasasi,
										pb.`nomor_perkara_kasasi` 		AS nomor_perkara_kasasi,
										pmb.mediasi_id 				AS mediasi_id_k,
										pmb.perkara_id				AS perkara_id_k,
										pmb.`tgl_kesepakatan_perdamaian` 	AS tgl_kesepakatan_perdamaian_k,
										pmb.`tgl_pengajuan_kesepakatan` 	AS tgl_pengajuan_kesepakatan_k,
										medb.data_mediator 			AS mediator_k,
										pmb.`isi_kesepakatan_perdamaian` 	AS isi_kesekapatan_perdamaian_k,
										IF(pmb.akta_perdamaian IS NULL,pb.putusan_kasasi,pmb.`akta_perdamaian`) AS akta_perdamaian_k,
										pmb.tgl_pemberitahuan_ke_ptma 		AS tgl_pemberitahuan_ke_ptma_k,
										IF(pmb.`isi_akta_perdamaian` IS NULL,pb.amar_putusan_kasasi,pmb.isi_akta_perdamaian) 		AS isi_akta_perdamaian_k
									FROM perkara_mediasi AS pmb 
									LEFT JOIN perkara_kasasi AS pb ON pb.`perkara_id`=pmb.`perkara_id`
									LEFT JOIN (	
										SELECT 
											mediator.perkara_id,GROUP_CONCAT(CONCAT('- ',CONCAT('1. ',mediator.nama_mediator,'<br>2. ,',IF(mediator.`bersertifikat`='Y','Bersertifikat','Tidak Bersertifikat'),'<br>3. ,',mediator.`lembaga_sertifikasi`,'<br>4. ,',mediator.`no_sertifikasi`,'dan ',DATE_FORMAT(mediator.`tgl_sertifikasi`,'%d-%m-%Y')))SEPARATOR ',<br>') AS data_mediator
										FROM (SELECT pmm.perkara_id,pmm.nama_mediator,pmm.status_mediator,mm.bersertifikat,mm.lembaga_sertifikasi,mm.no_sertifikasi,DATE_FORMAT(mm.tgl_sertifikasi,'%d-%m-%Y') AS tgl_sertifikasi 
										 FROM perkara_mediator AS pmm
										 LEFT JOIN mediator AS mm ON pmm.`mediator_id`=mm.id) AS mediator GROUP BY mediator.perkara_id
									) AS medb ON pmb.perkara_id=medb.perkara_id	
									WHERE tahapan_id=30) AS med_k ON medi.perkara_id=med_k.perkara_id_k

								LEFT JOIN (
									SELECT 
										pb.`permohonan_pk` 			AS tgl_permohonan_pk,
										pb.`nomor_perkara_pk`	 		AS nomor_perkara_pk,
										pmb.mediasi_id 				AS mediasi_id_pk,
										pmb.perkara_id				AS perkara_id_pk,
										pmb.`tgl_kesepakatan_perdamaian` 	AS tgl_kesepakatan_perdamaian_pk,
										pmb.`tgl_pengajuan_kesepakatan` 	AS tgl_pengajuan_kesepakatan_pk,
										medb.data_mediator 			AS mediator_pk,
										pmb.`isi_kesepakatan_perdamaian` 	AS isi_kesekapatan_perdamaian_pk,
										IF(pmb.akta_perdamaian IS NULL,pb.putusan_pk,pmb.`akta_perdamaian`) AS akta_perdamaian_pk,
										pmb.tgl_pemberitahuan_ke_ptma 		AS tgl_pemberitahuan_ke_ptma_pk,
										IF(pmb.`isi_akta_perdamaian` IS NULL,pb.amar_putusan_pk,pmb.isi_akta_perdamaian) 		AS isi_akta_perdamaian_pk
									FROM perkara_mediasi AS pmb 
									LEFT JOIN perkara_pk AS pb ON pb.`perkara_id`=pmb.`perkara_id`
									LEFT JOIN (	
										SELECT 
											mediator.perkara_id,GROUP_CONCAT(CONCAT('- ',CONCAT('1. ',mediator.nama_mediator,'<br>2. ,',IF(mediator.`bersertifikat`='Y','Bersertifikat','Tidak Bersertifikat'),'<br>3. ,',mediator.`lembaga_sertifikasi`,'<br>4. ,',mediator.`no_sertifikasi`,'dan ',DATE_FORMAT(mediator.`tgl_sertifikasi`,'%d-%m-%Y')))SEPARATOR ',<br>') AS data_mediator
										FROM (SELECT pmm.perkara_id,pmm.nama_mediator,pmm.status_mediator,mm.bersertifikat,mm.lembaga_sertifikasi,mm.no_sertifikasi,DATE_FORMAT(mm.tgl_sertifikasi,'%d-%m-%Y') AS tgl_sertifikasi 
										 FROM perkara_mediator AS pmm
										 LEFT JOIN mediator AS mm ON pmm.`mediator_id`=mm.id) AS mediator GROUP BY mediator.perkara_id
									) AS medb ON pmb.perkara_id=medb.perkara_id	
									WHERE tahapan_id=40) AS med_pk ON medi.perkara_id=med_pk.perkara_id_pk

								LEFT JOIN (
									SELECT 
										pb.`permohonan_eksekusi`		AS tgl_permohonan_ek,
										pb.`penetapan_teguran_eksekusi`		AS penetapan_teguran_ek,
										pb.`pelaksanaan_teguran_eksekusi`	AS teguran_ek,
										pb.`penetapan_sita_eksekusi`		AS penetapan_sita_ek,
										pb.`nomor_penetapan_sita_eksekusi`	AS nomor_penetapan_sita_ek,
										pb.`pelaksanaan_sita_eksekusi`		AS pelaksanaan_sita_ek,
										pb.`penetapan_perintah_eksekusi_rill`	AS penetapan_ek,
										pb.`pelaksanaan_eksekusi_rill`		AS pelaksanaan_ek,
										pmb.mediasi_id 				AS mediasi_id_pk,
										pmb.perkara_id				AS perkara_id_pk
									FROM perkara_mediasi AS pmb 
									LEFT JOIN perkara_eksekusi AS pb ON pb.`perkara_id`=pmb.`perkara_id`
									LEFT JOIN (	
										SELECT 
											mediator.perkara_id,GROUP_CONCAT(CONCAT('- ',CONCAT('1. ',mediator.nama_mediator,'<br>2. ,',IF(mediator.`bersertifikat`='Y','Bersertifikat','Tidak Bersertifikat'),'<br>3. ,',mediator.`lembaga_sertifikasi`,'<br>4. ,',mediator.`no_sertifikasi`,'dan ',DATE_FORMAT(mediator.`tgl_sertifikasi`,'%d-%m-%Y')))SEPARATOR ',<br>') AS data_mediator
										FROM (SELECT pmm.perkara_id,pmm.nama_mediator,pmm.status_mediator,mm.bersertifikat,mm.lembaga_sertifikasi,mm.no_sertifikasi,DATE_FORMAT(mm.tgl_sertifikasi,'%d-%m-%Y') AS tgl_sertifikasi 
										 FROM perkara_mediator AS pmm
										 LEFT JOIN mediator AS mm ON pmm.`mediator_id`=mm.id) AS mediator GROUP BY mediator.perkara_id
									) AS medb ON pmb.perkara_id=medb.perkara_id	
									WHERE tahapan_id=50) AS med_ek ON medi.perkara_id=med_ek.perkara_id_pk
 
						 $sql_waktu 
			";
			//echo $sql;exit;
		$q = $this->dbsipp->query($sql);

		return $q->result();
	}
	///ardan
	///rahman
	//REGISTER AKTA CERAI
	function register_10($tahun, $bulan,$perkara_id='')
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);

		if ($bulan == 0)
		{
			$sql_waktu = " YEAR(perkara_akta_cerai.tgl_akta_cerai)=$tahun ";
		}
		else
		{
			$sql_waktu = " YEAR(perkara_akta_cerai.tgl_akta_cerai)=$tahun AND MONTH(perkara_akta_cerai.tgl_akta_cerai)=$bulan ";
		}

		if($perkara_id<>'')
		{
			$sql_waktu=" perkara_akta_cerai.perkara_id=$perkara_id ";
		}
		$q = $this
			->dbsipp
			->query("
					SELECT
					perkara_akta_cerai.nomor_urut_akta_cerai
					,perkara.jenis_perkara_id
					,perkara_akta_cerai.nomor_akta_cerai
					,perkara_akta_cerai.no_seri_akta_cerai
					,DATE_FORMAT(perkara_ikrar_talak.tgl_ikrar_talak, '%d-%m-%Y') AS tglikrartalak
					,DATE_FORMAT(perkara_akta_cerai.tgl_akta_cerai, '%d-%m-%Y') AS tglaktacerai
					,perkara.nomor_perkara
					,DATE_FORMAT(perkara_putusan.tanggal_putusan, '%d-%m-%Y') AS tanggalputusan
					,CASE WHEN perkara_banding.nomor_putusan_banding = NULL THEN perkara_banding.nomor_putusan_banding ELSE '-' END AS nomorbanding
					,CASE WHEN perkara_banding.putusan_banding = NULL THEN DATE_FORMAT(perkara_banding.putusan_banding, '%d-%m-%Y') ELSE '' END AS putusanbanding
					,convert_tanggal_indonesia(perkara_banding.putusan_banding) AS putusan_banding_indo
					,convert_tanggal_indonesia(perkara_putusan.tanggal_putusan) AS tanggal_putusan_indo
					,convert_tanggal_indonesia(perkara_kasasi.putusan_kasasi) AS putusan_kasasi_indo
					,convert_tanggal_indonesia(perkara_pk.putusan_pk) AS putusan_pk_indo
					,CASE WHEN perkara_kasasi.nomor_putusan_kasasi = NULL THEN perkara_kasasi.nomor_putusan_kasasi ELSE '' END AS nomorkasasi
					,CASE WHEN perkara_kasasi.putusan_kasasi = NULL THEN DATE_FORMAT(perkara_kasasi.putusan_kasasi, '%d-%m-%Y') ELSE '-' END AS putusankasasi
					,CASE WHEN perkara_pk.nomor_putusan_pk = NULL THEN perkara_pk.nomor_putusan_pk ELSE '-' END AS nomorpk
					,CASE WHEN perkara_pk.putusan_pk = NULL THEN DATE_FORMAT(perkara_pk.putusan_pk, '%d-%m-%Y') ELSE '-' END AS putusanpk
					,perkara_akta_cerai.perceraian_ke
					,REPLACE(REPLACE(UPPER(perkara_pihak1.nama),' BINTI ',' binti '),' BIN ',' bin ') AS nama_p
					,REPLACE(REPLACE(UPPER(perkara_pihak2.nama),' BINTI ',' binti '),' BIN ',' bin ') AS nama_t
					,CASE WHEN perkara.jenis_perkara_id = 347 THEN CONCAT('A. ',DATE_FORMAT(perkara_putusan.tanggal_bht, '%d-%m-%Y')) ELSE 'A. -			' END AS tanggal_bht
					,CASE WHEN perkara.jenis_perkara_id = 346 THEN CONCAT('B. ',DATE_FORMAT(perkara_ikrar_talak.tgl_ikrar_talak, '%d-%m-%Y')) ELSE 'B. -' END AS tglikrartalak
					,convert_tanggal_indonesia(perkara_ikrar_talak.tgl_ikrar_talak) AS ikrar_indo
					,convert_tanggal_indonesia(perkara_putusan.tanggal_bht) AS bht_indo
					,convert_tanggal_indonesia(perkara_akta_cerai.tgl_akta_cerai) AS tgl_akta_indo
					,CASE
						WHEN
							perkara.jenis_perkara_id = 346
							THEN
							'raj\'i'
						ELSE
							'cari'
					END AS bain_raji
					,CASE WHEN perkara_akta_cerai.tgl_penyerahan_akta_cerai = NULL THEN '			' ELSE DATE_FORMAT(perkara_akta_cerai.tgl_penyerahan_akta_cerai, '%d-%m-%Y') END AS penyerahan_p
					,CASE WHEN perkara_akta_cerai.tgl_penyerahan_akta_cerai_pihak2 = NULL THEN '			' ELSE DATE_FORMAT(perkara_akta_cerai.tgl_penyerahan_akta_cerai_pihak2, '%d-%m-%Y') END AS penyerahan_t

					,perkara_putusan.amar_putusan
					,perkara_data_pernikahan.no_kutipan_akta_nikah
					,perkara_data_pernikahan.kua_tempat_nikah
					,convert_tanggal_indonesia(perkara_data_pernikahan.tgl_kutipan_akta_nikah) AS kutipan_indo
					,convert_tanggal_indonesia(perkara_akta_cerai.tgl_penyerahan_akta_cerai) AS penyerahan_t_indo
					,convert_tanggal_indonesia(perkara_akta_cerai.tgl_penyerahan_akta_cerai) AS penyerahan_p_indo

					FROM perkara_akta_cerai

					LEFT JOIN perkara ON perkara.perkara_id=perkara_akta_cerai.perkara_id
					LEFT JOIN perkara_data_pernikahan ON perkara_data_pernikahan.perkara_id=perkara_akta_cerai.perkara_id
					LEFT JOIN perkara_putusan ON perkara_putusan.perkara_id=perkara_akta_cerai.perkara_id
					LEFT JOIN perkara_banding ON perkara_banding.perkara_id=perkara_akta_cerai.perkara_id
					LEFT JOIN perkara_kasasi ON perkara_kasasi.perkara_id=perkara_akta_cerai.perkara_id
					LEFT JOIN perkara_pk ON perkara_pk.perkara_id=perkara_akta_cerai.perkara_id
					LEFT JOIN perkara_pihak1 ON perkara_pihak1.perkara_id=perkara_akta_cerai.perkara_id
					LEFT JOIN perkara_pihak2 ON perkara_pihak2.perkara_id=perkara_akta_cerai.perkara_id
					LEFT JOIN perkara_ikrar_talak ON perkara_ikrar_talak.perkara_id=perkara_akta_cerai.perkara_id
					WHERE $sql_waktu

					ORDER BY tgl_akta_cerai ASC, nomor_urut_akta_cerai ASC

			");

		return $q->result();
	}


	function register_21($tahun, $bulan, $tahapan=0, $perkara_id='')
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
	 
		if ($bulan == 0)
		{
			$sql_waktu = " YEAR(perkara_banding.permohonan_banding)=$tahun ";
		}
		else
		{
			$sql_waktu = " YEAR(perkara_banding.permohonan_banding)=$tahun AND MONTH(perkara_banding.permohonan_banding)=$bulan ";
		}

		if($perkara_id<>'')
		{
			$sql_waktu=" perkara_banding.perkara_id=$perkara_id ";
			
		}
		$sql=" SELECT 
 perkara_banding.perkara_id
 ,'' AS no_urut
,perkara_banding.nomor_perkara_pn
,(SELECT CASE WHEN COUNT(perkara_id) =1  THEN nama ELSE
GROUP_CONCAT(CONCAT(urutan,' ',nama)SEPARATOR '<br>') END FROM perkara_pihak2 WHERE perkara_id=perkara_banding.`perkara_id`) AS nama_terdakwa
,perkara_banding.pemohon_banding
,CONCAT(perkara_penetapan.majelis_hakim_text,'<br>',perkara_penetapan.panitera_pengganti_text) AS majelis_hakim_nama
,convert_tanggal_indonesia(putusan_pn) AS putusanpn 

,(SELECT CASE WHEN count(perkara_id)=1 then 
concat(IF(pihak=1,'Penuntut Umum','Terdakwa'), ' ',convert_tanggal_indonesia(tanggal_pemberitahuan_putusan))
else
GROUP_CONCAT(CONCAT(IF(pihak=1,'Penuntut Umum','Terdakwa'),' ',convert_tanggal_indonesia(tanggal_pemberitahuan_putusan))SEPARATOR'<br>') 

END  
from perkara_putusan_pemberitahuan_putusan where perkara_id=perkara_banding.perkara_id
) as pemberitahuanms
,convert_tanggal_indonesia(permohonan_banding) AS permohonanbanding
,convert_tanggal_indonesia(pemberitahuan_permohonan_banding) AS pemberitahuanpermohonanbanding
,convert_tanggal_indonesia(penerimaan_memori_banding) AS penerimaanmemoribanding
,convert_tanggal_indonesia(penyerahan_memori_banding) AS penyerahanmemoribanding
,convert_tanggal_indonesia(penerimaan_kontra_banding) AS penerimaankontrabanding
,convert_tanggal_indonesia(penyerahan_kontra_banding) AS penyerahankontrabanding
,minut.tanggalminutasi
,CONCAT(nomor_surat_pengiriman_berkas_banding, convert_tanggal_indonesia(pengiriman_berkas_banding)) AS pengirimanberkasbanding	
,convert_tanggal_indonesia(penerimaan_kembali_berkas_banding) AS penerimaankembaliberkasbanding 
,convert_tanggal_indonesia(pelaksanaan_inzage) AS pelaksanaaninzage
,convert_tanggal_indonesia(perkara_banding.pemberitahuan_putusan_banding) AS pemberitahuanputusanbanding
,CONCAT(convert_tanggal_indonesia(putusan_banding),'<br>',nomor_putusan_banding,'<br>',amar_putusan_banding) AS putusanbanding
,catatan_banding
 FROM perkara_banding
LEFT JOIN perkara_penetapan  ON perkara_penetapan.perkara_id=perkara_banding.perkara_id
LEFT JOIN (SELECT perkara_id, convert_tanggal_indonesia(tanggal_minutasi) AS tanggalminutasi FROM perkara_putusan ) AS minut ON minut.perkara_id=perkara_banding.perkara_id
  
  
 

						WHERE $sql_waktu AND alur_perkara_id=122  ORDER BY perkara_banding.permohonan_banding ASC
			";
			//echo $sql;exit;
		$q = $this->dbsipp->query($sql);
		return $q->result();
	}	
	function register_22($tahun, $bulan, $tahapan=0, $perkara_id='')
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
	 
		if ($bulan == 0)
		{
			$sql_waktu = " YEAR(perkara_kasasi.permohonan_kasasi)=$tahun ";
		}
		else
		{
			$sql_waktu = " YEAR(perkara_kasasi.permohonan_kasasi)=$tahun AND MONTH(perkara_kasasi.permohonan_kasasi)=$bulan ";
		}

		if($perkara_id<>'')
		{
			$sql_waktu=" perkara_kasasi.perkara_id=$perkara_id ";
			
		}
		$sql=" SELECT 
 (SELECT CASE WHEN COUNT(perkara_id) =1  THEN nama ELSE
GROUP_CONCAT(CONCAT(urutan,' ',nama)SEPARATOR '<br>') END FROM perkara_pihak2 WHERE perkara_id=perkara_kasasi.`perkara_id`) AS nama_terdakwa
,'' AS no_urut
,nomor_perkara_pn
,pemohon_kasasi
,convert_tanggal_indonesia(putusan_pn) AS putusanpn
,convert_tanggal_indonesia(pemberitahuan_putusan_banding) AS pemberitahuanputusanbanding
,convert_tanggal_indonesia(pemberitahuan_kasasi) AS pemberitahuankasasi
,convert_tanggal_indonesia(permohonan_kasasi) AS permohonankasasi
,convert_tanggal_indonesia(pemberitahuan_kasasi) AS pemberitahuankasasi
,convert_tanggal_indonesia(penerimaan_memori_kasasi) AS penerimaanmemorikasasi
,convert_tanggal_indonesia(penyerahan_memori_kasasi) AS penyerahanmemorikasasi
,convert_tanggal_indonesia(penerimaan_kontra_kasasi) AS penerimaankontrakasasi
,convert_tanggal_indonesia(penyerahan_kontra_kasasi) AS penyerahankontrakasasi
,minut.tanggalminutasi AS minutasi
,convert_tanggal_indonesia(pelaksanaan_inzage_kasasi) AS pelaksanaaninzagekasasi
,concat(convert_tanggal_indonesia(pengiriman_berkas_kasasi),'<br>',nomor_surat_pengiriman_berkas_kasasi) AS pengirimanberkaskasasi
,convert_tanggal_indonesia(penerimaan_berkas_kasasi) AS penerimaanberkaskasasi
,concat(convert_tanggal_indonesia(putusan_kasasi),'<br>',nomor_putusan_kasasi,'<br>',amar_putusan_kasasi) AS putusankasasi
,convert_tanggal_indonesia(pemberitahuan_putusan_kasasi) AS pemberitahuanputusankasasi

FROM perkara_kasasi
LEFT JOIN perkara on perkara.perkara_id=perkara_kasasi.perkara_id
LEFT JOIN (SELECT perkara_id, convert_tanggal_indonesia(tanggal_minutasi) AS tanggalminutasi FROM perkara_putusan ) AS minut ON minut.perkara_id=perkara_kasasi.perkara_id
WHERE $sql_waktu AND perkara_kasasi.alur_perkara_id=122  ORDER BY perkara_kasasi.permohonan_kasasi ASC
			";
			//echo $sql;exit;
		$q = $this->dbsipp->query($sql);
		return $q->result();
	}

	function register_24($tahun, $bulan, $tahapan=0, $perkara_id='')
	{  
		if ($bulan == 0)
		{
			$sql_waktu = " YEAR(tanggal_penerimaan)=$tahun ";
		}
		else
		{
			$sql_waktu = " YEAR(tanggal_penerimaan)=$tahun AND MONTH(tanggal_penerimaan)=$bulan ";
		}

		if($perkara_id<>'')
		{
			$sql_waktu=" id=$perkara_id ";
			
		}
		$sql="SELECT
					*
					,(SELECT CASE WHEN count(a.id)=0 THEN 1 ELSE count(a.id)+1 END  FROM perkara_barang_bukti AS a WHERE id<perkara_barang_bukti.id AND YEAR(a.tanggal_penerimaan)=YEAR(perkara_barang_bukti.tanggal_penerimaan)) AS no_urut
					,convert_tanggal_indonesia(tanggal_penerimaan) as tanggalpenerimaan
					,convert_tanggal_indonesia(tanggal_penyerahan) as tanggalpenyerahan
					,(
						SELECT 
							CASE WHEN count(id)=1 THEN nama 
						ELSE
							group_concat(concat('- ',nama) SEPARATOR '<br>' )
						END  
						FROM perkara_pihak1 WHERE perkara_id=perkara_barang_bukti.perkara_id ORDER by urutan ASC
					 ) AS nama_terdakwa 
				FROM perkara_barang_bukti 
						WHERE $sql_waktu ORDER BY tanggal_penerimaan ASC, id ASC";
				//		echo $sql;exit;
		$q = $this->dbsipp->query($sql);

		return $q->result();
	}
	function register_29($tahun, $bulan, $tahapan=0, $perkara_id='')
	{  
		if ($bulan == 0)
		{
			$sql_waktu = " YEAR(tanggal_penerimaan_permohonan)=$tahun ";
		}
		else
		{
			$sql_waktu = " YEAR(tanggal_penerimaan_permohonan)=$tahun AND MONTH(tanggal_penerimaan_permohonan)=$bulan ";
		}

		if($perkara_id<>'')
		{
			$sql_waktu=" izin_penyitaan_id=$perkara_id ";
			
		}
		$sql="
					SELECT
						izin_penyitaan_id
						,no_urut
						,convert_tanggal_indonesia(tanggal_penerimaan_permohonan) AS tanggalpenerimaanpermohonan		
						,CONCAT(convert_tanggal_indonesia(tanggal_surat_permohonan),'<br>', nomor_surat_permohonan) AS tanggalnomorpermohonan

						,penyidik_yang_memohon_izin
						,nama_intansi_yang_melakukan_penyitaan
						,nama_tersangka
						,CONCAT(IF(convert_tanggal_indonesia(tanggal_surat_ijin_persetujuan)='00 000','',convert_tanggal_indonesia(tanggal_surat_ijin_persetujuan)),'<br>', nomor_surat_ijin_persetujuan	) AS tanggalnomorpersetujuan
						,laporan_hasil_penyitaan
						,keterangan
					FROM
						register_izin_penyitaan_jinazat 
						WHERE $sql_waktu ORDER BY tanggal_penerimaan_permohonan ASC, no_urut ASC";
				//		echo $sql;exit;
		$q = $this->db->query($sql);

		return $q->result();
	}
	function register_31($tahun, $bulan, $tahapan=0, $perkara_id='')
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		if ($tahapan == 1)
		{
			$sql_tahapan = " AND perkara_putusan.perkara_id IS NULL ";
		}
		else if ($tahapan == 15)
		{
			$sql_tahapan = " AND perkara_putusan.perkara_id IS NOT NULL ";
		}
		else
		{
			$sql_tahapan = " ";
		}
		if ($bulan == 0)
		{
			$sql_waktu = " YEAR(perkara.tanggal_pendaftaran)=$tahun ";
		}
		else
		{
			$sql_waktu = " YEAR(perkara.tanggal_pendaftaran)=$tahun AND MONTH(perkara.tanggal_pendaftaran)=$bulan ";
		}

		if($perkara_id<>'')
		{
			$sql_waktu=" perkara.perkara_id=$perkara_id ";
			
		}
		$q = $this
			->dbsipp
			->query("
					SELECT
						perkara.perkara_id
						,perkara.nomor_urut_perkara
						,perkara.nomor_urut_register
						,perkara.nomor_perkara
						,perkara.jenis_perkara_id
						,perkara.jenis_perkara_nama
						,perkara.dakwaan
						,convert_tanggal_indonesia(perkara.tanggal_pendaftaran) AS tanggal_pendaftaran_indonesia
						,(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT('-',d.nama) SEPARATOR '<br>' ),
							CONCAT(d.nama))
							AS DATA
							FROM perkara_pihak1 b
							JOIN perkara a ON a.perkara_id = b.perkara_id
 							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
							LEFT JOIN tingkat_pendidikan f ON d.pendidikan_id = f.id
							WHERE a.perkara_id = perkara.`perkara_id` ) AS identitas_p
						,(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT('-',d.nama) SEPARATOR '<br>' ),
							CONCAT(d.nama))
							AS DATA
							FROM perkara_pihak2 b
							JOIN perkara a ON a.perkara_id = b.perkara_id
 							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
							LEFT JOIN tingkat_pendidikan f ON d.pendidikan_id = f.id
							WHERE a.perkara_id = perkara.`perkara_id` ) AS identitas_t
						,(select GROUP_CONCAT(CONCAT(case when pihak_ke =1 then '#sebutan_pihak1#' else '#sebutan_pihak2#' END,'<br>B. '
							 ,convert_tanggal_indonesia(tanggal_kuasa)
							 ,'<br>C. '
							 ,nama,'')SEPARATOR '<br><br>') 
							from perkara_pengacara WHERE perkara_id=perkara.perkara_id 
							 
							) AS tgl_nama_kuasa 
						,perkara.petitum
						,perkara.jenis_perkara_text
						,convert_tanggal_indonesia(perkara_penetapan.penetapan_hari_sidang) as phs
						,convert_tanggal_indonesia(perkara_penetapan.sidang_pertama) as sidangpertama
						,convert_tanggal_indonesia(perkara_putusan.tanggal_putusan) as tanggalputusan
						,convert_tanggal_indonesia(perkara_putusan.tanggal_bht) as tanggalbht
						,convert_tanggal_indonesia(perkara_putusan.tanggal_minutasi) as tanggalminutasi  
						,perkara_putusan.amar_putusan
						,perkara_penetapan.sidang_pertama
						,convert_tanggal_indonesia(perkara_penetapan.penetapan_majelis_hakim) as pmh
						,perkara_penetapan.majelis_hakim_text
						,(SELECT group_concat(CONCAT('<li>',convert_tanggal_indonesia(tanggal_sidang),'<br>',agenda,'</li>')separator '')
								as penundaan_sidang FROM perkara_jadwal_sidang WHERE perkara_id=perkara.perkara_id AND ditunda='Y' AND keberatan='T' AND ikrar_talak='T' AND tanggal_sidang > 'perkara_penetapan.sidang_pertama' AND urutan<>1) as penundaan_sidang
						 
						,(SELECT group_concat(CONCAT('<p>#sebutan_pihak',pihak,'# - ',convert_tanggal_indonesia(tanggal_pemberitahuan_putusan),'</p>')separator '<br>')
								as pemberitahuan_isi_putusan FROM perkara_putusan_pemberitahuan_putusan WHERE perkara_id=perkara.perkara_id AND tanggal_pemberitahuan_putusan IS NOT NULL) as pemberitahuan_isi_putusan

						  

						FROM
							perkara
						LEFT JOIN perkara_putusan ON perkara_putusan.perkara_id=perkara.perkara_id
						LEFT JOIN perkara_penetapan ON perkara_penetapan.perkara_id=perkara.perkara_id 

						WHERE $sql_waktu AND perkara.alur_perkara_id=123 $sql_tahapan ORDER BY perkara.perkara_id ASC
			");

		return $q->result();
	}
	///////////////=============register manual===================//
	///////============REGISTER CETAK======================/////
	function register_cetak_1($nomor_perkara)
	{

		$sql = "SELECT
					perkara.perkara_id
					,perkara.nomor_urut_register
					,perkara.nomor_perkara
					,perkara.tanggal_pendaftaran

					,perkara.petitum

					,perkara_penetapan.penetapan_hari_sidang
					,perkara_penetapan.sidang_pertama


					,perkara_putusan.tanggal_putusan
					,perkara_putusan.pemberitahuan_putusan
					,perkara_putusan.amar_putusan
					,perkara_putusan.tanggal_minutasi


					,perkara_kasasi.permohonan_kasasi


					,perkara_kasasi.pemberitahuan_kasasi
					,perkara_kasasi.penerimaan_memori_kasasi
					,perkara_kasasi.penyerahan_memori_kasasi
					,perkara_kasasi.penerimaan_kontra_kasasi
					,perkara_kasasi.pengiriman_berkas_kasasi
					,perkara_kasasi.penerimaan_berkas_kasasi
					,perkara_kasasi.pemberitahuan_putusan_kasasi
					,perkara_kasasi.nomor_perkara_kasasi
					,perkara_kasasi.putusan_kasasi
					,perkara_kasasi.amar_putusan_kasasi
					,perkara_putusan.tanggal_bht

					,perkara.jenis_perkara_nama
					,(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
								CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai #sebutan_pihak1# ',bulan_romawi(b.urutan) ) SEPARATOR '; \\\\par ' ),
							CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
								CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', sebagai #sebutan_pihak1#;' ))
							AS DATA
							FROM perkara_pihak1 b
							JOIN perkara a ON a.perkara_id = b.perkara_id
 							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
 							WHERE b.perkara_id = perkara.`perkara_id` ) AS identitas_p




				FROM 	perkara

				LEFT JOIN	perkara_penetapan	ON	perkara_penetapan.perkara_id=perkara.perkara_id

				LEFT JOIN	perkara_putusan		ON	perkara_putusan.perkara_id=perkara.perkara_id
				LEFT JOIN	perkara_kasasi		ON	perkara_kasasi.perkara_id=perkara.perkara_id

				WHERE perkara.nomor_perkara='$nomor_perkara'";
		//ECHO $sq
		//echo $sql;exit;
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$this
			->dbsipp
			->query('SET SESSION group_concat_max_len=100000');

		$q = $this
			->dbsipp
			->query($sql);
		return $q->result();
	}
	function register_cetak_2($nomor_perkara)
	{

		$sql = "SELECT
					perkara.perkara_id
					,perkara.nomor_urut_register
					,perkara.nomor_perkara
					,perkara.tanggal_pendaftaran

					,perkara.petitum

					,perkara_penetapan.penetapan_hari_sidang
					,perkara_penetapan.sidang_pertama


					,perkara_mediasi.penetapan_penunjukan_mediator
					,perkara_mediasi.mediator_text
					,mediator.tgl_sertifikasi
					,mediator.no_sertifikasi

					,perkara_mediasi.tgl_laporan_mediator
					,perkara_mediasi.hasil_mediasi
					,perkara_putusan.tanggal_putusan
					,perkara_putusan.pemberitahuan_putusan
					,perkara_putusan.amar_putusan
					,perkara_putusan.tanggal_minutasi

					,perkara_verzet.tanggal_pendaftaran_verzet
					,perkara_verzet.tanggal_penetapan_sidang_verzet
					,perkara_verzet.tanggal_sidang_pertama_verzet

					,perkara_verzet.putusan_verzet
					,perkara_verzet.amar_putusan_verzet

					,perkara_banding.permohonan_banding


					,perkara_banding.pemberitahuan_permohonan_banding
					,perkara_banding.penerimaan_memori_banding
					,perkara_banding.penyerahan_memori_banding
					,perkara_banding.penerimaan_kontra_banding
					,perkara_banding.penyerahan_kontra_banding
					,perkara_banding.pemberitahuan_inzage_pembanding
					,perkara_banding.pemberitahuan_inzage_terbanding
					,perkara_banding.pengiriman_berkas_banding
					,perkara_banding.penerimaan_kembali_berkas_banding
					,perkara_banding.pemberitahuan_putusan_banding_pembanding
					,perkara_banding.pemberitahuan_putusan_banding_terbanding
					,perkara_banding.nomor_perkara_banding
					,perkara_banding.putusan_banding
					,perkara_banding.amar_putusan_banding

					,perkara_kasasi.permohonan_kasasi


					,perkara_kasasi.pemberitahuan_kasasi
					,perkara_kasasi.penerimaan_memori_kasasi
					,perkara_kasasi.penyerahan_memori_kasasi
					,perkara_kasasi.penerimaan_kontra_kasasi
					,perkara_kasasi.pengiriman_berkas_kasasi
					,perkara_kasasi.penerimaan_berkas_kasasi
					,perkara_kasasi.pemberitahuan_putusan_kasasi_pihak1
					,perkara_kasasi.pemberitahuan_putusan_kasasi_pihak2
					,perkara_kasasi.nomor_perkara_kasasi
					,perkara_kasasi.putusan_kasasi
					,perkara_kasasi.amar_putusan_kasasi
					,perkara_putusan.tanggal_bht

					,perkara_pk.permohonan_pk


					,perkara_pk.pemberitahuan_pk
					,perkara_pk.penerimaan_memori_pk
					,perkara_pk.penyerahan_memori_pk
					,perkara_pk.penerimaan_kontra_pk
					,perkara_pk.tanggal_penyumpahan
					,perkara_pk.pengiriman_berkas_pk
					,perkara_pk.penerimaan_berkas_pk
					,perkara_pk.pemberitahuan_putusan_pk_pihak1
					,perkara_pk.pemberitahuan_putusan_pk_pihak2
					,perkara_pk.nomor_putusan_pk
					,perkara_pk.putusan_pk
					,perkara_pk.amar_putusan_pk

					,perkara_eksekusi.permohonan_eksekusi
					,perkara_eksekusi.penetapan_teguran_eksekusi
					,perkara_eksekusi.pelaksanaan_teguran_eksekusi
					,perkara_eksekusi.pelaksanaan_sita_eksekusi

					,perkara_ikrar_talak.penetapan_majelis_hakim	 as penetapan_majelis_hakim_ikrar
					,perkara_ikrar_talak.tanggal_penetapan_sidang_ikrar
					,perkara_ikrar_talak.tanggal_sidang_pertama AS tanggal_sidang_pertama_ikrar
					,perkara_ikrar_talak.tgl_ikrar_talak
					,perkara_ikrar_talak.amar_ikrar_talak
					,perkara_ikrar_talak.tgl_ikrar_talak

					,perkara_akta_cerai.tgl_akta_cerai
					,perkara_akta_cerai.nomor_akta_cerai
					,perkara_akta_cerai.no_seri_akta_cerai
					,perkara.jenis_perkara_nama
					,(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
								CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai #sebutan_pihak1# ',bulan_romawi(b.urutan) ) SEPARATOR '; \\\\par ' ),
							CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
								CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', sebagai #sebutan_pihak1#;' ))
							AS DATA
							FROM perkara_pihak1 b
							JOIN perkara a ON a.perkara_id = b.perkara_id
 							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
 							WHERE b.perkara_id = perkara.`perkara_id` ) AS identitas_p
					,(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
								CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END
							, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai #sebutan_pihak2# ',bulan_romawi(b.urutan) ) SEPARATOR '; \\\\par ' ),
							CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',

							CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END


							, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai #sebutan_pihak2#;' ))
							AS DATA
							FROM perkara_pihak2 b
							JOIN perkara a ON a.perkara_id = b.perkara_id
 							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
 							WHERE b.perkara_id = perkara.`perkara_id` ) AS identitas_t



				FROM 	perkara

				LEFT JOIN	perkara_penetapan	ON	perkara_penetapan.perkara_id=perkara.perkara_id
				LEFT JOIN	perkara_mediasi	ON	perkara_mediasi.perkara_id=perkara.perkara_id

				LEFT JOIN	perkara_putusan		ON	perkara_putusan.perkara_id=perkara.perkara_id
				LEFT JOIN	perkara_verzet		ON	perkara_verzet.perkara_id=perkara.perkara_id
				LEFT JOIN	perkara_banding		ON	perkara_banding.perkara_id=perkara.perkara_id
				LEFT JOIN	perkara_kasasi		ON	perkara_kasasi.perkara_id=perkara.perkara_id
				LEFT JOIN	perkara_pk			ON	perkara_pk.perkara_id=perkara.perkara_id
				LEFT JOIN	perkara_eksekusi	ON		perkara_eksekusi.perkara_id=perkara.perkara_id
				LEFT JOIN	perkara_ikrar_talak	ON		perkara_ikrar_talak.perkara_id=perkara.perkara_id
				LEFT JOIN	perkara_akta_cerai	ON		perkara_akta_cerai.perkara_id=perkara.perkara_id
				LEFT JOIN	mediator			ON	mediator.id=perkara_mediasi.mediator_id

				WHERE perkara.nomor_perkara='$nomor_perkara'";
		//ECHO $sq
		//echo $sql;exit;
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$this
			->dbsipp
			->query('SET SESSION group_concat_max_len=100000');

		$q = $this
			->dbsipp
			->query($sql);
		return $q->result();
	}
	function register_cetak_3($nomor_perkara)
	{

		$sql = "SELECT
				v_perkara_banding.*
				,CASE WHEN v_perkara_banding.pihak_pembanding=1 OR v_perkara_banding.pihak_pembanding=4
				THEN
					(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
								CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Pembanding ',bulan_romawi(b.urutan) ) SEPARATOR '; \\\\par ' ),
							CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
								CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', sebagai Pembanding;' ))
							AS DATA
							FROM perkara_pihak1 b
							JOIN perkara a ON a.perkara_id = b.perkara_id
 							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
 							WHERE b.perkara_id = v_perkara_banding.`perkara_id` )
				ELSE
					(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
								CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END
							, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Pembanding ',bulan_romawi(b.urutan) ) SEPARATOR '; \\\\par ' ),
							CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',

							CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END


							, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Pembanding;' ))
							AS DATA
							FROM perkara_pihak2 b
							JOIN perkara a ON a.perkara_id = b.perkara_id
 							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
 							WHERE b.perkara_id = v_perkara_banding.`perkara_id` )

				END AS pemohon_banding
				,CASE WHEN v_perkara_banding.pihak_pembanding=1 OR v_perkara_banding.pihak_pembanding=4
				THEN
					(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
								CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END
							, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Terbanding ',bulan_romawi(b.urutan) ) SEPARATOR '; \\\\par ' ),
							CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',

							CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END


							, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Terbanding;' ))
							AS DATA
							FROM perkara_pihak2 b
							JOIN perkara a ON a.perkara_id = b.perkara_id
 							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
 							WHERE b.perkara_id = v_perkara_banding.`perkara_id` )
				ELSE
					(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
								CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Terbanding# ',bulan_romawi(b.urutan) ) SEPARATOR '; \\\\par ' ),
							CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
								CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', sebagai Terbanding;' ))
							AS DATA
							FROM perkara_pihak1 b
							JOIN perkara a ON a.perkara_id = b.perkara_id
 							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
 							WHERE b.perkara_id = v_perkara_banding.`perkara_id` )

				END AS termohon_banding
				,perkara.jenis_perkara_nama
				,perkara_penetapan.panitera_pengganti_text
				,CONCAT(perkara_penetapan.majelis_hakim_nama,'<br>',perkara_penetapan.panitera_pengganti_text) AS majelis_hakim_nama

		FROM v_perkara_banding
		LEFT JOIN perkara ON perkara.perkara_id=v_perkara_banding.perkara_id
		LEFT JOIN perkara_penetapan ON perkara_penetapan.perkara_id=v_perkara_banding.perkara_id
		WHERE nomor_perkara_pn='$nomor_perkara'";
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$this
			->dbsipp
			->query('SET SESSION group_concat_max_len=100000');

		$q = $this
			->dbsipp
			->query($sql);
		return $q->result();
	}
	function register_cetak_4($nomor_perkara)
	{

		$sql = "SELECT
				v_perkara_kasasi.*
				,CASE WHEN v_perkara_kasasi.pihak_pemohon_kasasi=1 OR v_perkara_kasasi.pihak_pemohon_kasasi=4
				THEN
					(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
								CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai #sebutan_pihak1# ',bulan_romawi(b.urutan) ) SEPARATOR '; \\\\par ' ),
							CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
								CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon Kasasi;' ))
							AS DATA
							FROM perkara_pihak1 b
							JOIN perkara a ON a.perkara_id = b.perkara_id
 							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
 							WHERE b.perkara_id = v_perkara_kasasi.`perkara_id` )
				ELSE
					(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
								CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END
							, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Termohon Kasasi ',bulan_romawi(b.urutan) ) SEPARATOR '; \\\\par ' ),
							CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',

							CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END


							, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon Kasasi;' ))
							AS DATA
							FROM perkara_pihak2 b
							JOIN perkara a ON a.perkara_id = b.perkara_id
 							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
 							WHERE b.perkara_id = v_perkara_kasasi.`perkara_id` )

				END AS pemohon_kasasi
				,CASE WHEN v_perkara_kasasi.pihak_pemohon_kasasi=1 OR v_perkara_kasasi.pihak_pemohon_kasasi=4
				THEN
					(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
								CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END
							, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Termohon Kasasi# ',bulan_romawi(b.urutan) ) SEPARATOR '; \\\\par ' ),
							CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',

							CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END


							, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Termohon Kasasi;' ))
							AS DATA
							FROM perkara_pihak2 b
							JOIN perkara a ON a.perkara_id = b.perkara_id
 							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
 							WHERE b.perkara_id = v_perkara_kasasi.`perkara_id` )
				ELSE
					(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
								CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Termohon Kasasi ',bulan_romawi(b.urutan) ) SEPARATOR '; \\\\par ' ),
							CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
								CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', sebagai Termohon Kasasi;' ))
							AS DATA
							FROM perkara_pihak1 b
							JOIN perkara a ON a.perkara_id = b.perkara_id
 							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
 							WHERE b.perkara_id = v_perkara_kasasi.`perkara_id` )

				END AS termohon_kasasi
				,perkara.jenis_perkara_nama
				,perkara_penetapan.panitera_pengganti_text
				,CONCAT(perkara_penetapan.majelis_hakim_nama,'<br>',perkara_penetapan.panitera_pengganti_text) AS majelis_hakim_nama

		FROM v_perkara_kasasi
		LEFT JOIN perkara ON perkara.perkara_id=v_perkara_kasasi.perkara_id
		LEFT JOIN perkara_penetapan ON perkara_penetapan.perkara_id=v_perkara_kasasi.perkara_id
		WHERE nomor_perkara_pn='$nomor_perkara'";
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$this
			->dbsipp
			->query('SET SESSION group_concat_max_len=100000');

		$q = $this
			->dbsipp
			->query($sql);
		return $q->result();
	}

	function register_cetak_5($nomor_perkara)
	{
		$sql = "SELECT
				v_perkara_pk.*
				,CASE WHEN v_perkara_pk.pihak_pemohon_pk=1 OR v_perkara_pk.pihak_pemohon_pk=4
				THEN
					(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
								CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai #sebutan_pihak1# ',bulan_romawi(b.urutan) ) SEPARATOR '; \\\\par ' ),
							CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
								CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon Peninjauan Kembali;' ))
							AS DATA
							FROM perkara_pihak1 b
							JOIN perkara a ON a.perkara_id = b.perkara_id
 							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
 							WHERE b.perkara_id = v_perkara_pk.`perkara_id` )
				ELSE
					(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
								CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END
							, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon Peninjauan Kembali ',bulan_romawi(b.urutan) ) SEPARATOR '; \\\\par ' ),
							CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',

							CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END


							, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon Peninjauan Kembali;' ))
							AS DATA
							FROM perkara_pihak2 b
							JOIN perkara a ON a.perkara_id = b.perkara_id
 							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
 							WHERE b.perkara_id = v_perkara_pk.`perkara_id` )

				END AS pemohon_pk
				,CASE WHEN v_perkara_pk.pihak_pemohon_pk=1 OR v_perkara_pk.pihak_pemohon_pk=4
				THEN
					(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
								CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END
							, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Termohon Peninjauan Kembali ',bulan_romawi(b.urutan) ) SEPARATOR '; \\\\par ' ),
							CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',

							CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END


							, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Termohon Peninjauan Kembali;' ))
							AS DATA
							FROM perkara_pihak2 b
							JOIN perkara a ON a.perkara_id = b.perkara_id
 							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
 							WHERE b.perkara_id = v_perkara_pk.`perkara_id` )
				ELSE
					(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
								CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai #sebutan_pihak1# ',bulan_romawi(b.urutan) ) SEPARATOR '; \\\\par ' ),
							CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
								CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', sebagai Termohon PK;' ))
							AS DATA
							FROM perkara_pihak1 b
							JOIN perkara a ON a.perkara_id = b.perkara_id
 							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
 							WHERE b.perkara_id = v_perkara_pk.`perkara_id` )

				END AS termohon_pk

		FROM v_perkara_pk
		WHERE nomor_perkara_pn='$nomor_perkara'";
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$this
			->dbsipp
			->query('SET SESSION group_concat_max_len=100000');

		$q = $this
			->dbsipp
			->query($sql);
		return $q->result();
	}

	function register_cetak_8($nomor_perkara)
	{
		$sql = "SELECT 
					perkara_pengacara.*
					,pihak.nama as nama_p
					,perkara.nomor_perkara
					,pengacara_id as pengacara
					,convert_tanggal_indonesia(perkara_pengacara.tanggal_kuasa) as tanggal_kuasa 
					,(select pekerjaan from pihak where id=pengacara) as pekerjaan
					,convert_tanggal_indonesia(LEFT(perkara_pengacara.diinput_tanggal,10)) as tgl
					FROM perkara_pengacara
					LEFT JOIN pihak ON pihak.id=perkara_pengacara.pihak_id
					LEFT JOIN perkara ON perkara.perkara_id=perkara_pengacara.perkara_id
					WHERE perkara.nomor_perkara='$nomor_perkara'
					
			";
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);

		$q = $this
			->dbsipp
			->query($sql);
		return $q->result();
	}
	function register_cetak_9($nomor_perkara)
	{
		$sql = "SELECT 
					
					CASE 
						WHEN
							(SELECT pihak_diwakili FROM perkara_eksekusi_detil where perkara_id=perkara_eksekusi.perkara_id AND status_pihak_id=1 AND pihak_diwakili='Y' LIMIT 1)='Y'
						THEN
							CONCAT(
								(
									SELECT 
										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', bertindak untuk dan atas nama ' ) 
									FROM
										perkara_eksekusi_detil b
										JOIN pihak d ON b.pemohon_id = d.id
										JOIN agama e ON d.agama_id = e.id
									WHERE b.perkara_id = perkara_eksekusi.perkara_id AND status_pihak_id=1 LIMIT 1
								)
								,
								(SELECT
									IF(COUNT(b.pihak_id)>1,
										GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat ) SEPARATOR '; <br> ' ),

										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat ))
										AS DATA
									FROM
										perkara_eksekusi_detil b
										JOIN pihak d ON b.pihak_id = d.id
										JOIN agama e ON d.agama_id = e.id
									WHERE b.perkara_id = perkara_eksekusi.perkara_id AND status_pihak_id=1)
									,' sebagai Pemohon Eksekusi'
									)
						ELSE
							(SELECT
								IF(COUNT(b.pihak_id)>1,
									GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pendidikan ',
									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon Eksekusi ' ) SEPARATOR '; <br> ' ),

									CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon Eksekusi;' ))
									AS DATA
								FROM
									perkara_eksekusi_detil b
									JOIN pihak d ON b.pihak_id = d.id
									JOIN agama e ON d.agama_id = e.id
								WHERE b.perkara_id = perkara_eksekusi.perkara_id AND status_pihak_id=1)	
						END 
					 AS identitas_p
			, 
					CASE 
						WHEN
							(SELECT pihak_diwakili FROM perkara_eksekusi_detil where perkara_id=perkara_eksekusi.perkara_id AND status_pihak_id=2 AND pihak_diwakili='Y' LIMIT 1)='Y'
						THEN
							CONCAT(
								(
									SELECT 
										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', bertindak untuk dan atas nama ' ) 
									FROM
										perkara_eksekusi_detil b
										JOIN pihak d ON b.pemohon_id = d.id
										JOIN agama e ON d.agama_id = e.id
									WHERE b.perkara_id = perkara_eksekusi.perkara_id AND status_pihak_id=2 LIMIT 1
								)
								,
								(SELECT
									IF(COUNT(b.pihak_id)>1,
										GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat ) SEPARATOR '; <br> ' ),

										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat ))
										
									FROM
										perkara_eksekusi_detil b
										JOIN pihak d ON b.pihak_id = d.id
										JOIN agama e ON d.agama_id = e.id
									WHERE b.perkara_id = perkara_eksekusi.perkara_id AND status_pihak_id=2)
									,' sebagai Termohon Eksekusi'
									)
						ELSE
							(SELECT
								IF(COUNT(b.pihak_id)>1,
									GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pendidikan ',
									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', Termohon Pemohon Eksekusi ' ) SEPARATOR '; <br> ' ),

									CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', sebagai Termohon Eksekusi;' ))
									AS DATA
								FROM
									perkara_eksekusi_detil b
									JOIN pihak d ON b.pihak_id = d.id
									JOIN agama e ON d.agama_id = e.id
								WHERE b.perkara_id = perkara_eksekusi.perkara_id AND status_pihak_id=2)	
						END 
					 AS identitas_t	
			,permohonan_eksekusi
			,'-' AS jenis_ht_text
			,nomor_perkara_pn
			,putusan_pn
			,nomor_perkara_banding
			,putusan_banding
			,nomor_perkara_kasasi
			,putusan_kasasi
			,nomor_perkara_pk
			,putusan_pk
			,eksekusi_amar_putusan
			,penetapan_teguran_eksekusi
			,pelaksanaan_teguran_eksekusi
			,penetapan_sita_eksekusi
			,pelaksanaan_eksekusi_rill
			,penetapan_sita_eksekusi
			,eksekusi_amar_putusan
			,penetapan_perintah_eksekusi_lelang
			,pelaksanaan_eksekusi_lelang
			,penyerahan_hasil_lelang
			,penetapan_sita_eksekusi
			,pelaksanaan_sita_eksekusi
			,penetapan_perintah_eksekusi_lelang
			,pelaksanaan_eksekusi_lelang
			,penyerahan_hasil_lelang
			,catatan_eksekusi
			,perkara_id as id_eksekusi
			,'perkara_id' as field
			,'perkara_eksekusi_detil' AS tabel
			,jurusita_nama
			,nomor_register_eksekusi
			FROM perkara_eksekusi where nomor_register_eksekusi='$nomor_perkara'
			UNION
			SELECT 
				
			 
					CASE 
						WHEN
							(SELECT pihak_diwakili FROM perkara_eksekusi_detil_ht where ht_id=perkara_eksekusi_ht.ht_id AND status_pihak_id=1 AND pihak_diwakili='Y' LIMIT 1)='Y'
						THEN
							CONCAT(
								(
									SELECT 
										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', bertindak untuk dan atas nama ' ) 
									FROM
										perkara_eksekusi_detil_ht b
										JOIN pihak d ON b.pemohon_id = d.id
										JOIN agama e ON d.agama_id = e.id
									WHERE b.ht_id = perkara_eksekusi_ht.ht_id AND status_pihak_id=1 LIMIT 1
								)
								,
								(SELECT
									IF(COUNT(b.pihak_id)>1,
										GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat ) SEPARATOR '; <br> ' ),

										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat ))
										AS DATA
									FROM
										perkara_eksekusi_detil_ht b
										JOIN pihak d ON b.pihak_id = d.id
										JOIN agama e ON d.agama_id = e.id
									WHERE b.ht_id= perkara_eksekusi_ht.ht_id AND status_pihak_id=1)
									,' sebagai Pemohon Eksekusi'
									)
						ELSE
							(SELECT
								IF(COUNT(b.pihak_id)>1,
									GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pendidikan ',
									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon Eksekusi ' ) SEPARATOR '; <br> ' ),

									CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon Eksekusi;' ))
									AS DATA
								FROM
									perkara_eksekusi_detil_ht b
									JOIN pihak d ON b.pihak_id = d.id
									JOIN agama e ON d.agama_id = e.id
								WHERE b.ht_id = perkara_eksekusi_ht.ht_id AND status_pihak_id=1)	
						END 
					 AS identitas_p
			, 
					CASE 
						WHEN
							(SELECT pihak_diwakili FROM perkara_eksekusi_detil_ht where ht_id=perkara_eksekusi_ht.ht_id AND status_pihak_id=2 AND pihak_diwakili='Y' LIMIT 1)='Y'
						THEN
							CONCAT(
								(
									SELECT 
										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', bertindak untuk dan atas nama ' ) 
									FROM
										perkara_eksekusi_detil_ht b
										JOIN pihak d ON b.pemohon_id = d.id
										JOIN agama e ON d.agama_id = e.id
									WHERE b.ht_id= perkara_eksekusi_ht.ht_id AND status_pihak_id=2 LIMIT 1
								)
								,
								(SELECT
									IF(COUNT(b.pihak_id)>1,
										GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat ) SEPARATOR '; <br> ' ),

										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat ))
										
									FROM
										perkara_eksekusi_detil_ht b
										JOIN pihak d ON b.pihak_id = d.id
										JOIN agama e ON d.agama_id = e.id
									WHERE b.ht_id = perkara_eksekusi_ht.ht_id AND status_pihak_id=2)
									,' sebagai Termohon Eksekusi'
									)
						ELSE
							(SELECT
								IF(COUNT(b.pihak_id)>1,
									GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pendidikan ',
									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', Termohon Eksekusi ' ) SEPARATOR '; <br> ' ),

									CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', sebagai Termohon Eksekusi;' ))
									AS DATA
								FROM
									perkara_eksekusi_detil_ht b
									JOIN pihak d ON b.pihak_id = d.id
									JOIN agama e ON d.agama_id = e.id
								WHERE b.ht_id = perkara_eksekusi_ht.ht_id AND status_pihak_id=2)	
						END 
					 AS identitas_t	
			,permohonan_eksekusi
			,jenis_ht_text
			,nomor_perkara_pn
			,putusan_pn
			,nomor_perkara_banding
			,putusan_banding
			,nomor_perkara_kasasi
			,putusan_kasasi
			,nomor_perkara_pk
			,putusan_pk
			,eksekusi_amar_putusan
			,penetapan_teguran_eksekusi
			,pelaksanaan_teguran_eksekusi
			,penetapan_sita_eksekusi
			,pelaksanaan_eksekusi_rill
			,penetapan_sita_eksekusi
			,eksekusi_amar_putusan
			,penetapan_perintah_eksekusi_lelang
			,pelaksanaan_eksekusi_lelang
			,penyerahan_hasil_lelang
			,penetapan_sita_eksekusi
			,pelaksanaan_sita_eksekusi
			,penetapan_perintah_eksekusi_lelang
			,pelaksanaan_eksekusi_lelang
			,penyerahan_hasil_lelang
			,catatan_eksekusi
			,ht_id as id_eksekusi
			,'ht_id' as field
			,'perkara_eksekusi_detil_ht' AS tabel
			,jurusita_nama
			,eksekusi_nomor_perkara AS nomor_register_eksekusi
			FROM perkara_eksekusi_ht where eksekusi_nomor_perkara='$nomor_perkara'
			";
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$this
			->dbsipp
			->query('SET SESSION group_concat_max_len=100000');

		$q = $this
			->dbsipp
			->query($sql);
		return $q->result();
	}
	function register_cetak_10($nomor_perkara)
	{
		$sql = "SELECT 
					perkara_akta_cerai.nomor_urut_akta_cerai
					,perkara.jenis_perkara_id
					,perkara_akta_cerai.nomor_akta_cerai
					,perkara_akta_cerai.no_seri_akta_cerai
					,perkara_ikrar_talak.tgl_ikrar_talak
					,perkara_akta_cerai.tgl_akta_cerai
					,perkara.nomor_perkara
					,perkara_putusan.tanggal_putusan
					,perkara_banding.nomor_putusan_banding
					,perkara_banding.putusan_banding
					,perkara_kasasi.nomor_putusan_kasasi
					,perkara_kasasi.putusan_kasasi
					,perkara_pk.nomor_putusan_pk
					,perkara_pk.putusan_pk 
					,perkara_akta_cerai.perceraian_ke
					,REPLACE(REPLACE(UPPER(perkara_pihak1.nama),' BINTI ',' binti '),' BIN ',' bin ') AS nama_p
					,REPLACE(REPLACE(UPPER(perkara_pihak2.nama),' BINTI ',' binti '),' BIN ',' bin ') AS nama_t
					,perkara_putusan.tanggal_bht
					,perkara_ikrar_talak.tgl_ikrar_talak 
					,CASE
						WHEN
							perkara.jenis_perkara_id = 346
							THEN
							'raj\'i'
						ELSE
							'cari'
					END AS bain_raji
					,perkara_akta_cerai.tgl_penyerahan_akta_cerai 
					,perkara_akta_cerai.tgl_penyerahan_akta_cerai_pihak2

					,perkara_putusan.amar_putusan
					,perkara_data_pernikahan.tgl_kutipan_akta_nikah
					,perkara_data_pernikahan.no_kutipan_akta_nikah
					,perkara_data_pernikahan.kua_tempat_nikah 
					FROM perkara_akta_cerai

					LEFT JOIN perkara ON perkara.perkara_id=perkara_akta_cerai.perkara_id
					LEFT JOIN perkara_putusan ON perkara_putusan.perkara_id=perkara_akta_cerai.perkara_id
					LEFT JOIN perkara_banding ON perkara_banding.perkara_id=perkara_akta_cerai.perkara_id
					LEFT JOIN perkara_kasasi ON perkara_kasasi.perkara_id=perkara_akta_cerai.perkara_id
					LEFT JOIN perkara_pk ON perkara_pk.perkara_id=perkara_akta_cerai.perkara_id
					LEFT JOIN perkara_pihak1 ON perkara_pihak1.perkara_id=perkara_akta_cerai.perkara_id
					LEFT JOIN perkara_pihak2 ON perkara_pihak2.perkara_id=perkara_akta_cerai.perkara_id
					LEFT JOIN perkara_ikrar_talak ON perkara_ikrar_talak.perkara_id=perkara_akta_cerai.perkara_id
					LEFT JOIN perkara_data_pernikahan ON perkara_data_pernikahan.perkara_id=perkara_akta_cerai.perkara_id
					WHERE		perkara.nomor_perkara='$nomor_perkara' AND nomor_akta_cerai IS NOT NULL 
			";
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$q = $this
			->dbsipp
			->query($sql);
		//echo $sql;
		return $q->result();
	}
	function register_cetak_11($nomor_perkara)
	{

		$sql = "SELECT
					perkara.perkara_id
					,perkara.nomor_urut_register
					,perkara.nomor_perkara
					,perkara.tanggal_pendaftaran

					,perkara.tanggal_surat
					,perkara.dakwaan

					,perkara_penetapan.penetapan_hari_sidang
					,perkara_penetapan.sidang_pertama
					,perkara_penetapan.penetapan_majelis_hakim
					,perkara_penetapan.majelis_hakim_text
					,perkara_penetapan.panitera_pengganti_text


					,perkara_putusan.tanggal_putusan
					,perkara_putusan.pemberitahuan_putusan
					,perkara_putusan.amar_putusan
					,perkara_putusan.tanggal_minutasi
					,perkara_penuntutan.tanggal_penuntutan
					,perkara_penuntutan.isi_penuntutan
					,perkara_putusan_terdakwa.tanggal_putusan

				
					,perkara.jenis_perkara_nama
					,(SELECT tanggal_kirim_salinan_putusan FROM perkara_putusan_pemberitahuan_putusan where perkara_id=perkara.perkara_id AND pihak=2 LIMIT 1) as tanggal_kirim_salinan_putusan
					,(SELECT tanggal_menerima_putusan FROM perkara_putusan_pemberitahuan_putusan where perkara_id=perkara.perkara_id AND pihak=2 LIMIT 1) as tanggal_menerima_putusan
					,(SELECT tanggal_kirim_salinan_putusan FROM perkara_putusan_pemberitahuan_putusan where perkara_id=perkara.perkara_id AND pihak=1 LIMIT 1) as tanggal_kirim_ke_jaksa
					,(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(
								d.nama
								,', umur '
								,get_umur(d.tanggal_lahir,a.tanggal_pendaftaran)
								,' tahun, Tanggal Lahir ' 
								,convert_tanggal_indonesia(d.tanggal_lahir) 
								,', Jenis Kelamin '
								,CASE WHEN d.jenis_kelamin='P' THEN 'Perempuan' ELSE 'Laki-laki' END
								,', Kebangsaan '
								,CASE WHEN d.warga_negara_id>1 THEN (SELECT nama from negara WHERE id=d.warga_negara_id) ELSE '' END
								,', Tempat Tinggal '
								, d.alamat,', Agama '
								,e.nama 
								,', pekerjaan '
								,d.pekerjaan 
								,', sebagai Terdakwa '
								,bulan_romawi(b.urutan) ) SEPARATOR '; \\\\par ' ),
							CONCAT(
								d.nama
								,', umur '
								,get_umur(d.tanggal_lahir,a.tanggal_pendaftaran)
								,' tahun, Tanggal Lahir ' 
								,convert_tanggal_indonesia(d.tanggal_lahir) 
								,', Jenis Kelamin '
								,CASE WHEN d.jenis_kelamin='P' THEN 'Perempuan' ELSE 'Laki-laki' END
								,', Kebangsaan '
								,CASE WHEN d.warga_negara_id>1 THEN (SELECT nama from negara WHERE id=d.warga_negara_id) ELSE '' END
								,', Tempat Tinggal '
								, d.alamat,', Agama '
								,e.nama 
								,', pekerjaan '
								,d.pekerjaan 
								,', sebagai Terdakwa;' ))
							AS DATA
							FROM perkara_pihak2 b
							JOIN perkara a ON a.perkara_id = b.perkara_id
 							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
 							WHERE b.perkara_id = perkara.`perkara_id` ) AS identitas_terdakwa

					,(SELECT convert_tanggal_indonesia(tanggal_surat) FROM penahanan_terdakwa WHERE perkara_id=perkara.perkara_id AND jenis_penahanan_id=35 LIMIT 1) AS penahanan_penyidik
					,(SELECT convert_tanggal_indonesia(tanggal_surat) FROM penahanan_terdakwa WHERE perkara_id=perkara.perkara_id AND jenis_penahanan_id=38 LIMIT 1) AS penahanan_pu
					,(SELECT convert_tanggal_indonesia(tanggal_surat) FROM penahanan_terdakwa WHERE perkara_id=perkara.perkara_id AND jenis_penahanan_id=41 LIMIT 1) AS penahanan_ms
					,(SELECT convert_tanggal_indonesia(tanggal_surat) FROM penahanan_terdakwa WHERE perkara_id=perkara.perkara_id AND jenis_penahanan_id=44 LIMIT 1) AS penahanan_msa
					,(SELECT convert_tanggal_indonesia(tanggal_surat) FROM penahanan_terdakwa WHERE perkara_id=perkara.perkara_id AND jenis_penahanan_id=47 LIMIT 1) AS penahanan_ma
					,(SELECT GROUP_CONCAT(CONCAT(convert_tanggal_indonesia(permohonan_banding),' \\\\tab ', pemohon_nama)SEPARATOR ' \\\\par ') from perkara_banding_detil where perkara_id=perkara.perkara_id AND permohonan_banding IS NOT NULL) AS permohonan_banding
					,(SELECT GROUP_CONCAT(CONCAT(convert_tanggal_indonesia(pemberitahuan_permohonan_banding),' \\\\tab ', pemohon_nama)SEPARATOR ' \\\\par ') from perkara_banding_detil where perkara_id=perkara.perkara_id AND permohonan_banding IS NOT NULL AND pemberitahuan_permohonan_banding IS NOT NULL) AS pemberitahuan_permohonan_banding
					,(SELECT GROUP_CONCAT(CONCAT(convert_tanggal_indonesia(penerimaan_memori_banding),' \\\\tab ', pemohon_nama)SEPARATOR ' \\\\par ') from perkara_banding_detil where perkara_id=perkara.perkara_id AND permohonan_banding IS NOT NULL AND penerimaan_memori_banding IS NOT NULL) AS penerimaan_memori_banding
					,(SELECT GROUP_CONCAT(CONCAT(convert_tanggal_indonesia(penyerahan_memori_banding),' \\\\tab ', pemohon_nama)SEPARATOR ' \\\\par ') from perkara_banding_detil where perkara_id=perkara.perkara_id AND permohonan_banding IS NOT NULL AND penyerahan_memori_banding IS NOT NULL) AS penyerahan_memori_banding
					,(SELECT GROUP_CONCAT(CONCAT(convert_tanggal_indonesia(penerimaan_kontra_banding),' \\\\tab ', pemohon_nama)SEPARATOR ' \\\\par ') from perkara_banding_detil where perkara_id=perkara.perkara_id AND permohonan_banding IS NOT NULL AND penerimaan_kontra_banding IS NOT NULL) AS penerimaan_kontra_banding
					,(SELECT GROUP_CONCAT(CONCAT(convert_tanggal_indonesia(penyerahan_kontra_banding),' \\\\tab ', pemohon_nama)SEPARATOR ' \\\\par ') from perkara_banding_detil where perkara_id=perkara.perkara_id AND permohonan_banding IS NOT NULL AND penyerahan_kontra_banding IS NOT NULL) AS penyerahan_kontra_banding
					,(SELECT GROUP_CONCAT(CONCAT(convert_tanggal_indonesia(pelaksanaan_inzage),' \\\\tab ', pemohon_nama)SEPARATOR ' \\\\par ') from perkara_banding_detil where perkara_id=perkara.perkara_id AND permohonan_banding IS NOT NULL AND pelaksanaan_inzage IS NOT NULL) AS pelaksanaan_inzage
					,(SELECT CONCAT(convert_tanggal_indonesia(pengiriman_berkas_banding),' \\\\par ', nomor_surat_pengiriman_berkas_banding) from perkara_banding where perkara_id=perkara.perkara_id ) AS tanggal_nomor_kirim
					,(SELECT penerimaan_kembali_berkas_banding from perkara_banding where perkara_id=perkara.perkara_id ) AS penerimaan_kembali_berkas_banding
				FROM 	perkara

				LEFT JOIN	perkara_penetapan	ON	perkara_penetapan.perkara_id=perkara.perkara_id

				LEFT JOIN	perkara_putusan		ON	perkara_putusan.perkara_id=perkara.perkara_id
				LEFT JOIN	perkara_penuntutan		ON	perkara_penuntutan.perkara_id=perkara.perkara_id
				LEFT JOIN	perkara_putusan_terdakwa		ON	perkara_putusan_terdakwa.perkara_id=perkara.perkara_id
				
				WHERE perkara.nomor_perkara='$nomor_perkara'";
		//ECHO $sq
		//echo $sql;exit;
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$this
			->dbsipp
			->query('SET SESSION group_concat_max_len=100000');

		$q = $this
			->dbsipp
			->query($sql);
		return $q->result();
	}
	function register_cetak_16($nomor_perkara)
	{
		$sql = "SELECT
					perkara.perkara_id
					,perkara.nomor_urut_register
					,perkara.nomor_perkara
					,perkara.tanggal_pendaftaran

					,perkara.petitum

					,perkara_penetapan.penetapan_hari_sidang
					,perkara_penetapan.sidang_pertama


					,perkara_mediasi.penetapan_penunjukan_mediator
					,perkara_mediasi.mediator_text
					,mediator.tgl_sertifikasi
					,mediator.no_sertifikasi

					,perkara_mediasi.tgl_laporan_mediator
					,perkara_mediasi.hasil_mediasi
					,perkara_putusan.tanggal_putusan
					,perkara_putusan.pemberitahuan_putusan
					,perkara_putusan.amar_putusan
					,perkara_putusan.tanggal_minutasi

					,perkara_verzet.tanggal_pendaftaran_verzet
					,perkara_verzet.tanggal_penetapan_sidang_verzet
					,perkara_verzet.tanggal_sidang_pertama_verzet

					,perkara_verzet.putusan_verzet
					,perkara_verzet.amar_putusan_verzet

					,perkara_banding.permohonan_banding


					,perkara_banding.pemberitahuan_permohonan_banding
					,perkara_banding.penerimaan_memori_banding
					,perkara_banding.penyerahan_memori_banding
					,perkara_banding.penerimaan_kontra_banding
					,perkara_banding.penyerahan_kontra_banding
					,perkara_banding.pemberitahuan_inzage_pembanding
					,perkara_banding.pemberitahuan_inzage_terbanding
					,perkara_banding.pengiriman_berkas_banding
					,perkara_banding.penerimaan_kembali_berkas_banding
					,perkara_banding.pemberitahuan_putusan_banding_pembanding
					,perkara_banding.pemberitahuan_putusan_banding_terbanding
					,perkara_banding.nomor_perkara_banding
					,perkara_banding.putusan_banding
					,perkara_banding.amar_putusan_banding

					,perkara_kasasi.permohonan_kasasi


					,perkara_kasasi.pemberitahuan_kasasi
					,perkara_kasasi.penerimaan_memori_kasasi
					,perkara_kasasi.penyerahan_memori_kasasi
					,perkara_kasasi.penerimaan_kontra_kasasi
					,perkara_kasasi.pengiriman_berkas_kasasi
					,perkara_kasasi.penerimaan_berkas_kasasi
					,perkara_kasasi.pemberitahuan_putusan_kasasi_pihak1
					,perkara_kasasi.pemberitahuan_putusan_kasasi_pihak2
					,perkara_kasasi.nomor_perkara_kasasi
					,perkara_kasasi.putusan_kasasi
					,perkara_kasasi.amar_putusan_kasasi
					,perkara_putusan.tanggal_bht

					,perkara_pk.permohonan_pk


					,perkara_pk.pemberitahuan_pk
					,perkara_pk.penerimaan_memori_pk
					,perkara_pk.penyerahan_memori_pk
					,perkara_pk.penerimaan_kontra_pk
					,perkara_pk.tanggal_penyumpahan
					,perkara_pk.pengiriman_berkas_pk
					,perkara_pk.penerimaan_berkas_pk
					,perkara_pk.pemberitahuan_putusan_pk_pihak1
					,perkara_pk.pemberitahuan_putusan_pk_pihak2
					,perkara_pk.nomor_putusan_pk
					,perkara_pk.putusan_pk
					,perkara_pk.amar_putusan_pk

					,perkara_eksekusi.permohonan_eksekusi
					,perkara_eksekusi.penetapan_teguran_eksekusi
					,perkara_eksekusi.pelaksanaan_teguran_eksekusi
					,perkara_eksekusi.pelaksanaan_sita_eksekusi

					,perkara_ikrar_talak.penetapan_majelis_hakim	 as penetapan_majelis_hakim_ikrar
					,perkara_ikrar_talak.tanggal_penetapan_sidang_ikrar
					,perkara_ikrar_talak.tanggal_sidang_pertama AS tanggal_sidang_pertama_ikrar
					,perkara_ikrar_talak.tgl_ikrar_talak
					,perkara_ikrar_talak.amar_ikrar_talak
					,perkara_ikrar_talak.tgl_ikrar_talak

					,perkara_akta_cerai.tgl_akta_cerai
					,perkara_akta_cerai.nomor_akta_cerai
					,perkara_akta_cerai.no_seri_akta_cerai
					,perkara.jenis_perkara_nama
					,(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
								CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai #sebutan_pihak1# ',bulan_romawi(b.urutan) ) SEPARATOR '; \\\\par ' ),
							CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
								CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', sebagai #sebutan_pihak1#;' ))
							AS DATA
							FROM perkara_pihak1 b
							JOIN perkara a ON a.perkara_id = b.perkara_id
 							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
 							WHERE b.perkara_id = perkara.`perkara_id` ) AS identitas_p
					,(SELECT
							IF(COUNT(b.pihak_id)>1,
							GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',
								CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END
							, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai #sebutan_pihak2# ',bulan_romawi(b.urutan) ) SEPARATOR '; \\\\par ' ),
							CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,a.tanggal_pendaftaran),' tahun, agama ', e.nama, ', pendidikan ',

							CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END


							, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai #sebutan_pihak2#;' ))
							AS DATA
							FROM perkara_pihak2 b
							JOIN perkara a ON a.perkara_id = b.perkara_id
 							JOIN pihak d ON b.pihak_id = d.id
							JOIN agama e ON d.agama_id = e.id
 							WHERE b.perkara_id = perkara.`perkara_id` ) AS identitas_t



				FROM 	perkara

				LEFT JOIN	perkara_penetapan	ON	perkara_penetapan.perkara_id=perkara.perkara_id
				LEFT JOIN	perkara_mediasi	ON	perkara_mediasi.perkara_id=perkara.perkara_id

				LEFT JOIN	perkara_putusan		ON	perkara_putusan.perkara_id=perkara.perkara_id
				LEFT JOIN	perkara_verzet		ON	perkara_verzet.perkara_id=perkara.perkara_id
				LEFT JOIN	perkara_banding		ON	perkara_banding.perkara_id=perkara.perkara_id
				LEFT JOIN	perkara_kasasi		ON	perkara_kasasi.perkara_id=perkara.perkara_id
				LEFT JOIN	perkara_pk			ON	perkara_pk.perkara_id=perkara.perkara_id
				LEFT JOIN	perkara_eksekusi	ON		perkara_eksekusi.perkara_id=perkara.perkara_id
				LEFT JOIN	perkara_ikrar_talak	ON		perkara_ikrar_talak.perkara_id=perkara.perkara_id
				LEFT JOIN	perkara_akta_cerai	ON		perkara_akta_cerai.perkara_id=perkara.perkara_id
				LEFT JOIN	mediator			ON	mediator.id=perkara_mediasi.mediator_id

				WHERE perkara.nomor_perkara='$nomor_perkara'";
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$q = $this
			->dbsipp
			->query($sql);
		//echo $sql;
		return $q->result();
	}
	///////============REGISTER CETAK======================/////
	function tanggal_surat_kuasa($nomor_perkara, $pihak)
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$sql = "select
				(select group_concat(convert_tanggal_indonesia(tanggal_kuasa) SEPARATOR ' \\\\par ') from perkara_pengacara where perkara_id=perkara.perkara_id AND pihak_ke=$pihak) AS tanggal_kuasa
					from perkara where nomor_perkara='$nomor_perkara'

					";
		$q = $this
			->dbsipp
			->query($sql);
		//echo $sql;exit;
		return $q->result();
	}
	function tanggal_surat_kuasa_upaya_hukum($perkara_id, $tabel)
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$sql = "select GROUP_CONCAT(CONCAT(status_pihak_text, ': \\\\tab ', convert_tanggal_indonesia(pemohon_tanggal_surat)) SEPARATOR ' \\\\par ') as tanggal_surat_kuasa_upaya_hukum from $tabel
			where pihak_diwakili='Y' AND perkara_id=$perkara_id
					";
		$q = $this
			->dbsipp
			->query($sql);
		//echo $sql;exit;
		return $q->result();
	}
	function nama_kuasa_hukum($nomor_perkara, $pihak)
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$sql = "select
				(select group_concat(nama SEPARATOR ' \\\\par ') from perkara_pengacara where perkara_id=perkara.perkara_id AND pihak_ke=$pihak) AS nama_kuasa_hukum
					from perkara where nomor_perkara='$nomor_perkara'

					";
		$q = $this
			->dbsipp
			->query($sql);
		//echo $sql;exit;
		return $q->result();
	}

	function nama_kuasa_upaya_hukum($perkara_id, $tabel)
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$sql = "select GROUP_CONCAT(CONCAT(status_pihak_text, ': \\\\tab ', pemohon_nama) SEPARATOR ' \\\\par ') AS nama_kuasa_hukum_upaya_hukum from $tabel
			where pihak_diwakili='Y' AND perkara_id=$perkara_id
					";
		$q = $this
			->dbsipp
			->query($sql);
		//echo $sql;exit;
		return $q->result();
	}

	function tanggal_surat_kuasa_upaya_hukum_pk($perkara_id, $p)
	{
		$p1 = $p + 1;
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$sql = "select GROUP_CONCAT(CONCAT(convert_tanggal_indonesia(pemohon_tanggal_surat)) SEPARATOR ' \\\\par ') as tanggal_surat_kuasa_upaya_hukum from perkara_pk_detil
			where pihak_diwakili='Y' AND perkara_id=$perkara_id AND (status_pihak_id=$p or status_pihak_id=$p1)
					";
		$q = $this
			->dbsipp
			->query($sql);
		//echo $sql;exit;
		return $q->result();
	}

	function nama_kuasa_upaya_hukum_pk($perkara_id, $p)
	{
		$p1 = $p + 1;
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$sql = "select GROUP_CONCAT(CONCAT(pemohon_nama) SEPARATOR ' \\\\par ') AS nama_kuasa_hukum_upaya_hukum from perkara_pk_detil
			where pihak_diwakili='Y' AND perkara_id=$perkara_id AND (status_pihak_id=$p or status_pihak_id=$p1)
					";
		$q = $this
			->dbsipp
			->query($sql);
		//echo $sql;exit;
		return $q->result();
	}
	function no_urut_upaya_banding($nomor_perkara)
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$sql = "select (select count(xx.perkara_id) as urut from perkara_banding as xx
			where xx.permohonan_banding<=perkara_banding.permohonan_banding
			AND year(xx.permohonan_banding)=year(perkara_banding.permohonan_banding)
			AND xx.diinput_tanggal<=perkara_banding.diinput_tanggal

		)as urut
		from perkara_banding where nomor_perkara_pn='$nomor_perkara'
					";
		$q = $this
			->dbsipp
			->query($sql);
		//echo $sql;exit;
		return $q->result();
	}
	function no_urut_upaya_hukum($perkara_id, $upaya)
	{
		$this->dbsipp = $this->load->database("dbsipp", true);
		$sql = "select (select count(xx.perkara_id) as urut from perkara_".$upaya." as xx
			where xx.permohonan_".$upaya."<=perkara_".$upaya.".permohonan_".$upaya."
			AND year(xx.permohonan_".$upaya.")=year(perkara_".$upaya.".permohonan_".$upaya.")
			AND xx.diinput_tanggal<=perkara_".$upaya.".diinput_tanggal
		)as urut
		from perkara_".$upaya." where perkara_id='$perkara_id'	";
		$q = $this->dbsipp->query($sql);
		//echo $sql;exit;
		return $q->result();
	}

	function validasi_harian($tanggal)
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$sql = "SELECT 
				proses_id, proses_nama, count(perkara_id) as jumlah
				,CASE WHEN proses_id=10 
							THEN 'Panjar Biaya Perkara'
					WHEN proses_id=210 
							THEN 'Meterai' 
					WHEN proses_id=300 
							THEN 'Panjar Biaya Perkara Banding' 
					WHEN proses_id=410 
							THEN 'Panjar Biaya Perkara Kasasi' 
					WHEN proses_id=510 
							THEN 'Panjar Biaya Perkara PK' 
					WHEN proses_id=600 
							THEN 'Panjar Biaya Perkara Eksekusi' 
					ELSE ''
				END AS pembanding

				,CASE WHEN proses_id=10 
							THEN (select count(perkara_id) from perkara_biaya where tanggal_transaksi='$tanggal' AND tahapan_id=10 AND jenis_biaya_id=1)
					WHEN proses_id=210 
							THEN (select count(perkara_id) from perkara_biaya where tanggal_transaksi='$tanggal' AND tahapan_id=10 AND jenis_biaya_id=152)
					WHEN proses_id=300 
							THEN (select count(perkara_id) from perkara_biaya where tanggal_transaksi='$tanggal' AND tahapan_id=30 AND jenis_biaya_id=2)
					WHEN proses_id=410 
							THEN (select count(perkara_id) from perkara_biaya where tanggal_transaksi='$tanggal' AND tahapan_id=40 AND jenis_biaya_id=4)
					WHEN proses_id=510 
							THEN (select count(perkara_id) from perkara_biaya where tanggal_transaksi='$tanggal' AND tahapan_id=50 AND jenis_biaya_id=6)
							WHEN proses_id=600 
							THEN (select count(perkara_id) from perkara_biaya where tanggal_transaksi='$tanggal' AND tahapan_id=50 AND jenis_biaya_id=223)
					ELSE ''
				END AS jumlah_pembanding
				from perkara_proses where tanggal='$tanggal' 
				group by proses_id
				";
		$q = $this
			->dbsipp
			->query($sql);
		//echo $sql;exit;
		return $q->result();
	}
	function validasi_harian_1($tanggal)
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$sql = "select 
				1 AS no
				,'Pendaftaran Perkara' as proses_nama
				,count(perkara_id) as jumlah 
				, 'Panjar Biaya Perkara' as pembanding
				, (select count(perkara_id) from perkara_biaya where tanggal_transaksi='$tanggal' AND tahapan_id=10 AND jenis_biaya_id=1) as jumlah_pembanding
				from perkara
				where tanggal_pendaftaran='$tanggal'
				UNION 
				select 
				2 AS no
				,'Persidangan' as proses_nama
				,count(perkara_id) as jumlah 
				, 'Proses Jadwal Sidang' as pembanding
				, SUM(IF(sampai_jam IS NULL,0,1)) as jumlah_pembanding
				from perkara_jadwal_sidang
				where tanggal_sidang='$tanggal' 
				UNION 
				select 
				3 AS no
				,'Jadwal Mediasi' as proses_nama
				,count(id) as jumlah 
				, 'Proses Jadwal Mediasi' as pembanding
				, SUM(IF(sampai_jam IS NULL,0,1)) as jumlah_pembanding
				from perkara_jadwal_mediasi
				where tanggal_mediasi='$tanggal'
				UNION 
				select 
				4 AS no
				,'Keputusan Mediasi' as proses_nama
				,count(perkara_id) as jumlah 
				, '' as pembanding
				, '' as jumlah_pembanding
				from perkara_mediasi
				where keputusan_mediasi='$tanggal'
				UNION 
				select 
				5 AS no
				,'Putusan' as proses_nama
				,count(perkara_id) as jumlah 
				, 'Meterai' as pembanding
				, (select count(perkara_id) from perkara_biaya where tanggal_transaksi='$tanggal' AND tahapan_id=10 AND jenis_biaya_id=152) as jumlah_pembanding
				from perkara_putusan
				where tanggal_putusan='$tanggal'
				UNION 
				select 
				6 AS no
				,'Minutasi' as proses_nama
				,count(perkara_id) as jumlah 
				, '' as pembanding
				, '' as jumlah_pembanding
				from perkara_putusan
				where tanggal_minutasi='$tanggal'
				UNION 
				select 
				7 AS no
				,'Penetapan Ikrar Talak' as proses_nama
				,count(perkara_id) as jumlah 
				, '' as pembanding
				, '' as jumlah_pembanding
				from perkara_ikrar_talak
				where tgl_ikrar_talak='$tanggal'
				UNION 
				select 
				8 AS no
				,'Penerbitan Akta Cerai' as proses_nama
				,count(perkara_id) as jumlah 
				, '' as pembanding
				, '' as jumlah_pembanding
				from perkara_akta_cerai
				where tgl_akta_cerai='$tanggal'
				";
		$q = $this
			->dbsipp
			->query($sql);
		//echo $sql;exit;
		return $q->result();
	}

	function nama_pihak_eksekusi($id_eksekusi, $tabel, $field, $pihak)
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$sql = "	SELECT
					$field
					,group_concat((SELECT 
								GROUP_CONCAT(
										CONCAT(
												d.nama
												, ', umur '
												,case when a.permohonan_eksekusi IS NOT NULL 
													THEN get_umur(d.tanggal_lahir,a.permohonan_eksekusi)
													ELSE get_umur(d.tanggal_lahir,NOW())
												END
												,' tahun, agama '
												, e.nama
												, ', pendidikan '
												, CASE WHEN d.pendidikan_id>1 
													THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) 
													ELSE '' 
													END
												, ', pekerjaan '
												,d.pekerjaan
												, ', tempat kediaman di '
												, d.alamat
												, ', sebagai #sebagai_pihak" . $pihak . "# Eksekusi '
												) 
											SEPARATOR '; \\\\par ' 
												) 
								
								FROM pihak d
								JOIN $tabel a ON a.pihak_id = d.id 
								JOIN agama e ON d.agama_id = e.id
								WHERE d.id = " . $tabel . ".pihak_id )) as pihak
				FROM $tabel
				WHERE $field=$id_eksekusi AND status_pihak_id=$pihak
					";
		$q = $this
			->dbsipp
			->query($sql);

		return $q->result();
	}
	function nama_pihak_eksekusi_bc($id_eksekusi, $tabel, $field, $pihak)
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$sql = "	SELECT
					$field
					,(SELECT 
								GROUP_CONCAT(
										CONCAT(
												d.nama
												, ', umur '
												,get_umur(d.tanggal_lahir,a.permohonan_eksekusi)
												,' tahun, agama '
												, e.nama
												, ', pendidikan '
												, CASE WHEN d.pendidikan_id>1 
													THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) 
													ELSE '' 
													END
												, ', pekerjaan '
												,d.pekerjaan
												, ', tempat kediaman di '
												, d.alamat
												, ', sebagai #sebagai_pihak" . $pihak . "# Eksekusi '
												) 
											SEPARATOR '; \\\\par ' 
												) 
								
								FROM pihak d
								JOIN $tabel a ON a.pihak_id = d.id 
								JOIN agama e ON d.agama_id = e.id
								WHERE d.id = " . $tabel . ".pihak_id ) as pihak
				FROM $tabel
				WHERE $field=$id_eksekusi AND status_pihak_id=$pihak
					";
		$q = $this
			->dbsipp
			->query($sql);
		echo $sql . '============';
		return $q->result();
	}

	////////////json
	function make_query($table, $select_column, $order_column)
	{
		$this
			->db
			->select($select_column);
		$this
			->db
			->from($table);
		if (isset($_POST["search"]["value"]))
		{
			$this
				->db
				->like("tanggal", $_POST["search"]["value"]);
			$this
				->db
				->or_like("validator_nama", $_POST["search"]["value"]);
		}
		if (isset($_POST["order"]))
		{
			$this
				->db
				->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else
		{
			$this
				->db
				->order_by('tanggal', 'DESC');
		}
	}
	function make_query_irh($table, $select_column, $order_column)
	{
		$this
			->db
			->select($select_column);
		$this
			->db
			->from($table);
		if (isset($_POST["search"]["value"]))
		{
			$this
				->db
				->like("nomor_permohonan", $_POST["search"]["value"]);
			$this
				->db
				->or_like("tanggal_pendaftaran", $_POST["search"]["value"]);
		}
		if (isset($_POST["order"]))
		{
			$this
				->db
				->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else
		{
			$this
				->db
				->order_by('tanggal_pendaftaran', 'DESC');
			$this
				->db
				->order_by('id', 'DESC');
		}
	}
	function make_datatables($table, $select_column, $order_column)
	{
		$this->make_query($table, $select_column, $order_column);
		if (isset($_POST["length"]))
		{
			$this
				->db
				->limit($_POST['length'], $_POST['start']);
		}
		$query = $this
			->db
			->get();
		return $query->result();
	}
	function make_datatables_irh($table, $select_column, $order_column)
	{
		$this->make_query_irh($table, $select_column, $order_column);
		if (isset($_POST["length"]))
		{
			$this
				->db
				->limit($_POST['length'], $_POST['start']);
		}
		$query = $this
			->db
			->get();
		return $query->result();
	}
	function get_filtered_data($table, $select_column, $order_column)
	{
		$this->make_query($table, $select_column, $order_column);
		$query = $this
			->db
			->get();
		return $query->num_rows();
	}
	function get_filtered_data_irh($table, $select_column, $order_column)
	{
		$this->make_query_irh($table, $select_column, $order_column);
		$query = $this
			->db
			->get();
		return $query->num_rows();
	}
	function get_all_data($table)
	{
		$this
			->db
			->select("*");
		$this
			->db
			->from($table);
		return $this
			->db
			->count_all_results();
	}
	function get_all_data_where($table, $whereconditon)
	{
		$this
			->db
			->select("*");
		$this
			->db
			->from($table);
		$this
			->db
			->where($whereconditon);
		return $this
			->db
			->count_all_results();
	}
	function get_all_data_where_sipp($table, $whereconditon)
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$this
			->dbsipp
			->select("*");
		$this
			->dbsipp
			->from($table);
		$this
			->dbsipp
			->where($whereconditon);
		return $this
			->dbsipp
			->count_all_results();
	}
	////////////json
	///rahman
	//dari SIPP
	function get_data_indikator($bulanini, $bulandepan)
	{
		$jenis_pengadilan = 4;
		$sql = "SELECT 
				a.id,
				a.nama,
				(if (a.id<>118,
						(SELECT 
						COUNT(p.perkara_id) 
						FROM
						perkara AS p 
						LEFT OUTER JOIN perkara_putusan AS putus 
					ON p.perkara_id = putus.perkara_id 
						WHERE p.alur_perkara_id = a.id 
						AND LEFT(p.tanggal_pendaftaran, 7) < '" . $bulanini . "' 
						AND (
					putus.tanggal_putusan IS NULL 
					OR LEFT(putus.tanggal_putusan, 7) >= '" . $bulanini . "'
						) 
						AND '" . $bulanini . "' <= CONCAT(YEAR(CURRENT_DATE),'-',RIGHT(CONCAT('0',CAST(MONTH(CURRENT_DATE) AS CHAR(2))),2)
						)),(SELECT 
							COUNT(p.perkara_id)
							FROM
							perkara AS p 
							LEFT JOIN perkara_putusan AS putus 
						ON p.perkara_id = putus.perkara_id 
							WHERE p.alur_perkara_id = a.id 
							AND LEFT(p.tanggal_pendaftaran, 7) < '" . $bulanini . "' 
							AND (putus.tanggal_putusan IS NULL 
						OR LEFT(putus.tanggal_putusan, 7) >= '" . $bulanini . "')
							AND p.perkara_id NOT IN (SELECT diversi.perkara_id FROM perkara_diversi AS diversi WHERE diversi.hasil_diversi = 1 
							AND (diversi.tgl_penetapan_kesepakatan_diversi <> '0000-00-00' 
						OR LEFT(diversi.tgl_penetapan_kesepakatan_diversi,7) >= '" . $bulandepan . "'
							)))
						)) 
				AS belum_putus,
				(SELECT 
				COUNT(p.perkara_id) 
				FROM
				perkara AS p 
				WHERE p.alur_perkara_id = a.id 
				AND LEFT(p.tanggal_pendaftaran, 7) = '" . $bulanini . "') AS masuk,
				(IF(a.id <> 118, (SELECT 
				COUNT(p.perkara_id) 
				FROM
				perkara AS p 
				LEFT OUTER JOIN perkara_putusan AS putus 
						ON p.perkara_id = putus.perkara_id 
				WHERE p.alur_perkara_id = a.id 
				AND LEFT(p.tanggal_pendaftaran, 7) <= '" . $bulanini . "'
				AND LEFT(putus.tanggal_putusan, 7) = '" . $bulanini . "'), 
				IF((SELECT 
				COUNT(p.perkara_id) 
				FROM
				perkara AS p 
				LEFT OUTER JOIN perkara_putusan AS putus 
						ON p.perkara_id = putus.perkara_id 
				WHERE p.alur_perkara_id = a.id 
				AND LEFT(p.tanggal_pendaftaran, 7) <= '" . $bulanini . "'
				AND LEFT(putus.tanggal_putusan, 7) = '" . $bulanini . "')=0,
				(SELECT 
				COUNT(p.perkara_id)+(SELECT 
					COUNT(p.perkara_id) 
					FROM
					perkara AS p 
					LEFT OUTER JOIN perkara_putusan AS putus 
							ON p.perkara_id = putus.perkara_id 
					WHERE p.alur_perkara_id = a.id 
					AND LEFT(p.tanggal_pendaftaran, 7) <= '" . $bulanini . "'
					AND LEFT(putus.tanggal_putusan, 7) = '" . $bulanini . "') 
				FROM
				perkara AS p 
				LEFT OUTER JOIN perkara_diversi AS putus 
						ON p.perkara_id = putus.perkara_id 
				WHERE p.alur_perkara_id = a.id 
				AND LEFT(p.tanggal_pendaftaran, 7) <= '" . $bulanini . "'
				AND LEFT(putus.tgl_penetapan_kesepakatan_diversi, 7) = '" . $bulanini . "'
				AND putus.hasil_diversi=1 AND tgl_minutasi IS NOT NULL AND dibuka_kembali=0), 
				(SELECT 
				COUNT(p.perkara_id) 
				FROM
				perkara AS p 
				LEFT OUTER JOIN perkara_putusan AS putus 
						ON p.perkara_id = putus.perkara_id 
				WHERE p.alur_perkara_id = a.id 
				AND LEFT(p.tanggal_pendaftaran, 7) <= '" . $bulanini . "'
				AND LEFT(putus.tanggal_putusan, 7) = '" . $bulanini . "'))			
				)) AS putus,
				(IF (a.id<>118,
						(SELECT 
						COUNT(p.perkara_id) 
						FROM
						perkara AS p 
						LEFT OUTER JOIN perkara_putusan AS putus 
					ON p.perkara_id = putus.perkara_id 
						WHERE p.alur_perkara_id = a.id 
						AND LEFT(p.tanggal_pendaftaran, 7) < '" . $bulandepan . "'
						AND (putus.tanggal_putusan IS NULL 
					OR LEFT(putus.tanggal_putusan, 7) >= '" . $bulandepan . "')
						),(SELECT 
							COUNT(p.perkara_id)
							FROM
							perkara AS p 
							LEFT JOIN perkara_putusan AS putus 
						ON p.perkara_id = putus.perkara_id 
							WHERE p.alur_perkara_id = a.id 
							AND LEFT(p.tanggal_pendaftaran, 7) < '" . $bulandepan . "' 
							AND (putus.tanggal_putusan IS NULL 
						OR LEFT(putus.tanggal_putusan, 7) >= '" . $bulandepan . "')
							AND p.perkara_id NOT IN (SELECT diversi.perkara_id FROM perkara_diversi AS diversi WHERE diversi.hasil_diversi = 1 
							AND tgl_minutasi IS NOT NULL AND dibuka_kembali=0
							AND (diversi.tgl_penetapan_kesepakatan_diversi <> '0000-00-00' 
						OR LEFT(diversi.tgl_penetapan_kesepakatan_diversi,7) >= '" . $bulandepan . "'
							)))))
				AS sisa,
				(SELECT 
				COUNT(*) 
				FROM
				perkara_banding 
				WHERE alur_perkara_id = a.id 
				AND LEFT(permohonan_banding, 7) = '" . $bulanini . "') AS banding,
				(SELECT 
				COUNT(*) 
				FROM
				perkara_kasasi 
				WHERE alur_perkara_id = a.id 
				AND LEFT(permohonan_kasasi, 7) = '" . $bulanini . "' 
				AND '" . $bulanini . "' <= '" . $bulanini . "' ) AS kasasi,
				(SELECT 
				COUNT(*) 
				FROM
				perkara_pk 
				WHERE alur_perkara_id = a.id 
				AND LEFT(permohonan_pk, 7) = '" . $bulanini . "'
				AND '" . $bulanini . "' <= '" . $bulanini . "' ) AS pk,
				(SELECT 
				COUNT(*) 
				FROM
				perkara_eksekusi 
				WHERE alur_perkara_id = a.id 
				AND LEFT(permohonan_eksekusi, 7) = '" . $bulanini . "'
				AND '" . $bulanini . "' <= '" . $bulanini . "' ) AS eksekusi,
				(SELECT 
				COUNT(*) 
				FROM
				perkara_grasi 
				WHERE alur_perkara_id = a.id 
				AND LEFT(permohonan_grasi, 7) = '" . $bulanini . "'
				AND '" . $bulanini . "' <= '" . $bulanini . "' ) AS grasi 
					FROM
				alur_perkara AS a 
					WHERE a.aktif = 'Y'		AND jenis_pengadilan = '" . $jenis_pengadilan . "'
					ORDER BY a.id ";

		// echo $sql;exit;
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$query = $this
			->dbsipp
			->query($sql);
		return $query->result();

	}
	function get_data_indikator_tahunan($tahun_perkara)
	{
		$jenis_pengadilan = 4;
		$sql = "SELECT 
					a.id,
					a.nama,
					(if (a.id<>118,
							(SELECT 
							COUNT(p.perkara_id) 
							FROM
							perkara AS p 
							LEFT OUTER JOIN perkara_putusan AS putus 
						ON p.perkara_id = putus.perkara_id 
							WHERE p.alur_perkara_id = a.id 
							AND LEFT(p.tanggal_pendaftaran, 4) < '" . $tahun_perkara . "' 
							AND (
						putus.tanggal_putusan IS NULL 
						OR LEFT(putus.tanggal_putusan, 4) >= '" . $tahun_perkara . "'
							) 
							AND '" . $tahun_perkara . "' <= CONCAT(YEAR(CURRENT_DATE),'-',RIGHT(CONCAT('0',CAST(MONTH(CURRENT_DATE) AS CHAR(2))),2)
							)),(SELECT 
								COUNT(p.perkara_id)
								FROM
								perkara AS p 
								LEFT JOIN perkara_putusan AS putus 
							ON p.perkara_id = putus.perkara_id 
								WHERE p.alur_perkara_id = a.id 
								AND LEFT(p.tanggal_pendaftaran, 4) < '" . $tahun_perkara . "' 
								AND (putus.tanggal_putusan IS NULL 
							OR LEFT(putus.tanggal_putusan, 4) >= '" . $tahun_perkara . "')
								AND p.perkara_id NOT IN (SELECT diversi.perkara_id FROM perkara_diversi AS diversi WHERE diversi.hasil_diversi = 1 
								AND (diversi.tgl_penetapan_kesepakatan_diversi <> '0000-00-00' 
							OR LEFT(diversi.tgl_penetapan_kesepakatan_diversi,4) > '" . $tahun_perkara . "'
								)))
							)) 
					AS belum_putus,
					(SELECT 
					COUNT(p.perkara_id) 
					FROM
					perkara AS p 
					WHERE p.alur_perkara_id = a.id 
					AND LEFT(p.tanggal_pendaftaran, 4) = '" . $tahun_perkara . "') AS masuk,
					(IF(a.id <> 118, (SELECT 
					COUNT(p.perkara_id) 
					FROM
					perkara AS p 
					LEFT OUTER JOIN perkara_putusan AS putus 
							ON p.perkara_id = putus.perkara_id 
					WHERE p.alur_perkara_id = a.id 
					AND LEFT(p.tanggal_pendaftaran, 4) <= '" . $tahun_perkara . "'
					AND LEFT(putus.tanggal_putusan, 4) = '" . $tahun_perkara . "'), 
					IF((SELECT 
					COUNT(p.perkara_id) 
					FROM
					perkara AS p 
					LEFT OUTER JOIN perkara_putusan AS putus 
							ON p.perkara_id = putus.perkara_id 
					WHERE p.alur_perkara_id = a.id 
					AND LEFT(p.tanggal_pendaftaran, 4) <= '" . $tahun_perkara . "'
					AND LEFT(putus.tanggal_putusan, 4) = '" . $tahun_perkara . "')=0,
					(SELECT 
					COUNT(p.perkara_id)+(SELECT 
						COUNT(p.perkara_id) 
						FROM
						perkara AS p 
						LEFT OUTER JOIN perkara_putusan AS putus 
								ON p.perkara_id = putus.perkara_id 
						WHERE p.alur_perkara_id = a.id 
						AND LEFT(p.tanggal_pendaftaran, 4) <= '" . $tahun_perkara . "'
						AND LEFT(putus.tanggal_putusan, 4) = '" . $tahun_perkara . "') 
					FROM
					perkara AS p 
					LEFT OUTER JOIN perkara_diversi AS putus 
							ON p.perkara_id = putus.perkara_id 
					WHERE p.alur_perkara_id = a.id 
					AND LEFT(p.tanggal_pendaftaran, 4) <= '" . $tahun_perkara . "'
					AND LEFT(putus.tgl_penetapan_kesepakatan_diversi, 4) = '" . $tahun_perkara . "'
					AND putus.hasil_diversi=1 AND tgl_minutasi IS NOT NULL AND dibuka_kembali=0), 
					(SELECT 
					COUNT(p.perkara_id) 
					FROM
					perkara AS p 
					LEFT OUTER JOIN perkara_putusan AS putus 
							ON p.perkara_id = putus.perkara_id 
					WHERE p.alur_perkara_id = a.id 
					AND LEFT(p.tanggal_pendaftaran, 4) <= '" . $tahun_perkara . "'
					AND LEFT(putus.tanggal_putusan, 4) = '" . $tahun_perkara . "'))			
					)) AS putus,
					(IF (a.id<>118,
							(SELECT 
							COUNT(p.perkara_id) 
							FROM
							perkara AS p 
							LEFT OUTER JOIN perkara_putusan AS putus 
						ON p.perkara_id = putus.perkara_id 
							WHERE p.alur_perkara_id = a.id 
							AND LEFT(p.tanggal_pendaftaran, 4) < '" . $tahun_perkara . "'
							AND (putus.tanggal_putusan IS NULL 
						OR LEFT(putus.tanggal_putusan, 4) >= '" . $tahun_perkara . "')
							),(SELECT 
								COUNT(p.perkara_id)
								FROM
								perkara AS p 
								LEFT JOIN perkara_putusan AS putus 
							ON p.perkara_id = putus.perkara_id 
								WHERE p.alur_perkara_id = a.id 
								AND LEFT(p.tanggal_pendaftaran, 4) < '" . $tahun_perkara . "' 
								AND (putus.tanggal_putusan IS NULL 
							OR LEFT(putus.tanggal_putusan, 4) >= '" . $tahun_perkara . "')
								AND p.perkara_id NOT IN (SELECT diversi.perkara_id FROM perkara_diversi AS diversi WHERE diversi.hasil_diversi = 1 
								AND tgl_minutasi IS NOT NULL AND dibuka_kembali=0
								AND (diversi.tgl_penetapan_kesepakatan_diversi <> '0000-00-00' 
							OR LEFT(diversi.tgl_penetapan_kesepakatan_diversi,4) >= '" . $tahun_perkara . "'
								)))))
					AS sisa,
					(SELECT 
					COUNT(*) 
					FROM
					perkara_banding 
					WHERE alur_perkara_id = a.id 
					AND LEFT(permohonan_banding, 4) = '" . $tahun_perkara . "') AS banding,
					(SELECT 
					COUNT(*) 
					FROM
					perkara_kasasi 
					WHERE alur_perkara_id = a.id 
					AND LEFT(permohonan_kasasi, 4) = '" . $tahun_perkara . "' 
					AND '" . $tahun_perkara . "' <= '" . $tahun_perkara . "' ) AS kasasi,
					(SELECT 
					COUNT(*) 
					FROM
					perkara_pk 
					WHERE alur_perkara_id = a.id 
					AND LEFT(permohonan_pk, 4) = '" . $tahun_perkara . "'
					AND '" . $tahun_perkara . "' <= '" . $tahun_perkara . "' ) AS pk,
					(SELECT 
					COUNT(*) 
					FROM
					perkara_eksekusi 
					WHERE alur_perkara_id = a.id 
					AND LEFT(permohonan_eksekusi, 4) = '" . $tahun_perkara . "'
					AND '" . $tahun_perkara . "' <= '" . $tahun_perkara . "' ) AS eksekusi,
					(SELECT 
					COUNT(*) 
					FROM
					perkara_grasi 
					WHERE alur_perkara_id = a.id 
					AND LEFT(permohonan_grasi, 4) = '" . $tahun_perkara . "'
					AND '" . $bulanini . "' <= '" . $tahun_perkara . "' ) AS grasi 
						FROM
					alur_perkara AS a 
						WHERE a.aktif = 'Y'		AND jenis_pengadilan = '" . $jenis_pengadilan . "'
						ORDER BY a.id ";

		// echo $sql;exit;
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$query = $this
			->dbsipp
			->query($sql);
		return $query->result();

	}
	function tahun_perkara()
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$query = $this
			->dbsipp
			->query("SELECT DISTINCT(LEFT(tanggal_pendaftaran,4)) AS tahun FROM perkara ORDER BY tahun DESC");
		return $query->result();
	}
	function get_data_register($periode, $jml_karakter)
	{
		$sql = " 
				SELECT 1 AS no, 'Register Induk Perkara Permohonan' AS nama, count(perkara_id) AS jumlah, 'Berdasarkan tanggal Pendaftaran' AS ket from perkara WHERE left(tanggal_pendaftaran,$jml_karakter)='" . $periode . "' AND alur_perkara_id=16
				UNION
				
				SELECT 2 AS no, 'Register Induk Perkara Gugatan' AS nama, count(perkara_id) AS jumlah, 'Berdasarkan tanggal Pendaftaran' AS ket from perkara WHERE left(tanggal_pendaftaran,$jml_karakter)='" . $periode . "' AND alur_perkara_id=15
				UNION
				
				SELECT 3 AS no, 'Register Permohonan Banding' AS nama, count(perkara_id) AS jumlah, 'Berdasarkan tanggal Pendaftaran' AS ket from perkara_banding WHERE left(permohonan_banding,$jml_karakter)='" . $periode . "' 
				UNION

				SELECT 4 AS no, 'Register Permohonan Kasasi' AS nama, count(perkara_id) AS jumlah, 'Berdasarkan tanggal Pendaftaran' AS ket from perkara_kasasi WHERE left(permohonan_kasasi,$jml_karakter)='" . $periode . "' 
				UNION

				SELECT 5 AS no, 'Register Permohonan Peninjauan Kembali' AS nama, count(perkara_id) AS jumlah, 'Berdasarkan tanggal Pendaftaran' AS ket from perkara_pk WHERE left(permohonan_pk,$jml_karakter)='" . $periode . "' 
				UNION 
				SELECT 8 AS no, 'Register Surat Kuasa' AS nama, (SELECT COUNT(DISTINCT nomor_kuasa) AS nomor from perkara_pengacara WHERE left(diinput_tanggal,".$jml_karakter.")='".$periode."') + (SELECT count(DISTINCT pemohon_nomor_surat) AS nomor from perkara_banding_detil WHERE left(diinput_tanggal,".$jml_karakter.")='".$periode."' AND pihak_diwakili='Y') + (SELECT count(DISTINCT pemohon_nomor_surat) AS nomor from perkara_kasasi_detil WHERE left(diinput_tanggal,".$jml_karakter.")='".$periode."' AND pihak_diwakili='Y') + (SELECT count(DISTINCT pemohon_nomor_surat) AS nomor from perkara_pk_detil WHERE left(diinput_tanggal,".$jml_karakter.")='".$periode."' AND pihak_diwakili='Y') AS jumlah,'Berdasarkan Tanggal Pendaftaran Surat Kuasa' AS ket from perkara_pengacara 
				UNION

				SELECT 10 AS no, 'Register Akta Cerai' AS nama, count(perkara_id) AS jumlah, 'Berdasarkan tanggal diterbitkan Akta Cerai' AS ket from perkara_akta_cerai WHERE left(tgl_akta_cerai,$jml_karakter)='" . $periode . "'
				
				UNION 
				SELECT 16 AS no, 'Register Mediasi' AS nama, count(perkara_id) AS jumlah,'Berdasarkan Tanggal Penunjukkan Mediator' AS ket from perkara_mediasi WHERE left(penetapan_penunjukan_mediator,$jml_karakter)='" . $periode . "' 

				UNION 
				SELECT 13 AS no, 'Register Ekonomi Syari\'ah' AS nama, count(perkara_id) AS jumlah,'Berdasarkan Tanggal Pendaftaran' AS ket from perkara WHERE left(tanggal_pendaftaran,$jml_karakter)='" . $periode . "' AND jenis_perkara_id=370

				UNION 
				SELECT 12 AS no, 'Register P3HP' AS nama, count(perkara_id) AS jumlah,'Berdasarkan Tanggal Pendaftaran' AS ket from perkara WHERE left(tanggal_pendaftaran,$jml_karakter)='" . $periode . "' AND jenis_perkara_id=371
				UNION 
				SELECT 11 AS no, 'Register Perkara Jinayah' AS nama, count(perkara_id) AS jumlah,'Berdasarkan Tanggal Pendaftaran' AS ket from perkara WHERE left(tanggal_pendaftaran,$jml_karakter)='" . $periode . "' AND alur_perkara_id=122
				UNION 
				SELECT 9 AS no, 'Register Eksekusi' AS nama,		(SELECT COUNT(*) from perkara_eksekusi_ht WHERE left(permohonan_eksekusi,$jml_karakter)='" . $periode . "') + (select count(*) from perkara_eksekusi WHERE left(permohonan_eksekusi,$jml_karakter)='" . $periode . "') AS jumlah ,'Berdasarkan Tanggal Pendaftaran' AS ket FROM perkara_eksekusi

				UNION 
				SELECT 14 AS no, 'Register Istbat Rukyat Hilal dan Pemberian Nasehat/Keterangan tentang Perbedaan Penentuan Arah Kiblat dan Penentuan Awal Waktu Shalat' AS nama,		count(ikrh.id) AS jumlah ,'Berdasarkan Tanggal Pendaftaran' AS ket FROM " . $this
			->db->database . ".register_permohonan_penetapan_ikrh AS ikrh WHERE left(ikrh.tanggal_pendaftaran,$jml_karakter)='" . $periode . "'
				UNION
				SELECT 6 AS no, 'Register Penyitaan Barang Bergerak' AS nama, '-' AS jumlah, 'Dalam proses' AS ket FROM perkara_eksekusi
				UNION
				SELECT 7 AS no, 'Register Penyitaan Barang Tidak Bergerak' AS nama, '-' AS jumlah, 'Dalam proses' AS ket FROM perkara_eksekusi
				UNION
				SELECT 15 AS no, 'Register Eksekusi Putusan Arbitrase Syariah' AS nama, '-' AS jumlah, 'Dalam proses' AS ket FROM perkara_eksekusi

				ORDER BY no ASC
				";
		//echo $this->db->database;exit;
		//echo $sql;exit;
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$query = $this
			->dbsipp
			->query($sql);
		return $query->result();

	}

	//dari SIPP
	function make_datatables_where($table, $select_column, $order_column, $where, $default_sort)
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$this->make_query_where($table, $select_column, $order_column, $where, $default_sort);
		if (isset($_POST["length"]))
		{
			$this
				->dbsipp
				->limit($_POST['length'], $_POST['start']);
		}

		$query = $this
			->dbsipp
			->get();
		return $query->result();
	}
	function make_query_where($table, $select_column, $order_column, $where, $default_sort)
	{
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$this
			->dbsipp
			->select($select_column);
		$this
			->dbsipp
			->from($table);
		if ($table == "perkara" OR $table == "perkara_banding" OR $table == "perkara_kasasi" OR $table == "perkara_pk" )
		{
			$this
				->dbsipp
				->where($where);
		}
		if (isset($_POST["search"]["value"]))
		{
			if ($table == "perkara" OR $table == "perkara_banding" OR $table == "perkara_kasasi" OR $table == "perkara_pk" )
			{
				$this
					->dbsipp
					->group_start();
			}
			for ($posisinya = 0;$posisinya < count($order_column);$posisinya++)
			{

				if ($order_column[$posisinya] <> NULL)
				{
					if ($posisinya == 0)
					{
						$this
							->dbsipp
							->like($order_column[$posisinya], $_POST["search"]["value"]);
					}
					else
					{
						$this
							->dbsipp
							->or_like($order_column[$posisinya], $_POST["search"]["value"]);
					}
				}
			}
			if ($table == "perkara" OR $table == "perkara_banding" OR $table == "perkara_kasasi" OR $table == "perkara_pk" )
			{
				$this
					->dbsipp
					->group_end();

			}
		}

		if (isset($_POST["order"]))
		{
			$this
				->dbsipp
				->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else
		{
			if ($table == "perkara_akta_cerai")
			{
				$this
					->dbsipp
					->order_by('tahun_akta_cerai', 'DESC');
				$this
					->dbsipp
					->order_by('nomor_urut_akta_cerai', 'DESC');
			}
			else
			{
				$this
					->dbsipp
					->order_by($default_sort, 'DESC');
			}

		}
	}
	function get_filtered_data_where($table, $select_column, $order_column, $where, $default_sort)
	{

		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$this->make_query_where($table, $select_column, $order_column, $where, $default_sort);

		$query = $this
			->dbsipp
			->get();
		return $query->num_rows();
	}
	function get_data_order($table, $order)
	{
		$sql="SELECT * FROM $table ORDER BY $order";
		$query = $this->db->query($sql);
		return $query->result();	
	}
	function sisa_lalu($alur_perkara_id, $periode, $bulan, $tahun)
	{
		 	$filter=" perkara.alur_perkara_id=$alur_perkara_id AND (perkara_putusan.tanggal_putusan IS NULL OR perkara_putusan.tanggal_putusan ='0000-00-00' OR perkara_putusan.tanggal_putusan >= '".$tahun."-".$bulan."-01') AND perkara.tanggal_pendaftaran < '".$tahun."-".$bulan."-01' ";
		
		$this->dbsipp = $this->load->database("dbsipp", true);
		$sql="SELECT perkara.perkara_id FROM perkara LEFT JOIN perkara_putusan ON perkara_putusan.perkara_id=perkara.perkara_id WHERE $filter";
		$query = $this->dbsipp->query($sql);
		return $query->num_rows();	
	}
	function jumlah_putus($alur_perkara_id, $periode, $bulan, $tahun, $tanggal_penutupan)
	{
		if($periode=='bulanan')
		{
			$filter=" perkara.alur_perkara_id=$alur_perkara_id AND (left(perkara_putusan.tanggal_putusan,7) = '".$tahun."-".$bulan."') AND tanggal_pendaftaran <='".$tanggal_penutupan."' AND tanggal_putusan <='".$tanggal_penutupan."' ";
		}else
		{
			$filter=" perkara.alur_perkara_id=$alur_perkara_id AND (left(perkara_putusan.tanggal_putusan,4) = '".$tahun."') AND tanggal_pendaftaran <='".$tanggal_penutupan."' AND tanggal_putusan <='".$tanggal_penutupan."' ";
		}
		$this->dbsipp = $this->load->database("dbsipp", true);
		$sql="SELECT perkara.perkara_id FROM perkara LEFT JOIN perkara_putusan ON perkara_putusan.perkara_id=perkara.perkara_id WHERE $filter";
		$query = $this->dbsipp->query($sql);
		return $query->num_rows();	
	}
	function jumlah_sisa_perkara($alur_perkara_id, $periode, $bulan, $tahun, $tanggal_penutupan)
	{
		 	$filter=" perkara.alur_perkara_id=$alur_perkara_id AND (perkara_putusan.tanggal_putusan > '".$tanggal_penutupan."' OR perkara_putusan.tanggal_putusan IS NULL or perkara_putusan.tanggal_putusan ='0000-00-00') AND perkara.tanggal_pendaftaran <='".$tanggal_penutupan."' ";
		
		$this->dbsipp = $this->load->database("dbsipp", true);
		$sql="SELECT perkara.perkara_id FROM perkara LEFT JOIN perkara_putusan ON perkara_putusan.perkara_id=perkara.perkara_id WHERE $filter";
		//echo $sql;exit;
		$query = $this->dbsipp->query($sql);
		return $query->num_rows();	
	}

	function sisa_lalu_upaya_hukum($upaya, $periode, $bulan, $tahun)
	{
		$sql=" SELECT perkara_id from perkara_".$upaya." WHERE (putusan_".$upaya." IS NULL OR putusan_".$upaya." ='0000-00-00' OR putusan_".$upaya." >= '".$tahun."-".$bulan."-01') AND permohonan_".$upaya." < '".$tahun."-".$bulan."-01' ";	
		//echo "SQL SISA LALU : ".$sql."M=<br>";
		$this->dbsipp = $this->load->database("dbsipp", true);
		$query = $this->dbsipp->query($sql);
		return $query->num_rows();	
	}
	function jumlah_putus_upaya_hukum($upaya, $periode, $bulan, $tahun, $tanggal_penutupan)
	{
		 
		$sql=" SELECT perkara_id from perkara_".$upaya." WHERE left(putusan_".$upaya.",4)=$tahun AND permohonan_".$upaya." <='".$tanggal_penutupan."' ";
		//echo "SQL PUTUS : ".$sql."M=<br>";
		$this->dbsipp = $this->load->database("dbsipp", true);
		$query = $this->dbsipp->query($sql);
		return $query->num_rows();	
	}
	function jumlah_sisa_perkara_upaya_hukum($upaya, $periode, $bulan, $tahun, $tanggal_penutupan)
	{
		$sql=" SELECT perkara_id from perkara_".$upaya." WHERE (putusan_".$upaya." IS NULL OR putusan_".$upaya." ='0000-00-00' OR putusan_".$upaya." > '".$tanggal_penutupan."') AND permohonan_".$upaya." <= '".$tanggal_penutupan."' ";
		$this->dbsipp = $this->load->database("dbsipp", true);
		//$sql="SELECT perkara.perkara_id FROM perkara LEFT JOIN perkara_putusan ON perkara_putusan.perkara_id=perkara.perkara_id WHERE $filter";
		//echo "SQL SISA: ".$sql."M=<br>";
		$query = $this->dbsipp->query($sql);
		return $query->num_rows();	
	}
	function jumlah_sisa_perkara_upaya_hukum_sudah_dikirim($upaya, $periode, $bulan, $tahun, $tanggal_penutupan)
	{
		$sql=" SELECT perkara_id from perkara_".$upaya." WHERE (putusan_".$upaya." IS NULL OR putusan_".$upaya." ='0000-00-00' OR putusan_".$upaya." > '".$tanggal_penutupan."') AND permohonan_".$upaya." <= '".$tanggal_penutupan."' AND (pengiriman_berkas_".$upaya." <='$tanggal_penutupan') ";
		$this->dbsipp = $this->load->database("dbsipp", true);
		//$sql="SELECT perkara.perkara_id FROM perkara LEFT JOIN perkara_putusan ON perkara_putusan.perkara_id=perkara.perkara_id WHERE $filter";
		//echo $sql;exit;
		$query = $this->dbsipp->query($sql);
		return $query->num_rows();	
	}
	function jumlah_sisa_perkara_upaya_hukum_belum_dikirim($upaya, $periode, $bulan, $tahun, $tanggal_penutupan)
	{
		$sql=" SELECT perkara_id from perkara_".$upaya." WHERE (putusan_".$upaya." IS NULL OR putusan_".$upaya." ='0000-00-00' OR putusan_".$upaya." > '".$tanggal_penutupan."') AND permohonan_".$upaya." <= '".$tanggal_penutupan."' AND (pengiriman_berkas_".$upaya." IS NULL OR pengiriman_berkas_".$upaya." ='0000-00-00' OR pengiriman_berkas_".$upaya." >'$tanggal_penutupan') ";
		$this->dbsipp = $this->load->database("dbsipp", true);
		//$sql="SELECT perkara.perkara_id FROM perkara LEFT JOIN perkara_putusan ON perkara_putusan.perkara_id=perkara.perkara_id WHERE $filter";
		//echo $sql;exit;
		$query = $this->dbsipp->query($sql);
		return $query->num_rows();	
	}
	function get_jumlah_surat_kuasa_khusus($search_text='')
	{
		$this->dbsipp = $this->load->database("dbsipp", true);
		if($search_text != '')
		{
			$filter_a= " WHERE perkara.nomor_perkara like '".$search_text."%' ";
			$filter_b= " AND  perkara.nomor_perkara like '".$search_text."%' ";
			$filter_eksekusi= " AND (  
									perkara_eksekusi.eksekusi_nomor_perkara like '".$search_text."%'
							 )";
			$filter_eksekusi_ht= " AND (  
									perkara_eksekusi_ht.eksekusi_nomor_perkara like '".$search_text."%'
							 )";
		}else
		{
			$filter_a= " ";
			$filter_b= " ";
			$filter_eksekusi= " ";
			$filter_eksekusi_ht= " ";
		}
		$sql="SELECT 
						DATE_FORMAT(LEFT(perkara_pengacara.aktif_mulai,10),'%d-%m-%Y') as tgl
						,perkara_pengacara.nomor_kuasa as nomor_kuasa
						,(select nama from pihak where id=perkara_pengacara.pihak_id) as nama_p
						,perkara_pengacara.nama as nama
						,(select pekerjaan from pihak where id=perkara_pengacara.pengacara_id) as pekerjaan
						,perkara.nomor_perkara as nomor_perkara
						,DATE_FORMAT(perkara_pengacara.tanggal_kuasa,'%d-%m-%Y') as tanggal_kuasa 
						,0 as pengacara
						,perkara_pengacara.aktif_mulai AS waktune
						,'' AS keterangan
						,perkara_pengacara.keterangan AS ket
					FROM perkara_pengacara
					
					LEFT JOIN perkara ON perkara.perkara_id=perkara_pengacara.perkara_id
					$filter_a
					GROUP BY perkara_pengacara.nomor_kuasa, perkara_pengacara.perkara_id

					UNION 
					SELECT 
						DATE_FORMAT(LEFT(perkara_banding_detil.diinput_tanggal,10),'%d-%m-%Y') as tgl
						,perkara_banding_detil.pemohon_nomor_surat AS nomor_kuasa
						,perkara_banding_detil.pihak_nama as nama_p
						,perkara_banding_detil.pemohon_nama as nama 
						,perkara_banding_detil.pemohon_pekerjaan as pekerjaan 
 						,perkara.nomor_perkara  as nomor_perkara
						,DATE_FORMAT(perkara_banding_detil.pemohon_tanggal_surat,'%d-%m-%Y') as tanggal_kuasa 
						,0 as pengacara 
						,perkara_banding_detil.diinput_tanggal AS waktune
						,'<br>Banding' AS keterangan
						,'' AS ket
					FROM perkara_banding_detil
					LEFT JOIN perkara_banding ON perkara_banding.perkara_id=perkara_banding_detil.perkara_id
					LEFT JOIN perkara ON perkara.perkara_id=perkara_banding_detil.perkara_id
					WHERE perkara_banding_detil.pihak_diwakili='Y' $filter_b
					
					UNION 
					SELECT 
						DATE_FORMAT(LEFT(perkara_kasasi_detil.diinput_tanggal,10),'%d-%m-%Y') as tgl
						,perkara_kasasi_detil.pemohon_nomor_surat AS nomor_kuasa
						,perkara_kasasi_detil.pihak_nama as nama_p
						,perkara_kasasi_detil.pemohon_nama as nama 
						,perkara_kasasi_detil.pemohon_pekerjaan as pekerjaan 
 						,perkara.nomor_perkara as nomor_perkara
						,DATE_FORMAT(perkara_kasasi_detil.pemohon_tanggal_surat,'%d-%m-%Y') as tanggal_kuasa 
						,0 as pengacara 
						,perkara_kasasi_detil.diinput_tanggal AS waktune
						,'<br>Kasasi' AS keterangan
						,'' AS ket
					FROM perkara_kasasi_detil
					LEFT JOIN perkara_kasasi ON perkara_kasasi.perkara_id=perkara_kasasi_detil.perkara_id
					LEFT JOIN perkara ON perkara.perkara_id=perkara_kasasi_detil.perkara_id
					 
					WHERE perkara_kasasi_detil.pihak_diwakili='Y' $filter_b

					UNION 
					SELECT 
						DATE_FORMAT(LEFT(perkara_pk_detil.diinput_tanggal,10),'%d-%m-%Y') as tgl
						,perkara_pk_detil.pemohon_nomor_surat AS nomor_kuasa
						,perkara_pk_detil.pihak_nama as nama_p
						,perkara_pk_detil.pemohon_nama as nama 
						,perkara_pk_detil.pemohon_pekerjaan as pekerjaan 
 						,perkara.nomor_perkara as nomor_perkara
						,DATE_FORMAT(perkara_pk_detil.pemohon_tanggal_surat,'%d-%m-%Y') as tanggal_kuasa 
						,0 as pengacara 
						,perkara_pk_detil.diinput_tanggal AS waktune
						,'<br>PK' AS keterangan
						,'' AS ket
					FROM perkara_pk_detil
					LEFT JOIN perkara_pk ON perkara_pk.perkara_id=perkara_pk_detil.perkara_id
					LEFT JOIN perkara ON perkara.perkara_id=perkara_pk_detil.perkara_id
					 
					WHERE perkara_pk_detil.pihak_diwakili='Y' $filter_b

					UNION 
					SELECT 
						DATE_FORMAT(LEFT(perkara_eksekusi_detil.diinput_tanggal,10),'%d-%m-%Y') as tgl
						,perkara_eksekusi_detil.pemohon_nomor_surat AS nomor_kuasa
						,perkara_eksekusi_detil.pihak_nama as nama_p
						,perkara_eksekusi_detil.pemohon_nama as nama 
						,perkara_eksekusi_detil.pemohon_pekerjaan as pekerjaan 
 						,perkara.nomor_perkara as nomor_perkara
						,DATE_FORMAT(perkara_eksekusi_detil.pemohon_tanggal_surat,'%d-%m-%Y') as tanggal_kuasa 
						,0 as pengacara 
						,perkara_eksekusi_detil.diinput_tanggal AS waktune
						,'<br>Eksekusi' AS keterangan
						,'' AS ket
					FROM perkara_eksekusi_detil
					LEFT JOIN perkara_eksekusi ON perkara_eksekusi.perkara_id=perkara_eksekusi_detil.perkara_id 
					LEFT JOIN perkara ON perkara.perkara_id=perkara_eksekusi_detil.perkara_id 
					 
					WHERE perkara_eksekusi_detil.pihak_diwakili='Y' $filter_eksekusi

					UNION 
					SELECT 
						DATE_FORMAT(LEFT(perkara_eksekusi_detil_ht.diinput_tanggal,10),'%d-%m-%Y') as tgl
						,perkara_eksekusi_detil_ht.pemohon_nomor_surat AS nomor_kuasa
						,perkara_eksekusi_detil_ht.pihak_nama as nama_p
						,perkara_eksekusi_detil_ht.pemohon_nama as nama 
						,perkara_eksekusi_detil_ht.pemohon_pekerjaan as pekerjaan 
 						,perkara_eksekusi_ht.nomor_perkara_pn as nomor_perkara
						,DATE_FORMAT(perkara_eksekusi_detil_ht.pemohon_tanggal_surat,'%d-%m-%Y') as tanggal_kuasa 
						,0 as pengacara 
						,perkara_eksekusi_detil_ht.diinput_tanggal AS waktune
						,'<br>Eksekusi Hak Tanggungan' AS keterangan
						,'' AS ket
					FROM perkara_eksekusi_detil_ht
					LEFT JOIN perkara_eksekusi_ht ON perkara_eksekusi_ht.ht_id=perkara_eksekusi_detil_ht.ht_id 
					 
					WHERE perkara_eksekusi_detil_ht.pihak_diwakili='Y' $filter_eksekusi_ht


					
				";

			$q = $this
				->dbsipp
				->query($sql);	
			//echo $sql;exit;
		return $q->num_rows();	
	}
	function get_data_surat_kuasa_khusus($perpage,$begin,$search_text='')
	{
		$this->dbsipp = $this->load->database("dbsipp", true);
		if($search_text != '')
		{
			$filter_a= " WHERE perkara.nomor_perkara like '".$search_text."%' ";
			$filter_b= " AND  perkara.nomor_perkara like '".$search_text."%' ";
			$filter_eksekusi= " AND (  
									perkara_eksekusi.eksekusi_nomor_perkara like '".$search_text."%'
							 )";
			$filter_eksekusi_ht= " AND (  
									perkara_eksekusi_ht.eksekusi_nomor_perkara like '".$search_text."%'
							 )";
		}else
		{
			$filter_a= " ";
			$filter_b= " ";
			$filter_eksekusi= "";
			$filter_eksekusi_ht= "";
		}
		$sql="SELECT 
						DATE_FORMAT(LEFT(perkara_pengacara.aktif_mulai,10),'%d-%m-%Y') as tgl
						,perkara_pengacara.nomor_kuasa as nomor_kuasa
						,CASE WHEN perkara_pengacara.keterangan='Subtitusi' THEN (select a.nama from perkara_pengacara AS a where a.perkara_id=perkara_pengacara.perkara_id AND a.pihak_ke=perkara_pengacara.pihak_ke AND a.urutan<perkara_pengacara.urutan ORDER BY a.urutan DESC limit 1) ELSE (
						select nama from pihak where id=perkara_pengacara.pihak_id) END as nama_p
						,perkara_pengacara.nama as nama
						,(select pekerjaan from pihak where id=perkara_pengacara.pengacara_id) as pekerjaan
						,perkara.nomor_perkara as nomor_perkara
						,DATE_FORMAT(perkara_pengacara.tanggal_kuasa,'%d-%m-%Y') as tanggal_kuasa 
						,0 as pengacara
						,perkara_pengacara.aktif_mulai AS waktune
						,'' AS keterangan
						,perkara_pengacara.keterangan AS ket
						,1 AS jenis
						,perkara_pengacara.id AS id
					FROM perkara_pengacara
					
					LEFT JOIN perkara ON perkara.perkara_id=perkara_pengacara.perkara_id
					$filter_a
					GROUP BY perkara_pengacara.nomor_kuasa, perkara_pengacara.perkara_id
					UNION 
					SELECT 
						DATE_FORMAT(LEFT(perkara_banding_detil.diinput_tanggal,10),'%d-%m-%Y') as tgl
						,perkara_banding_detil.pemohon_nomor_surat AS nomor_kuasa
						,perkara_banding_detil.pihak_nama as nama_p
						,perkara_banding_detil.pemohon_nama as nama 
						,perkara_banding_detil.pemohon_pekerjaan as pekerjaan 
 						,perkara.nomor_perkara  as nomor_perkara
						,DATE_FORMAT(perkara_banding_detil.pemohon_tanggal_surat,'%d-%m-%Y') as tanggal_kuasa 
						,0 as pengacara 
						,perkara_banding_detil.diinput_tanggal AS waktune
						,'<br>Banding' AS keterangan
						,'' AS ket
						,2 AS jenis
						,perkara_banding_detil.id AS id

					FROM perkara_banding_detil
					LEFT JOIN perkara_banding ON perkara_banding.perkara_id=perkara_banding_detil.perkara_id
					LEFT JOIN perkara ON perkara.perkara_id=perkara_banding_detil.perkara_id
					WHERE perkara_banding_detil.pihak_diwakili='Y' $filter_b
					
					UNION 
					SELECT 
						DATE_FORMAT(LEFT(perkara_kasasi_detil.diinput_tanggal,10),'%d-%m-%Y') as tgl
						,perkara_kasasi_detil.pemohon_nomor_surat AS nomor_kuasa
						,perkara_kasasi_detil.pihak_nama as nama_p
						,perkara_kasasi_detil.pemohon_nama as nama 
						,perkara_kasasi_detil.pemohon_pekerjaan as pekerjaan 
 						,perkara.nomor_perkara as nomor_perkara
						,DATE_FORMAT(perkara_kasasi_detil.pemohon_tanggal_surat,'%d-%m-%Y') as tanggal_kuasa 
						,0 as pengacara 
						,perkara_kasasi_detil.diinput_tanggal AS waktune
						,'<br>Kasasi' AS keterangan
						,'' AS ket
						,3 AS jenis
						,perkara_kasasi_detil.id AS id
					FROM perkara_kasasi_detil
					LEFT JOIN perkara_kasasi ON perkara_kasasi.perkara_id=perkara_kasasi_detil.perkara_id
					LEFT JOIN perkara ON perkara.perkara_id=perkara_kasasi_detil.perkara_id
					 
					WHERE perkara_kasasi_detil.pihak_diwakili='Y' $filter_b

					UNION 
					SELECT 
						DATE_FORMAT(LEFT(perkara_pk_detil.diinput_tanggal,10),'%d-%m-%Y') as tgl
						,perkara_pk_detil.pemohon_nomor_surat AS nomor_kuasa
						,perkara_pk_detil.pihak_nama as nama_p
						,perkara_pk_detil.pemohon_nama as nama 
						,perkara_pk_detil.pemohon_pekerjaan as pekerjaan 
 						,perkara.nomor_perkara as nomor_perkara
						,DATE_FORMAT(perkara_pk_detil.pemohon_tanggal_surat,'%d-%m-%Y') as tanggal_kuasa 
						,0 as pengacara 
						,perkara_pk_detil.diinput_tanggal AS waktune
						,'<br>PK' AS keterangan
						,'' AS ket
						,4 AS jenis
						,perkara_pk_detil.id AS id
					FROM perkara_pk_detil
					LEFT JOIN perkara_pk ON perkara_pk.perkara_id=perkara_pk_detil.perkara_id
					LEFT JOIN perkara ON perkara.perkara_id=perkara_pk_detil.perkara_id
					 
					WHERE perkara_pk_detil.pihak_diwakili='Y' $filter_b

					UNION 
					SELECT 
						DATE_FORMAT(LEFT(perkara_eksekusi_detil.diinput_tanggal,10),'%d-%m-%Y') as tgl
						,perkara_eksekusi_detil.pemohon_nomor_surat AS nomor_kuasa
						,perkara_eksekusi_detil.pihak_nama as nama_p
						,perkara_eksekusi_detil.pemohon_nama as nama 
						,perkara_eksekusi_detil.pemohon_pekerjaan as pekerjaan 
 						,perkara.nomor_perkara as nomor_perkara
						,DATE_FORMAT(perkara_eksekusi_detil.pemohon_tanggal_surat,'%d-%m-%Y') as tanggal_kuasa 
						,0 as pengacara 
						,perkara_eksekusi_detil.diinput_tanggal AS waktune
						,'<br>Eksekusi' AS keterangan
						,'' AS ket
						,5 AS jenis
						,perkara_eksekusi_detil.id AS id
					FROM perkara_eksekusi_detil
					LEFT JOIN perkara_eksekusi ON perkara_eksekusi.perkara_id=perkara_eksekusi_detil.perkara_id 
					LEFT JOIN perkara ON perkara.perkara_id=perkara_eksekusi_detil.perkara_id 
					 
					WHERE perkara_eksekusi_detil.pihak_diwakili='Y'  $filter_eksekusi
					UNION 
					SELECT 
						DATE_FORMAT(LEFT(perkara_eksekusi_detil_ht.diinput_tanggal,10),'%d-%m-%Y') as tgl
						,perkara_eksekusi_detil_ht.pemohon_nomor_surat AS nomor_kuasa
						,perkara_eksekusi_detil_ht.pihak_nama as nama_p
						,perkara_eksekusi_detil_ht.pemohon_nama as nama 
						,perkara_eksekusi_detil_ht.pemohon_pekerjaan as pekerjaan 
 						,perkara_eksekusi_ht.nomor_perkara_pn as nomor_perkara
						,DATE_FORMAT(perkara_eksekusi_detil_ht.pemohon_tanggal_surat,'%d-%m-%Y') as tanggal_kuasa 
						,0 as pengacara 
						,perkara_eksekusi_detil_ht.diinput_tanggal AS waktune
						,'<br>Eksekusi Hak Tanggungan' AS keterangan
						,'' AS ket
						,6 AS jenis
						,perkara_eksekusi_detil_ht.id AS id

					FROM perkara_eksekusi_detil_ht
					LEFT JOIN perkara_eksekusi_ht ON perkara_eksekusi_ht.ht_id=perkara_eksekusi_detil_ht.ht_id 
					 
					WHERE perkara_eksekusi_detil_ht.pihak_diwakili='Y'  $filter_eksekusi_ht


					
					
					ORDER by waktune DESC, nomor_kuasa ASC
					LIMIT $perpage OFFSET $begin
				";

			$q = $this
				->dbsipp
				->query($sql);	
			//echo $sql;exit;
		return $q->result();
	}
	function register_surat_kuasa_cetak($jenis, $tahun,$bulan,$id)
	{
		$this->dbsipp = $this->load->database("dbsipp", true);
		
			if($bulan==0)
			{
				$filter=" WHERE YEAR(perkara_pengacara.aktif_mulai)= $tahun ";
			}else
			{
				$filter=" WHERE YEAR(perkara_pengacara.aktif_mulai)= $tahun AND MONTH(perkara_pengacara.aktif_mulai)=$bulan ";
			}
			if($id!='')
			{
				if($jenis==1)
				{
					$filter=" WHERE id= $id";
				
					$sql="SELECT 
							convert_tanggal_indonesia(LEFT(perkara_pengacara.aktif_mulai,10)) as tgl
							,perkara_pengacara.nomor_kuasa as nomor_kuasa
							,CASE WHEN perkara_pengacara.keterangan='Subtitusi' THEN (select a.nama from perkara_pengacara AS a where a.perkara_id=perkara_pengacara.perkara_id AND a.pihak_ke=perkara_pengacara.pihak_ke AND a.urutan<perkara_pengacara.urutan ORDER BY a.urutan DESC limit 1) ELSE (select nama from pihak where id=perkara_pengacara.pihak_id) END as nama_p
							,perkara_pengacara.nama as nama
							,(select pekerjaan from pihak where id=perkara_pengacara.pengacara_id) as pekerjaan
							,perkara.nomor_perkara as nomor_perkara
							,convert_tanggal_indonesia(perkara_pengacara.tanggal_kuasa) as tanggal_kuasa 
							,0 as pengacara
							,perkara_pengacara.aktif_mulai AS waktune
							,'' AS keterangan
							,perkara_pengacara.keterangan AS ket
						FROM perkara_pengacara
						
						LEFT JOIN perkara ON perkara.perkara_id=perkara_pengacara.perkara_id
						$filter
						GROUP BY perkara_pengacara.nomor_kuasa, perkara_pengacara.perkara_id
						";
				}else
				if($jenis==2)
				{
					$filter=" WHERE perkara_banding_detil.id= $id";
				
					$sql="SELECT 
							convert_tanggal_indonesia(LEFT(perkara_banding_detil.diinput_tanggal,10)) as tgl
							,perkara_banding_detil.pemohon_nomor_surat AS nomor_kuasa
							,perkara_banding_detil.pihak_nama as nama_p
							,perkara_banding_detil.pemohon_nama as nama 
							,perkara_banding_detil.pemohon_pekerjaan as pekerjaan 
	 						,perkara_banding.nomor_perkara_pn as nomor_perkara
							,convert_tanggal_indonesia(perkara_banding_detil.pemohon_tanggal_surat) as tanggal_kuasa 
							,0 as pengacara 
							,perkara_banding_detil.diinput_tanggal AS waktune
							,'<br>Banding' AS keterangan
							,'' AS ket
						FROM perkara_banding_detil
						LEFT JOIN perkara_banding ON perkara_banding.perkara_id=perkara_banding_detil.perkara_id
						 $filter";
				}else
				if($jenis==3)
				{
					$filter=" WHERE perkara_kasasi_detil.id= $id";
				
					$sql="SELECT 
							convert_tanggal_indonesia(LEFT(perkara_kasasi_detil.diinput_tanggal,10)) as tgl
							,perkara_kasasi_detil.pemohon_nomor_surat AS nomor_kuasa
							,perkara_kasasi_detil.pihak_nama as nama_p
							,perkara_kasasi_detil.pemohon_nama as nama 
							,perkara_kasasi_detil.pemohon_pekerjaan as pekerjaan 
	 						,perkara_kasasi.nomor_perkara_pn as nomor_perkara
							,convert_tanggal_indonesia(perkara_kasasi_detil.pemohon_tanggal_surat) as tanggal_kuasa 
							,0 as pengacara 
							,perkara_kasasi_detil.diinput_tanggal AS waktune
							,'<br>Kasasi' AS keterangan
							,'' AS ket
						FROM perkara_kasasi_detil
						LEFT JOIN perkara_kasasi ON perkara_kasasi.perkara_id=perkara_kasasi_detil.perkara_id
						 $filter";
				}
				if($jenis==4)
				{
					$filter=" WHERE perkara_pk_detil.id= $id";
				
					$sql="SELECT 
							convert_tanggal_indonesia(LEFT(perkara_pk_detil.diinput_tanggal,10)) as tgl
							,perkara_pk_detil.pemohon_nomor_surat AS nomor_kuasa
							,perkara_pk_detil.pihak_nama as nama_p
							,perkara_pk_detil.pemohon_nama as nama 
							,perkara_pk_detil.pemohon_pekerjaan as pekerjaan 
	 						,perkara_pk.nomor_perkara_pn as nomor_perkara
							,convert_tanggal_indonesia(perkara_pk_detil.pemohon_tanggal_surat) as tanggal_kuasa 
							,0 as pengacara 
							,perkara_pk_detil.diinput_tanggal AS waktune
							,'<br>Peninjauan Kembali' AS keterangan
							,'' AS ket
						FROM perkara_pk_detil
						LEFT JOIN perkara_pk ON perkara_pk.perkara_id=perkara_pk_detil.perkara_id
 
						 $filter";
				}else
				if($jenis==5)
				{
					$filter=" WHERE perkara_eksekusi_detil.id= $id";
				
					$sql="SELECT 
							convert_tanggal_indonesia(LEFT(perkara_eksekusi_detil.diinput_tanggal,10)) as tgl
							,perkara_eksekusi_detil.pemohon_nomor_surat AS nomor_kuasa
							,perkara_eksekusi_detil.pihak_nama as nama_p
							,perkara_eksekusi_detil.pemohon_nama as nama 
							,perkara_eksekusi_detil.pemohon_pekerjaan as pekerjaan 
	 						,perkara_eksekusi.nomor_perkara_pn as nomor_perkara
							,convert_tanggal_indonesia(perkara_eksekusi_detil.pemohon_tanggal_surat) as tanggal_kuasa 
							,0 as pengacara 
							,perkara_eksekusi_detil.diinput_tanggal AS waktune
							,'<br>Eksekusi' AS keterangan
							,'' AS ket
						FROM perkara_eksekusi_detil
						LEFT JOIN perkara_eksekusi ON perkara_eksekusi.perkara_id=perkara_eksekusi_detil.perkara_id 
						 $filter";
				}else
				if($jenis==6)
				{
					$filter=" WHERE perkara_eksekusi_detil_ht.id= $id";
				
					$sql="SELECT 
							convert_tanggal_indonesia(LEFT(perkara_eksekusi_detil_ht.diinput_tanggal,10)) as tgl
							,perkara_eksekusi_detil_ht.pemohon_nomor_surat AS nomor_kuasa
							,perkara_eksekusi_detil_ht.pihak_nama as nama_p
							,perkara_eksekusi_detil_ht.pemohon_nama as nama 
							,perkara_eksekusi_detil_ht.pemohon_pekerjaan as pekerjaan 
	 						,perkara_eksekusi_ht.eksekusi_nomor_perkara as nomor_perkara
							,convert_tanggal_indonesia(perkara_eksekusi_detil_ht.pemohon_tanggal_surat) as tanggal_kuasa 
							,0 as pengacara 
							,perkara_eksekusi_detil_ht.diinput_tanggal AS waktune
							,'<br>Eksekusi Hak Tanggungan' AS keterangan
							,'' AS ket
						FROM perkara_eksekusi_detil_ht
						LEFT JOIN perkara_eksekusi_ht ON perkara_eksekusi_ht.ht_id=perkara_eksekusi_detil_ht.ht_id  
						 $filter";
				}
			}		
			
		$q = $this->dbsipp->query($sql);	
			//echo $sql;exit;
		return $q->result();
	}
	function get_data_surat_kuasa_khusus_2019()
	{
		$this->dbsipp = $this->load->database("dbsipp", true);
		 
		$sql="SELECT 
						LEFT(perkara_pengacara.aktif_mulai,10) as tgl
						,perkara_pengacara.nomor_kuasa as nomor_kuasa
						,perkara_pengacara.id as id
						,pihak.nama as nama_p
						,perkara_pengacara.nama as nama
						,(select pekerjaan from pihak where id=perkara_pengacara.pengacara_id) as pekerjaan
						,perkara.nomor_perkara as nomor_perkara
						,perkara_pengacara.tanggal_kuasa as tanggal_kuasa 
						,0 as pengacara
						,perkara_pengacara.aktif_mulai AS waktune
						,perkara_pengacara.keterangan AS keterangan
					FROM perkara_pengacara
					LEFT JOIN pihak ON pihak.id=perkara_pengacara.pihak_id
					LEFT JOIN perkara ON perkara.perkara_id=perkara_pengacara.perkara_id
					  
					ORDER by perkara_pengacara.id DESC, nomor_kuasa ASC LIMIT 1000
				";

			$q = $this
				->dbsipp
				->query($sql);	
			//echo $sql;exit;
		return $q->result();
	}
	function get_data_eksekusi()
	{
		$sql = "SELECT 
					CASE 
						WHEN
							(SELECT pihak_diwakili FROM perkara_eksekusi_detil where perkara_id=perkara_eksekusi.perkara_id AND status_pihak_id=1 AND pihak_diwakili='Y' LIMIT 1)='Y'
						THEN
							CONCAT(
								(
									SELECT 
										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', bertindak untuk dan atas nama ' ) 
									FROM
										perkara_eksekusi_detil b
										JOIN pihak d ON b.pemohon_id = d.id
										JOIN agama e ON d.agama_id = e.id
									WHERE b.perkara_id = perkara_eksekusi.perkara_id AND status_pihak_id=1 LIMIT 1
								)
								,
								(SELECT
									IF(COUNT(b.pihak_id)>1,
										GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat ) SEPARATOR '; <br> ' ),

										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat ))
										AS DATA
									FROM
										perkara_eksekusi_detil b
										JOIN pihak d ON b.pihak_id = d.id
										JOIN agama e ON d.agama_id = e.id
									WHERE b.perkara_id = perkara_eksekusi.perkara_id AND status_pihak_id=1)
									,' sebagai Pemohon Eksekusi'
									)
						ELSE
							(SELECT
								IF(COUNT(b.pihak_id)>1,
									GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pendidikan ',
									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon Eksekusi ' ) SEPARATOR '; <br> ' ),

									CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon Eksekusi;' ))
									AS DATA
								FROM
									perkara_eksekusi_detil b
									JOIN pihak d ON b.pihak_id = d.id
									JOIN agama e ON d.agama_id = e.id
								WHERE b.perkara_id = perkara_eksekusi.perkara_id AND status_pihak_id=1)	
						END 
					 AS identitas_p
			, 
					CASE 
						WHEN
							(SELECT pihak_diwakili FROM perkara_eksekusi_detil where perkara_id=perkara_eksekusi.perkara_id AND status_pihak_id=2 AND pihak_diwakili='Y' LIMIT 1)='Y'
						THEN
							CONCAT(
								(
									SELECT 
										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', bertindak untuk dan atas nama ' ) 
									FROM
										perkara_eksekusi_detil b
										JOIN pihak d ON b.pemohon_id = d.id
										JOIN agama e ON d.agama_id = e.id
									WHERE b.perkara_id = perkara_eksekusi.perkara_id AND status_pihak_id=2 LIMIT 1
								)
								,
								(SELECT
									IF(COUNT(b.pihak_id)>1,
										GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat ) SEPARATOR '; <br> ' ),

										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat ))
										
									FROM
										perkara_eksekusi_detil b
										JOIN pihak d ON b.pihak_id = d.id
										JOIN agama e ON d.agama_id = e.id
									WHERE b.perkara_id = perkara_eksekusi.perkara_id AND status_pihak_id=2)
									,' sebagai Termohon Eksekusi'
									)
						ELSE
							(SELECT
								IF(COUNT(b.pihak_id)>1,
									GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pendidikan ',
									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', Termohon Pemohon Eksekusi ' ) SEPARATOR '; <br> ' ),

									CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', sebagai Termohon Eksekusi;' ))
									AS DATA
								FROM
									perkara_eksekusi_detil b
									JOIN pihak d ON b.pihak_id = d.id
									JOIN agama e ON d.agama_id = e.id
								WHERE b.perkara_id = perkara_eksekusi.perkara_id AND status_pihak_id=2)	
						END 
					 AS identitas_t	 		 
			,nomor_urut_perkara_eksekusi
			,nomor_register_eksekusi AS nomor_register_eksekusi
			,permohonan_eksekusi AS tgl_daftar
			,convert_tanggal_indonesia(permohonan_eksekusi) AS permohonan_eksekusi
			,'-' AS jenis_ht_text
			,nomor_perkara_pn
			,convert_tanggal_indonesia(putusan_pn) AS putusan_pn
			,nomor_perkara_banding
			,convert_tanggal_indonesia(putusan_banding) AS putusan_banding
			,nomor_perkara_kasasi
			,convert_tanggal_indonesia(putusan_kasasi) AS putusan_kasasi
			,nomor_perkara_pk
			,convert_tanggal_indonesia(putusan_pk) AS putusan_pk
			,eksekusi_amar_putusan
			,convert_tanggal_indonesia(penetapan_teguran_eksekusi) AS penetapan_teguran_eksekusi
			,convert_tanggal_indonesia(pelaksanaan_teguran_eksekusi) AS pelaksanaan_teguran_eksekusi 
			,convert_tanggal_indonesia(pelaksanaan_eksekusi_rill) AS pelaksanaan_eksekusi_rill
			,'-' AS pendaftaran_sita 
			,convert_tanggal_indonesia(penetapan_sita_eksekusi) AS penetapan_sita_eksekusi
			,convert_tanggal_indonesia(pelaksanaan_sita_eksekusi) AS pelaksanaan_sita_eksekusi 
			,convert_tanggal_indonesia(penetapan_perintah_eksekusi_lelang) AS penetapan_perintah_eksekusi_lelang
			,convert_tanggal_indonesia(pelaksanaan_eksekusi_lelang) AS pelaksanaan_eksekusi_lelang
			,convert_tanggal_indonesia(penyerahan_hasil_lelang) AS penyerahan_hasil_lelang
			,'-' AS permohonan_pengosongan
			,'-' AS penetapan_pengosongan
			,'-' AS pelaksanaan_pengosongan
			,'-' AS penetapan_perintah_eksekusi_lelang_ht
			,'-' AS pelaksanaan_eksekusi_lelang_ht
			,'-' AS pendaftaran_sita_ht
			,'-' AS penetapan_perintah_eksekusi_lelang_ht
			,'-' AS pelaksanaan_eksekusi_lelang_ht
			,'-' AS penyerahan_hasil_lelang_ht
			,'-' AS pengangkatan_sita

			FROM perkara_eksekusi  
			UNION
			SELECT
			 
					CASE 
						WHEN
							(SELECT pihak_diwakili FROM perkara_eksekusi_detil_ht where ht_id=perkara_eksekusi_ht.ht_id AND status_pihak_id=1 AND pihak_diwakili='Y' LIMIT 1)='Y'
						THEN
							CONCAT(
								(
									SELECT 
										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', bertindak untuk dan atas nama ' ) 
									FROM
										perkara_eksekusi_detil_ht b
										JOIN pihak d ON b.pemohon_id = d.id
										JOIN agama e ON d.agama_id = e.id
									WHERE b.ht_id = perkara_eksekusi_ht.ht_id AND status_pihak_id=1 LIMIT 1
								)
								,
								(SELECT
									IF(COUNT(b.pihak_id)>1,
										GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat ) SEPARATOR '; <br> ' ),

										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat ))
										AS DATA
									FROM
										perkara_eksekusi_detil_ht b
										JOIN pihak d ON b.pihak_id = d.id
										JOIN agama e ON d.agama_id = e.id
									WHERE b.ht_id= perkara_eksekusi_ht.ht_id AND status_pihak_id=1)
									,' sebagai Pemohon Eksekusi'
									)
						ELSE
							(SELECT
								IF(COUNT(b.pihak_id)>1,
									GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pendidikan ',
									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon Eksekusi ' ) SEPARATOR '; <br> ' ),

									CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', sebagai Pemohon Eksekusi;' ))
									AS DATA
								FROM
									perkara_eksekusi_detil_ht b
									JOIN pihak d ON b.pihak_id = d.id
									JOIN agama e ON d.agama_id = e.id
								WHERE b.ht_id = perkara_eksekusi_ht.ht_id AND status_pihak_id=1)	
						END 
					 AS identitas_p
			, 
					CASE 
						WHEN
							(SELECT pihak_diwakili FROM perkara_eksekusi_detil_ht where ht_id=perkara_eksekusi_ht.ht_id AND status_pihak_id=2 AND pihak_diwakili='Y' LIMIT 1)='Y'
						THEN
							CONCAT(
								(
									SELECT 
										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', bertindak untuk dan atas nama ' ) 
									FROM
										perkara_eksekusi_detil_ht b
										JOIN pihak d ON b.pemohon_id = d.id
										JOIN agama e ON d.agama_id = e.id
									WHERE b.ht_id= perkara_eksekusi_ht.ht_id AND status_pihak_id=2 LIMIT 1
								)
								,
								(SELECT
									IF(COUNT(b.pihak_id)>1,
										GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat ) SEPARATOR '; <br> ' ),

										CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
										CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat ))
										
									FROM
										perkara_eksekusi_detil_ht b
										JOIN pihak d ON b.pihak_id = d.id
										JOIN agama e ON d.agama_id = e.id
									WHERE b.ht_id = perkara_eksekusi_ht.ht_id AND status_pihak_id=2)
									,' sebagai Termohon Eksekusi'
									)
						ELSE
							(SELECT
								IF(COUNT(b.pihak_id)>1,
									GROUP_CONCAT(CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pendidikan ',
									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', pekerjaan ',d.pekerjaan, ', tempat kediaman di ', d.alamat, ', Termohon Eksekusi ' ) SEPARATOR '; <br> ' ),

									CONCAT(d.nama, ', umur ',get_umur(d.tanggal_lahir,perkara_eksekusi_ht.permohonan_eksekusi),' tahun, agama ', e.nama, ', pekerjaan ',d.pekerjaan, ', pendidikan ',
									CASE WHEN d.pendidikan_id>1 THEN (SELECT nama from tingkat_pendidikan WHERE id=d.pendidikan_id) ELSE '' END, ', tempat kediaman di ', d.alamat, ', sebagai Termohon Eksekusi;' ))
									AS DATA
								FROM
									perkara_eksekusi_detil_ht b
									JOIN pihak d ON b.pihak_id = d.id
									JOIN agama e ON d.agama_id = e.id
								WHERE b.ht_id = perkara_eksekusi_ht.ht_id AND status_pihak_id=2)	
						END 
					 AS identitas_t	
			,nomor_urut_perkara_eksekusi		 
			,eksekusi_nomor_perkara AS nomor_register_eksekusi
			,permohonan_eksekusi AS tgl_daftar 
			,convert_tanggal_indonesia(permohonan_eksekusi) AS permohonan_eksekusi
			,jenis_ht_text
			,nomor_perkara_pn
			,convert_tanggal_indonesia(putusan_pn) AS putusan_pn
			,nomor_perkara_banding
			,convert_tanggal_indonesia(putusan_banding) AS putusan_banding
			,nomor_perkara_kasasi
			,convert_tanggal_indonesia(putusan_kasasi) AS putusan_kasasi
			,nomor_perkara_pk
			,convert_tanggal_indonesia(putusan_pk) AS putusan_pk
			,eksekusi_amar_putusan
			,convert_tanggal_indonesia(penetapan_teguran_eksekusi) AS penetapan_teguran_eksekusi
			,convert_tanggal_indonesia(pelaksanaan_teguran_eksekusi) AS pelaksanaan_teguran_eksekusi 
			,convert_tanggal_indonesia(pelaksanaan_eksekusi_rill) AS pelaksanaan_eksekusi_rill
			,'-' AS pendaftaran_sita 
			,'-' AS penetapan_sita_eksekusi 
			,'-' AS pelaksanaan_sita_eksekusi 
			,'-' AS penetapan_perintah_eksekusi_lelang
			,'-' AS pelaksanaan_eksekusi_lelang
			,'-' AS penyerahan_hasil_lelang
			,'-' AS permohonan_pengosongan
			,'-' AS penetapan_pengosongan
			,'-' AS pelaksanaan_pengosongan
			,convert_tanggal_indonesia(penetapan_perintah_eksekusi_lelang) AS penetapan_perintah_eksekusi_lelang_ht
			,convert_tanggal_indonesia(pelaksanaan_eksekusi_lelang) AS pelaksanaan_eksekusi_lelang_ht
			,'-' AS pendaftaran_sita_ht
			,convert_tanggal_indonesia(penetapan_perintah_eksekusi_lelang) AS penetapan_perintah_eksekusi_lelang_ht
			,convert_tanggal_indonesia(pelaksanaan_eksekusi_lelang) AS pelaksanaan_eksekusi_lelang_ht
			,convert_tanggal_indonesia(penyerahan_hasil_lelang) AS penyerahan_hasil_lelang_ht
			,'-' AS pengangkatan_sita

			FROM perkara_eksekusi_ht   

			ORDER BY tgl_daftar ASC, nomor_urut_perkara_eksekusi ASC
			";
		//	echo $sql;exit;
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$this
			->dbsipp
			->query('SET SESSION group_concat_max_len=100000');

		$q = $this
			->dbsipp
			->query($sql);
		return $q->result();
	}

	function get_data_mediasi()
	{
		$sql = "  (select 
				 	v.perkara_id AS perkara_id,
				 	v.mediasi_id AS mediasi_id,
				 	v.mediator_text AS mediator_text,
				 	p.nomor_perkara AS nomor_perkara,
				 	p.jenis_perkara_id AS jenis_perkara_id,
				 	p.jenis_perkara_nama AS jenis_perkara_nama,
				 	p.alur_perkara_id AS alur_perkara_id,
				 	put.tanggal_putusan AS tanggal_putusan,
				 	put.status_putusan_id AS status_putusan_id,
				 	v.penetapan_penunjukan_mediator AS penetapan_penunjukan_mediator,
				 	v.dimulai_mediasi AS dimulai_mediasi,
				 	v.keputusan_mediasi AS keputusan_mediasi,
				 	v.tgl_laporan_mediator AS tgl_laporan_mediator,
				 	v.hasil_mediasi AS hasil_mediasi,
				 	v.akta_perdamaian AS akta_perdamaian,
				 	dphk1.data_pihak1 AS data_pihak1,
				 	dphk2.data_pihak2 AS data_pihak2
				 	from 
 		((
 			(perkara_mediasi v left join perkara_jadwal_mediasi jm on(((v.mediasi_id = jm.mediasi_id) and (jm.urutan = 1)))) 
 		join perkara p on((v.perkara_id = p.perkara_id))) 

 		left join perkara_putusan put on((v.perkara_id = put.perkara_id))
 		LEFT JOIN (SELECT 
						pp1.perkara_id,GROUP_CONCAT(CONCAT('- ',CONCAT(phk.nama))SEPARATOR ',<br>') AS data_pihak1
										FROM perkara_pihak1 AS pp1
										LEFT JOIN pihak AS phk ON pp1.pihak_id=phk.id GROUP BY pp1.perkara_id
									) AS dphk1 ON dphk1.perkara_id=v.perkara_id
 		LEFT JOIN (SELECT 
						pp2.perkara_id,GROUP_CONCAT(CONCAT('- ',CONCAT(phk2.nama))SEPARATOR ',<br>') AS data_pihak2
										FROM perkara_pihak2 AS pp2
										LEFT JOIN pihak AS phk2 ON pp2.pihak_id=phk2.id GROUP BY pp2.perkara_id
									) AS dphk2 ON dphk2.perkara_id=v.perkara_id
 		))
				ORDER BY v.penetapan_penunjukan_mediator DESC
			";
		//	echo $sql;exit;
		$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$this
			->dbsipp
			->query('SET SESSION group_concat_max_len=100000');

		$q = $this
			->dbsipp
			->query($sql);
		return $q->result();
	}


	
	function get_data_register_induk_perkara($perpage,$begin,$search_text='',$alur_perkara_id,$filter)
	{
		if($search_text != '')
		{
			$pencarian="WHERE (convert_tanggal_indonesia(tanggal_pendaftaran)  like '%".$search_text."%' 
								OR
								upper(nomor_perkara) like '".strtoupper($search_text)."%' 
								OR  
								upper(para_pihak) like '%".strtoupper($search_text)."%' 
								OR  
								upper(jenis_perkara_nama)  like  '%".strtoupper($search_text)."%' 
								OR  
								upper(tahapan_terakhir_text) like '%".strtoupper($search_text)."%' 
								OR  
								upper(proses_terakhir_text) like '%".strtoupper($search_text)."%' ) AND $filter
								"; 
		}else
		{
			$pencarian=" WHERE $filter ";
		}
		$sql 	="SELECT 
					perkara_id,
			convert_tanggal_indonesia(tanggal_pendaftaran) AS tanggal_indonesia ,
			tanggal_pendaftaran,
			nomor_perkara,
			para_pihak,
			jenis_perkara_nama,
			tahapan_terakhir_text,
			nomor_urut_register,
			proses_terakhir_text
				FROM perkara  
				".$pencarian."

				ORDER by tanggal_pendaftaran DESC
						, nomor_urut_register DESC 
				LIMIT $perpage OFFSET $begin";
		//echo $sql;exit; 
				$this->dbsipp = $this->load	->database("dbsipp", true);
		$q = $this->dbsipp->query($sql);
		return $q->result();
	}
	function get_data_penyitaan($jenis_penyitaan_id,$perpage,$begin,$search_text='')
	{
		if($search_text != '')
		{
			$pencarian="WHERE (
								upper(nomor_perkara) like '".strtoupper($search_text)."%' 
								OR  
								upper(nama_para_pihak) like '%".strtoupper($search_text)."%' 
								OR  
								upper(penyimpan_barang_sitaan)  like  '%".strtoupper($search_text)."%' 
								OR  
								upper(nama_js) like '%".strtoupper($search_text)."%' )
								AND jenis_penyitaan_id=$jenis_penyitaan_id
								"; 
		}else
		{
			$pencarian=" WHERE jenis_penyitaan_id=$jenis_penyitaan_id ";
		}
		$sql 	="SELECT *
					,REPLACE(nama_para_pihak,'\\r','<br>') AS namaparapihak
					,DATE_FORMAT(tanggal_penetapan_sita,'%d-%m-%Y') AS tanggalpenetapansita
					,DATE_FORMAT(tanggal_pelaksanaan_sita,'%d-%m-%Y') AS tanggalpelaksanaansita
					,DATE_FORMAT(tanggal_pendaftaran_penyitaan,'%d-%m-%Y') AS tanggalpendaftaranpenyitaan
				FROM register_penyitaan  
				".$pencarian."

				ORDER by tanggal_penetapan_sita DESC
						, nomor_urut DESC 
				LIMIT $perpage OFFSET $begin";
		//echo $sql;exit; 
		
		$q = $this->db->query($sql);
		return $q->result();
	}
	

	function get_jumlah_penyitaan($jenis_penyitaan_id, $search_text='')
	{
		if($search_text != '')
		{
			$pencarian="WHERE (
								upper(nomor_perkara) like '".strtoupper($search_text)."%' 
								OR  
								upper(nama_para_pihak) like '%".strtoupper($search_text)."%' 
								OR  
								upper(penyimpan_barang_sitaan)  like  '%".strtoupper($search_text)."%' 
								OR  
								upper(nama_js) like '%".strtoupper($search_text)."%' )
								AND jenis_penyitaan_id=$jenis_penyitaan_id
								"; 
		}else
		{
			$pencarian=" WHERE  jenis_penyitaan_id =$jenis_penyitaan_id";
		}
		$sql 	="SELECT id
				FROM register_penyitaan 

				".$pencarian;
		//echo $sql;exit;
 		
		$q = $this->db->query($sql);
		return $q->num_rows();	
 	}	
	function get_data_register_induk_perkara_upaya_hukum($perpage,$begin,$search_text='',$alur_perkara_id,$filter,$tabel)
	{
		if($tabel=="banding")
		{
			$kembali="kembali_";
		}else
		{
			$kembali="";
		}
		if($search_text != '')
		{
			$pencarian="WHERE (convert_tanggal_indonesia(permohonan_".$tabel.")  like '%".$search_text."%' 
								OR
								convert_tanggal_indonesia(pengiriman_berkas_".$tabel.")  like '%".$search_text."%' 
								OR
								convert_tanggal_indonesia(penerimaan_".$kembali."berkas_".$tabel.")  like '%".$search_text."%' 
								OR
								upper(status_".$tabel."_text) like '%".strtoupper($search_text)."%' 
								OR
								upper(pemohon_".$tabel.") like '%".strtoupper($search_text)."%' 
								OR
								upper(nomor_perkara_".$tabel.") like '".strtoupper($search_text)."%' 
								OR
								upper(nomor_perkara_pn) like '".strtoupper($search_text)."%'  ) AND $filter
								"; 
		}else
		{
			$pencarian=" WHERE $filter ";
		}
		$sql 	="SELECT 
					perkara_id,
					CONCAT(convert_tanggal_indonesia(permohonan_".$tabel."),'<br>',pemohon_".$tabel.") AS tanggal_indonesia ,
				permohonan_".$tabel." AS daftar,
				nomor_perkara_pn AS nomor_perkara,
				convert_tanggal_indonesia(pengiriman_berkas_".$tabel.") AS pengiriman_berkas,
				convert_tanggal_indonesia(penerimaan_".$kembali."berkas_".$tabel.") as penerimaan_kembali,
				convert_tanggal_indonesia(pemberitahuan_putusan_".$tabel.") AS pemberitahuan_putusan,
				status_".$tabel."_text AS status,
				convert_tanggal_indonesia(putusan_".$tabel.") AS putus,
				nomor_perkara_banding as nomor_upaya_hukum
				FROM perkara_".$tabel."  
				".$pencarian."

				ORDER by permohonan_".$tabel." DESC 
				LIMIT $perpage OFFSET $begin";
		//echo $sql;exit; 
				$this->dbsipp = $this->load	->database("dbsipp", true);
		$q = $this->dbsipp->query($sql);
		return $q->result();
	}
	///register akta cerai
	function get_data_barang_bukti($perpage,$begin,$search_text='')
	{
		if($search_text != '')
		{
			$pencarian=" WHERE convert_tanggal_indonesia(tanggal_penerimaan) like '%".$search_text."%' 
								OR
								nomor_perkara like '".$search_text."%' 
								OR
								jenis_barang_bukti like '%".$search_text."%' 
								OR
								tempat_penyimpanan like '%".$search_text."%' 
								OR
								tempat_penyerahan like '%".$search_text."%' 
								OR  
								nama_penerima like '".$search_text."%'
								 
								"; 
		}else
		{
			$pencarian=" ";
		}
		$sql 	="SELECT 
					*
					,convert_tanggal_indonesia(tanggal_penerimaan) as tanggalpenerimaan
					,convert_tanggal_indonesia(tanggal_penyerahan) as tanggalpenyerahan
					,(
						SELECT 
							CASE WHEN count(id)=1 THEN nama 
						ELSE
							group_concat(concat('- ',nama) SEPARATOR '<br>' )
						END  
						FROM perkara_pihak1 WHERE perkara_id=perkara_barang_bukti.perkara_id ORDER by urutan ASC
					 ) AS nama_terdakwa 
				FROM perkara_barang_bukti 

				".$pencarian."

				ORDER by tanggal_penerimaan DESC, id DESC
				LIMIT $perpage OFFSET $begin";
		//echo $sql;exit;
 		$this->dbsipp = $this->load	->database("dbsipp", true);
		$q = $this->dbsipp->query($sql);
		return $q->result();
	}

	function get_jumlah_bb($search_text='')
	{
		if($search_text != '')
		{
			$pencarian=" WHERE convert_tanggal_indonesia(tanggal_penerimaan) like '%".$search_text."%' 
								OR
								nomor_perkara like '".$search_text."%' 
								OR
								jenis_barang_bukti like '%".$search_text."%' 
								OR
								tempat_penyimpanan like '%".$search_text."%' 
								OR
								tempat_penyerahan like '%".$search_text."%' 
								OR  
								nama_penerima like '".$search_text."%'
								"; 
		}else
		{
			$pencarian=" ";
		}
		$sql 	="SELECT id
				FROM perkara_barang_bukti 

				".$pencarian;
		//echo $sql;exit;
 		$this->dbsipp = $this->load	->database("dbsipp", true);
		$q = $this->dbsipp->query($sql);
		return $q->num_rows();	
 	}		
	///register akta cerai
	function get_data_aktacerai($perpage,$begin,$search_text='')
	{
		if($search_text != '')
		{
			$pencarian=" WHERE (convert_tanggal_indonesia(tgl_akta_cerai) like '%".$search_text."%' 
								OR
								nomor_perkara like '".$search_text."%' 
								OR
								pihak1_text like '".$search_text."%' 
								OR
								pihak2_text like '".$search_text."%' 
								OR
								no_seri_akta_cerai like '%".$search_text."%' 
								OR  
								nomor_akta_cerai like '".$search_text."%'
								) AND nomor_akta_cerai IS NOT NULL
								"; 
		}else
		{
			$pencarian=" WHERE  nomor_akta_cerai IS NOT NULL";
		}
		$sql 	="SELECT 
					perkara_akta_cerai.*
					,pihak1_text
					,pihak2_text
					,nomor_perkara
					,convert_tanggal_indonesia(tgl_akta_cerai) as tanggalaktacerai
					,convert_tanggal_indonesia(tanggal_putusan) as tanggalputusan
					,convert_tanggal_indonesia(tanggal_bht) as tanggalbht
					,convert_tanggal_indonesia(tgl_ikrar_talak) as tglikrartalak
					,DATE_FORMAT(tgl_penyerahan_akta_cerai,'%d-%m-%Y') as penyerahan_p
					,DATE_FORMAT(tgl_penyerahan_akta_cerai_pihak2,'%d-%m-%Y') as penyerahan_t
					,CASE WHEN jenis_perkara_id=347 THEN convert_tanggal_indonesia(tanggal_bht) ELSE convert_tanggal_indonesia(tgl_ikrar_talak) END AS bht_ikrar
				FROM perkara_akta_cerai 
				LEFT JOIN perkara ON perkara.perkara_id=perkara_akta_cerai.perkara_id
				LEFT JOIN perkara_putusan ON perkara_putusan.perkara_id=perkara_akta_cerai.perkara_id
				LEFT JOIN perkara_ikrar_talak ON perkara_ikrar_talak.perkara_id=perkara_akta_cerai.perkara_id

				".$pencarian."

				ORDER by tahun_akta_cerai DESC
						, nomor_urut_akta_cerai DESC 
				LIMIT $perpage OFFSET $begin";
		//echo $sql;exit;
 		$this->dbsipp = $this->load	->database("dbsipp", true);
		$q = $this->dbsipp->query($sql);
		return $q->result();
	}	
	function get_jumlah_aktacerai($search_text='')
	{
		if($search_text != '')
		{
			$pencarian=" WHERE (convert_tanggal_indonesia(tgl_akta_cerai) like '%".$search_text."%' 
								OR
								nomor_perkara like '".$search_text."%' 
								OR
								pihak1_text like '".$search_text."%' 
								OR
								pihak2_text like '".$search_text."%' 
								OR
								no_seri_akta_cerai like '%".$search_text."%' 
								OR  
								nomor_akta_cerai like '".$search_text."%'
								) AND nomor_akta_cerai IS NOT NULL
								"; 
		}else
		{
			$pencarian=" WHERE  nomor_akta_cerai IS NOT NULL";
		}
		$sql 	="SELECT perkara_akta_cerai.perkara_id
				FROM perkara_akta_cerai 
				LEFT JOIN perkara ON perkara.perkara_id=perkara_akta_cerai.perkara_id
				LEFT JOIN perkara_putusan ON perkara_putusan.perkara_id=perkara_akta_cerai.perkara_id
				LEFT JOIN perkara_ikrar_talak ON perkara_ikrar_talak.perkara_id=perkara_akta_cerai.perkara_id

				".$pencarian;
		//echo $sql;exit;
 		$this->dbsipp = $this->load	->database("dbsipp", true);
		$q = $this->dbsipp->query($sql);
		return $q->num_rows();	
 	}	
	function get_data_izin_penyitaan($perpage,$begin,$search_text='')
	{
		if($search_text != '')
		{
			$pencarian=" WHERE  convert_tanggal_indonesia(a.tanggal_penerimaan_permohonan) like '%".$search_text."%' 
								OR
								convert_tanggal_indonesia(a.tanggal_surat_permohonan) like '%".$search_text."%' 
								OR  
								a.nomor_surat_permohonan like '%".$search_text."%' 
								OR  
								a.penyidik_yang_memohon_izin like '%".$search_text."%' 
								OR  
								a.nama_intansi_yang_melakukan_penyitaan like '%".$search_text."%' 
								OR  
								convert_tanggal_indonesia(a.tanggal_surat_ijin_persetujuan) like '%".$search_text."%' 
								OR  
								a.nomor_surat_ijin_persetujuan like '%".$search_text."%' 
								OR  
								a.nama_tersangka like '%".$search_text."%' 
								"; 
		}else
		{
			$pencarian="";
		}
		$sql 	="SELECT 
					a.izin_penyitaan_id
					,a.no_urut
					,convert_tanggal_indonesia(a.tanggal_penerimaan_permohonan) AS tanggalpenerimaanpermohonan
					,convert_tanggal_indonesia(a.tanggal_surat_permohonan) AS tanggalsuratpermohonan
					,a.nomor_surat_permohonan
					,a.penyidik_yang_memohon_izin

					,a.nama_intansi_yang_melakukan_penyitaan
					,convert_tanggal_indonesia(a.tanggal_surat_ijin_persetujuan) AS tanggalsuratijinpersetujuan
					,a.nomor_surat_ijin_persetujuan
					,a.barang_yang_dimohonkan_izin_penyitaan
					,a.barang_yang_diberikan_izin_penyitaan
					,a.laporan_hasil_penyitaan
					,a.nama_tersangka 
				FROM register_izin_penyitaan_jinazat AS a
				".$pencarian."

				ORDER by a.tanggal_penerimaan_permohonan DESC
						, a.izin_penyitaan_id DESC 
				LIMIT $perpage OFFSET $begin";
		//echo $sql;exit;
		$this->db->query('SET SESSION group_concat_max_len=100000');
		$q = $this->db->query($sql);
		return $q->result();
	}	
	function get_data_izin_penyitaan_detail($izin_penyitaan_id)
	{
		$sql 	="SELECT a.*
				FROM register_izin_penyitaan_jinazat AS a
				WHERE a.izin_penyitaan_id=$izin_penyitaan_id";
		//echo $sql;exit;
		$this->db->query('SET SESSION group_concat_max_len=100000');
		$q = $this->db->query($sql);
		return $q->result();
	}	
	function get_data_izin_penyitaan_detail_tersangka($izin_penyitaan_id)
	{
		$sql 	="SELECT a.*
				FROM register_pihak_izin_penyitaan AS a
				WHERE a.izin_penyitaan_id=$izin_penyitaan_id ORDER by a.urutan ASC ";
		//echo $sql;exit;
		$this->db->query('SET SESSION group_concat_max_len=100000');
		$q = $this->db->query($sql);
		return $q->result();
	}	
	function get_nomor_urutan_data_izin_penyitaan($tahun)
	{
		$sql 	="SELECT no_urut FROM register_izin_penyitaan_jinazat WHERE LEFT(tanggal_surat_permohonan,4)=$tahun ORDER by no_urut DESC limit 1";
		//echo $sql;exit;
		$q = $this->db->query($sql);
		return $q->result();
	}	
	function get_data_pihak()
	{
		$sql 	="SELECT 
							a.*
							,convert_tanggal_indonesia(a.tanggal_lahir) AS tanggallahir
							,case when a.jenis_kelamin='L' then 'Laki-laki' else 'Perempuan' END AS kelamin
				FROM pihak AS a ORDER by a.id DESC LIMIT 50";
				$this->dbsipp = $this
			->load
			->database("dbsipp", true);
		$q = $this->dbsipp->query($sql);
		return $q->result();
	}
	function get_info_pihak($id)
	{
		
		$sql 	="SELECT 
							a.jenis_pihak_id
							,case when a.jenis_pihak_id=1 then 'Perorangan' when a.jenis_pihak_id=2 then 'Pemerintah' when a.jenis_pihak_id=3 then 'Badan Hukum'  else 'Lainnya' END AS jenis_pihak
							,a.nama
							,a.tempat_lahir
							,a.tanggal_lahir
							,convert_tanggal_indonesia(a.tanggal_lahir) AS tanggallahir
							,a.nomor_indentitas
							,get_umur(a.tanggal_lahir,NOW()) as umur
							,case when a.jenis_kelamin='L' then 'Laki-laki' else 'Perempuan' END AS jenis_kelamin
							,b.nama AS warga_negara
							,d.nama AS agama
							,a.pekerjaan
							,a.alamat
							,a.status_kawin
							,(SELECT nama from tingkat_pendidikan where id=a.pendidikan_id) as pendidikan
							,case when a.difabel='Y' then 'Ya' else 'Tidak' END AS difabel
							,case when a.status_kawin=1 then 'Kawin' when a.status_kawin=2 then 'Tidak Kawin' when a.status_kawin=3 then 'Duda'  when a.status_kawin=4 then 'Janda'    else '' END AS status_kawin

				FROM  pihak AS a 
				LEFT JOIN  negara AS b ON b.id=a.warga_negara_id
				LEFT JOIN  agama AS d ON d.id=a.agama_id
				 

				WHERE a.id=$id";
		//return $sql;exit;
			$this->dbsipp = $this->load->database("dbsipp", true);
		$q = $this->dbsipp->query($sql);
		return $q->result();
	}
	function cek_nama_tersangka($izin_penyitaan_id)
	{
			$sql 	="select case when count(id)>1 then GROUP_CONCAT(CONCAT('-',nama) separator '<br>') else nama END as nama from register_pihak_izin_penyitaan where izin_penyitaan_id=$izin_penyitaan_id";
		//return $sql;exit;
		$q = $this->db->query($sql);
		return $q->result();

	}
	///register izin penyitaan jinazat
}

