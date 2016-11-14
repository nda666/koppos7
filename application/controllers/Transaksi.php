<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Transaksi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    public function clean()
    {
        $this->session->unset_userdata('id_penjualan');
    }

    public function get_new_session()
    {
        // Set tempdata expired to 1 day
        $this->session->set_tempdata('id_penjualan', date('ymdhis'), 86400);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['res' => 'ok'], JSON_NUMERIC_CHECK));
        return;
    }
    public function index()
    {

        if (!$this->session->has_userdata('id_penjualan')) {
            $this->session->set_tempdata('id_penjualan', date('ymdhis'), 86400);
        }
        $this->load->view('transaksi/index');
    }

    public function data_json()
    {
        $find  = $this->input->get('find');
        $kat   = $this->input->get('kat');
        $jenis = $this->input->get('jenis');
        if (!$find == '') {
            $this->db->like('nama', $find, 'both');
        }
        if (!$kat == '') {
            $this->db->where('id_kat_brng', $kat);
        }
        if (!$jenis == '') {
            $this->db->where('id_jenis_brng', $jenis);
        }
        $this->db->where('kat_harga', 'baru')->where('stok >', 0);
        $query = $this->db->select('id_brng, CONCAT(nama, " | " ,stok, " | ", CONCAT("Rp.", FORMAT(h_jual,0))) as text')->get('t_brng');
        if ($query) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($query->result(), JSON_NUMERIC_CHECK));

            return;
        } else {
            print_r($this->db->error());
        }
    }

    public function kategori_json()
    {
        $query = $this->db->select('id_kat_brng, kategori as text')->get('t_kat_brng');
        if ($query) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($query->result(), JSON_NUMERIC_CHECK));

            return;
        } else {
            print_r($this->db->error());
        }
    }

    public function jenis_json()
    {
        $find = $this->input->get('find');
        if (!$find == '') {
            $this->db->like('nama', $find, 'both');
        }
        $query = $this->db->select('id_jenis_brng, jenis as text')->get('t_jenis_brng');
        if ($query) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($query->result(), JSON_NUMERIC_CHECK));

            return;
        } else {
            print_r($this->db->error());
        }
    }

    public function transaksi_json($id_penjualan)
    {
        $query = $this->db->select('t_brng.*, qty, id_penjualan')
            ->where('id_penjualan', $id_penjualan)
            ->join('t_brng', 't_brng.id_brng = t_ptroli.id_brng')
            ->get('t_ptroli');
        if ($query) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($query->result(), JSON_NUMERIC_CHECK));
            return;
        }

        return;
    }

    public function insert()
    {

        $data = [
            'id_penjualan' => $this->input->post('id_penjualan'),
            'qty'          => $this->input->post('qty'),
            'id_brng'      => $this->input->post('id_brng'),
            'tgl'          => date('Y-m-d'),
        ];
        $this->load->model('M_Transaksi', 'mtrans');
        if ($this->mtrans->insert_to_troli($data)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['res' => true, 'message' => 'Barang sudah masuk keranjang'], JSON_NUMERIC_CHECK));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['res' => false, 'message' => $this->mtrans->getError()], JSON_NUMERIC_CHECK));
        }
        return;
    }

    public function update()
    {
        $data = [
            'id_penjualan' => $this->input->post('id_penjualan'),
            'qty'          => $this->input->post('qty'),
            'id_brng'      => $this->input->post('id_brng'),
            'tgl'          => date('Y-m-d'),
        ];
        $this->load->model('M_Transaksi', 'mtrans');
        if ($this->mtrans->update_troli($data)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['res' => true, 'message' => 'Data berhasil diubah'], JSON_NUMERIC_CHECK));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['res' => false, 'message' => $this->mtrans->getError()], JSON_NUMERIC_CHECK));
        }
        return;
    }
}

/* End of file Transaksi.php */
/* Location: ./application/controllers/Transaksi.php */
