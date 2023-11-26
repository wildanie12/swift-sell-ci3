<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class KonfigurasiModel extends CI_Model {

	public $table = 'konfigurasi';

	public function set($config, $type, $value)
	{
		$object = array('value_'. $type => $value);
		return $this->db->update($this->table, $object, array('nama' => $config));
	}
	public function set_batch($objects)
	{
		foreach ($objects as $key => $value) {
			$config = $this->db->get_where($this->table, array('nama' => $key))->row_array();			
			$this->set($key, $config['default_value'], $value);
		}
	}
	public function get($nama, $mode = 'VALUE')
	{
		$config = $this->db->get_where($this->table, array('nama' => $nama))->row_array();
		$default_type = $config['default_value'];
		if ($mode == 'VALUE') {
			return $config['value_'.$default_type];
		}
		else if ($mode == 'OBJECT') {
			return $config;
		}
	}

}

/* End of file KonfigurasiModel.php */
/* Location: ./application/models/KonfigurasiModel.php */
?>
