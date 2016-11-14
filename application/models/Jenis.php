<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jenis extends CI_Model {

	public $table = 't_jenis_brng';
	public $primary = 'id_jenis_brng';

	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * get all row
	 * @return Object
	 */
	public function getAll(){
		$query = $this->db->select('*')->get($this->table);
		return $query->result();
	}

	
}

/* End of file Jenis.php */
/* Location: ./application/models/Jenis.php */