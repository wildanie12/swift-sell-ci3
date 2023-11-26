<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

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

	// --------------------------------------------------------------------------
	// ** Controller 		: Halaman Menu Utama
	// --------------------------------------------------------------------------
	public function index()
	{
		// Init
		$this->load->model('navigation');
		$data['user_active'] = $this->route_hak_akses(array('administrator', 'staf gudang'));
		$level = $data['user_active']['level'];
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
		$data['ui_navbar_title'] = 'Laporan';
		$data['ui_navbar_link'] = $this->navigation->nav_laporan[$level];
		$data['ui_sidebar_title'] =  $data['app_name'];
		$data['ui_sidebar_nav'] = $this->init_sidebar($level, 4);
		$this->load->view('laporan/index', $data);
	}

	// --------------------------------------------------------------------------
	// ** Controller 		: Pembelian
	// --------------------------------------------------------------------------
	public function pembelian()
	{
		// Init
		$this->load->model('navigation');
		$data['user_active'] = $this->route_hak_akses(array('administrator', 'staf gudang'));
		$level = $data['user_active']['level'];
		$data['waktu_sekarang'] = new DateTime();

		// Konfigurasi
		$this->load->model('KonfigurasiModel');
		$data['app_theme'] = $this->KonfigurasiModel->get('APP_THEME');
		$data['app_name'] = $this->KonfigurasiModel->get('APP_NAMA_TOKO');
		$data['app_favicon'] = $this->KonfigurasiModel->get('APP_LOGO');
		$data['app_logo'] = $this->KonfigurasiModel->get('APP_LOGO');

		// Ui
		$data['ui_title'] = $data['app_name']. ' - Laporan Pembelian';
		$data['ui_css'] = array(
		);
		$data['ui_js'] = array(
			'custom/js/datetime.js',
			'custom/js/dynamic-img.js',
			'chartjs/js/chart.min.js',
		);
		$data['ui_navbar_title'] = 'Laporan';
		$data['ui_navbar_link'] = $this->navigation->nav_laporan[$level];
		$data['ui_sidebar_title'] =  $data['app_name'];
		$data['ui_sidebar_nav'] = $this->init_sidebar($level, 4);

		// Data - User (Staf Gudang dan Administrator)
		$this->load->model('UserModel');
		$this->db->where('level', 'administrator');
		$this->db->or_where('level', 'staf gudang');
		$this->db->order_by('nama_lengkap', 'asc');
		$data['data_user'] = $this->UserModel->show(0, 0, 'OBJECT');

		// Data - Supplier
		$this->load->model('SupplierModel');
		$this->db->order_by('nama', 'asc');
		$data['data_supplier'] = $this->SupplierModel->show(0, 0, 'OBJECT');

		$this->load->view('laporan/pembelian/index', $data);
	}

	// --------------------------------------------------------------------------
	// ** Ajax 					: Read Single (Ambil berdasarkan faktur)
	// ** Level akses 			: Kasir, Administrator
	// ** Parent Controller 	: Transaksi Beli
	// --------------------------------------------------------------------------
	public function read_transaksi_beli()
	{
		$this->load->model('TransaksiBeliModel');
		$id = $this->input->get('id');
		$json = $this->TransaksiBeliModel->single_by('id', $id, 'OBJECT');

		echo json_encode($json);
	}

	// --------------------------------------------------------------------------
	// ** Ajax				: Data List Transaksi Pembelian
	// ** Controller 		: Pembelian
	// --------------------------------------------------------------------------
	public function list_pembelian($ui) {

		$this->load->model('TransaksiBeliModel');
		$this->load->model('UserModel');
		$this->load->model('SupplierModel');
		$this->load->model('StokModel');

		// Pre-Load Data

		if ($this->input->get('username') != '') {
			$data['kasir'] = $this->UserModel->single($this->input->get('username'), 'OBJECT');
			
		}
		if ($this->input->get('supplier') != '') {
			$data['supplier'] = $this->SupplierModel->single($this->input->get('supplier'), 'OBJECT');
			
		}

		// Data - Filter 
		$this->db->start_cache();
		$data['limit'] = $this->input->get('limit');
		if ($data['limit'] < 0) {
			$data['limit'] = 0;
		}
		$data['page'] = $this->input->get('page');
		if ($data['page'] < 0) {
			$data['page'] = 1;
		}
		$data['filter']['Tanggal Laporan'] = date('d-m-Y');
		$data['offset'] = $data['limit'] * ($data['page'] - 1);

		$cari = $this->input->get('cari');
		$berdasarkan = $this->input->get('berdasarkan');
		if ($cari != '' && $berdasarkan != '') {
			$data['filter']['Pencarian ['.$berdasarkan .']'] = $cari;
			$this->db->like($berdasarkan, $cari, 'BOTH');
		}

		$username = $this->input->get('username');
		if ($username != '') {
			$data['filter']['Pengguna'] = $data['kasir']->nama_lengkap;
			$this->db->where('username', $username);
		}

		$tanggal_faktur_dari = $this->input->get('tanggal_faktur_dari');
		$tanggal_faktur_ke = $this->input->get('tanggal_faktur_ke');
		if ($tanggal_faktur_dari != '' && $tanggal_faktur_ke != '') {
			$data['filter']['Tanggal Faktur'] = date('d F Y', strtotime($tanggal_faktur_dari)) . ' - ' . date('d F Y', strtotime($tanggal_faktur_ke));
			$this->db->where('tanggal_faktur BETWEEN "'. $tanggal_faktur_dari . '" AND "' . $tanggal_faktur_ke . '"');
		}
		else if ($tanggal_faktur_dari != '') {
			$data['filter']['Tanggal Faktur setelah'] = date('d F Y', strtotime($tanggal_faktur_dari));
			$this->db->where('tanggal_faktur >= "'. $tanggal_faktur_dari . '"');
		}
		else if ($tanggal_faktur_ke != '') {
			$data['filter']['Tanggal Faktur sebelum'] = date('d F Y', strtotime($tanggal_faktur_ke));
			$this->db->where('tanggal_faktur <= "'. $tanggal_faktur_ke . '"');
		}

		$supplier = $this->input->get('supplier');
		if ($supplier != '') {
			$data['filter']['Supplier'] = $data['supplier']->nama;
			$this->db->where('supplier_id', $supplier);
		}

		$jenis_pembayaran = $this->input->get('jenis_pembayaran');
		if ($jenis_pembayaran != '') {
			$data['filter']['Jenis Pembayaran'] = $jenis_pembayaran;
			$this->db->where('jenis_pembayaran', $jenis_pembayaran);
		}

		$this->db->order_by('tanggal_faktur', 'desc');
		$this->db->stop_cache();

		// Data - Fetch
		$this->load->model('BarangModel');

		$data['data_filtered'] = $this->TransaksiBeliModel->show($data['limit'], $data['offset'], 'OBJECT');
		$data['count_filtered'] = $this->TransaksiBeliModel->show($data['limit'], $data['offset'], 'COUNT');
		$data['count_all'] = $this->TransaksiBeliModel->show(0, 0, 'COUNT');
		$this->db->flush_cache();


		// -----------------------------------------------------------------------
		// Perhitungan data Paginasi
		// -----------------------------------------------------------------------
		if ($data['count_filtered'] < 1) {
			$data['count_filtered'] = 1;
		}
		$data['total_page'] = floor($data['count_all'] / $data['limit']);
		if ($data['count_all'] % $data['limit'] > 0) {
			$data['total_page']++;
		}

		if ($ui == 'json') {
			echo json_encode($data);
		}
		else {
			$this->load->view('laporan/pembelian/ajax/' . $ui, $data);
		}
	}



	// --------------------------------------------------------------------------
	// ** Controller 		: Pembelian
	// --------------------------------------------------------------------------
	public function penjualan()
	{
		// Init
		$this->load->model('navigation');
		$this->load->model('sidebar');
		$data['user_active'] = $this->route_hak_akses(array('kasir', 'administrator'));
		$level = $data['user_active']['level'];
		$data['waktu_sekarang'] = new DateTime();

		// Konfigurasi
		$this->load->model('KonfigurasiModel');
		$data['app_theme'] = $this->KonfigurasiModel->get('APP_THEME');
		$data['app_name'] = $this->KonfigurasiModel->get('APP_NAMA_TOKO');
		$data['app_favicon'] = $this->KonfigurasiModel->get('APP_LOGO');
		$data['app_logo'] = $this->KonfigurasiModel->get('APP_LOGO');

		// Ui
		$data['ui_title'] = $data['app_name']. ' - Laporan Penjualan';
		$data['ui_css'] = array(
		);
		$data['ui_js'] = array(
			'custom/js/datetime.js',
			'custom/js/dynamic-img.js',
			'chartjs/js/chart.min.js',
		);
		$data['ui_navbar_title'] = 'Laporan';
		$data['ui_navbar_link'] = $this->navigation->nav_laporan[$level];
		$data['ui_sidebar_title'] = $data['app_name'];
		$data['ui_sidebar_nav'] = $this->init_sidebar($level, 4);

		// Data - User (Staf Gudang dan Administrator)
		$this->load->model('UserModel');
		$this->db->where('level', 'administrator');
		$this->db->or_where('level', 'kasir');
		$this->db->order_by('nama_lengkap', 'asc');
		$data['data_user'] = $this->UserModel->show(0, 0, 'OBJECT');

		// Data - Supplier
		$this->load->model('SupplierModel');
		$this->db->order_by('nama', 'asc');
		$data['data_supplier'] = $this->SupplierModel->show(0, 0, 'OBJECT');

		$this->load->view('laporan/penjualan/index', $data);
	}


	// --------------------------------------------------------------------------
	// ** Ajax				: Data List Transaksi Pembelian
	// ** Controller 		: Pembelian
	// --------------------------------------------------------------------------
	public function list_penjualan($ui) {
		$this->load->model('TransaksiModel');
		$this->load->model('ItemTransaksiModel');
		$this->load->model('BarangModel');
		$this->load->model('StokModel');
		$this->load->model('UserModel');

		// Pre-Load Data

		if ($this->input->get('username') != '') {
			$data['kasir'] = $this->UserModel->single($this->input->get('username'), 'OBJECT');
		}

		// Data - Filter 
		$this->db->start_cache();
		$data['limit'] = $this->input->get('limit');
		if ($data['limit'] < 0) {
			$data['limit'] = 0;
		}
		$data['page'] = $this->input->get('page');
		if ($data['page'] < 0) {
			$data['page'] = 1;
		}
		$data['filter']['Tanggal Laporan'] = date('d-m-Y');
		$data['offset'] = $data['limit'] * ($data['page'] - 1);

		$username = $this->input->get('username');
		if ($username != '') {
			$data['filter']['Kasir'] = $data['kasir']->nama_lengkap;
			$this->db->where('kasir', $username);
		}

		$tanggal_dari = $this->input->get('tanggal_dari');
		$tanggal_ke = $this->input->get('tanggal_ke');
		if ($tanggal_dari != '' && $tanggal_ke != '') {
			$data['filter']['Tanggal'] = date('d F Y', strtotime($tanggal_dari)) . ' - ' . date('d F Y', strtotime($tanggal_ke));
			$this->db->where('tanggal BETWEEN "' .$tanggal_dari. '" AND "' .$tanggal_ke. '"');
		}
		else if ($tanggal_dari != '') {
			$data['filter']['Tanggal'] = 'Setelah tanggal ' . date('d F Y', strtotime($tanggal_dari));
			$this->db->where('tanggal >= "' .$tanggal_dari);
		}
		else if ($tanggal_ke != '') {
			$data['filter']['Tanggal'] = 'Sebelum tanggal ' . date('d F Y', strtotime($tanggal_ke));
			$this->db->where('tanggal < "' .$tanggal_ke);
		}

		$this->db->order_by('id', 'desc');
		$this->db->stop_cache();

		// Data - Fetch

		$data['data_filtered'] = $this->TransaksiModel->show($data['limit'], $data['offset'], 'OBJECT');
		$data['count_filtered'] = $this->TransaksiModel->show($data['limit'], $data['offset'], 'COUNT');
		$this->db->flush_cache();
		$data['count_all'] = $this->TransaksiModel->show(0, 0, 'COUNT');

		$this->load->view('laporan/penjualan/ajax/'. $ui, $data);
	}





	// --------------------------------------------------------------------------
	// ** Controller 		: Barang
	// --------------------------------------------------------------------------
	public function barang()
	{
		// Init
		$this->load->model('navigation');
		$data['user_active'] = $this->route_hak_akses(array('staf gudang', 'administrator'));
		$level = $data['user_active']['level'];
		$data['waktu_sekarang'] = new DateTime();

		// Konfigurasi
		$this->load->model('KonfigurasiModel');
		$data['app_theme'] = $this->KonfigurasiModel->get('APP_THEME');
		$data['app_name'] = $this->KonfigurasiModel->get('APP_NAMA_TOKO');
		$data['app_favicon'] = $this->KonfigurasiModel->get('APP_LOGO');
		$data['app_logo'] = $this->KonfigurasiModel->get('APP_LOGO');

		// Ui
		$data['ui_title'] = $data['app_name']. ' - Laporan Barang';
		$data['ui_css'] = array(
		);
		$data['ui_js'] = array(
			'custom/js/datetime.js',
			'custom/js/dynamic-img.js',
			'chartjs/js/chart.min.js',
		);
		$data['ui_navbar_title'] = 'Laporan';
		$data['ui_navbar_link'] = $this->navigation->nav_laporan[$level];
		$data['ui_sidebar_title'] =  $data['app_name'];
		$data['ui_sidebar_nav'] = $this->init_sidebar($level, 4);


		// Data - Supplier
		$this->load->model('KategoriModel');
		$this->db->order_by('nama', 'asc');
		$data['data_kategori'] = $this->KategoriModel->show(0, 0, 'OBJECT');

		$this->load->view('laporan/barang/index', $data);
	}

	// --------------------------------------------------------------------------
	// ** Ajax				: Data List Transaksi Pembelian
	// ** Controller 		: Pembelian
	// --------------------------------------------------------------------------
	public function list_barang($ui) {

		// Preload
		$this->load->model('KategoriModel');
		$kategori = $this->input->get('kategori');
		if ($kategori != '') {
			$data['kategori'] = $this->KategoriModel->single($kategori, 'OBJECT');
		}

		// Data - Filter 
		$this->db->start_cache();
		$data['limit'] = $this->input->get('limit');
		if ($data['limit'] < 0) {
			$data['limit'] = 0;
		}
		$data['page'] = $this->input->get('page');
		if ($data['page'] < 0) {
			$data['page'] = 1;
		}
		$data['filter']['Tanggal Laporan'] = date('d-m-Y');
		$data['offset'] = $data['limit'] * ($data['page'] - 1);

		if ($kategori != '') {
			$data['filter']['Kategori'] = $data['kategori']->nama;
			$this->db->where('kategori_id', $kategori);
		}

		$status = $this->input->get('status');
		if ($status != '') {
			$data['filter']['Status'] = $status;
			$this->db->where('status', $status);
		}

		$this->db->order_by('id', 'desc');
		$this->db->stop_cache();

		// Data - Fetch
		$this->load->model('BarangModel');
		$this->load->model('StokModel');

		$data['data'] = $this->BarangModel->show($data['limit'], $data['offset'], 'OBJECT');
		$data['data_count'] = $this->BarangModel->show($data['limit'], $data['offset'], 'COUNT');
		$this->db->flush_cache();
		$data['data_all_count'] = $this->BarangModel->show(0, 0, 'COUNT');

		$this->load->view('laporan/barang/ajax/'. $ui, $data);
	}


	// --------------------------------------------------------------------------
	// ** Controller 		: Stok Barang
	// --------------------------------------------------------------------------
	public function stok()
	{
		// Init
		$this->load->model('navigation');
		$data['user_active'] = $this->route_hak_akses(array('staf gudang', 'administrator'));
		$level = $data['user_active']['level'];
		$data['waktu_sekarang'] = new DateTime();

		// Konfigurasi
		$this->load->model('KonfigurasiModel');
		$data['app_theme'] = $this->KonfigurasiModel->get('APP_THEME');
		$data['app_name'] = $this->KonfigurasiModel->get('APP_NAMA_TOKO');
		$data['app_favicon'] = $this->KonfigurasiModel->get('APP_LOGO');
		$data['app_logo'] = $this->KonfigurasiModel->get('APP_LOGO');

		// Ui
		$data['ui_title'] = $data['app_name']. ' - Laporan Stok Barang';
		$data['ui_css'] = array(
		);
		$data['ui_js'] = array(
			'custom/js/datetime.js',
			'custom/js/dynamic-img.js',
		);
		$data['ui_navbar_title'] = 'Laporan';
		$data['ui_navbar_link'] = $this->navigation->nav_laporan[$level];
		$data['ui_sidebar_title'] =  $data['app_name'];
		$data['ui_sidebar_nav'] = $this->init_sidebar($level, 4);


		// Data - Barang
		$this->load->model('BarangModel');
		$this->db->order_by('nama', 'asc');
		$data['data_barang'] = $this->BarangModel->show(0, 0, 'OBJECT');

		$this->load->view('laporan/stok/index', $data);
	}

	// --------------------------------------------------------------------------
	// ** Ajax				: Data List Stok Barang
	// ** Controller 		: Pembelian
	// --------------------------------------------------------------------------
	public function list_stok($ui) {

		// Preload
		$this->load->model('TransaksiBeliModel');
		$this->load->model('SupplierModel');
		$this->load->model('BarangModel');
		$barang = $this->input->get('barang');
		if ($barang != '') {
			$barang= $this->BarangModel->single($barang, 'OBJECT');
		}

		// Data - Filter 
		$this->db->start_cache();
		$data['limit'] = $this->input->get('limit');
		if ($data['limit'] < 0) {
			$data['limit'] = 0;
		}
		$data['page'] = $this->input->get('page');
		if ($data['page'] < 0) {
			$data['page'] = 1;
		}
		$data['filter']['Tanggal Laporan'] = date('d-m-Y');
		$data['offset'] = $data['limit'] * ($data['page'] - 1);

		if ($barang != '') {
			$data['filter']['Barang'] = $barang->nama;
			$this->db->where('barang_id', $barang->id);
		}

		$data['transaksi_id'] = $this->input->get('transaksi_id');
		if ($data['transaksi_id'] != '') {
			$this->db->where('transaksi_id', $data['transaksi_id']);
			$data['filter']['ID Transaksi'] = $data['transaksi_id'];
		}

		$tanggal_masuk_ke = $this->input->get('tanggal_masuk_ke');
		$tanggal_masuk_dari = $this->input->get('tanggal_masuk_dari');
		if ($tanggal_masuk_ke != '' && $tanggal_masuk_dari != '') {
			$data['filter']['Tanggal masuk'] = date('d F Y', strtotime($tanggal_masuk_ke)) . ' - ' . date('d F Y', strtotime($tanggal_masuk_ke));
			$this->db->where('tanggal_masuk BETWEEN "' .$tanggal_masuk_dari. '" AND "' .$tanggal_masuk_ke. '"');
		}
		else if ($tanggal_masuk_ke != '') {
			$data['filter']['Tanggal masuk sebelum'] = date('d F Y', strtotime($tanggal_masuk_ke));
			$this->db->where('tanggal_masuk <= "' . $tanggal_masuk_ke . '"');
		}
		else if ($tanggal_masuk_dari != '') {
			$data['filter']['Tanggal masuk setelah'] = date('d F Y', strtotime($tanggal_masuk_dari));
			$this->db->where('tanggal_masuk >="' . $tanggal_masuk_dari. '"');
		}


		$tanggal_kadaluarsa_ke = $this->input->get('tanggal_kadaluarsa_ke');
		$tanggal_kadaluarsa_dari = $this->input->get('tanggal_kadaluarsa_dari');
		if ($tanggal_kadaluarsa_ke != '' && $tanggal_kadaluarsa_dari != '') {
			$data['filter']['Tanggal kadaluarsa'] = date('d F Y', strtotime($tanggal_kadaluarsa_ke)) . ' - ' . date('d F Y', strtotime($tanggal_kadaluarsa_ke));
			$this->db->where('tgl_kadaluarsa BETWEEN "' .$tanggal_kadaluarsa_dari. '" AND "' .$tanggal_kadaluarsa_ke. '"');
		}
		else if ($tanggal_kadaluarsa_ke != '') {
			$data['filter']['Tanggal kadaluarsa sebelum'] = date('d F Y', strtotime($tanggal_kadaluarsa_ke));
			$this->db->where('tgl_kadaluarsa <= "' . $tanggal_kadaluarsa_ke . '"');
		}
		else if ($tanggal_kadaluarsa_dari != '') {
			$data['filter']['Tanggal kadaluarsa setelah'] = date('d F Y', strtotime($tanggal_kadaluarsa_dari));
			$this->db->where('tgl_kadaluarsa >="' . $tanggal_kadaluarsa_dari. '"');
		}



		$this->db->order_by('barang_id', 'desc');
		$this->db->stop_cache();

		// Data - Fetch
		$this->load->model('StokModel');

		$data['data'] = $this->StokModel->show($data['limit'], $data['offset'], 'OBJECT');
		$data['data_count'] = $this->StokModel->show($data['limit'], $data['offset'], 'COUNT');
		$this->db->flush_cache();
		$data['data_all_count'] = $this->StokModel->show(0, 0, 'COUNT');

		$this->load->view('laporan/stok/ajax/'. $ui, $data);
	}



	// --------------------------------------------------------------------------
	// ** Controller 		: Supplier
	// --------------------------------------------------------------------------
	public function supplier()
	{
		// Init
		$this->load->model('navigation');
		$data['user_active'] = $this->route_hak_akses(array('staf gudang', 'administrator'));
		$level = $data['user_active']['level'];
		$data['waktu_sekarang'] = new DateTime();

		// Konfigurasi
		$this->load->model('KonfigurasiModel');
		$data['app_theme'] = $this->KonfigurasiModel->get('APP_THEME');
		$data['app_name'] = $this->KonfigurasiModel->get('APP_NAMA_TOKO');
		$data['app_favicon'] = $this->KonfigurasiModel->get('APP_LOGO');
		$data['app_logo'] = $this->KonfigurasiModel->get('APP_LOGO');

		// Ui
		$data['ui_title'] = $data['app_name']. ' - Laporan Supplier';
		$data['ui_css'] = array(
		);
		$data['ui_js'] = array(
			'custom/js/datetime.js',
			'custom/js/dynamic-img.js',
		);
		$data['ui_navbar_title'] = 'Laporan';
		$data['ui_navbar_link'] = $this->navigation->nav_laporan[$level];
		$data['ui_sidebar_title'] =  $data['app_name'];
		$data['ui_sidebar_nav'] = $this->init_sidebar($level, 4);


		$this->load->view('laporan/supplier/index', $data);
	}



	// --------------------------------------------------------------------------
	// ** Ajax				: Data List Supplier
	// ** Controller 		: Supplier
	// --------------------------------------------------------------------------
	public function list_supplier($ui) {


		// Data - Filter 
		$this->db->start_cache();
		$data['limit'] = $this->input->get('limit');
		if ($data['limit'] < 0) {
			$data['limit'] = 0;
		}
		$data['page'] = $this->input->get('page');
		if ($data['page'] < 0) {
			$data['page'] = 1;
		}
		$data['filter']['Tanggal Laporan'] = date('d-m-Y');
		$data['offset'] = $data['limit'] * ($data['page'] - 1);


		$this->db->order_by('nama', 'asc');
		$this->db->stop_cache();

		// Data - Fetch
		$this->load->model('SupplierModel');
		$this->load->model('TransaksiBeliModel');

		$data['data'] = $this->SupplierModel->show($data['limit'], $data['offset'], 'OBJECT');
		$data['data_count'] = $this->SupplierModel->show($data['limit'], $data['offset'], 'COUNT');
		$this->db->flush_cache();
		$data['data_all_count'] = $this->SupplierModel->show(0, 0, 'COUNT');

		$this->load->view('laporan/supplier/ajax/'. $ui, $data);
	}

	

	// --------------------------------------------------------------------------
	// ** Controller 		: User
	// --------------------------------------------------------------------------
	public function user()
	{
		// Init
		$this->load->model('navigation');
		$data['user_active'] = $this->route_hak_akses(array('administrator'));
		$level = $data['user_active']['level'];
		$data['waktu_sekarang'] = new DateTime();

		// Konfigurasi
		$this->load->model('KonfigurasiModel');
		$data['app_theme'] = $this->KonfigurasiModel->get('APP_THEME');
		$data['app_name'] = $this->KonfigurasiModel->get('APP_NAMA_TOKO');
		$data['app_favicon'] = $this->KonfigurasiModel->get('APP_LOGO');
		$data['app_logo'] = $this->KonfigurasiModel->get('APP_LOGO');

		// Ui
		$data['ui_title'] = $data['app_name']. ' - Laporan Stok Barang';
		$data['ui_css'] = array(
		);
		$data['ui_js'] = array(
			'custom/js/datetime.js',
			'custom/js/dynamic-img.js',
		);
		$data['ui_navbar_title'] = 'Laporan';
		$data['ui_navbar_link'] = $this->navigation->nav_laporan[$level];
		$data['ui_sidebar_title'] =  $data['app_name'];
		$data['ui_sidebar_nav'] = $this->init_sidebar($level, 4);


		$this->load->view('laporan/user/index', $data);
	}



	// --------------------------------------------------------------------------
	// ** Ajax				: Data List Supplier
	// ** Controller 		: Supplier
	// --------------------------------------------------------------------------
	public function list_user($ui) {


		// Data - Filter 
		$this->db->start_cache();
		$data['limit'] = $this->input->get('limit');
		if ($data['limit'] < 0) {
			$data['limit'] = 0;
		}
		$data['page'] = $this->input->get('page');
		if ($data['page'] < 0) {
			$data['page'] = 1;
		}
		$data['filter']['Tanggal Laporan'] = date('d-m-Y');
		$data['offset'] = $data['limit'] * ($data['page'] - 1);

		$level = $this->input->get('level');
		if ($level != '') {
			$data['filter']['Level'] = $level;
			$this->db->where('level', $level);	
		}
		$blokir = $this->input->get('blokir');
		if ($blokir != '') {
			$data['filter']['Blokir'] = (($blokir) ? 'Ya' : 'Tidak');
			$this->db->where('blokir', $blokir);	
		}

		$cari = $this->input->get('cari');
		$berdasarkan = $this->input->get('berdasarkan');
		if ($cari != '' && $berdasarkan != '') {
			$data['filter']['Pencarian ['.$berdasarkan .']'] = $cari;
			$this->db->like($berdasarkan, $cari, 'BOTH');
		}

		$this->db->order_by('nama_lengkap', 'asc');
		$this->db->stop_cache();

		// Data - Fetch
		$this->load->model('UserModel');

		$data['data'] = $this->UserModel->show($data['limit'], $data['offset'], 'OBJECT');
		$data['data_count'] = $this->UserModel->show($data['limit'], $data['offset'], 'COUNT');
		$this->db->flush_cache();
		$data['data_all_count'] = $this->UserModel->show(0, 0, 'COUNT');

		$this->load->view('laporan/user/ajax/'. $ui, $data);
	}
}

/* End of file Laporan.php */
/* Location: ./application/controllers/Laporan.php */
?>