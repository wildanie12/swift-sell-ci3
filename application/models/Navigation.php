<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Navigation extends CI_Model {

	// ---------------------------------------------------
	// ** Level 		: Data Nav 
	// ---------------------------------------------------
	public $nav_data = array(
		'administrator' => array(
			'Barang|data/barang|fas fa-clipboard-list',
			'Stok|data/stok|fas fa-list-ol',
			'Harga|data/harga|fas fa-dollar-sign',
			'User|data/user|fas fa-users',
			'Transaksi|data/transaksi|fas fa-sync-alt',
		),
		'staf gudang' => array(
			'Barang|data/barang|fas fa-clipboard-list',
			'Stok|data/stok|fas fa-list-ol',
			'Harga|data/harga|fas fa-dollar-sign',
		),
		'kasir' => array(
			'Transaksi|data/transaksi|fas fa-sync-alt',
		)
	);

	public $nav_transaksi = array(
		'administrator' => array(
			'Pembelian|transaksi/pembelian|fas fa-arrow-alt-circle-down',
			'Penjualan|transaksi/penjualan|fas fa-arrow-alt-circle-up'
		),
		'staf gudang' => array(
			'Pembelian|transaksi/pembelian|fas fa-th'
		),
		'kasir' => array(
			'Penjualan|transaksi/penjualan|fas fa-th'
		)
	);

	public $nav_laporan = array(
		'administrator' => array(
			'Pembelian|laporan/pembelian|fas fa-arrow-alt-circle-down',
			'Penjualan|laporan/penjualan|fas fa-arrow-alt-circle-up',
			'Barang|laporan/barang|fas fa-clipboard-list',
			'Stok Barang|laporan/stok|fas fa-cubes',
			'Supplier|laporan/supplier|fas fa-industry',
			'User|laporan/user|fas fa-users'
		),
		'staf gudang' => array(
			'Pembelian|laporan/pembelian|fas fa-th',
			'Barang|laporan/barang|fas fa-clipboard-list',
			'Stok Barang|laporan/stok|fas fa-cubes',
			'Supplier|laporan/supplier|fas fa-industry',
		),
	);

	public $nav_statistik = array(
		'administrator' => array(
			'Pemasukan|statistik/pemasukan|fas fa-arrow-alt-circle-down',
			'Stok Barang|statistik/stok|fas fa-cubes'
		),
		'staf gudang' => array(
			'Stok Barang|statistik/stok|fas fa-cubes'
		),
		'kasir' => array(
			'Pemasukan|statistik/pemasukan|fas fa-arrow-alt-circle-down'
		)
	);



	public function get_data_nav($level)
	{
		switch ($level) {
			case 'administrator':
				return $this->nav_administrator;
				break;
			
			case 'staf gudang':
				return $this->nav_staf_gudang;
				break;
		}
	}

}

/* End of file Navigation.php */
/* Location: ./application/models/Navigation.php */
?>