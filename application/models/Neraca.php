<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Classname extends CI_Model
{
    /**
     * @var string
     */
    public $table = 'neraca';
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Ambil data beri nilai limit default
     * @method getData
     * @param  integer $limit [data limit]
     * @return void
     */
    public function getData($limit = 10)
    {
        $this->db->select('*');
        $this->db->from('neraca');
        $query = $this->db->query();
        return $query->result();
    }

    /**
     * @param array $data
     */
    public function insertData($data = [])
    {
        $this->db->insert_string('table', $data);
    }

    /**
     * @param string $find
     */
    public function existCol($find = "")
    {
        $this->db->from($this->table);
        $this->db->where('kode', $find);
        $count = $this->db->count_all_results();
        return ($count > 0) ? false : true;
    }
}
