<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {

	public $table = 'user';

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
		$query = $this->db->get_where($this->table, array('username' => $id));

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
		return $this->db->update($this->table, $object, array('username' => $id));
	}

	public function delete($id)
	{
		return $this->db->delete($this->table, array('username' => $id));
	}

}

/* End of file UserModel.php */
/* Location: ./application/models/UserModel.php */
?>