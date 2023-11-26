<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sidebar extends CI_Model {

	// ------------------------------------------------------
	// ** Atribut 	: Data Universal Sidebar Links
	// ------------------------------------------------------
	public $data_administrator = array(
		'Dashboard|dashboard|pe-7s-news-paper',
		'Data|data|pe-7s-notebook',
		'Transaksi|transaksi|pe-7s-refresh-2',
		'Laporan|laporan|pe-7s-note2',
		'Statistik|statistik|pe-7s-graph1',
		'Konfigurasi|konfigurasi|pe-7s-tools'
	);

	public $data_staf_gudang = array(
		'Dashboard|dashboard|pe-7s-news-paper',
		'Transaksi|transaksi|pe-7s-refresh-2',
		'Laporan|laporan|pe-7s-note2',
		'Data|data|pe-7s-notebook',
	);

	public $data_kasir = array(
		'Dashboard|dashboard|pe-7s-news-paper',
		'Data|data|pe-7s-notebook',
		'Transaksi|transaksi|pe-7s-refresh-2',
		'Laporan|laporan|pe-7s-note2',
	);

	
	// ------------------------------------------------------
	// ** Metode 	: Mengambil data sidebar
	// ------------------------------------------------------
	public function get($level, $active = FALSE)
	{
		if ($active != FALSE) {
			$this->data_administrator[$active] .= '|active'; 
		}
		switch ($level) {
			case 'administrator':
				return $this->data_administrator;
				break;

			case 'staf gudang':
				return $this->data_staf_gudang;
				break;

			case 'kasir':
				return $this->data_kasir;
				break;
		}
	}

	// ------------------------------------------------------
	// ** Metode 	: Menambah data sidebar
	// ------------------------------------------------------
	public function push($value)
	{
		$this->data[] = $value;
    }
}

/* End of file Sidebar.php */
/* Location: ./application/models/Sidebar.php */
?>