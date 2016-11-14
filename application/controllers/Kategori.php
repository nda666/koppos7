<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Kategori extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['sites']);
    }

    public function index()
    {
        $data['page_title'] = 'Kategori Barang';
        $this->load->view('kategori/index', $data);
    }

    public function data_json()
    {
        $query = $this->db->select('*,Concat("' . base_url('kategori/delete/') . '", t_kat_brng.id_kat_brng) as delUrl, ')->get('t_kat_brng');

        if ($query) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($query->result(), JSON_NUMERIC_CHECK));

            return;
        }
        return;
    }

    public function validation()
    {
        $this->load->library('form_validation');
        $this->load->config('sites_validation');
        $vRule = $this->config->item('t_kat_brng');
        $this->form_validation->set_rules($vRule);
        if (!$this->form_validation->run()) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'respone' => false,
                    'message' => $this->form_validation->error_array(),
                ]), JSON_NUMERIC_CHECK);

            return false;
        }

        return true;

    }

    public function insert()
    {
        if (!http_method_checker('post')) {
            return;
        }
        if (!$this->validation()) {
            return;
        }
        $post = $this->input->post();
        $query = $this->db->insert_string('t_kat_brng', $post);
        $query = $this->db->query($query);
        $json = [];
        if (!$query) {
            $error = $this->db->error();
            $json = [
                'response' => false,
                'error' => $error,
                'message' => 'Terjadi kesalahan database, Gagal menyimpan data.<br>',
            ];
        } else {
            $json = [
                'response' => true,
                'message' => 'Berhasil menyimpan data.<br>',
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json, JSON_NUMERIC_CHECK));

        return;
    }

    public function edit()
    {
        if (!http_method_checker('post')) {
            return;
        }
        if (!$this->validation()) {
            return;
        }
        $post = $this->input->post();
        $id   = $post['id_kat_brng'];
        unset($post['id_kat_brng']);
        $query = $this->db->update('t_kat_brng', $post, 'id_kat_brng = ' . $id);
        if (!$query) {
            $error = $this->db->error();
            $json  = [
                'response' => false,
                'message'  => 'Terjadi kesalahan database, Gagal menyimpan data.<br>' & $error['message'],
                'query'    => $query,
            ];
        } else {
            $json = [
                'response' => true,
                'message'  => 'Berhasil menyimpan data.<br>',
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json, JSON_NUMERIC_CHECK));

        return;
    }

    public function delete($id)
    {
        $query = $this->db->where('id_kat_brng =', $id)->delete('t_kat_brng');
        $json  = (!$query) ?
        [
            'response' => false,
            'message'  => 'Gagal menghapus data.<br>',
            'error'    => $this->db->error(),
        ] : [
            'response' => true,
            'message'  => 'Berhasil menghapus data.<br>',
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json, JSON_NUMERIC_CHECK));

        return;
    }
}

/* End of file Kategori.php */
/* Location: ./application/controllers/Kategori.php */
