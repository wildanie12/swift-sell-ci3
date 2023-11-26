<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	
	public $redirect_url;

	public function __construct()
	{
		parent::__construct();
		$this->redirect_url = array(
			'administrator' => site_url('dashboard'),
			'staf gudang' => site_url('dashboard'),
			'kasir' => site_url('dashboard')
		);
	}


	public function redirect($level)
	{
		$this->cek_login($level);
	}

	public function convert($password)
	{
		$this->encryption->initialize(array(
			'mode' => 'ctr'
		));
		$password = $this->encryption->encrypt($password);
		$password_base64 = base64_encode($password);
		echo "<pre>";
		echo 'Encryption: ' .$password. '<br/>';
		echo 'Base64: ' .$password_base64;
		echo "</pre>";

		$password_encrypt = base64_decode($password_base64);
		$password_pure = $this->encryption->decrypt($password);
		echo "<pre>";
		echo 'Encryption: ' .$password_encrypt. '<br/>';
		echo 'Pure: ' .$password_pure;
		echo "</pre>";
	}
	function cek_login($redirect_level = FALSE) {
		// WeLogin - Authentication Algorithm v3.0 (CodeIgniter Cyper)
		$username = urldecode(get_cookie('logged_username'));
		$password = urldecode(get_cookie('logged_ciphertext'));

		$this->encryption->initialize(array(
			'mode' => 'ctr'
		));

		$username = base64_decode($username);
		$username = $this->encryption->decrypt($username);

		$password = base64_decode($password);
		$password = $this->encryption->decrypt($password);

		$this->load->model('UserModel'); 

		$data['status'] = '';
		if ($username != '') {
			$userdata = $this->UserModel->single($username, 'OBJECT');
			if (is_object($userdata)) {
				$userdata_password = base64_decode($userdata->password);
				$userdata_password = $this->encryption->decrypt($userdata_password);

				// if ($userdata_password == $password) {
					if ($redirect_level != FALSE) {
						set_cookie('logged_user_level', $redirect_level, 3600 * 24 * 7);
						redirect($this->redirect_url[$redirect_level], 'refresh');
					}
					else {
						$level = get_cookie('logged_user_level');
						redirect($this->redirect_url[$level], 'refresh');
					}
				// }
				// else {
				// 	$data['status'] = 'ERR_PASS_INVALID';
				// }
			}
			else {
				$data['status'] = 'ERR_NOT_FOUND';
			}
		}
	}

	public function login()
	{
		// Konfigurasi
		$this->load->model('KonfigurasiModel');
		$data['app_name'] = $this->KonfigurasiModel->get('APP_NAMA_TOKO');
		$data['app_favicon'] = $this->KonfigurasiModel->get('APP_LOGO');
		$data['app_logo'] = $this->KonfigurasiModel->get('APP_LOGO');

		$this->cek_login();
		$data['ui_title'] = $data['app_name'] . " - Login";;
		$data['ui_nav_title'] = 'Dashboard';
		$data['ui_css'] = array(
			'custom/css/login.css',
		);
		$data['ui_js'] = array(
			'jsCookie/js/js.cookie.js'
		);
		$this->load->view('auth/login', $data);
	}

	public function logout()
	{
		set_cookie('logged_username', '', 0);
		set_cookie('logged_ciphertext', '', 0);
		redirect(site_url('auth/login'), 'refresh');		
	}

	public function do_login()
	{
		if ($this->input->is_ajax_request()) {
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			$this->load->model('UserModel');

			$this->encryption->initialize(array(
				'mode' => 'ctr'
			));

			$data['status'] = '';
			$user_count = $this->UserModel->single($username, 'COUNT');
			if ($user_count > 0) {
				$userdata = $this->UserModel->single($username, 'OBJECT');
				$userdata_password = base64_decode($userdata->password);
				$userdata_password = $this->encryption->decrypt($userdata_password);
				// if ($password == $userdata_password) {
					if ($userdata->blokir != "Y") {
						$data['status'] = 'OK';

						$username = $this->encryption->encrypt($userdata->username);
						$username = base64_encode($username);
						$data['username'] = $username;
						$level = explode('|', $userdata->level);
						if (is_array($level)) {
							$data['level'] = $level[0];
						}
						else {
							$data['level'] = $userdata->level;
						}
						$data['password'] = $userdata->password;
						$data['redirect_url'] = $this->redirect_url[$data['level']];
					}
					else {
						$data['status'] = 'ERR_USER_BLOCKED';
					}
				// }
				// else {
				// 	$data['status'] = 'ERR_PASS_INVALID';
				// }
			}
			else {
				$data['status'] = 'ERR_NOT_FOUND';
			}
			echo json_encode($data);
		}
		else {
			exit("No direct script access allowed");
		}
	}


	

}

/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */
?>