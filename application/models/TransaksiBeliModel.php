<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class TransaksiBeliModel extends CI_Model {

	public $table = 'transaksi_beli';

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

	public function single($faktur, $mode)
	{
		$query = $this->db->get_where($this->table, array('no_faktur' => $faktur));

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

	public function single_by($field, $id, $mode)
	{
		$query = $this->db->get_where($this->table, array($field => $id));

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
}

/* End of file TransaksiBeliModel.php */
/* Location: ./application/models/TransaksiBeliModel.php */
?>