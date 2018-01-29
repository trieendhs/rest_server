<?php
	
	require APPPATH . '/libraries/REST_Controller.php';

	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Kategori extends REST_Controller {
	
		// show data pembelian
		function index_get() {
			$get_kategori = $this->db->query("select * from kategori")->result();

			// $get_transaksi = $this->db->query("select pemb.id_pembelian, pemb.id_pembeli,
			// pemb.tanggal_beli,pemb. total_harga, pemb.id_tiket from pembeli, pembelian pemb, tiket Where
			// pemb.id_pembeli=pembeli.id_pembeli and pemb.id_tiket=tiket.id_tiket")->result();

			$this->response(array("status"=>"success","result" => $get_kategori));
		}

		// insert pembelian
		function index_post() 
		{
			$data_kategori = array(
				'id' => $this->post('id'),
				'jenis' => $this->post('jenis')
			);
			if (empty($data_kategori['id']))
			{
				$this->response(array('status'=>'fail',"message"=>"ID Kategori kosong"));
			}else 
			{
				$getId = $this->db->query("select id from kategori where
				id ='".$data_kategori['id']."'")->result();

				//jika id_pembelian tidak ada dalam database maka eksekusi insert
				if (empty($getId))
				{
					if (empty($data_kategori['id']))
					{
						$this->response(array('status'=>'fail',"message"=>"ID kategori kosong"));
					}
					else if(empty($data_kategori['jenis']))
					{
						$this->response(array('status'=>'fail',"message"=>"Jenis kategori kosong"));
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
							$insert= $this->db->insert('kategori',$data_kategori);
							if ($insert)
							{
								$this->response(array('status'=>'success','result' =>
								$data_kategori,"message"=>$insert));
							}
						}else
						{
							$this->response(array('status'=>'fail',"message"=>$message));
						}
					}
				}else
				{
					$this->response(array('status'=>'fail',"message"=>"id_kategori sudah ada"));
				}
			}
		}

		// update data pembelian
		function index_put() 
		{
			$data_kategori = array(
				'id' => $this->put('id'),
				'jenis' => $this->put('jenis')
			);
			if (empty($data_kategori['id']))
			{
				$this->response(array('status'=>'fail',"message"=>"id_kategori kosong"));
			}else
			{
				$getId = $this->db->query("Select id from kategori where
				id ='".$data_kategori['id']."'")->result();
				//jika id_pembelian harus ada dalam database
				if (empty($getId))
				{
					$this->response(array('status'=>'fail',"message"=>"id_kategori tidak ada/salah"));
				}else
				{
					//jika masuk disini maka dipastikan id_pembelian ada dalam database
					if (empty($data_kategori['jenis']))
					{
						$this->response(array('status'=>'fail',"message"=>"jenis kosong"));
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
							$this->db->where('id',$data_kategori['id']);
							$update= $this->db->update('kategori',$data_kategori);
							if ($update)
							{
								$this->response(array('status'=>'success','result' =>
								$data_kategori,"message"=>$update));
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
			$id_kategori = $this->delete('id');
			if (empty($id_kategori))
			{
				$this->response(array('status' => 'fail', "message"=>"id_kategori harus diisi"));
			}else
			{
				$this->db->where('id', $id_kategori);
				$delete = $this->db->delete('kategori');
				if ($this->db->affected_rows()) 
				{
					$this->response(array('status' => 'success','message' =>"Berhasil delete dengan id_kategori = ".$id_kategori));
				} else
				{
					$this->response(array('status' => 'fail', 'message' =>"id_kategori tidak dalam database"));
				}
			}
		}

	
	}
	
	/* End of file Kategori.php */
	/* Location: ./application/controllers/Kategori.php */
?>