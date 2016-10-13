<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Koderekening extends CI_Controller
{
    public function index()
    {
        $this->db->select('*');
        $this->db->from('poserba_barang');
        $this->db->limit(10, 0);
        $barang = $this->db->get();
        $data['barang'] = $barang->result();
        $this->db->select('*');
        $query = $this->db->get('jenis_kode_rekening');
        $data['jenisRekening'] = $query->result();
        $this->load->view('kode_rekening/index.php', $data);
    }

    public function data_json()
    {
        $this->db->select('*', false);
        $this->db->from('kode_rekening');
        $barang = $this->db->get();
        $data = $barang->result();
        $cols = [
            'ID' => [
                'index' => 1,
                'type' => 'number',
                'unique' => true,
                'cls' => 'col-sm-1',
            ],
            'Kode' => [
                'index' => 2,
                'type' => 'string',
                'cls' => 'col-sm-3',
            ],
            'Nama' => [
                'index' => 3,
                'type' => 'string',
                'cls' => 'col-sm-5',
            ],
            'Keterangan' => [
                'index' => 4,
                'type' => 'string',
                'cls' => 'col-sm-3',
            ],
            'Action' => [
                'index' => 5,
                'type' => 'string',
                'cls' => 'col-sm-2',
                'format' => '<button id="edit-btn-{0}" data-toggle="tooltip" data-placement="left" title="Ubah Data" data-unique="{0}" class="edit-btn btn btn-primary btn-sm"><i class="fa fa-edit"></i></button> <button id="delete-btn-{0}" data-toggle="tooltip" data-placement="left" title="Hapus Data" data-url="'.base_url('koderekening/delete/{0}').'" class="delete-btn btn btn-danger btn-sm "><i class="fa fa-trash"></i></button>',
                'sorting' => false,
                'tooltip' => 'Click button "<i class="fa fa-edit"></i>"  untuk mengubah dan "<i class="fa fa-trash"></i>" untuk menghapus',
            ],

        ];
        $rows = [];
        foreach ($data as $key => $value) {
            $rows[] = ['ID' => $value->id, 'Nama' => $value->nama, 'Keterangan' => $value->keterangan, 'Kode' => $value->kode, 'Action' => $value->id, 'jenisID' => $value->jenis_id];
        }
        $json = ['rows' => $rows, 'cols' => $cols];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json, JSON_NUMERIC_CHECK));
    }

    /**
     */
    public function insert_action()
    {
        $post = $this->input->post();
        // Do form validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('jenis_id', 'Jenis Rekening', 'required|is_unique[kode_rekening.kode]');
        $this->form_validation->set_rules('nama', 'Nama Rekening', 'required|min_length[3]|max_length[50]');
        if (!$this->form_validation->run()) {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header('412')
                ->set_output(json_encode($this->form_validation->error_array()));

            return;
        }
        // Uppercase name & keterangan
        $post['nama'] = strtoupper($post['nama']);
        $post['keterangan'] = strtoupper($post['keterangan']);
        $this->db->select('kode_rekening.kode')
            ->join('kode_rekening', 'kode_rekening.jenis_id = jenis_kode_rekening.id', 'left')
            ->from('jenis_kode_rekening');
        $this->db->where('jenis_kode_rekening.id', $post['jenis_id'])
            ->order_by('kode_rekening.kode', 'desc');
        if ($query = $this->db->get()) {
            $fRow = $query->row();
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['response' => false, 'message' => 'Kode rekening tidak ditemukan']));

            return;
        }
        $tempKode = $fRow->kode;
        $exp = explode(' ', $tempKode);

        if (isset($post['useKode']) && $post['useKode'] == 1) {
            $post['kode'] = $exp[0].' '.$exp[1].' '.(strlen(($exp[2] + 1))  == 1 ? '0'.($exp[2] + 1) : ($exp[2] + 1));
        } else {
            $post['kode'] = $exp[0].' '.$exp[1].' '.$post['kode'];
        }
        // DELETE useKode index
        unset($post['useKode']);

        if ($this->db->insert('kode_rekening', $post)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['response' => true, 'message' => 'Sukses menambah data baru.']));

            return;
        } else {
            $this->lang->load('db');
            $erObj = $this->db->error();
            $error['messages'] = $this->db->error();
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($error, JSON_NUMERIC_CHECK));

            return;
        }
    }

    public function edit_action()
    {
        $id = $this->input->post('id');
        $post = $this->input->post();

        $this->db->select('jenis_kode_rekening.kode')
            ->join('kode_rekening', 'kode_rekening.jenis_id = jenis_kode_rekening.id', 'left')
            ->from('jenis_kode_rekening');
        $this->db->where('jenis_kode_rekening.id', $post['jenis_id'])
            ->order_by('kode_rekening.kode', 'desc');
        if ($query = $this->db->get()) {
            $fRow = $query->row();
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['response' => false, 'message' => 'Kode rekening tidak ditemukan']));

            return;
        }
        $tempKode = $fRow->kode;
        $exp = explode(' ', $tempKode);
        $post['kode'] = $exp[0].' '.$exp[1].' '.$post['kode'];

        unset($post['id']);
        $this->db->where('id', $id);

        $this->db->update('kode_rekening', $post);
        $error = $this->db->error();
        if ($error['code'] == 0) {
            $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode([
                        'response' => true,
                        'message' => 'Data berhasil diubah',
                    ]));

            return;
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'response' => false,
                'error' => $error,
                'message' => 'Terjadi kesalahan basis data.<br><b>Message:</b> <i>'.$error['message'].'</i>',
            ]));

        return;
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete('kode_rekening')) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'response' => true,
                    'message' => 'Data berhasil dihapus',
                ]));

            return;
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'response' => false,
                'message' => 'Data gagal dihapus',
            ]));
    }
}
