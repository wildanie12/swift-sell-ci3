<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistik extends CI_Controller {
	
	// --------------------------------------------------------------------------
	// ** Atribut 		: Sidebar 
	// --------------------------------------------------------------------------
	var $ui_sidebar_nav;

	// --------------------------------------------------------------------------
	// **  Metode		: Inisialisasi Metode
	// --------------------------------------------------------------------------
	function __construct() {
		parent::__construct();
	}

	// --------------------------------------------------------------------------
	// ** Metode 	: Cek Login
	// --------------------------------------------------------------------------
	public function cek_login($lempar = FALSE) {
		// Verify Logged User
		$this->load->model('UserModel');
		$username = urldecode(get_cookie('logged_username'));
		$password = urldecode(get_cookie('logged_ciphertext'));
		$level = urldecode(get_cookie('logged_user_level'));

		$this->encryption->initialize(array(
			'mode' => 'ctr'
		));
		$username = base64_decode($username);
		$username = $this->encryption->decrypt($username);
		
		$data['status'] = '';
		if ($username != '') {
			$userdata = $this->UserModel->single($username, 'OBJECT');
			if (is_object($userdata)) {

				$userdata_password = base64_decode($userdata->password);
				$userdata_password = $this->encryption->decrypt($userdata_password);

				$password = base64_decode($password);
				$password = $this->encryption->decrypt($password);

				// Verifying level
				$userdata_level = explode('|', $userdata->level);
				if (is_array($userdata_level)) {
					$level_granted = FALSE;
					foreach ($userdata_level as $item) {
						if ($item == $level) {
							$level_granted = TRUE;
						}
					}
					if (!$level_granted) {
						redirect(site_url('auth/redirect/' . $userdata_level[0]),'refresh');
					}
				}
				else {
					if ($userdata->level != $level) {
						redirect(site_url('auth/redirect/' . $userdata->level),'refresh');
					}
				}

				if ($userdata_password == $password) {
					$data['status'] = 'OK';
					$data['userdata'] = $userdata;
				}
				else {
					echo "not match";
					$data['status'] = 'ERR_PASS_INVALID';
					if ($lempar != FALSE) {
						set_cookie('logged_username', '', 0);
						set_cookie('logged_ciphertext', '', 0);
						redirect(site_url('auth/login'),'refresh');
					}
				}
			}
			else {
				$data['status'] = 'ERR_NOT_FOUND';
				if ($lempar != FALSE) {
					set_cookie('logged_username', '', 0);
					set_cookie('logged_ciphertext', '', 0);
					redirect(site_url('auth/login'),'refresh');
				}
			}
			return $data;
		}
		else {
			$data['status'] = 'ERR_EMPTY_COOKIE';
			if ($lempar != FALSE) {
				set_cookie('logged_username', '', 0);
				set_cookie('logged_ciphertext', '', 0);
				redirect(site_url('auth/login'),'refresh');
			}
		}
	}


	// -------------------------------------------------------------
	// ** Inisialisasi Sidebar
	// -------------------------------------------------------------
	public function init_sidebar($level, $active = FALSE)
	{
		if ($level == 'administrator') {
			$this->ui_sidebar_nav = array(
				'Dashboard|ni ni-tv-2|' .site_url('dashboard'),
				'Data|ni ni-archive-2|' .site_url('data'),
				'Transaksi|ni ni-cart|' .site_url('transaksi'),
				'Laporan|fas fa-book|' .site_url('laporan'),
				'Statistik|fas fa-chart-line|' .site_url('statistik'),
				'Konfigurasi|ni ni-settings|' .site_url('konfigurasi')
			);
		}
		else if ($level == 'staf gudang') {
			$this->ui_sidebar_nav = array(
				'Dashboard|ni ni-tv-2|' .site_url('dashboard'),
				'Data|ni ni-archive-2|' .site_url('data'),
				'Transaksi|ni ni-cart|' .site_url('transaksi'),
				'Laporan|fas fa-book|' .site_url('laporan'),
			);
		}
		else if ($level == 'kasir') {
			$this->ui_sidebar_nav = array(
				'Dashboard|ni ni-tv-2|' .site_url('dashboard'),
				'Data|ni ni-archive-2|' .site_url('data'),
				'Transaksi|ni ni-cart|' .site_url('transaksi'),
			);
		}
		if ($active != FALSE) {
			$as = 1;
			$this->ui_sidebar_nav[$active-1] = $this->ui_sidebar_nav[$active-1] . '|active';
		}
		return $this->ui_sidebar_nav;
	}

	// -------------------------------------------------------------
	// ** Metode 			: Routing Hak Akses
	// -------------------------------------------------------------
	public function route_hak_akses($hak_akses)
	{
		$data['status'] = 'RESTRICTED';
		$hak_akses_display = '';

		if ($hak_akses != 'GUEST') {
			$login = $this->cek_login('Lempar');  // buang guest
		}
		else {
			$login = $this->cek_login();
		}

		// Pengecekan level pengguna
		if ($login['status'] == 'OK') {
			$current_level = get_cookie('logged_user_level');
			$data['userdata'] = $login['userdata'];		
			$data['level'] = $current_level; 
		}
		else {
			$data['level'] = 'GUEST'; 
		}

		// Pengkondisian hak akses
		if (is_array($hak_akses)) {
			foreach ($hak_akses as $akses) {
				$hak_akses_display .= $akses . ', ';
				if ($akses == $current_level) {
					$data['status'] = 'OK';
				}
			}
			$hak_akses_display = rtrim($hak_akses_display, ', ');
		}
		else {
			$hak_akses_display = $hak_akses;
			if ($hak_akses == 'ALL_WITH_GUEST') {
				$data['status'] = 'OK';
			}
			else if ($hak_akses == 'ALL_LOGGED_USER_ONLY') {
				if ($login['status'] == 'OK') {
					$data['status'] = 'OK';
				}
			}
			else {
				if ($hak_akses == $current_level) {
					$data['status'] = 'OK';
				}
				else {
					$userdata_level = explode('|', $data['userdata']->level);
					if (is_array($userdata_level)) {
						foreach ($userdata_level as $level) {
							if ($hak_akses == $level) {
								set_cookie('logged_user_level', $level, 3600 * 24 * 7);
								$data['status'] == 'OK';
							}
						}
					}
				}
			}
		}
		if ($data['status'] != 'OK') {
			echo "<pre><code>";
			echo "Level pengguna dibatasi, Level anda: ". $current_level;
			echo "<br/>Granted user level: " .$hak_akses_display. "<br/>";
			echo "<a href='" .site_url('auth/logout'). "'>Logout</a>";
			echo "</code></pre>";
			die;
		}
		return $data;
	}

	


	// -------------------------------------------------------------
	// ** Controller 		: Halaman Dashboard Utama
	// -------------------------------------------------------------
	public function index()
	{
		// Init
		$this->load->model('navigation');
		$data['user_active'] = $this->route_hak_akses('administrator');
		$level = $data['user_active']['level'];
		$data['waktu_sekarang'] = new DateTime();

		// Konfigurasi
		$this->load->model('KonfigurasiModel');
		$data['app_theme'] = $this->KonfigurasiModel->get('APP_THEME');
		$data['app_name'] = $this->KonfigurasiModel->get('APP_NAMA_TOKO');
		$data['app_favicon'] = $this->KonfigurasiModel->get('APP_LOGO');
		$data['app_logo'] = $this->KonfigurasiModel->get('APP_LOGO');

		// Ui
		$data['ui_title'] = $data['app_name']. ' - Transaksi';
		$data['ui_css'] = array(
		);
		$data['ui_js'] = array(
			'custom/js/datetime.js',
			'custom/js/dynamic-img.js',
			'chartjs/js/chart.min.js',
		);
		$data['ui_navbar_title'] = 'Statistik';
		$data['ui_navbar_link'] = $this->navigation->nav_statistik[$level];
		$data['ui_sidebar_title'] =  $data['app_name'];
		$data['ui_sidebar_nav'] = $this->init_sidebar($level, 5);

		$this->load->view('statistik/index', $data);
	}

	// -------------------------------------------------------------
	// ** Controller 		: Statistik Pemasukan
	// -------------------------------------------------------------
	public function pemasukan()
	{
		// Init
		$this->load->model('navigation');
		$this->load->model('sidebar');
		$data['user_active'] = $this->route_hak_akses('administrator');
		$level = $data['user_active']['level'];
		$data['waktu_sekarang'] = new DateTime();

		// Konfigurasi
		$this->load->model('KonfigurasiModel');
		$data['app_theme'] = $this->KonfigurasiModel->get('APP_THEME');
		$data['app_name'] = $this->KonfigurasiModel->get('APP_NAMA_TOKO');
		$data['app_favicon'] = $this->KonfigurasiModel->get('APP_LOGO');
		$data['app_logo'] = $this->KonfigurasiModel->get('APP_LOGO');

		// Ui
		$data['ui_title'] = $data['app_name']. ' - Transaksi';
		$data['ui_css'] = array(
		);
		$data['ui_js'] = array(
			'custom/js/datetime.js',
			'custom/js/dynamic-img.js',
			'chartjs/js/chart.min.js',
		);
		$data['ui_navbar_title'] = 'Statistik';
		$data['ui_navbar_link'] = $this->navigation->nav_statistik[$level];
		$data['ui_sidebar_title'] =  $data['app_name'];
		$data['ui_sidebar_nav'] = $this->init_sidebar($level, 5);

		$this->load->view('statistik/pemasukan', $data);
	}

	// --------------------------------------------------------------------------
	// ** Ajax Script 		: Ambil Statistik Stok
	// ** Level Akses 		: All
	// ** Parent Controller	: Barang
	// --------------------------------------------------------------------------
	public function statistik_pemasukan()
	{
		$this->load->model('TransaksiModel');
		$this->load->model('ItemTransaksiModel');

		$tanggal_awal = $this->input->get('tanggal_awal');
		$tanggal_akhir = $this->input->get('tanggal_akhir');
		
		if ($tanggal_awal != '' && $tanggal_akhir != '') {
			$tanggal_awal = new DateTime($tanggal_awal);
			$tanggal_akhir = new DateTime($tanggal_akhir);
			$tanggal_akhir->modify('+1 Day');
		}
		else {
			$tanggal_awal = new DateTime();
			$tanggal_awal->modify('-7 Day');
			$tanggal_akhir = new DateTime();
			$tanggal_akhir->modify('+1 Day');
		}

		$interval = new DateInterval('P1D');
		$range = new DatePeriod($tanggal_awal, $interval, $tanggal_akhir);

		$json['label'] = array();
		$json['pemasukan'] = array();
		foreach ($range as $date) {
			$this->db->where('tanggal', $date->format('Y-m-d'));
			$data_transaksi = $this->TransaksiModel->show(0, 0, 'OBJECT');
			$this->db->reset_query();

			$total_harian = 0;
			foreach ($data_transaksi as $transaksi) {
				$total_harian += $transaksi->total;
			}
			$json['label'][] = $date->format('d F');
			$json['pemasukan'][] = $total_harian;
		}
		echo json_encode($json);
	}


	// -------------------------------------------------------------
	// ** Controller 		: Statistik Pemasukan
	// -------------------------------------------------------------
	public function stok()
	{
		// Init
		$this->load->model('navigation');
		$this->load->model('sidebar');
		$data['user_active'] = $this->route_hak_akses('administrator');
		$level = $data['user_active']['level'];
		$data['waktu_sekarang'] = new DateTime();

		// Konfigurasi
		$this->load->model('KonfigurasiModel');
		$data['app_theme'] = $this->KonfigurasiModel->get('APP_THEME');
		$data['app_name'] = $this->KonfigurasiModel->get('APP_NAMA_TOKO');
		$data['app_favicon'] = $this->KonfigurasiModel->get('APP_LOGO');
		$data['app_logo'] = $this->KonfigurasiModel->get('APP_LOGO');

		// Ui
		$data['ui_title'] = $data['app_name']. ' - Transaksi';
		$data['ui_css'] = array(
		);
		$data['ui_js'] = array(
			'custom/js/datetime.js',
			'custom/js/dynamic-img.js',
			'chartjs/js/chart.min.js',
		);
		$data['ui_navbar_title'] = 'Statistik';
		$data['ui_navbar_link'] = $this->navigation->nav_statistik[$level];
		$data['ui_sidebar_title'] =  $data['app_name'];
		$data['ui_sidebar_nav'] = $this->init_sidebar($level, 5);

		$this->load->view('statistik/stok', $data);
	}

	// --------------------------------------------------------------------------
	// ** Ajax Script 		: Ambil Statistik Stok
	// ** Level Akses 		: All
	// ** Parent Controller	: Barang
	// --------------------------------------------------------------------------
	public function statistik_stok()
	{
		$this->load->model('StokModel');
		$this->load->model('ItemTransaksiModel');
		$this->load->model('TransaksiModel');

		$tanggal_awal = $this->input->get('tanggal_awal');
		$tanggal_akhir = $this->input->get('tanggal_akhir');
		
		if ($tanggal_awal != '' && $tanggal_akhir != '') {
			$tanggal_awal = new DateTime($tanggal_awal);
			$tanggal_akhir = new DateTime($tanggal_akhir);
			$tanggal_akhir->modify('+1 Day');
		}
		else {
			$tanggal_awal = new DateTime();
			$tanggal_awal->modify('-7 Day');
			$tanggal_akhir = new DateTime();
			$tanggal_akhir->modify('+1 Day');
		}

		$interval = new DateInterval('P1D');
		$range = new DatePeriod($tanggal_awal, $interval, $tanggal_akhir);

		$json['label'] = array();
		$json['pemasukan'] = array();
		foreach ($range as $date) {
			$json['label'][] = $date->format('d F');

			// Barang Masuk
			$this->db->where('tanggal_masuk', $date->format('Y-m-d'));
			$data_stok = $this->StokModel->show(0, 0 ,"OBJECT");
			$this->db->reset_query();
			$barang_masuk = 0;
			foreach ($data_stok as $stok) {
				$barang_masuk += $stok->stok;
			}
			$json['barang_masuk'][] = $barang_masuk;

			// Barang Keluar
			$this->db->where('tanggal', $date->format('Y-m-d'));
			$data_transaksi = $this->TransaksiModel->show(0, 0, 'OBJECT');
			$this->db->reset_query();
			$barang_keluar = 0;
			foreach ($data_transaksi as $transaksi) {
				$this->db->where('transaksi_id', $transaksi->id);
				$data_item = $this->ItemTransaksiModel->show(0, 0, 'OBJECT');
				$this->db->reset_query();
				foreach ($data_item as $item) {
					$barang_keluar += $item->qty;
				}
			}
			$json['barang_keluar'][] = $barang_keluar;

		}
		echo json_encode($json);
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */
?>