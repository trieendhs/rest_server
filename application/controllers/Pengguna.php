<?php
	
	require APPPATH . '/libraries/REST_Controller.php';

	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class User extends REST_Controller {
	
		// show data pembelian
		function index_get() {
			$get_user= $this->db->query("select * from user")->result();

			// $get_transaksi = $this->db->query("select pemb.id_pembelian, pemb.id_pembeli,
			// pemb.tanggal_beli,pemb. total_harga, pemb.id_tiket from pembeli, pembelian pemb, tiket Where
			// pemb.id_pembeli=pembeli.id_pembeli and pemb.id_tiket=tiket.id_tiket")->result();

			$this->response(array("status"=>"success","result" => $get_user));
		}

		// insert pembelian
		function index_post() 
		{
			$data_user = array(
				'id' => $this->post('id'),
				'username' => $this->post('username'),
				'nama' => $this->post('nama'),
				'password' => $this->post('password'),
				'status_user' => $this->post('status_user')
			);
			if (empty($data_user['id']))
			{
				$this->response(array('status'=>'fail',"message"=>"ID User kosong"));
			}else 
			{
				$getId = $this->db->query("select id from user where
				id ='".$data_user['id']."'")->result();

				//jika id_pembelian tidak ada dalam database maka eksekusi insert
				if (empty($getId))
				{
					if (empty($data_user['id']))
					{
						$this->response(array('status'=>'fail',"message"=>"ID user kosong"));
					}
					else if(empty($data_user['username']))
					{
						$this->response(array('status'=>'fail',"message"=>"Username kosong"));
					}
					else if(empty($data_user['nama']))
					{
						$this->response(array('status'=>'fail',"message"=>"Nama kosong"));
					}
					else if(empty($data_user['password']))
					{
						$this->response(array('status'=>'fail',"message"=>"Password kosong"));
					}
					else if(empty($data_user['status_user']))
					{
						$this->response(array('status'=>'fail',"message"=>"Status user kosong"));
					}
					else
					{
						//jika masuk pada else atau kondisi ini maka dipastikan seluruh input telah di set
						//jika akan melakukan pembelian id_pembeli dan id_tiket harus dipastikan ada
						// $getIdKategori = $this->db->query("select id from kategori Where
						// id ='".$data_pariwisata['id_kategori']."'")->result();
						// $getIdTiket = $this->db->query("Select id_tiket from tiket Where
						// id_tiket='".$data_pembelian['id_tiket']."'")->result();
						$message="";
						// if (empty($getIdPembeli)) $message.="id_pembeli tidak ada/salah ";
						// if (empty($getIdKategori)) 
						// {
						// 	if (empty($message)) 
						// 	{
						// 		$message.="id_kategori tidak ada/salah";
						// 	}
						// 	else 
						// 	{
						// 		$message.="dan id_kategori tidak ada/salah";
						// 	}
						// }
						if (empty($message))
						{
							$insert= $this->db->insert('user',$data_user);
							if ($insert)
							{
								$this->response(array('status'=>'success','result' =>
								$data_user,"message"=>$insert));
							}
						}else
						{
							$this->response(array('status'=>'fail',"message"=>$message));
						}
					}
				}else
				{
					$this->response(array('status'=>'fail',"message"=>"id_user sudah ada"));
				}
			}
		}

		// update data pembelian
		function index_put() 
		{
			$data_user = array(
				'id' => $this->put('id'),
				'username' => $this->put('username'),
				'nama' => $this->put('nama'),
				'password' => $this->put('password'),
				'status_user' => $this->put('status_user')
			);
			if (empty($data_user['id']))
			{
				$this->response(array('status'=>'fail',"message"=>"id_user kosong"));
			}else
			{
				$getId = $this->db->query("Select id from user where
				id ='".$data_user['id']."'")->result();
				//jika id_pembelian harus ada dalam database
				if (empty($getId))
				{
					$this->response(array('status'=>'fail',"message"=>"id_user tidak ada/salah"));
				}else
				{
					//jika masuk disini maka dipastikan id_pembelian ada dalam database
					if(empty($data_user['username']))
					{
						$this->response(array('status'=>'fail',"message"=>"Username kosong"));
					}
					else if(empty($data_user['nama']))
					{
						$this->response(array('status'=>'fail',"message"=>"Nama kosong"));
					}
					else if(empty($data_user['password']))
					{
						$this->response(array('status'=>'fail',"message"=>"Password kosong"));
					}
					else if(empty($data_user['status_user']))
					{
						$this->response(array('status'=>'fail',"message"=>"Status user kosong"));
					}
					// else if(empty($data_pariwisata['nama']))
					// {
					// 	$this->response(array('status'=>'fail',"message"=>"Nama pariwisata kosong"));
					// }
					// else if(empty($data_pariwisata['deskripsi']))
					// {
					// 	$this->response(array('status'=>'fail',"message"=>"Deskripsi pariwisata kosong"));
					// }
					// else if(empty($data_pariwisata['lokasi']))
					// {
					// 	$this->response(array('status'=>'fail',"message"=>"Lokasi pariwisata kosong"));
					// }
					// else if(empty($data_pariwisata['tiket']))
					// {
					// 	$this->response(array('status'=>'fail',"message"=>"Tiket pariwisata kosong"));
					// }
					else
					{
						//jika masuk pada else atau kondisi ini maka dipastikan seluruh input telah di set
						//jika akan melakukan edit pembelian id_pembeli dan id_tiket harus dipastikan ada
						// $getIdKategori = $this->db->query("Select id from kategori Where
						// id ='".$data_pariwisata['id_kategori']."'")->result();
						// $getIdTiket = $this->db->query("Select id_tiket from tiket Where
						// id_tiket='".$data_pembelian['id_tiket']."'")->result();
						$message="";
						// if (empty($getIdPembeli)) $message.="id_pembeli tidak ada/salah ";
						// if (empty($getIdKategori)) 
						// {
						// 	if (empty($message)) 
						// 	{
						// 		$message.="id_kategori tidak ada/salah";
						// 	}
						// 	else 
						// 	{
						// 		$message.="dan id_kategori tidak ada/salah";
						// 	}
						// }
						if (empty($message))
						{
							$this->db->where('id',$data_user['id']);
							$update= $this->db->update('user',$data_user);
							if ($update)
							{
								$this->response(array('status'=>'success','result' =>
								$data_user,"message"=>$update));
							}
						}else
						{
							$this->response(array('status'=>'fail',"message"=>$message));
						}
					}
				}
			}
		}

		// delete pembelian
		function index_delete() 
		{
			$id_user = $this->delete('id');
			if (empty($id_user))
			{
				$this->response(array('status' => 'fail', "message"=>"id_user harus diisi"));
			}else
			{
				$this->db->where('id', $id_user);
				$delete = $this->db->delete('user');
				if ($this->db->affected_rows()) 
				{
					$this->response(array('status' => 'success','message' =>"Berhasil delete dengan id_user = ".$id_user));
				} else
				{
					$this->response(array('status' => 'fail', 'message' =>"id_user tidak dalam database"));
				}
			}
		}
	
	}
	
	/* End of file User.php */
	/* Location: ./application/controllers/User.php */
?>