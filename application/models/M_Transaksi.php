<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class M_Transaksi extends CI_Model
{

    public $table      = "t_pdetail";
    protected $id_brng = "";
    protected $stok    = "";

    protected $error = [];

    public function __construct()
    {
        parent::__construct();

    }

    private function _initialize()
    {

    }

    public function getError()
    {
        return $this->error;
    }

    public function getStok()
    {
        return $this->error;
    }

    public function update_troli($data)
    {
        if ($data['qty'] <= 0) {
            $this->error[] = "Quantity tidak boleh kurang dari 1.";
            return false;
        }
        if (!isset($data['id_brng'])) {
            $this->error[] = "Silahkan pilih barang untuk dimasukkan ke keranjang.";
            return false;
        }
        $this->_initialize();
        $this->db->trans_start();
        $query = $this->db->query("SELECT * from t_brng WHERE id_brng = " . $data['id_brng']);
        $brng  = $query->row();
        if ($brng->stok <= 0 || $brng->stok < $data['qty']) {
            $this->db->trans_rollback();
            $this->error[] = 'Stok Barang: "<b>[' . $brng->id_brng . '] ' . $brng->nama . '</b>" Tidak Mencukupi.';
            return false;
        }

        $this->db->update('t_ptroli', $data, 'id_penjualan = ' . $data['id_penjualan'] . ' AND id_brng = ' . $data['id_brng']);

        if (!$this->db->trans_status()) {
            $error[] = $this->db->error();
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_complete();
        return true;

    }

    /**
     * Begin insert transaction
     * @param  [array] $data [Data to insert]
     * @return [bool]
     */
    public function insert_to_troli($data)
    {
        if ($data['qty'] <= 0) {
            $this->error[] = "Quantity tidak boleh kurang dari 1.";
            return false;
        }
        if (!isset($data['id_brng'])) {
            $this->error[] = "Silahkan pilih barang untuk dimasukkan ke keranjang.";
            return false;
        }
        $this->_initialize();
        $this->db->trans_start();
        $query = $this->db->query("SELECT * from t_brng WHERE id_brng = " . $data['id_brng']);
        $brng  = $query->row();
        if ($brng->stok <= 0 || $brng->stok < $data['qty']) {
            $this->db->trans_rollback();
            $this->error[] = "Stok tidak mencukupi.";
            return false;
        }

        $query      = $this->db->query("SELECT * from t_ptroli WHERE id_penjualan = " . $data['id_penjualan'] . " AND id_brng = " . $data['id_brng']);
        $brngOnCart = $query->row();
        if (count($brngOnCart) == 1) {
            if ($brngOnCart->qty + $data['qty'] > $brng->stok) {
                $this->db->trans_rollback();
                $this->error[] = "Stok tidak mencukupi.";
                return false;
            }
            $data['qty'] += $brngOnCart->qty;
            $this->db->update('t_ptroli', $data, 'id_penjualan = ' . $data['id_penjualan'] . ' AND id_brng = ' . $data['id_brng']);
        } else {
            $this->db->insert('t_ptroli', $data);
        }

        if (!$this->db->trans_status()) {
            $error[] = $this->db->error();
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_complete();
        return true;
    }

    /**
     * [INSERT data from troli to penjualan]
     * @param  [string] $session [Current Troli Session]
     * @return [bool]
     */
    public function insert_to_penjualan($session)
    {
        $this->insert_to_penjualan();

    }
}

/* End of file M_Transaksi.php */
/* Location: ./application/models/M_Transaksi.php */
