<?php
	
	require APPPATH . '/libraries/REST_Controller.php';

	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Pariwisata extends REST_Controller {
	
		// show data pembelian
		function index_get() {
			$get_pariwisata = $this->db->query("select a.*,b.jenis from pariwisata as a join kategori as b on a.id_kategori=b.id")->result();

			// $get_transaksi = $this->db->query("select pemb.id_pembelian, pemb.id_pembeli,
			// pemb.tanggal_beli,pemb. total_harga, pemb.id_tiket from pembeli, pembelian pemb, tiket Where
			// pemb.id_pembeli=pembeli.id_pembeli and pemb.id_tiket=tiket.id_tiket")->result();

			$this->response(array("status"=>"success","result" => $get_pariwisata));
		}

		// insert pembelian
		function index_post() 
		{
			$data_pariwisata = array(
				'id' => $this->post('id'),
				'id_kategori' => $this->post('id_kategori'),
				'nama' => $this->post('nama'),
				'lokasi' => $this->post('lokasi'),
				'deskripsi' => $this->post('deskripsi'),
				'tiket' => $this->post('tiket')
			);
			if (empty($data_pariwisata['id']))
			{
				$this->response(array('status'=>'fail',"message"=>"ID Pariwisata kosong"));
			}else 
			{
				$getId = $this->db->query("select id from pariwisata where
				id ='".$data_pariwisata['id']."'")->result();

				//jika id_pembelian tidak ada dalam database maka eksekusi insert
				if (empty($getId))
				{
					if (empty($data_pariwisata['id']))
					{
						$this->response(array('status'=>'fail',"message"=>"ID Pariwisata kosong"));
					}
					else if(empty($data_pariwisata['nama']))
					{
						$this->response(array('status'=>'fail',"message"=>"Nama Pariwisata kosong"));
					}
					else if(empty($data_pariwisata['lokasi']))
					{
						$this->response(array('status'=>'fail',"message"=>"Lokasi kosong"));
					}
					else if(empty($data_pariwisata['tiket']))
					{
						$this->response(array('status'=>'fail',"message"=>"Harga tiket kosong"));
					}
					else if(empty($data_pariwisata['id_kategori']))
					{
						$this->response(array('status'=>'fail',"message"=>"Kategori pariwisata kosong"));
					}
					else if(empty($data_pariwisata['deskripsi']))
					{
						$this->response(array('status'=>'fail',"message"=>"Deskripsi pariwisata kosong"));
					}
					else
					{
						//jika masuk pada else atau kondisi ini maka dipastikan seluruh input telah di set
						//jika akan melakukan pembelian id_pembeli dan id_tiket harus dipastikan ada
						$getIdKategori = $this->db->query("select id from kategori Where
						id ='".$data_pariwisata['id_kategori']."'")->result();
						// $getIdTiket = $this->db->query("Select id_tiket from tiket Where
						// id_tiket='".$data_pembelian['id_tiket']."'")->result();
						$message="";
						// if (empty($getIdPembeli)) $message.="id_pembeli tidak ada/salah ";
						if (empty($getIdKategori)) 
						{
							if (empty($message)) 
							{
								$message.="id_kategori tidak ada/salah";
							}
							else 
							{
								$message.="dan id_kategori tidak ada/salah";
							}
						}
						if (empty($message))
						{
							$insert= $this->db->insert('pariwisata',$data_pariwisata);
							if ($insert)
							{
								$this->response(array('status'=>'success','result' =>
								$data_pariwisata,"message"=>$insert));
							}
						}else
						{
							$this->response(array('status'=>'fail',"message"=>$message));
						}
					}
				}else
				{
					$this->response(array('status'=>'fail',"message"=>"id_pariwisata sudah ada"));
				}
			}
		}

		// update data pembelian
		function index_put() 
		{
			$data_pariwisata = array(
				'id' => $this->put('id'),
				'id_kategori' => $this->put('id_kategori'),
				'nama' => $this->put('nama'),
				'deskripsi' => $this->put('deskripsi'),
				'tiket' => $this->put('tiket'),
				'lokasi' => $this->put('lokasi')
			);
			if (empty($data_pariwisata['id']))
			{
				$this->response(array('status'=>'fail',"message"=>"id_pariwisata kosong"));
			}else
			{
				$getId = $this->db->query("Select id from pariwisata where
				id ='".$data_pariwisata['id']."'")->result();
				//jika id_pembelian harus ada dalam database
				if (empty($getId))
				{
					$this->response(array('status'=>'fail',"message"=>"id_pariwisata tidak ada/salah"));
				}else
				{
					//jika masuk disini maka dipastikan id_pembelian ada dalam database
					if (empty($data_pariwisata['id_kategori']))
					{
						$this->response(array('status'=>'fail',"message"=>"id_kategori kosong"));
					}
					else if(empty($data_pariwisata['nama']))
					{
						$this->response(array('status'=>'fail',"message"=>"Nama pariwisata kosong"));
					}
					else if(empty($data_pariwisata['deskripsi']))
					{
						$this->response(array('status'=>'fail',"message"=>"Deskripsi pariwisata kosong"));
					}
					else if(empty($data_pariwisata['lokasi']))
					{
						$this->response(array('status'=>'fail',"message"=>"Lokasi pariwisata kosong"));
					}
					else if(empty($data_pariwisata['tiket']))
					{
						$this->response(array('status'=>'fail',"message"=>"Tiket pariwisata kosong"));
					}
					else
					{
						//jika masuk pada else atau kondisi ini maka dipastikan seluruh input telah di set
						//jika akan melakukan edit pembelian id_pembeli dan id_tiket harus dipastikan ada
						$getIdKategori = $this->db->query("Select id from kategori Where
						id ='".$data_pariwisata['id_kategori']."'")->result();
						// $getIdTiket = $this->db->query("Select id_tiket from tiket Where
						// id_tiket='".$data_pembelian['id_tiket']."'")->result();
						$message="";
						// if (empty($getIdPembeli)) $message.="id_pembeli tidak ada/salah ";
						if (empty($getIdKategori)) 
						{
							if (empty($message)) 
							{
								$message.="id_kategori tidak ada/salah";
							}
							else 
							{
								$message.="dan id_kategori tidak ada/salah";
							}
						}
						if (empty($message))
						{
							$this->db->where('id',$data_pariwisata['id']);
							$update= $this->db->update('pariwisata',$data_pariwisata);
							if ($update)
							{
								$this->response(array('status'=>'success','result' =>
								$data_pariwisata,"message"=>$update));
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
			$id_pariwisata = $this->delete('id');
			if (empty($id_pariwisata))
			{
				$this->response(array('status' => 'fail', "message"=>"id_pariwisata harus diisi"));
			}else
			{
				$this->db->where('id', $id_pariwisata);
				$delete = $this->db->delete('pariwisata');
				if ($this->db->affected_rows()) 
				{
					$this->response(array('status' => 'success','message' =>"Berhasil delete dengan id_pariwisata = ".$id_pariwisata));
				} else
				{
					$this->response(array('status' => 'fail', 'message' =>"id_pariwisata tidak dalam database"));
				}
			}
		}

	
	}
	
	/* End of file Pembelian.php */
	/* Location: ./application/controllers/Pembelian.php */
?>