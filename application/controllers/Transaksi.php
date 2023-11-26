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
		$c_pesan_penutup = $this->KonfigurasiModel->get('PRINTER_PESAN_PENUTUP');
		$c_feed = $this->KonfigurasiModel->get('PRINTER_END_FEED');
		$c_ppn = $this->KonfigurasiModel->get('DATA_PPN');


		function buatBaris4Kolom($kolom1, $kolom2, $kolom3, $kolom4) {
            // Mengatur lebar setiap kolom (dalam satuan karakter)
            $lebar_kolom_1 = 17;
            $lebar_kolom_2 = 3;
            $lebar_kolom_3 = 8;
            $lebar_kolom_4 = 9;
 
            // Melakukan wordwrap(), jadi jika karakter teks melebihi lebar kolom, ditambahkan \n 
            $kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);
            $kolom2 = wordwrap($kolom2, $lebar_kolom_2, "\n", true);
            $kolom3 = wordwrap($kolom3, $lebar_kolom_3, "\n", true);
            $kolom4 = wordwrap($kolom4, $lebar_kolom_4, "\n", true);
 
            // Merubah hasil wordwrap menjadi array, kolom yang memiliki 2 index array berarti memiliki 2 baris (kena wordwrap)
            $kolom1Array = explode("\n", $kolom1);
            $kolom2Array = explode("\n", $kolom2);
            $kolom3Array = explode("\n", $kolom3);
            $kolom4Array = explode("\n", $kolom4);
 
            // Mengambil jumlah baris terbanyak dari kolom-kolom untuk dijadikan titik akhir perulangan
            $jmlBarisTerbanyak = max(count($kolom1Array), count($kolom2Array), count($kolom3Array), count($kolom4Array));
 
            // Mendeklarasikan variabel untuk menampung kolom yang sudah di edit
            $hasilBaris = array();
 
            // Melakukan perulangan setiap baris (yang dibentuk wordwrap), untuk menggabungkan setiap kolom menjadi 1 baris 
            for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {
 
                // memberikan spasi di setiap cell berdasarkan lebar kolom yang ditentukan, 
                $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");
                $hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebar_kolom_2, " ");
 
                // memberikan rata kanan pada kolom 3 dan 4 karena akan kita gunakan untuk harga dan total harga
                $hasilKolom3 = str_pad((isset($kolom3Array[$i]) ? $kolom3Array[$i] : ""), $lebar_kolom_3, " ", STR_PAD_LEFT);
                $hasilKolom4 = str_pad((isset($kolom4Array[$i]) ? $kolom4Array[$i] : ""), $lebar_kolom_4, " ", STR_PAD_LEFT);
 
                // Menggabungkan kolom tersebut menjadi 1 baris dan ditampung ke variabel hasil (ada 1 spasi disetiap kolom)
                $hasilBaris[] = $hasilKolom1 . " " . $hasilKolom2 . " " . $hasilKolom3 . " " . $hasilKolom4;
            }
 
            // Hasil yang berupa array, disatukan kembali menjadi string dan tambahkan \n disetiap barisnya.
            return implode($hasilBaris, "\n") . "\n";
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

        $this->load->library('escpos');
        $connector = new Escpos\PrintConnectors\WindowsPrintConnector("printer_a");
        $printer = new Escpos\Printer($connector);

		// Judul
		$printer->initialize();
		$printer->selectPrintMode(Escpos\Printer::MODE_DOUBLE_HEIGHT);
		$printer->setJustification(Escpos\Printer::JUSTIFY_CENTER);
		$printer->text($c_title);
		$printer->text("\n\n");

		// Tabel
		$printer->initialize();
		$printer->text("----------------------------------------\n");
		$printer->text(buatBaris4Kolom("Barang", "jml", "Harga", "Subtotal"));
		$printer->text("----------------------------------------\n");
		foreach ($data_item as $item) {
			$printer->text(buatBaris4Kolom($item->barang, $item->qty, number_format($item->harga, 0, '', '.'), number_format($item->total, 0, '', '.')));
		}
		$printer->text("----------------------------------------\n");

		// Pesan penutup
        $printer->initialize();
        $printer->setJustification(Escpos\Printer::JUSTIFY_CENTER);
        $printer->text("\n");
        $printer->text($c_pesan_penutup);
        $printer->feed((int) $c_feed);
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