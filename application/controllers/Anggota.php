<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/Sites_captcha.php';

class Anggota extends CI_Controller
{
    protected $cap;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('sites');
        $this->cap = new Sites_captcha;
    }

    public function index()
    {
        $data['page_title'] = "Anggota";
        $this->load->view('anggota/index',$data);
    }

    public function data_json()
    {
        $query = $this->db->select('*, Concat("' . base_url('anggota/delete/') . '", anggota.id_anggota) as delUrl, Concat("' . base_url('anggota/get-captcha/') . '") as getCaptcha')
            ->get('anggota');
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($query->result(), JSON_NUMERIC_CHECK));

        return;
    }
    private function validation()
    {
        $this->load->library('form_validation');
        $this->load->config('sites_validation');
        $vRule = $this->config->item('anggota');
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
        $post  = $this->input->post();
        $query = $this->db->insert_string('anggota', $post);
        $query = $this->db->query($query);
        $json  = [];
        if (!$query) {
            $error = $this->db->error();
            $json  = [
                'response' => false,
                'message'  => 'Gagal menghapus data.<br><strong>'. $error['code'] .'</strong> '. $error['message'],
        
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

    public function edit()
    {
        if (!http_method_checker('post')) {
            return;
        }
        if (!$this->validation()) {
            return;
        }
        $post = $this->input->post();
        $id   = $post['id_anggota'];
        unset($post['id_anggota']);
        if (!$query = $this->db->update('anggota', $post, 'id_anggota = ' . $id)) {
            $error = $this->db->error();
            $json  = [
                'response' => false,
                'message'  => 'Gagal menghapus data.<br><strong>'. $error['code'] .'</strong> '. $error['message'],
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
        $cap = strtoupper($this->input->post('anggota_del_captcha'));
        if (!$this->cap->check_captcha($cap, 'anggota_del_captcha')) {
            $json = [
                'response' => false,
                'expired' => true,
                'message'  => 'Maaf, captcha yang anda masukkan tidak benar / captcha sudah expired. Silahkan masukkan kembali captcha yang baru.',
            ];
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($json, JSON_NUMERIC_CHECK));
            return;
        }
        $query = $this->db->where('id_anggota =', $id)->delete('anggota');
        $error = $this->db->error();
        $json  = (!$query) ?
        [
            'response' => false,
            'message'  => 'Gagal menghapus data.<br><strong>'. $error['code'] .'</strong> '. $error['message'],
        ] : [
            'response' => true,
            'message'  => 'Berhasil menghapus data.<br>',
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json, JSON_NUMERIC_CHECK));

       

        return;
    }

    public function get_captcha()
    {
        $this->cap->captcha('anggota_del_captcha')->json();

    }


    public function get_ses(){
        print_r($this->session->tempdata());
    }

}
