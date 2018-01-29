<?php

	require APPPATH . '/libraries/REST_Controller.php';
	
	class User extends REST_Controller {
	
		//$this->response(array("status"=>"success","result" => $get_pembeli));
		//$this->response(array("status"=>"success"));
		function __construct($config = 'rest'){
			parent::__construct($config);
			$this->load->database();
		}
		
		function index_get()
		{
			$get_user = $this->db->query("SELECT * FROM user")->result();
			$this->response(array("status"=>"success","result" => $get_user));
		}
		function index_post() 
		{
			$action = $this->post('action');
			$data_user = array(
			'id_user' => $this->post('id_user'),
			'username' => $this->post('username'),
			'nama' => $this->post('nama'),
			'password' => $this->post('password'),
			'status_user' => $this->post('status_user'),
			'photo_id' => $this->post('photo_id')
			);
			if ($action==='post')
			{
				$this->insertUser($data_user);
			}else if ($action==='put')
			{
				$this->updateUser($data_user);
			}else if ($action==='delete')
			{
				$this->deleteUser($data_user);
			}else
			{
				$this->response(array("status"=>"failed","message" => "action harus diisi"));
			}
		}

		function insertUser($data_user)
		{
			//function upload image
			$uploaddir = str_replace("application/", "", APPPATH).'upload/';
			if(!file_exists($uploaddir) && !is_dir($uploaddir)) 
			{
				echo mkdir($uploaddir, 0750, true);
			}
			if (!empty($_FILES))
			{
				$path = $_FILES['photo_id']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				// $user_img = time() . rand() . '.' . $ext;
				$user_img = $data_user['id_user']. '.' . "png";
				$uploadfile = $uploaddir . $user_img;
				$data_user['photo_id'] = "upload/".$user_img;
			}else
			{
				$data_user['photo_id']="";
			}
			//////////////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////
			//cek validasi
			if (empty($data_user['id_user']))
			{
				$this->response(array('status' => "failed", "message"=>"ID User harus
				diisi"));
			}else if (empty($data_user['nama']))
			{
				$this->response(array('status' => "failed", "message"=>"nama harus
				diisi"));
			}
			else if (empty($data_user['username']))
			{
				$this->response(array('status' => "failed", "message"=>"username harus
				diisi"));
			}else if (empty($data_user['password']))
			{
				$this->response(array('status' => "failed", "message"=>"password harus
				diisi"));
				}else if (empty($data_user['status_user']))
			{
				$this->response(array('status' => "failed", "message"=>"status user harus
				diisi"));
			}
			else
			{
				$get_user_baseid = $this->db->query("SELECT * FROM user WHERE id_user='".$data_user['id_user']."'")->result();
				if(empty($get_user_baseid))
				{
					$insert= $this->db->insert('user',$data_user);
					if (!empty($_FILES))
					{
						if ($_FILES["photo_id"]["name"]) 
						{
							if(move_uploaded_file($_FILES["photo_id"]["tmp_name"],$uploadfile))
							{
								$insert_image = "success";
							} else
							{
								$insert_image = "failed";
							}
						}else
						{
							$insert_image = "Image Tidak ada Masukan";
						}

						$data_user['photo_id'] = base_url()."upload/".$user_img;

					}else{
						$data_user['photo_id'] = "";
					}
					if ($insert)
					{
						$this->response(array('status'=>'success','result' => array($data_user),"message"=>$insert));
					}
				}else
				{
					$this->response(array('status' => "failed", "message"=>"ID User
					sudah ada"));
				}
			}
		}
		function updateUser($data_user)
		{
			//function upload image
			$uploaddir = str_replace("application/", "", APPPATH).'upload/';
			if(!file_exists($uploaddir) && !is_dir($uploaddir)) 
			{
				echo mkdir($uploaddir, 0750, true);
			}
			if(!empty($_FILES))
			{
				$path = $_FILES['photo_id']['name'];
				// $ext = pathinfo($path, PATHINFO_EXTENSION);
				//$user_img = time() . rand() . '.' . $ext;
				$user_img = $data_user['id_user'].'.' ."png";
				$uploadfile = $uploaddir . $user_img;
				$data_user['photo_id'] = "upload/".$user_img;
			}
			//$this->response(array(base_url()."upload/".$user_img));
			//////////////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////
			//cek validasi
			if (empty($data_user['id_user']))
			{
				$this->response(array('status' => "failed", "message"=>"ID User harus
				diisi"));
			}else if (empty($data_user['nama']))
			{
				$this->response(array('status' => "failed", "message"=>"nama harus
				diisi"));
			}else if (empty($data_user['username']))
			{
				$this->response(array('status' => "failed", "message"=>"username harus
				diisi"));
			}else if (empty($data_user['password']))
			{
				$this->response(array('status' => "failed", "message"=>"password harus
				diisi"));
			}else if (empty($data_user['status_user']))
			{
				$this->response(array('status' => "failed", "message"=>"status user harus
				diisi"));
			}else
			{
				$get_user_baseid = $this->db->query("SELECT * FROM user WHERE id_user='".$data_user['id_user']."'")->result();
				if(empty($get_user_baseid))
				{
					$this->response(array('status' => "failed", "message"=>"Id_user Tidak ada dalam database"));
				}else
				{
					//$this->response(unlink($uploadfile));
					//cek apakah image
					if (!empty($_FILES["photo_id"]["name"])) 
					{
						if(move_uploaded_file($_FILES["photo_id"]["tmp_name"],$uploadfile))
						{
							$insert_image = "success";
						} else
						{
							$insert_image = "failed";
						}
					}else
					{
						$insert_image = "Image Tidak ada Masukan";
					}
					if ($insert_image==="success")
					{
						//jika photo di update eksekusi query
						$update= $this->db->query("Update user Set nama='".$data_user['nama']."', username ='".$data_user['username']."' , password='".$data_user['password']."', status_user='".$data_user['status_user']."', photo_id ='".$data_user['photo_id']."' Where id_user='".$data_user['id_user']."'");
						$data_user['photo_id'] = base_url()."upload/".$user_img;
					}else
					{
						//jika photo di kosong atau tidak di update eksekusi query
						$update= $this->db->query("Update user Set nama='".$data_user['nama']."', username ='".$$data_user['username']."' , password='".$data_user['password']."', status_user='".$data_user['status_user']."' Where id_user ='".$data_user['id_user']."'");
						$getPhotoPath =$this->db->query("SELECT photo_id FROM user Where id_user='".$data_user['id_user']."'")->result();
						if(!empty($getPhotoPath))
						{
							foreach ($getPhotoPath as $row)
							{
								$user_img = $row->photo_id;
								$data_user['photo_id'] =
								base_url().$user_img;
							}
						}
					}
					if ($update)
					{
						$this->response(array('status'=>'success','result' =>
						array($data_user),"message"=>$update));
					}
				}
			}
		}
							
		function deleteUser($data_user)
		{
			if (empty($data_user['id_user']))
			{
				$this->response(array('status' => "failed", "message"=>"ID User harus diisi"));
			}
			else{
				$getPhotoPath =$this->db->query("SELECT photo_id FROM user Where id_user='".$data_user['id_user']."'")->result();
				if(!empty($getPhotoPath))
				{
					foreach ($getPhotoPath as $row)
					{
						$path = str_replace("application/", "",	APPPATH).$row->photo_id;
					}
					//delete image
					unlink($path);
					$this->db->query("Delete From user Where id_user='".$data_user['id_user']."'");
					$this->response(array('status'=>'success',"message"=>"Data id =".$data_user['id_user']." berhasil di delete "));
				} else
				{
					$this->response(array('status'=>'fail',"message"=>"Id User tidak ada dalam database"));
				}
			}
		}
						
	
	}
	
	/* End of file Pembeli.php */
	/* Location: ./application/controllers/Pembeli.php */
?>