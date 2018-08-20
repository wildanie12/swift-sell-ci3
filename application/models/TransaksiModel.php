<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class TransaksiModel extends CI_Model {

	public $table = 'transaksi';

	public function show($limit, $offset, $mode)
	{
		$query = $this->db->get($this->table, $limit, $offset);

		if ($mode == 'QUERY') {
			return $query;
		}
		else if ($mode == 'OBJECT') {
			return $query->result();
		}
		else if ($mode == 'COUNT') {
			return $query->num_rows();
		}
		else if ($mode == 'ARRAY') {
			return $query->result_array();
		}
	}

	public function single($id, $mode)
	{
		$query = $this->db->get_where($this->table, array('id' => $id));

		if ($mode == 'QUERY') {
			return $query;
		}
		else if ($mode == 'OBJECT') {
			return $query->row();
		}
		else if ($mode == 'COUNT') {
			return $query->num_rows();
		}
		else if ($mode == 'ARRAY') {
			return $query->row_array();
		}
	}

	public function insert($object)
	{
		return $this->db->insert($this->table, $object);
	}

	public function update($object, $id)
	{
		return $this->db->update($this->table, $object, array('id' => $id));
	}

	public function delete($id)
	{
		return $this->db->delete($this->table, array('id' => $id));
	}	

	public function get_stok($barang_id)
	{
		$total = 0;
		$this->db->where('barang_id', $barang_id);
		$data = $this->db->get($this->table)->result();
		foreach ($data as $stok) {
			$total += $stok->stok;
		}
		return $total;
	}

	public function getNewID()
	{	
		$this->db->select('MAX(id) AS kode');
		$data = $this->db->get($this->table)->row();
		return $data->kode;
	}

}

/* End of file TransaksiModel.php */
/* Location: ./application/models/TransaksiModel.php */
?>