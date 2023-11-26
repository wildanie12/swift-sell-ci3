<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {

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
	// ** Controller 		: Halaman index (Menu utama / data menu center)
	// ** Level Akses 		: Semua Level
	// --------------------------------------------------------------------------
	public function index()
	{
		// Init
		$data['user_active'] = $this->route_hak_akses(array('staf gudang', 'administrator', 'kasir'));
		$data['waktu_sekarang'] = new DateTime();

		// Konfigurasi
		$this->load->model('KonfigurasiModel');
		$data['app_theme'] = $this->KonfigurasiModel->get('APP_THEME');
		$data['app_name'] = $this->KonfigurasiModel->get('APP_NAMA_TOKO');
		$data['app_favicon'] = $this->KonfigurasiModel->get('APP_LOGO');
		$data['app_logo'] = $this->KonfigurasiModel->get('APP_LOGO');

		// Ui
		$data['ui_title'] = $data['app_name']. ' - Data';
		$data['ui_css'] = array(
		);
		$data['ui_js'] = array(
			'custom/js/datetime.js',
			'custom/js/dynamic-img.js',
			'chartjs/js/chart.min.js',
		);
		$this->load->model('navigation');
		$data['ui_navbar_title'] = 'Data';
		$data['ui_navbar_link'] = $this->navigation->nav_data[$data['user_active']['level']];
		$data['ui_sidebar_title'] =  $data['app_name'];
		$data['ui_sidebar_nav'] = $this->init_sidebar($data['user_active']['level'], 2);
		$this->load->view('data/index', $data);
	}


	
	// --------------------------------------------------------------------------
	// ** Controller 		: Halaman Data Barang
	// ** Level Akses 		: Staf gudang, Administrator
	// --------------------------------------------------------------------------
	public function barang($mode = 'list')
	{
		// Init
		$this->load->model('navigation');
		$this->load->model('sidebar');
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
		$data['ui_title'] = $data['app_name']. ' - Barang';
		$data['ui_css'] = array();
		$data['ui_js'] = array(
			'custom/js/datetime.js',
			'custom/js/dynamic-img.js',
			'chartjs/js/chart.min.js',
		);
		$data['ui_navbar_title'] = 'Data';
		$data['ui_navbar_link'] = $this->navigation->nav_data[$level];
		$data['ui_sidebar_title'] =  $data['app_name'];
		$data['ui_sidebar_nav'] = $this->init_sidebar($level, 2);

		// Ui Mode Router
		if ($mode == 'list') {
			
			// Data - Kategori
			$this->load->model('KategoriModel');
			$data['data_kategori'] = $this->KategoriModel->show(0, 0, 'OBJECT');
			$this->load->view('data/barang/index', $data);
		}
		else {
			// Data - [single]
			$barang_id = $mode;
			$this->load->model('BarangModel');
			$this->load->model('KategoriModel');
			$this->load->model('StokModel');
			$data['barang'] = $this->BarangModel->single($barang_id, 'OBJECT');
			$data['kategori'] = $this->KategoriModel->single($data['barang']->kategori_id, 'OBJECT');
			$data['stok_tersedia'] = $this->StokModel->get_stok($data['barang']->id);
			$data['data_stok'] = $this->StokModel->show(0, 0, 'OBJECT');
			$this->load->view('data/barang/rincian', $data);
		}
	}

	public function upd()
	{
		$this->db->where('foto', 'assets/custom/images/barang/img_unavailable.png');
		$this->load->model('BarangModel');
		$data = $this->BarangModel->show(0, 0, 'OBJECT');
		foreach ($data as $row) {
			$this->BarangModel->update(array('foto' => 'assets/custom/images/img_unavailable.png'), $row->id);
		}
	}


	// --------------------------------------------------------------------------
	// ** Ajax Script 		: Ambil Data Barang (Read)
	// ** Level Akses 		: Staf gudang, Administrator
	// ** Parent Controller	: Barang
	// --------------------------------------------------------------------------
	public function list_barang($ui)
	{
		// Init
		$data['user_active'] = $this->route_hak_akses(array('staf gudang', 'administrator'));
		$data['waktu_sekarang'] = new DateTime();

		// Data - Filter 
		$data['limit'] = $this->input->get('limit');
		if ($data['limit'] == '') {
			$data['limit'] = 100;
		}
		else if ($data['limit'] <= 0) {
			$data['limit'] = 0;
		}
		$data['page'] = $this->input->get('page');
		if ($data['page'] < 0) {
			$data['page'] = 1;
		}
		$data['offset'] = $data['limit'] * ($data['page'] - 1);

		$this->db->start_cache();
		$search = $this->input->get('search');
		$search_by = $this->input->get('search_by');
		if ($search != '' && $search_by != '') {
			$this->db->like($search_by, $search, 'BOTH');
		}

		$kategori = $this->input->get('kategori');
		if ($kategori != '') {
			$this->db->where('kategori_id', $kategori);
		}

		$status = $this->input->get('status');
		if ($status != '') {
			$this->db->where('status', $status);
		}

		$this->db->order_by('id', 'desc');
		$this->db->stop_cache();

		// Data - Fetch
		$this->load->model('BarangModel');
		$this->load->model('StokModel');
		$this->load->model('KategoriModel');
		$this->load->model('HargaModel');

		$data['data_filtered'] = $this->BarangModel->show($data['limit'], $data['offset'], 'OBJECT');
		$data['count_filtered'] = $this->BarangModel->show($data['limit'], $data['offset'], 'COUNT');
		$data['count_all'] = $this->BarangModel->show(0, 0, 'COUNT');
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
			$this->load->view('data/barang/ajax/' . $ui, $data);
		}
	}


	// --------------------------------------------------------------------------
	// ** Ajax Script 		: Baca Tabel Kategori (Single)
	// ** Level Akses 		: Staf gudang, Administrator
	// ** Parent Controller	: Barang
	// --------------------------------------------------------------------------
	public function read_barang()
	{
		$this->load->model('BarangModel');
		$this->load->model('KategoriModel');
		$id = $this->input->get('id');
		$data = $this->BarangModel->single($id, 'OBJECT');
		$kategori = $this->KategoriModel->single($data->kategori_id, 'OBJECT');
		$object = array(
			'id' => $data->id,
			'nama' => $data->nama,
			'satuan' => $data->satuan,
			'harga' => $data->harga,
			'harga_formatted' => 'Rp. ' . number_format($data->harga, 0, '', '.'),
			'kategori_id' => $data->kategori_id,
			'kategori_formatted' => ((is_object($kategori))? $kategori->nama : 'Referensi kategori tidak ditemukan'),
			'ingat_habis' => $data->ingat_habis,
			'foto' => $data->foto,
			'foto_formatted' => site_url($data->foto),
			'status' => $data->status
		);
		echo json_encode($object);
	}



	// --------------------------------------------------------------------------
	// ** Ajax Script 		: Tulis Tabel Kategori (Update/Delete)
	// ** Level Akses 		: Staf gudang, Administrator
	// ** Parent Controller	: Barang
	// --------------------------------------------------------------------------
	public function write_barang($mode)
	{
		$this->load->model('BarangModel');
		if ($mode == 'insert') {
			$object = array(
				'nama' => $this->input->post('barang_nama'),
				'kategori_id' => $this->input->post('barang_kategori_id'),
				'satuan' => $this->input->post('barang_satuan'),
				'status' => $this->input->post('barang_status'),
				'harga' => $this->input->post('barang_harga'),
			);
			$config['upload_path'] = './assets/custom/images/barang/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|jfif';
			$config['max_size']  = '20000';
			
			$this->load->library('upload', $config);
			
			if ($this->upload->do_upload('barang_foto')){
				$data_upload = $this->upload->data();
				$object['foto'] = 'assets/custom/images/barang/' .$data_upload['file_name'];
			}
			else {
				$object['foto'] = 'assets/custom/images/img_unavailable.png';
			}
			$this->BarangModel->insert($object);
		}
		if ($mode == 'update') {
			$id = $this->input->post('id');
			$barang = $this->BarangModel->single($id, 'OBJECT');
			$object = array(
				'nama' => $this->input->post('barang_nama'),
				'kategori_id' => $this->input->post('barang_kategori_id'),
				'status' => $this->input->post('barang_status'),
				'satuan' => $this->input->post('barang_satuan'),
				'harga' => $this->input->post('barang_harga'),
			);

			$config['upload_path'] = './assets/custom/images/barang/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|jfif';
			$config['max_size']  = '20000';
			
			$this->load->library('upload', $config);
			
			if ($this->upload->do_upload('barang_foto')){
				if ($barang->foto != '') {
					if ($barang->foto != 'assets/custom/images/img_unavailable.png') {
						if (file_exists('./' .$barang->foto)) {
							unlink('./' .$barang->foto);
						}
					}
				}
				$data_upload = $this->upload->data();
				$object['foto'] = 'assets/custom/images/barang/' .$data_upload['file_name'];
			}

			$this->BarangModel->update($object, $id);
		}
		else if ($mode == 'delete') {
			/* ----------------------------------------------
			 * Protokol penghapusan barang
			 * - Hapus stok
			 * - Hapus harga
			 */

			$this->load->model('StokModel');
			$this->load->model('HargaModel');
			
			$id = $this->input->post('id');

			// Hapus stok
			$this->db->where('barang_id', $id);
			$data_stok = $this->StokModel->show(0, 0, 'OBJECT');
			foreach ($data_stok as $stok) {
				$this->StokModel->delete($stok->id);
			}

			// Hapus harga
			$this->db->where('barang_id', $id);
			$data_harga = $this->HargaModel->show(0, 0, 'OBJECT');
			foreach ($data_harga as $harga) {
				$this->HargaModel->delete($harga->id);
			}

			// Hapus barang
			$barang = $this->BarangModel->single($id, 'OBJECT');
			if (is_object($barang)) {
				if ($barang->foto != '') {
					if ($barang->foto != 'assets/custom/images/img_unavailable.png') {
						unlink('./' .$barang->foto);
					}
				}
				$this->BarangModel->delete($id);
			}
		}
	}

	// --------------------------------------------------------------------------
	// ** Controller 		: Halaman Data harga
	// ** Level Akses 		: Staf gudang, Administrator
	// --------------------------------------------------------------------------
	public function harga($mode = 'list')
	{
		// Init
		$this->load->model('navigation');
		$this->load->model('sidebar');
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
		$data['ui_title'] = $data['app_name']. ' - Harga';
		$data['ui_css'] = array();
		$data['ui_js'] = array(
			'custom/js/datetime.js',
			'custom/js/dynamic-img.js',
			'chartjs/js/chart.min.js',
		);
		$data['ui_navbar_title'] = 'Data';
		$data['ui_navbar_link'] = $this->navigation->nav_data[$level];
		$data['ui_sidebar_title'] =  $data['app_name'];
		$data['ui_sidebar_nav'] = $this->init_sidebar($level, 2);

		
		// Data - Kategori
		$this->load->model('BarangModel');
		$data['data_barang'] = $this->BarangModel->show(0, 0, 'OBJECT');
		$this->load->view('data/harga/index', $data);
	}

	// --------------------------------------------------------------------------
	// ** Ajax Script 		: List harga
	// ** Level Akses 		: Staf gudang, Administrator
	// ** Parent Controller	: Barang
	// --------------------------------------------------------------------------
	public function list_harga($ui)
	{
		// Init
		$data['user_active'] = $this->route_hak_akses(array('staf gudang', 'administrator'));
		$data['waktu_sekarang'] = new DateTime();

		// Data - Filter 
		$data['limit'] = $this->input->get('limit');
		if ($data['limit'] == '') {
			$data['limit'] = 100;
		}
		else if ($data['limit'] <= 0) {
			$data['limit'] = 0;
		}
		$data['page'] = $this->input->get('page');
		if ($data['page'] < 0) {
			$data['page'] = 1;
		}
		$data['offset'] = $data['limit'] * ($data['page'] - 1);

		$this->db->start_cache();

		$barang = $this->input->get('barang');
		if ($barang != '') {
			$this->db->where('barang_id', $barang);
		}

		$search = $this->input->get('search');
		$search_by = $this->input->get('search_by');
		if ($search != '' && $search_by != '') {
			$this->db->like($search_by, $search, 'BOTH');
		}

		$this->db->order_by('barang_id', 'asc');
		$this->db->stop_cache();

		// Data - Fetch
		$this->load->model('BarangModel');
		$this->load->model('HargaModel');

		$data['data_filtered'] = $this->HargaModel->show($data['limit'], $data['offset'], 'OBJECT');
		$data['count_filtered'] = $this->HargaModel->show($data['limit'], $data['offset'], 'COUNT');
		$data['count_all'] = $this->HargaModel->show(0, 0, 'COUNT');
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
			$this->load->view('data/harga/ajax/' . $ui, $data);
		}
	}


	// --------------------------------------------------------------------------
	// ** Ajax Script 		: Baca Tabel harga (Single)
	// ** Level Akses 		: Staf gudang, Administrator
	// ** Parent Controller	: Barang
	// --------------------------------------------------------------------------
	public function read_harga()
	{
		$this->load->model('KategoriModel');
		$this->load->model('BarangModel');
		$this->load->model('HargaModel');
		$id = $this->input->get('id');
		$data = $this->HargaModel->single($id, 'OBJECT');
		$barang = $this->BarangModel->single($data->barang_id, 'OBJECT');
		$object = array(
			'id' => $data->id,
			'barang_id' => $data->barang_id,
			'range1' => $data->range1,
			'harga' => $data->harga,
			'nama' => $data->nama,
			'barang_nama' => ((is_object($barang))? $barang->nama : 'Referensi barang tidak ditemukan'),
			'barang_satuan' => ((is_object($barang))? $barang->satuan : 'Referensi barang tidak ditemukan'),
			'barang_harga' => ((is_object($barang))? $barang->harga : 'Referensi barang tidak ditemukan'),
			'barang_harga_formatted' => ((is_object($barang))? 'Rp. ' . number_format($barang->harga, 0, '', '.') : 'Referensi barang tidak ditemukan'),
			'barang_kategori_id' => ((is_object($barang))? $barang->kategori_id : 'Referensi barang tidak ditemukan'),
			'barang_kategori_formatted' => ((is_object($barang))? ((is_object($this->KategoriModel->single($barang->id, 'OBJECT'))? ($this->KategoriModel->single($barang->id, 'OBJECT'))->nama : '')) : 'Referensi barang tidak ditemukan'),
			'barang_ingat_habis' => ((is_object($barang))? $barang->ingat_habis : 'Referensi barang tidak ditemukan'),
			'barang_foto' => ((is_object($barang))? $barang->foto : 'Referensi barang tidak ditemukan'),
			'barang_foto_formatted' => ((is_object($barang))? site_url($barang->foto) : 'Referensi barang tidak ditemukan'),
			'barang_status' => ((is_object($barang))? $barang->status : 'Referensi barang tidak ditemukan'),
		);
		echo json_encode($object);
	}



	// --------------------------------------------------------------------------
	// ** Ajax Script 		: Tulis Tabel harga (Update/Delete)
	// ** Level Akses 		: Staf gudang, Administrator
	// ** Parent Controller	: Barang
	// --------------------------------------------------------------------------
	public function write_harga($mode)
	{
		$this->load->model('HargaModel');
		if ($mode == 'insert') {
			$object = array(
				'barang_id' => $this->input->post('barang_id'),
				'range1' => $this->input->post('range1'),
				'harga' => $this->input->post('harga'),
				'nama' => $this->input->post('nama'),
			);
			$this->HargaModel->insert($object);
		}
		if ($mode == 'update') {
			$id = $this->input->post('id');
			$object = array(
				'barang_id' => $this->input->post('barang_id'),
				'range1' => $this->input->post('range1'),
				'harga' => $this->input->post('harga'),
				'nama' => $this->input->post('nama'),
			);
			$this->HargaModel->update($object, $id);
		}
		else if ($mode == 'delete') {
			$id = $this->input->post('id');
			$this->HargaModel->delete($id);
		}
	}

	// --------------------------------------------------------------------------
	// ** Ajax Script 		: Ambil Data Kategori (Read)
	// ** Level Akses 		: Staf gudang, Administrator
	// ** Parent Controller	: Barang
	// --------------------------------------------------------------------------
	public function list_kategori($ui)
	{
		// Init
		$data['user_active'] = $this->route_hak_akses(array('staf gudang', 'administrator'));
		$data['waktu_sekarang'] = new DateTime();

		// Data - Filter 
		$this->db->start_cache();
		$data['limit'] = $this->input->get('limit');
		if ($data['limit'] == '') {
			$data['limit'] = 100;
		}
		else if ($data['limit'] <= 0) {
			$data['limit'] = 0;
		}
		$data['page'] = $this->input->get('page');
		if ($data['page'] < 0) {
			$data['page'] = 1;
		}
		$data['offset'] = $data['limit'] * ($data['page'] - 1);

		$cari = $this->input->get('cari');
		$berdasarkan = $this->input->get('berdasarkan');
		if ($cari != '' && $berdasarkan != '') {
			$this->db->like($berdasarkan, $cari, 'BOTH');
		}
		$this->db->order_by('id', 'desc');
		$this->db->stop_cache();

		// Data - Fetch
		$this->load->model('KategoriModel');

		$data['data'] = $this->KategoriModel->show($data['limit'], $data['offset'], 'OBJECT');
		$data['data_count'] = $this->KategoriModel->show($data['limit'], $data['offset'], 'COUNT');
		$this->db->flush_cache();
		$data['data_all_count'] = $this->KategoriModel->show(0, 0, 'COUNT');

		$this->load->view('data/kategori/ajax/'. $ui, $data);
	}

	// --------------------------------------------------------------------------
	// ** Ajax Script 		: Tulis Tabel Kategori (Update/Delete)
	// ** Level Akses 		: Staf gudang, Administrator
	// ** Parent Controller	: Barang
	// --------------------------------------------------------------------------
	public function write_kategori($mode)
	{
		$this->load->model('KategoriModel');
		if ($mode == 'insert') {
			$object = array(
				'nama' => $this->input->post('nama'),
				'foto' => $this->input->post('foto'),
				'keterangan' => $this->input->post('keterangan')
			);
			$this->KategoriModel->insert($object);
		}
		if ($mode == 'update') {
			$id = $this->input->post('id');
			$object = array(
				'nama' => $this->input->post('nama'),
				'foto' => $this->input->post('foto'),
				'keterangan' => $this->input->post('keterangan')
			);
			$this->KategoriModel->update($object, $id);
		}
		else if ($mode == 'delete') {
			$id = $this->input->post('id');
			$this->KategoriModel->delete($id);
		}
	}


	// --------------------------------------------------------------------------
	// ** Ajax Script 		: Ambil Statistik Stok
	// ** Level Akses 		: All
	// ** Parent Controller	: Barang
	// --------------------------------------------------------------------------
	public function statistik_barang($barang_id)
	{
		$this->load->model('StokModel');
		$this->load->model('BarangModel');
		$this->load->model('TransaksiModel');
		$this->load->model('ItemTransaksiModel');
		$barang = $this->BarangModel->single($barang_id, 'OBJECT');

		$tanggal_awal = $this->input->get('tanggal_awal');
		$tanggal_akhir = $this->input->get('tanggal_akhir');

		$tanggal_awal = new DateTime($tanggal_awal);
		$tanggal_akhir = new DateTime($tanggal_akhir);
		$tanggal_akhir->modify('+1 Day');

		$interval = new DateInterval('P1D');
		$range = new DatePeriod($tanggal_awal, $interval, $tanggal_akhir);

		$json['label'] = array();
		$json['barang_masuk'] = array();
		$json['barang_keluar'] = array();
		foreach ($range as $date) {

			// -------------------------------
			// Data Pemasukan Stok
			// -------------------------------
			$barang_masuk = 0;
			$this->db->where('barang_id', $barang_id);
			$this->db->where('tanggal_masuk', $date->format('Y-m-d'));
			$data_stok = $this->StokModel->show(0, 0, 'OBJECT');
			$this->db->reset_query();
			foreach ($data_stok as $stok) {
				$barang_masuk += $stok->stok;				
			}

			// -----------------------------
			// Data Pengeluaran Stok
			// -----------------------------
			// Transaksi >> Item Transaksi >>| Stok >>| Barang  || QTY on Item Transaksi
			// -----------------------------
			$barang_keluar = 0;
			$this->db->where('tanggal', $date->format('Y-m-d'));
			$data_transaksi = $this->TransaksiModel->show(0, 0, "OBJECT");
			foreach ($data_transaksi as $transaksi) {
				$this->db->where('transaksi_id', $transaksi->id);
				$data_item_tr = $this->ItemTransaksiModel->show(0, 0, 'OBJECT');
				foreach ($data_item_tr as $item_tr) {
					$stok = $this->StokModel->single($item_tr->stok_id, 'OBJECT');
					if (is_object($stok)) {
						if ($stok->barang_id == $barang_id) {
							$barang_keluar += $item_tr->qty;
						}
					}
				}
			}

			$json['label'][] = $date->format('d M');
			$json['barang_masuk'][] = $barang_masuk;
			$json['barang_keluar'][] = $barang_keluar;
		}
		echo json_encode($json);
	}

	// --------------------------------------------------------------------------
	// ** Ajax Script 		: Ambil Statistik Penjualan
	// ** Level Akses 		: All
	// ** Parent Controller	: Barang
	// --------------------------------------------------------------------------
	public function statistik_penjualan($barang_id)
	{
		$this->load->model('StokModel');
		$this->load->model('BarangModel');
		$this->load->model('TransaksiModel');
		$this->load->model('ItemTransaksiModel');
		$barang = $this->BarangModel->single($barang_id, 'OBJECT');

		$tanggal_awal = $this->input->get('tanggal_awal');
		$tanggal_akhir = $this->input->get('tanggal_akhir');

		$tanggal_awal = new DateTime($tanggal_awal);
		$tanggal_akhir = new DateTime($tanggal_akhir);
		$tanggal_akhir->modify('+1 Day');

		$interval = new DateInterval('P1D');
		$range = new DatePeriod($tanggal_awal, $interval, $tanggal_akhir);

		$json['label'] = array();
		$json['pemasukan'] = array();
		foreach ($range as $date) {
			$json['label'][] = $date->format('d M');
			$penjualan = 0;
			$this->db->where('barang_id', $barang_id);
			$data_stok = $this->StokModel->show(0, 0, 'OBJECT');
			$this->db->reset_query();
			foreach ($data_stok as $stok) {
				$this->db->where('stok_id', $stok->id);
				$data_item = $this->ItemTransaksiModel->show(0, 0, 'OBJECT');
				$this->db->reset_query();
				foreach ($data_item as $item) {
					 $transaksi = $this->TransaksiModel->single($item->transaksi_id, 'OBJECT');
					 if ($transaksi->tanggal == $date->format('Y-m-d')) {
					 	$penjualan += $item->total;
					 }
				}
			}
			$json['penjualan'][] = $penjualan;
		}
		echo json_encode($json);
	}



	// --------------------------------------------------------------------------
	// ** Controller 		: Halaman Data Stok
	// ** Level Akses 		: Staf gudang, Administrator
	// --------------------------------------------------------------------------
	public function stok($mode = 'list', $submit = FALSE)
	{
		// Init
		$this->load->model('navigation');
		$this->load->model('sidebar');
		$data['user_active'] = $this->route_hak_akses(array('staf gudang', 'administrator'));
		$level = $data['user_active']['level'];
		$data['waktu_sekarang'] = new DateTime();

		// Konfigurasi
		$this->load->model('KonfigurasiModel');
		$data['app_theme'] = $this->KonfigurasiModel->get('APP_THEME');
		$data['app_name'] = $this->KonfigurasiModel->get('APP_NAMA_TOKO');
		$data['app_favicon'] = $this->KonfigurasiModel->get('APP_LOGO');
		$data['app_logo'] = $this->KonfigurasiModel->get('APP_LOGO');
		$data['default_kadaluarsa'] = $this->KonfigurasiModel->get('DATA_DEFAULT_KADALUARSA');

		// Ui
		$data['ui_title'] = $data['app_name']. ' - Stok';
		$data['ui_css'] = array();
		$data['ui_js'] = array(
			'custom/js/datetime.js',
			'custom/js/dynamic-img.js',
			'JsBarcode/js/JsBarcode.all.min.js',
		);
		$data['ui_navbar_title'] = 'Data';
		$data['ui_navbar_link'] = $this->navigation->nav_data[$level];
		$data['ui_sidebar_title'] =  $data['app_name'];
		$data['ui_sidebar_nav'] = $this->init_sidebar($level, 2);

		if ($mode == 'list') {

			// ** Data Barang
			// ------------------------
			$this->load->model('BarangModel');
			$this->db->order_by('nama', 'asc');
			$data['data_barang'] = $this->BarangModel->show(0, 0, 'OBJECT');
			$this->load->view('data/stok/index', $data);
		}
		else if ($mode == 'tambah') {
			if ($submit != FALSE) {
				$this->load->model('StokModel');

				$barang_id = $this->input->post('barang_id');
				$redirect_url = $this->input->post('redirect');
				$barcode = $this->input->post('barcode');
				$tgl_kadaluarsa = $this->input->post('tgl_kadaluarsa');
				$ingat_kadaluarsa = $this->input->post('ingat_kadaluarsa');

				$barcode_wrapper_array = explode('|', rtrim($barcode, '|'));
				foreach ($barcode_wrapper_array as $wrapper) {
					$element = explode(':', $wrapper);
					$kode = $element[0];
					$stok = $element[1];

					$object = array(
						'barcode' => $element[0],
						'stok_awal' => $element[1],
						'stok' => $element[1],
						'tanggal_masuk' => date('Y-m-d'),
						'tgl_kadaluarsa' => $tgl_kadaluarsa,
						'ingat_kadaluarsa' => $ingat_kadaluarsa,
						'barang_id' => $barang_id,
						'transaksi_id' => -1
					);
					$this->StokModel->insert($object);
				}

				if ($redirect_url != '') {
					redirect(site_url($redirect_url),'refresh');
				}
				else {
					redirect(site_url('data/stok'),'refresh');
				}
				die;
			}

			$this->load->model('BarangModel');
			$barang_id = $this->input->get('barang');
			$data['redirect'] = $this->input->get('redirect');
			$data['barang'] = $this->BarangModel->single($barang_id, 'OBJECT');

			$this->load->view('data/stok/tambah', $data);
		}

	}


	// --------------------------------------------------------------------------
	// ** Ajax 			: Cek Kode Stok
	// --------------------------------------------------------------------------
	public function cek_kode()
	{
		$barcode = $this->input->get('barcode');
		$this->load->model('StokModel');
		$this->load->model('BarangModel');

		$this->db->where('barcode', $barcode);
		$json['stok_count'] = $this->StokModel->show(0, 0, 'COUNT');
		if ($json['stok_count'] > 0) {
			$json['stok'] = $this->StokModel->single_by('barcode', $barcode, 'OBJECT');
			$json['barang'] = $this->BarangModel->single($json['stok']->barang_id, 'OBJECT');
		}
		echo json_encode($json);
	}







	// --------------------------------------------------------------------------
	// ** Ajax Script 		: Ambil Data Stok (Read)
	// ** Level Akses 		: Staf gudang, Administrator
	// ** Parent Controller	: Stok
	// --------------------------------------------------------------------------
	public function list_stok($ui)
	{
		// Init
		$data['user_active'] = $this->route_hak_akses(array('staf gudang', 'administrator', 'kasir'));
		$data['waktu_sekarang'] = new DateTime();

		// Data - Filter 
		$this->db->start_cache();
		$data['limit'] = $this->input->get('limit');
		if ($data['limit'] == '') {
			$data['limit'] = 100;
		}
		else if ($data['limit'] <= 0) {
			$data['limit'] = 0;
		}
		$data['page'] = $this->input->get('page');
		if ($data['page'] < 0) {
			$data['page'] = 1;
		}
		$data['offset'] = $data['limit'] * ($data['page'] - 1);

		$transaksi = $this->input->get('transaksi');
		if ($transaksi != '') {
			$this->db->where('transaksi_id', $transaksi);
		}

		$search = $this->input->get('search');
		$search_by = $this->input->get('search_by');
		if ($search != '' && $search_by != '') {
			$this->db->like($search_by, $search, 'BOTH');
		}

		$barang = $this->input->get('barang');
		if ($barang != '') {
			$this->db->where('barang_id', $barang);
		}
		$this->db->order_by('id', 'desc');
		$this->db->stop_cache();

		// Data - Fetch
		$this->load->model('BarangModel');
		$this->load->model('StokModel');
		$this->load->model('KategoriModel');

		$data['data_filtered'] = $this->StokModel->show($data['limit'], $data['offset'], 'OBJECT');
		$data['count_filtered'] = $this->StokModel->show($data['limit'], $data['offset'], 'COUNT');
		$data['count_all'] = $this->StokModel->show(0, 0, 'COUNT');
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

		$this->load->view('data/stok/ajax/'. $ui, $data);
	}


	// --------------------------------------------------------------------------
	// ** Ajax Script 		: Baca Tabel Kategori (Single)
	// ** Level Akses 		: Staf gudang, Administrator
	// ** Parent Controller	: Barang
	// --------------------------------------------------------------------------
	public function read_stok($mode = 'id')
	{
		$this->load->model('StokModel');
		$this->load->model('BarangModel');
		if ($mode == 'id') {
			$id = $this->input->get('id');
			$stok = $this->StokModel->single($id, 'OBJECT');
		}
		else if ($mode == 'barcode') {
			$barcode = $this->input->get('barcode');
			$stok = $this->StokModel->single_by('barcode', $barcode, 'OBJECT');
		}

		if (is_object($stok)) {
			$barang = $this->BarangModel->single($stok->barang_id, 'OBJECT');
			$object = array(
				'id' => $stok->id,
				'barcode' => $stok->barcode,
				'stok_awal' => $stok->stok_awal,
				'stok' => $stok->stok,
				'tanggal_masuk' => $stok->tanggal_masuk,
				'tgl_kadaluarsa' => $stok->tgl_kadaluarsa,
				'ingat_kadaluarsa' => $stok->ingat_kadaluarsa,
				'barang_id' => $stok->barang_id,
				'transaksi_id' => $stok->transaksi_id
			);
			if (isset($barang)) {
				$object['barang_id'] = $barang->id;
				$object['barang_nama'] = $barang->nama;
				$object['barang_satuan'] = $barang->satuan;
				$object['barang_harga'] = $barang->harga;
				$object['barang_harga_formatted'] = 'Rp ' .number_format($barang->harga, 0, '', '.');
				$object['barang_kategori_id'] = $barang->kategori_id;
				$object['barang_ingat_habis'] = $barang->ingat_habis;
				$object['barang_foto'] = $barang->foto;
				$object['barang_foto_formatted'] = site_url($barang->foto);
				$object['barang_status'] = $barang->status;
			}
			echo json_encode($object);
		}
		else {
			echo "Referensi stok tidak ditemukan";
		}
	}


	// --------------------------------------------------------------------------
	// ** Ajax Script 		: Write Stok
	// ** Level Akses 		: Staf gudang, Administrator
	// ** Parent Controller	: Stok
	// --------------------------------------------------------------------------
	public function write_stok($mode)
	{
		$this->load->model('StokModel');
		
		if ($mode == 'delete') {
			$id = $this->input->post('id');
			$this->StokModel->delete($id);
		}
		else if ($mode == 'insert') {
			$this->load->model('StokModel');
			$barang_id = $this->input->post('stok-barang_id');
			$redirect_url = $this->input->post('redirect');
			$barcode = $this->input->post('stok-barcode');
			$tgl_kadaluarsa = $this->input->post('stok-tgl_kadaluarsa');
			$ingat_kadaluarsa = $this->input->post('stok-ingat_kadaluarsa');
			$transaksi_id = $this->input->post('stok-transaksi_id');

			$barcode_wrapper_array = explode('|', rtrim($barcode, '|'));
			foreach ($barcode_wrapper_array as $wrapper) {
				$element = explode(':', $wrapper);
				$kode = $element[0];
				$stok = $element[1];

				$object = array(
					'barcode' => $element[0],
					'stok_awal' => $element[1],
					'stok' => $element[1],
					'tanggal_masuk' => date('Y-m-d'),
					'tgl_kadaluarsa' => $tgl_kadaluarsa,
					'ingat_kadaluarsa' => $ingat_kadaluarsa,
					'barang_id' => $barang_id,
					'transaksi_id' => $transaksi_id
				);
				$this->StokModel->insert($object);
			}
		}
		else if ($mode == 'update') {
			$this->load->model('StokModel');
			$id = $this->input->post('id');
			$object = array(
				'barcode' => $this->input->post('stok-barcode'),
				'stok' => $this->input->post('stok-stok'),
				'ingat_kadaluarsa' => $this->input->post('stok-ingat_kadaluarsa'),
				'tgl_kadaluarsa' => $this->input->post('stok-tgl_kadaluarsa')
			);
			$this->StokModel->update($object, $id);
		}
	}

	// --------------------------------------------------------------------------
	// ** Metode 	 		: Mencari ID Barang Baru
	// ** Level Akses 		: Staf gudang, Administrator
	// ** Parent controller : Stok
	// --------------------------------------------------------------------------
	public function getNewID()
	{
		$this->load->model('StokModel');
		$kode = $this->StokModel->getNewID();
		if ($kode == '') {
			$kode = 0;
		}
		$kode++;
		$kode .= random_string('numeric', 2);
		$json['kode'] = $kode;
		echo json_encode($json);
	}



	// --------------------------------------------------------------------------
	// ** Controller 			: User
	// ** Level akses 			: Administrator
	// --------------------------------------------------------------------------
	public function user()
	{
		// Init
		$this->load->model('navigation');
		$this->load->model('sidebar');
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
		$data['ui_title'] = $data['app_name']. ' - User';
		$data['ui_css'] = array(
		);
		$data['ui_js'] = array(
			'custom/js/datetime.js',
			'custom/js/dynamic-img.js',
			'chartjs/js/chart.min.js',
		);
		$data['ui_navbar_title'] = 'Data';
		$data['ui_navbar_link'] = $this->navigation->nav_data[$level];
		$data['ui_sidebar_title'] =  $data['app_name'];
		$data['ui_sidebar_nav'] = $this->init_sidebar($level, 2);

		// Data - Kategori
		$this->load->model('KategoriModel');
		$data['data_kategori'] = $this->KategoriModel->show(0, 0, 'OBJECT');
		$this->load->view('data/user/index', $data);
	}


	// --------------------------------------------------------------------------
	// ** Ajax Script 		: Ambil Data User (Read)
	// ** Level Akses 		: Administrator
	// ** Parent Controller	: User
	// --------------------------------------------------------------------------
	public function list_user($ui)
	{
		// Init
		$data['user_active'] = $this->route_hak_akses(array('administrator'));
		$data['waktu_sekarang'] = new DateTime();

		// Data - Filter 
		$this->db->start_cache();
		$data['limit'] = $this->input->get('limit');
		if ($data['limit'] == '') {
			$data['limit'] = 100;
		}
		else if ($data['limit'] <= 0) {
			$data['limit'] = 0;
		}
		$data['page'] = $this->input->get('page');
		if ($data['page'] < 0) {
			$data['page'] = 1;
		}
		$data['offset'] = $data['limit'] * ($data['page'] - 1);

		$search = $this->input->get('search');
		$search_by = $this->input->get('search_by');
		if ($search != '' && $search_by != '') {
			$this->db->like($search_by, $search, 'BOTH');
		}

		$level = $this->input->get('level');
		if ($level != '') {
			$this->db->where('level', $level);
		}

		$blokir = $this->input->get('blokir');
		if ($blokir != '') {
			$this->db->where('blokir', $blokir);
		}


		$this->db->order_by('nama_lengkap', 'asc');
		$this->db->stop_cache();

		// Data - Fetch
		$this->load->model('UserModel');

		$data['data_filtered'] = $this->UserModel->show($data['limit'], $data['offset'], 'OBJECT');
		$data['count_filtered'] = $this->UserModel->show($data['limit'], $data['offset'], 'COUNT');
		$data['count_all'] = $this->UserModel->show(0, 0, 'COUNT');
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

		$this->load->view('data/user/ajax/'. $ui, $data);
	}


	// --------------------------------------------------
	// ** Ajax Script 		: Tulis Data User (Write)
	// ** Level Akses 		: Administrator
	// ** Parent Controller	: User
	// --------------------------------------------------
	public function write_user($mode)
	{
		$this->load->model('UserModel');
		if ($mode == 'insert') {
			$this->encryption->initialize(array(
				'mode' => 'ctr'
			));
			$object = array(
				'nama_lengkap' => $this->input->post('user-nama_lengkap'),
				'username' => $this->input->post('user-username'),
				'password' => base64_encode($this->encryption->encrypt($this->input->post('user-password'))),
				'level' => $this->input->post('user-level'),
				'alamat' => $this->input->post('user-alamat'),
				'alamat_printer' => $this->input->post('user-alamat_printer'),
				'nama_printer' => $this->input->post('user-nama_printer'),
				'tgl_masuk' => date('Y-m-d'),
				'blokir' => 'N'
			);
			$config['upload_path'] = './assets/custom/images/user/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|jfif';
			$config['max_size']  = '20000';
			
			$this->load->library('upload', $config);
			
			if ($this->upload->do_upload('user-avatar')){
				$data_upload = $this->upload->data();
				$object['avatar'] = 'assets/custom/images/user/' .$data_upload['file_name'];
			}
			else {
				$object['avatar'] = 'assets/custom/images/img_unavailable.png';
			}
			$this->UserModel->insert($object);
		}
		if ($mode == 'update') {
			$this->encryption->initialize(array(
				'mode' => 'ctr'
			));
			$username = $this->input->post('user-username');
			$user = $this->UserModel->single($username, 'OBJECT');
			$object = array(
				'nama_lengkap' => $this->input->post('user-nama_lengkap'),
				'username' => $this->input->post('user-username'),
				'level' => $this->input->post('user-level'),
				'alamat' => $this->input->post('user-alamat'),
				'alamat_printer' => $this->input->post('user-alamat_printer'),
				'nama_printer' => $this->input->post('user-nama_printer'),
				'tgl_masuk' => date('Y-m-d'),
				'blokir' => 'Y'
			);
			if ($this->input->post('user-password') != '') {
				$object['password'] = base64_encode($this->encryption->encrypt($this->input->post('user-password')));
			}

			$config['upload_path'] = './assets/custom/images/user/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|jfif';
			$config['max_size']  = '20000';
			
			$this->load->library('upload', $config);
			
			if ($this->upload->do_upload('user-avatar')){
				if ($user->foto != '') {
					if ($user->foto != 'assets/custom/images/img_unavailable.png') {
						unlink('./' .$user->foto);
					}
				}
				$data_upload = $this->upload->data();
				$object['avatar'] = 'assets/custom/images/user/' .$data_upload['file_name'];
			}
			$this->UserModel->update($object, $username);
		}
		else if ($mode == 'delete') {
			$username = $this->input->post('username');
			$user = $this->UserModel->single($username, 'OBJECT');
			if ($user->avatar != '') {
				if ($user->avatar != 'assets/custom/images/img_unavailable.png') {
					unlink('./' .$user->avatar);
				}
			}
			$this->UserModel->delete($username);
		}
	}

	// --------------------------------------------------------------------------
	// ** Ajax Script 		: Baca Tabel User (Single)
	// ** Level Akses 		: Staf gudang, Administrator
	// ** Parent Controller	: Barang
	// --------------------------------------------------------------------------
	public function read_user()
	{
		$this->load->model('UserModel');
		$username = $this->input->get('username');
		$data = $this->UserModel->single($username, 'OBJECT');
		$object = array(
			'username' => $data->username,
			'password' => $data->password,
			'nama_lengkap' => $data->nama_lengkap,
			'level' => $data->level,
			'blokir' => $data->blokir,
			'alamat' => $data->alamat,
			'avatar' => $data->avatar,
			'avatar_formatted' => site_url($data->avatar),
			'tgl_masuk' => $data->tgl_masuk,
			'alamat_printer' => $data->alamat_printer,
			'nama_printer' => $data->nama_printer
		);
		echo json_encode($object);
	}



	// --------------------------------------------------------------------------
	// ** Controller 		: Halaman Data Transaksi
	// ** Level Akses 		: kasir, Administrator
	// --------------------------------------------------------------------------
	public function transaksi()
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
		$data['ui_title'] = $data['app_name']. ' - Transaksi';
		$data['ui_css'] = array(
		);
		$data['ui_js'] = array(
			'custom/js/datetime.js',
			'custom/js/dynamic-img.js',
			'chartjs/js/chart.min.js',
		);
		$data['ui_navbar_title'] = 'Data';
		$data['ui_navbar_link'] = $this->navigation->nav_data[$level];
		$data['ui_sidebar_title'] =  $data['app_name'];
		$data['ui_sidebar_nav'] = $this->init_sidebar($level, 2);

		// Data - Kategori
		$this->load->model('UserModel');
		$this->db->where('level', 'kasir');
		$this->db->or_where('level', 'administrator');
		$data['data_user'] = $this->UserModel->show(0, 0, 'OBJECT');
		$this->load->view('data/transaksi/index', $data);
	}


	// --------------------------------------------------------------------------
	// ** Ajax Script 		: Ambil Data Transkasi (Read)
	// ** Level Akses 		: Administrator
	// ** Parent Controller	: Transaksi
	// --------------------------------------------------------------------------
	public function list_transaksi($ui)
	{
		// Init
		$data['user_active'] = $this->route_hak_akses(array('administrator', 'kasir'));
		$data['waktu_sekarang'] = new DateTime();

		// Data - Filter 
		$this->db->start_cache();
		$data['limit'] = $this->input->get('limit');
		if ($data['limit'] == '') {
			$data['limit'] = 100;
		}
		else if ($data['limit'] <= 0) {
			$data['limit'] = 0;
		}
		$data['page'] = $this->input->get('page');
		if ($data['page'] < 0) {
			$data['page'] = 1;
		}
		$data['offset'] = $data['limit'] * ($data['page'] - 1);

		$search = $this->input->get('search');
		$search_by = $this->input->get('search_by');
		if ($search != '' && $search_by != '') {
			$this->db->like($search_by, $search, 'BOTH');
		}

		$username = $this->input->get('username');
		if ($username != '') {
			$this->db->where('kasir', $username);
		}

		$tanggal_dari = $this->input->get('tanggal_dari');
		$tanggal_sampai = $this->input->get('tanggal_sampai');
		if ($tanggal_dari != '' && $tanggal_sampai != '') {
			$this->db->where('tanggal BETWEEN "' .$tanggal_dari. '" AND "' .$tanggal_sampai. '" ');
		}
		else if ($tanggal_dari != '') {
			$this->db->where('tanggal >= "' .$tanggal_dari. '"');
		}
		else if ($tanggal_sampai != '') {
			$this->db->where('tanggal <= "' .$tanggal_sampai. '"');
		}

		$this->db->order_by('id', 'desc');
		$this->db->stop_cache();

		// Data - Fetch
		$this->load->model('TransaksiModel');
		$this->load->model('UserModel');

		$data['data'] = $this->TransaksiModel->show($data['limit'], $data['offset'], 'OBJECT');
		$data['data_count'] = $this->TransaksiModel->show($data['limit'], $data['offset'], 'COUNT');
		$this->db->flush_cache();
		$data['data_all_count'] = $this->TransaksiModel->show(0, 0, 'COUNT');

		$this->load->view('data/transaksi/ajax/'. $ui, $data);
	}

	public function write_Transaksi($mode)
	{
		$this->load->model('TransaksiModel');
		$this->load->model('ItemTransaksiModel');
		if ($mode == 'delete') {
			$id = $this->input->post('id');

			// Item
			$this->db->where('transaksi_id', $id);
			$data_item = $this->ItemTransaksiModel->show(0, 0, "OBJECT");
			$this->db->reset_query();
			foreach ($data_item as $item) {
				$this->ItemTransaksiModel->delete($item->id);
			}
			$this->TransaksiModel->delete($id);
		}
	}

	// --------------------------------------------------------------------------
	// ** Ajax Script 		: Ambil Data Item TR (Read)
	// ** Level Akses 		: Administrator
	// ** Parent Controller	: Transaksi
	// --------------------------------------------------------------------------
	public function list_item_transaksi($ui)
	{
		// Init
		$data['user_active'] = $this->route_hak_akses(array('kasir', 'administrator'));
		$data['userdata'] = $data['user_active']['userdata'];
		$data['waktu_sekarang'] = new DateTime();

		// Data - Filter 
		$this->db->start_cache();
		$transaksi = $this->input->get('id');
		if ($transaksi != '') {
			$this->db->where('transaksi_id', $transaksi);
		}
		$this->db->stop_cache();

		// Data - Fetch
		$this->load->model('TransaksiModel');
		$this->load->model('ItemTransaksiModel');
		$this->load->model('StokModel');
		$this->load->model('BarangModel');


		$data['data'] = $this->ItemTransaksiModel->show(0, 0, 'OBJECT');
		$data['data_count'] = $this->ItemTransaksiModel->show(0, 0, 'COUNT');
		$this->db->flush_cache();
		$data['data_all_count'] = $this->ItemTransaksiModel->show(0, 0, 'COUNT');
		$data['transaksi'] = $this->TransaksiModel->single($transaksi, 'OBJECT');

		$this->load->view('data/item_transaksi/ajax/'. $ui, $data);
	}

	// --------------------------------------------------------------------------
	// ** Ajax Script 		: Overall Data capaian
	// ** Level Akses 		: Administrator
	// ** Parent Controller	: Dashboard
	// --------------------------------------------------------------------------
	public function capaian()
	{
		$waktu_sekarang = new DateTime();

		$this->load->model('BarangModel');
		$this->load->model('StokModel');
		$this->load->model('TransaksiModel');
		$this->load->model('ItemTransaksiModel');

		$this->db->where('status', 'dijual');
		$json['barang']['count'] = $this->BarangModel->show(0, 0, 'COUNT');
		$this->db->reset_query();

		$this->db->where('stok != 0');
		$data_stok = $this->StokModel->show(0, 0, "OBJECT");
		$this->db->reset_query();
		$json['stok']['count'] = 0;
		foreach ($data_stok as $stok) {
			$barang = $this->BarangModel->single($stok->barang_id, 'OBJECT');
			if ($barang->status == 'dijual') {
				$json['stok']['count'] += $stok->stok;
			}
		}

		$this->db->where('tanggal', $waktu_sekarang->format('Y-m-d'));
		$json['transaksi']['count'] = $this->TransaksiModel->show(0, 0, 'COUNT');
		
		$this->db->where('tanggal', $waktu_sekarang->format('Y-m-d'));
		$data_transaksi = $this->TransaksiModel->show(0, 0, 'OBJECT');
		$this->db->reset_query();
		
		$json['item_transaksi']['count'] = 0;
		foreach ($data_transaksi as $transaksi) {
			$this->db->where('transaksi_id', $transaksi->id);
			$data_item = $this->ItemTransaksiModel->show(0, 0, "OBJECT");
			$this->db->reset_query();
			foreach ($data_item as $item) {
				$json['item_transaksi']['count'] += $item->qty;
			}
		}
		echo json_encode($json);
	}



	public function edit_profil()
	{
		// Init
		$this->load->model('navigation');
		$this->load->model('sidebar');
		$data['user_active'] = $this->route_hak_akses('ALL_LOGGED_USER_ONLY');
		$level = $data['user_active']['level'];
		$data['waktu_sekarang'] = new DateTime();

		// Konfigurasi
		$this->load->model('KonfigurasiModel');
		$data['app_theme'] = $this->KonfigurasiModel->get('APP_THEME');
		$data['app_name'] = $this->KonfigurasiModel->get('APP_NAMA_TOKO');
		$data['app_favicon'] = $this->KonfigurasiModel->get('APP_LOGO');
		$data['app_logo'] = $this->KonfigurasiModel->get('APP_LOGO');

		// Ui
		$data['ui_title'] = $data['app_name']. ' - Edit profil';
		$data['ui_css'] = array(
		);
		$data['ui_js'] = array(
			'custom/js/datetime.js',
			'custom/js/dynamic-img.js',
			'chartjs/js/chart.min.js',
		);
		$data['ui_navbar_title'] = 'Profil';
		$data['ui_navbar_link'] = array();
		$data['ui_sidebar_title'] =  $data['app_name'];
		$data['ui_sidebar_nav'] = $this->init_sidebar($level);
		$this->load->view('profile/edit', $data);
	}
}

/* End of file Data.php */
/* Location: ./application/controllers/Data.php */
?>