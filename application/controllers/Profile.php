<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
	// --------------------------------------------------------------------------
	// ** Atribut 		: Userdata / Login 
	// --------------------------------------------------------------------------
	public $userdata;


	// --------------------------------------------------------------------------
	// **  Metode		: Pengidentifikasi data login
	// --------------------------------------------------------------------------
	function __construct() {
		parent::__construct();
		$this->load->model('UserModel');

		$username = get_cookie('logged_username');
		$password = get_cookie('logged_md5');
		
		$data['status'] = '';
		$user_count = $this->UserModel->single($username, 'COUNT');
		if ($user_count > 0) {
			$userdata = $this->UserModel->single($username, 'OBJECT');
			if ($userdata->password == $password) {
				$data['status'] = 'OK';
				$data['userdata'] = $userdata;
			}
			else {
				$data['status'] = 'ERR_PASS_INVALID';
				set_cookie('logged_username', '', 0);
				set_cookie('logged_md5', '', 0);
				redirect(base_url(),'refresh');
				die;
			}
		}
		else {
			$data['status'] = 'ERR_NOT_FOUND';
			set_cookie('logged_username', '', 0);
			set_cookie('logged_md5', '', 0);
			redirect(base_url(),'refresh');
			die;
		}
		$this->userdata = $data;
	}




	// -------------------------------------------------------------
	// ** Metode 			: Routing Hak Akses
	// -------------------------------------------------------------
	public function route_hak_akses($hak_akses)
	{
		$data['status'] = 'RESTRICTED';
		$hak_akses_string = '';
		$data['level'] = $this->userdata['userdata']->level;
		if ($hak_akses != 'ALL') {
			foreach ($hak_akses as $akses) {
				$hak_akses_string .= $akses . ', ';
				if ($this->userdata['userdata']->level == $akses) {
					// Good to go
					$data['status'] = 'OK';
				}
			}
		}
		else {
			$hak_akses_string = 'All kind of level';
			$data['status'] = 'OK';
		}
		$hak_akses_string = rtrim($hak_akses_string, ', ');
		if ($data['status'] != 'OK') {
			echo "<pre><code>";
			echo "Restricted User Level, Your level: ". $this->userdata['userdata']->level;
			echo "<br/>Granted user level: " .$hak_akses_string. "<br/>";
			echo "</code></pre>";
			die;
		}
		return $data;
	}
	public function edit()
	{
		// Init
		$this->load->model('navigation');
		$this->load->model('sidebar');
		$level = $this->route_hak_akses('ALL');
		$level = $level['level'];
		$data['userdata'] = $this->userdata['userdata'];
		$data['waktu_sekarang'] = new DateTime();

		// Konfigurasi
		$this->load->model('KonfigurasiModel');
		$data['app_theme'] = $this->KonfigurasiModel->get('APP_THEME');
		$data['app_name'] = $this->KonfigurasiModel->get('APP_NAMA_TOKO');
		$data['app_favicon'] = $this->KonfigurasiModel->get('APP_LOGO');
		$data['app_logo'] = $this->KonfigurasiModel->get('APP_LOGO');

		// Ui
		$data['ui_title'] = $data['app_name']. ' - Laporan';
		$data['ui_css'] = array(
		);
		$data['ui_js'] = array(
			'custom/js/datetime.js',
			'custom/js/dynamic-img.js',
			'chartjs/js/chart.min.js',
		);
		$data['nav_brand'] = 'Laporan';
		$data['nav_links'] = $this->navigation->nav_laporan[$level];
		$data['nav_active'] = '';
		$data['sidebar_title'] =  $data['app_name'];
		$data['sidebar_links'] = $this->sidebar->get($level);
		$data['sidebar_active'] = 'Laporan';
		$this->load->view('profile/edit', $data);
	}

}

/* End of file Profile.php */
/* Location: ./application/controllers/Profile.php */
?>