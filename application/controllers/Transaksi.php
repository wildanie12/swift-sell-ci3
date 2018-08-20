<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

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
		$data['ui_title'] = $data['app_name']. ' - Transaksi';
		$data['ui_css'] = array(
		);
		$data['ui_js'] = array(
			'custom/js/datetime.js',
			'custom/js/dynamic-img.js',
			'chartjs/js/chart.min.js',
		);
		$data['ui_navbar_title'] = 'Transaksi';
		$data['ui_navbar_link'] = $this->navigation->nav_transaksi[$level];
		$data['ui_sidebar_title'] =  $data['app_name'];
		$data['ui_sidebar_nav'] = $this->init_sidebar($level, 3);
		$this->load->view('transaksi/index', $data);
	}

	// --------------------------------------------------------------------------
	// ** Controller 		: Halaman Transaksi Pembelian
	// ** Level Akses 		: Kasir, Administrator
	// --------------------------------------------------------------------------
	public function pembelian()
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
		$data['default_kadaluarsa'] = $this->KonfigurasiModel->get('DATA_DEFAULT_KADALUARSA');

		// Ui
		$data['ui_title'] = $data['app_name']. ' - Transaksi Pembelian';
		$data['ui_css'] = array(
		);
		$data['ui_js'] = array(
			'custom/js/datetime.js',
			'custom/js/dynamic-img.js',
			'jsBarcode/js/jsBarcode.all.min.js'
		);
		$data['ui_navbar_title'] = 'Transaksi';
		$data['ui_navbar_link'] = $this->navigation->nav_transaksi[$level];
		$data['ui_sidebar_title'] = $data['app_name'];
		$data['ui_sidebar_nav'] = $this->init_sidebar($level, 3);

		// Data - Barang
		$this->load->model('BarangModel');
		$this->db->order_by('nama', 'asc');
		$data['data_barang'] = $this->BarangModel->show(0, 0, 'OBJECT');
		$this->db->reset_query();

		$this->load->view('transaksi/pembelian', $data);
	}


	// --------------------------------------------------------------------------
	// ** Ajax 					: Read Single (Ambil berdasarkan faktur)
	// ** Level akses 			: Kasir, Administrator
	// ** Parent Controller 	: Transaksi Beli
	// --------------------------------------------------------------------------
	public function read_transaksi_beli()
	{
		$this->load->model('TransaksiBeliModel');
		$faktur = $this->input->get('faktur');
		$json['count'] = $this->TransaksiBeliModel->single($faktur, 'COUNT');
		$json['data'] = $this->TransaksiBeliModel->single($faktur, 'OBJECT');

		echo json_encode($json);
	}


	// --------------------------------------------------------------------------
	// ** Ajax Script 		: Tulis Tabel Transaksi (Insert/Delete)
	// ** Level Akses 		: Staf gudang, Administrator
	// ** Parent Controller	: transaksi beli
	// --------------------------------------------------------------------------
	public function write_transaksi_beli($mode)
	{
		$this->load->model('TransaksiBeliModel');
		if ($mode == 'insert') {
			$data['user_active'] = $this->route_hak_akses(array('kasir', 'administrator'));
			$level = $data['user_active']['level'];
			$waktu_sekarang = new DateTime();

			$object = array(
				'no_faktur' => $this->input->post('pembelian-no_faktur'),
				'tanggal_faktur' => $this->input->post('pembelian-tanggal_faktur'),
				'supplier_id' => $this->input->post('pembelian-supplier_id'),
				'harga_beli' => $this->input->post('pembelian-harga_beli'),
				'jenis_pembayaran' => $this->input->post('pembelian-jenis_pembayaran'),
				'username' => $data['user_active']['userdata']->username,
				'tanggal' => date('Y-m-d'),
				'waktu' => date('H:i:s')
			);
			if ($object['jenis_pembayaran'] == 'kredit') {
				$object['jatuh_tempo'] = $this->input->post('pembelian-jatuh_tempo');
			}
			$this->TransaksiBeliModel->insert($object);
			$json['transaksi_id'] = $this->db->insert_id();
			echo json_encode($json);
		}
		else if ($mode == 'set_selesai') {
			$id = $this->input->post('id');
			$selesai = $this->input->post('selesai');
			$object = array(
				'kredit_selesai' => $selesai
			);
			$this->TransaksiBeliModel->update($object, $id);
		}
		else if ($mode == 'delete') {
			$this->load->model('StokModel');
			
			$id = $this->input->post('id');
			$query = $this->TransaksiBeliModel->delete($id);
			if ($query) {
				$this->db->where('transaksi_id', $id);
				$data_stok = $this->StokModel->show(0, 0, 'OBJECT');
				foreach ($data_stok as $stok) {
					$this->StokModel->delete($stok->id);
				}
			}
		}
	}


	// --------------------------------------------------------------------------
	// ** Ajax 					: Supplier
	// ** Level akses 			: Kasir, Administrator
	// ** Parent Controller 	: Transaksi Beli
	// --------------------------------------------------------------------------
	public function list_supplier($ui)
	{
		// Init
		$data['user_active'] = $this->route_hak_akses(array('staf gudang', 'administrator'));
		$data['waktu_sekarang'] = new DateTime();

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
		$data['offset'] = $data['limit'] * ($data['page'] - 1);

		$cari = $this->input->get('cari');
		$berdasarkan = $this->input->get('berdasarkan');
		if ($cari != '' && $berdasarkan != '') {
			$this->db->like($berdasarkan, $cari, 'BOTH');
		}

		$this->db->order_by('nama', 'desc');
		$this->db->stop_cache();

		// Data - Fetch
		$this->load->model('SupplierModel');

		$data['data'] = $this->SupplierModel->show($data['limit'], $data['offset'], 'OBJECT');
		$data['data_count'] = $this->SupplierModel->show($data['limit'], $data['offset'], 'COUNT');
		$this->db->flush_cache();
		$data['data_all_count'] = $this->SupplierModel->show(0, 0, 'COUNT');

		$this->load->view('data/supplier/ajax-'. $ui, $data);
	}



	// --------------------------------------------------------------------------
	// ** Ajax Script 		: Tulis Tabel Supplier (Insert/Delete)
	// ** Level Akses 		: Staf gudang, Administrator
	// ** Parent Controller	: transaksi beli
	// --------------------------------------------------------------------------
	public function write_supplier($mode)
	{
		$this->load->model('SupplierModel');
		if ($mode == 'insert') {
			$object = array(
				'nama' => $this->input->post('supplier_nama'),
				'alamat' => $this->input->post('supplier_alamat'),
				'foto' => 'assets/custom/images/img_unavailable.png'
			);
			$this->SupplierModel->insert($object);
		}
		else if ($mode == 'delete') {
			$id = $this->input->post('id');
			$this->SupplierModel->delete($id);
		}
	}


	// --------------------------------------------------------------------------
	// ** Controller 		: Halaman Transaksi Penjualan
	// ** Level Akses 		: Kasir, Administrator
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
		$data['app_alamat'] = $this->KonfigurasiModel->get('APP_ALAMAT');
		$data['app_favicon'] = $this->KonfigurasiModel->get('APP_LOGO');
		$data['app_logo'] = $this->KonfigurasiModel->get('APP_LOGO');
		$data['default_kadaluarsa'] = $this->KonfigurasiModel->get('DATA_DEFAULT_KADALUARSA');

		// Ui
		$data['ui_title'] = $data['app_name']. ' - Transaksi Penjualan';
		$data['ui_css'] = array(
		);
		$data['ui_js'] = array(
			'custom/js/datetime.js',
			'custom/js/dynamic-img.js',
			'jsBarcode/js/jsBarcode.all.min.js'
		);
		$data['ui_navbar_title'] = 'Transaksi';
		$data['ui_navbar_link'] = $this->navigation->nav_transaksi[$level];
		$data['ui_sidebar_title'] = $data['app_name'];
		$data['ui_sidebar_nav'] = $this->init_sidebar($level, 3);

		// Data - Barang
		$this->load->model('BarangModel');
		$this->db->order_by('nama', 'asc');
		$data['data_barang'] = $this->BarangModel->show(0, 0, 'OBJECT');
		$this->db->reset_query();

		$this->load->view('transaksi/penjualan', $data);
	}


	// --------------------------------------------------------------------------
	// ** Ajax Script 		: Lihat Tabel Stok (Fetch Barang Penjualan)
	// ** Parent Controller	: Transaksi Jual
	// --------------------------------------------------------------------------
	public function read_stok()
	{
		$this->load->model('StokModel');
		$this->load->model('BarangModel');
		$barcode = $this->input->get('barcode');

		$json['stok'] = $this->StokModel->single_barcode($barcode, 'OBJECT');
		$json['barang'] = $this->BarangModel->single($json['stok']->barang_id, 'OBJECT');
		$json['harga_string'] = 'Rp. ' .number_format($json['barang']->harga, 0, '', '.'). ',-';
		echo json_encode($json);
	}



	// --------------------------------------------------------------------------
	// ** Ajax Script 		: Tulis Tabel Trnsaksi 
	// ** Parent Controller	: transaksi Jual
	// --------------------------------------------------------------------------
	public function write_transaksi_jual($mode)
	{

		$userdata = $this->route_hak_akses(array('administrator', 'kasir'));
		$this->load->model('KonfigurasiModel');
		$ppn = $this->KonfigurasiModel->get('DATA_PPN');

		$this->load->model('TransaksiModel');
		if ($mode == 'insert') {
			$object = array(
				'tanggal' => date('Y-m-d'),
				'waktu' => date('H:i:s'),
				'kasir' => $userdata['userdata']->username,
				'ppn' => $ppn,
				'total' => 0,
				'bayar' => 0,
				'total_ppn' => 0,
				'kembali' => 0
			);
			$this->TransaksiModel->insert($object);
			$json['transaksi_id'] = $this->db->insert_id();
			echo json_encode($json);
		}
		else if ($mode == 'delete') {
			$this->load->model('ItemTransaksiModel');
			$id = $this->input->post('transaksi');
			$this->db->where('transaksi_id', $id);
			$data_item = $this->ItemTransaksiModel->show(0, 0, 'OBJECT');
			
			$this->load->model('StokModel');
			foreach ($data_item as $item) {
				$stok = $this->StokModel->single($item->stok_id, 'OBJECT');
				if (is_object($stok)) {
					if ($item->harga_id != '') {
						$nilai_stok = $stok->stok + $item->qty_raw;
					}
					else {
						$nilai_stok = $stok->stok + $item->qty;
					}
					$this->StokModel->update(array('stok' => $nilai_stok), $stok->id);
				}
				$this->ItemTransaksiModel->delete($item->id);
			}

			$this->TransaksiModel->delete($id);
		}
	}

	// --------------------------------------------------------------------------
	// ** Ajax Script 		: Tulis Tabel Item Transaksi 
	// ** Parent Controller	: transaksi Jual
	// --------------------------------------------------------------------------
	public function write_item_transaksi($mode)
	{
		$userdata = $this->route_hak_akses(array('administrator', 'kasir'));
		$this->load->model('KonfigurasiModel');
		$ppn = $this->KonfigurasiModel->get('DATA_PPN');

		$this->load->model('ItemTransaksiModel');
		if ($mode == 'insert') {

			$stok_id = $this->input->post('stok_id'); 
			$transaksi_id = $this->input->post('transaksi_id'); 
			$qty = $this->input->post('qty'); 

			$this->load->model('HargaModel');
			$this->load->model('BarangModel');
			$this->load->model('StokModel');
			$stok = $this->StokModel->single($stok_id, 'OBJECT');

			if (is_object($stok)) {
				$barang = $this->BarangModel->single($stok->barang_id, 'OBJECT');
				if (is_object($barang)) {
					$this->db->order_by('range1', 'desc');
					$this->db->where('barang_id', $barang->id);						
					$data_harga = $this->HargaModel->show(0, 0, 'OBJECT');
					if (is_array($data_harga)) {

						// ----------------------------------------------------------
						// * Pengurangan stok
						$stok_sekarang = $stok->stok - $qty;
						$this->StokModel->update(array('stok' => $stok_sekarang), $stok->id);

						
						// -------------------------------------------------------
						// * Penentuan harga
						foreach ($data_harga as $harga) {
							$jumlah = floor($qty / $harga->range1);
							$qty = $qty % $harga->range1;

							if ($jumlah > 0) {
								$data = array(
									'stok_id' => $stok->id,
									'transaksi_id' =>  $transaksi_id,
									'barang' => $barang->nama . ' (' . $harga->nama . ')',
									'qty' => $jumlah,
									'qty_raw' => ($jumlah * $harga->range1),
									'harga_id' => $harga->id,
									'harga' => $harga->harga,
									'total' => ($jumlah * $harga->harga)
								);
								$this->ItemTransaksiModel->insert($data);
							}
						}
						// ----------------------------------------------------------
						// * Penentuan sisa
						if ($qty > 0) {
							$data = array(
								'stok_id' => $stok->id,
								'transaksi_id' =>  $transaksi_id,
								'barang' => $barang->nama . ' (' . $barang->satuan . ')',
								'qty' => $qty,
								'harga' => $barang->harga,
								'total' => ($qty * $barang->harga)
							);
							$this->ItemTransaksiModel->insert($data);
						}
					}
					else {
						echo "Tidak ada klasifikasi harga";
					}
				}
				else {
					echo "Referensi barang tidak ditemukan";
				}
			}
			else {
				echo "Referensi stok tidak ditemukan";
			}
		}
		else if ($mode == 'delete') {
			$id = $this->input->post('id');

			// -------------------------------------------------------------------
			// * Tambah stok (Redo pengurangan stok karena transaksi)

			$this->load->model('StokModel');
			$item_transaksi = $this->ItemTransaksiModel->single($id, 'OBJECT');
			$stok = $this->StokModel->single($item_transaksi->stok_id, 'OBJECT');
			if (is_object($stok)) {
				if ($item_transaksi->harga_id != '') {
					$nilai_stok = $stok->stok + $item_transaksi->qty_raw;
				}
				else {
					$nilai_stok = $stok->stok + $item_transaksi->qty;
				}
				$this->StokModel->update(array('stok' => $nilai_stok), $stok->id);
			}
			$this->ItemTransaksiModel->delete($id);
		}
	}

	// --------------------------------------------------------------------------
	// ** Ajax 					: Keranjang
	// ** Parent Controller 	: Transaksi Jual
	// --------------------------------------------------------------------------
	public function keranjang()
	{
		// Init
		$data['userdata'] = $this->route_hak_akses(array('administrator', 'kasir'));
		$data['waktu_sekarang'] = new DateTime();
		$this->load->model('KonfigurasiModel');
		$data['ppn'] = $this->KonfigurasiModel->get('DATA_PPN');

		// Data - Filter 
		$this->db->start_cache();
		$transaksi = $this->input->get('transaksi_id');
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

		$this->load->view('transaksi/keranjang', $data);
	}

	// --------------------------------------------------------------------------
	// ** Ajax 					: Cari data total TR
	// ** Parent Controller 	: Transaksi Jual
	// --------------------------------------------------------------------------
	public function cetak_struk()
	{
		// Init
		$user = $this->route_hak_akses(array('administrator', 'kasir'));
		$user = $user['userdata'];

		$c_printer_name = $user->nama_printer;
		$c_printer_address = $user->alamat_printer;

		// Load Config
		$this->load->model('KonfigurasiModel');
		$c_title = $this->KonfigurasiModel->get('APP_NAMA_TOKO');
		$c_ppn = $this->KonfigurasiModel->get('DATA_PPN');


		function columnify($col_1, $col_2, $col_3, $col_4) {
			$col_1_width = 14;
			$col_2_width = 4;
			$col_3_width = 10;
			$col_4_width = 13;

			$space = 0;

		    $col_1_wrapped = wordwrap($col_1, $col_1_width, "\n", true);
		    $col_2_wrapped = wordwrap($col_2, $col_2_width, "\n", true);
		    $col_3_wrapped = wordwrap($col_3, $col_3_width, "\n", true);
		    $col_4_wrapped = wordwrap($col_4, $col_4_width, "\n", true);


		    $col_1_lines = explode("\n", $col_1_wrapped);
		    $col_2_lines = explode("\n", $col_2_wrapped);
		    $col_3_lines = explode("\n", $col_3_wrapped);
		    $col_4_lines = explode("\n", $col_4_wrapped);
		    $allLines = array();
		    for ($i = 0; $i < max(count($col_1_lines), count($col_2_lines), count($col_3_lines), count($col_4_lines)); $i++) {

		        $col_1_part = str_pad(isset($col_1_lines[$i]) ? $col_1_lines[$i] : "", $col_1_width, " ");
		        $col_2_part = str_pad(isset($col_2_lines[$i]) ? $col_2_lines[$i] : "", $col_2_width, " ");
		        $col_3_part = str_pad(isset($col_3_lines[$i]) ? $col_3_lines[$i] : "", $col_3_width, " ");
		        $col_4_part = str_pad(isset($col_4_lines[$i]) ? $col_4_lines[$i] : "", $col_4_width, " ");
		        $allLines[] = $col_1_part . str_repeat(" ", 1) . $col_2_part . str_repeat(" ", $space) . $col_3_part . str_repeat(" ", $space) . $col_4_part;
		    }
		    return implode($allLines, "\n") . "\n";
		}
		function columnify_duo($col_1, $col_2) {
			$col_1_width = 10;
			$col_2_width = 28;

			$space = 1;

		    $col_1_wrapped = wordwrap($col_1, $col_1_width, "\n", true);
		    $col_2_wrapped = wordwrap($col_2, $col_2_width, "\n", true);


		    $col_1_lines = explode("\n", $col_1_wrapped);
		    $col_2_lines = explode("\n", $col_2_wrapped);
		    $allLines = array();
		    for ($i = 0; $i < max(count($col_1_lines), count($col_2_lines)); $i++) {
		        $col_1_part = str_pad(isset($col_1_lines[$i]) ? $col_1_lines[$i] : "", $col_1_width, " ");
		        $col_2_part = str_pad(isset($col_2_lines[$i]) ? $col_2_lines[$i] : "", $col_2_width, " ");
		        $allLines[] = $col_1_part . str_repeat(" ", $space) . $col_2_part;
		    }
		    return implode($allLines, "\n") . "\n";
		}


		// Data Section
		$this->load->model('TransaksiModel');
		$this->load->model('ItemTransaksiModel');
		$this->load->model('StokModel');
		$this->load->model('BarangModel');
		$transaksi_id = $this->input->get('transaksi_id');

		$transaksi = $this->TransaksiModel->single($transaksi_id, 'OBJECT');

		$this->db->where('transaksi_id', $transaksi_id);
		$data_item = $this->ItemTransaksiModel->show(0, 0, "OBJECT");
		$this->db->reset_query();

		// Printing Section
		$this->load->library('EscPos.php');

		$profile = Escpos\CapabilityProfile::load("simple");
		$connector = new Escpos\PrintConnectors\WindowsPrintConnector($c_printer_name);
		// $connector = new Escpos\PrintConnectors\FilePrintConnector("php://stdout");
		$printer = new Escpos\Printer($connector);

	    $modes = array(
			Escpos\Printer::MODE_FONT_A,
			Escpos\Printer::MODE_FONT_B,
			Escpos\Printer::MODE_EMPHASIZED,
			Escpos\Printer::MODE_DOUBLE_HEIGHT,
			Escpos\Printer::MODE_DOUBLE_WIDTH,
			Escpos\Printer::MODE_UNDERLINE
		);
		$justification = array(
			Escpos\Printer::JUSTIFY_LEFT,
			Escpos\Printer::JUSTIFY_CENTER,
			Escpos\Printer::JUSTIFY_RIGHT
		);

		$printer -> initialize();
		$printer -> selectPrintMode($modes[3]);
		$printer -> setJustification(EscPos\Printer::JUSTIFY_CENTER);
		
		$printer -> text($c_title . "\n\n");
		
		$printer -> setJustification($justification[0]);
		$printer -> selectPrintMode($modes[0]);
		$printer -> initialize();
		$printer -> selectPrintMode($modes[1]);

		$printer -> text(columnify_duo('Kasir', ': '.$user->nama_lengkap));
		$printer -> text(columnify('Barang', 'Qty', 'harga', 'Subtotal'));
		$printer -> text("------------------------------------------\n");
		foreach ($data_item as $item) {
			$stok = $this->StokModel->single($item->stok_id, 'OBJECT');
			$barang = $this->BarangModel->single($stok->barang_id, 'OBJECT');

			$printer -> text(columnify($item->barang, $item->qty,'Rp.'.$item->harga, 'Rp.'.$item->total));
		}
		$printer -> text("------------------------------------------\n");
		$printer -> text(columnify('', '', 'PPN('.$c_ppn.'%)', 'Rp.'.$transaksi->ppn));
		$printer -> text(columnify('', '', 'Total+PPN', 'Rp.'.$transaksi->total_ppn));
		$printer -> text(columnify('', '', 'Bayar', 'Rp.'.$transaksi->bayar));
		$printer -> text(columnify('', '', 'Kembali', 'Rp.'.$transaksi->kembali));
		$printer->cut();
		$printer->close();
	}


	// --------------------------------------------------------------------------
	// ** Ajax 					: Cari data total TR
	// ** Parent Controller 	: Transaksi Jual
	// --------------------------------------------------------------------------
	public function get_total()
	{
		$this->load->model('TransaksiModel');
		$this->load->model('ItemTransaksiModel');
		$this->load->model('KonfigurasiModel');
		$ppn = $this->KonfigurasiModel->get('DATA_PPN');
		
		$transaksi = $this->input->get('transaksi_id');
		if ($transaksi != '') {
			$this->db->where('transaksi_id', $transaksi);
		}
		$data_item = $this->ItemTransaksiModel->show(0, 0, 'OBJECT');

		$total = 0;
		foreach ($data_item as $item) {
			$total += $item->total;
		}
		$total_w_ppn = $total * $ppn / 100;

		$object['total'] = $total;
		$object['total_ppn'] = $total + $total_w_ppn;
		$object['persentase_ppn'] = $ppn;
		$object['ppn'] = $total_w_ppn;

		$this->TransaksiModel->update($object, $transaksi);
		$object['total_string'] = 'Rp. '.number_format($object['total_ppn'], 0, '', '.') .',-';

		echo json_encode($object);
	}

	// --------------------------------------------------------------------------
	// ** Ajax 					: Update Pembayaran
	// ** Parent Controller 	: Transaksi Jual
	// --------------------------------------------------------------------------
	public function update_bayar()
	{
		$this->load->model('TransaksiModel');
		$transaksi_id = $this->input->post('transaksi_id');
		$object = array(
			'bayar' => $this->input->post('bayar'),
			'kembali' => $this->input->post('kembali')
		);
		$this->TransaksiModel->update($object, $transaksi_id);
	}

}

/* End of file Transaksi.php */
/* Location: ./application/controllers/Transaksi.php */
?>