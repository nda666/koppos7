<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Neraca extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Codeigniter : Write Less Do More
    }

    public function index()
    {
        $this->load->view('neraca/index');
    }
    
    public function journal_json(){
        $cols = [
            'ID' => [
                'index' => 1,
                'type' => 'number',
                'unique' => true,
                'cls' => 'col-sm-1',
            ],
            'Jenis' => [
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
            'Debet' => [
                'index' => 5,
                'type' => 'number',
                'cls' => 'col-sm-3',
                
            ],
            'Kredit' => [
                'index' => 6,
                'type' => 'number',
                'cls' => 'col-sm-3',
            ],
            
            'Action' => [
                'index' => 7,
                'type' => 'string',
                'cls' => 'col-sm-2',
                'format' => '<button id="edit-btn-{0}" data-toggle="tooltip" data-placement="left" title="Ubah Data" data-unique="{0}" class="edit-btn btn btn-primary btn-sm"><i class="fa fa-edit"></i></button> <button id="delete-btn-{0}" data-toggle="tooltip" data-placement="left" title="Hapus Data" data-url="'.base_url('koderekening/delete/{0}').'" class="delete-btn btn btn-danger btn-sm "><i class="fa fa-trash"></i></button>',
                'sorting' => false,
                'tooltip' => 'Click button "<i class="fa fa-edit"></i>"  untuk mengubah dan "<i class="fa fa-trash"></i>" untuk menghapus',
            ],

        ];
        $this->db->select('neraca.id,neraca.debet,neraca.kredit,neraca.tanggal,kode_rekening.kode, kode_rekening.nama, kode_rekening.keterangan, jenis_kode_rekening.jenis');
        
        $this->db->join('kode_rekening', 'kode_rekening.id = neraca.kode_id');
        $this->db->join('jenis_kode_rekening', 'kode_rekening.jenis_id = jenis_kode_rekening.id');
        
        $this->db->from('neraca');
        $barang = $this->db->get();
        $data = $barang->result();
        
        $rows = [];
        foreach ($data as $key => $value) {
            $rows[] = ['ID' => $value->id, 'Nama' => $value->nama, 'Keterangan' => $value->keterangan, 'Kode' => $value->kode, 'Action' => $value->id, 'jenisID' => $value->jenis_id, 'Jenis' => $value->jenis, 'Debet' => $value->debet, 'Kredit' => $value->kredit];
        }
        
        $json = ['rows' => $rows, 'cols' => $cols, 'b' => $this->db->last_query()];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json, JSON_NUMERIC_CHECK));
    }

}
