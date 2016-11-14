<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['sites']);
    }

    public function index()
    {
        $this->load->model('jenis');
        $data['data_jenis'] = $this->jenis->getAll();
        $data['page_title'] = 'Barang';
        $query              = $this->db->select('*')->get('t_kat_brng');
        if ($query) {
            $data['data_kategori'] = $query->result();
        }
        $this->load->view('barang/index', $data);
    }

    public function data_json()
    {
        $query = $this->db->select('t_brng.*, t_kat_brng.kategori,t_jenis_brng.jenis ,Concat("' . base_url('barang/delete/') . '", t_brng.id_brng) as delUrl,')
            ->join('t_kat_brng', 't_brng.id_kat_brng = t_kat_brng.id_kat_brng', 'left')
            ->join('t_jenis_brng', 't_brng.id_jenis_brng = t_jenis_brng.id_jenis_brng', 'left')
            ->get('t_brng');
        if ($query) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($query->result(), JSON_NUMERIC_CHECK));

            return;
        }
        return;
    }

    private function validation()
    {
        $this->load->library('form_validation');
        $this->load->config('sites_validation');
        $vRule = $this->config->item('t_brng');
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
        $query = $this->db->insert_string('t_brng', $post);
        $query = $this->db->query($query);
        $json  = [];
        if (!$query) {
            $error = $this->db->error();
            $json  = [
                'response' => false,
                'error'    => $error,
                'message'  => 'Terjadi kesalahan database, Gagal menyimpan data.<br>',
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
        $id   = $post['id_brng'];
        unset($post['id_brng']);
        $query = $this->db->update('t_brng', $post, 'id_brng = ' . $id);
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
        $query = $this->db->where('id_brng =', $id)->delete('t_brng');
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

    public function export()
    {
        $get = $this->input->get();
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle('title')
            ->setDescription('description');

        $objPHPExcel->setActiveSheetIndex(0);

        $i = 0;
        $objPHPExcel->getActiveSheet()
            ->mergeCellsByColumnAndRow(0, $i + 1, 9, $i + 1);

        $objPHPExcel->getActiveSheet()
            ->setCellValueByColumnAndRow(0, $i + 1, "LAPORAN STOK AKHIR POSERBA \n" . strtoupper(date('F Y')));
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
        $objPHPExcel->getActiveSheet()
            ->getStyle('A1:J1')->applyFromArray([
            'font'      => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ],
        ]);
        $i  = 1;

        $qr = $this->db->get('t_kat_brng');
        foreach ($qr->result() as $q) {
            $i++;
            $s = $i + 1;
            $objPHPExcel->getActiveSheet()
                ->mergeCellsByColumnAndRow(0, $i, 9, $i);

            $objPHPExcel->getActiveSheet()
                ->setCellValueByColumnAndRow(0, $i, "KATEGORI: " . $q->kategori);
            $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(($i == 2) ? 20 : 40);

            $objPHPExcel->getActiveSheet()
                ->getStyle('A' . $i . ':J' . $i)->applyFromArray([
                'font' => [
                    'bold' => true,
                ],

            ]);
            $objPHPExcel->getActiveSheet()
                ->setCellValueByColumnAndRow(0, $i + 1, 'ID')
                ->setCellValueByColumnAndRow(1, $i + 1, 'KODE')
                ->setCellValueByColumnAndRow(2, $i + 1, 'NAMA')
                ->setCellValueByColumnAndRow(3, $i + 1, 'SUPLAYER')
                ->setCellValueByColumnAndRow(4, $i + 1, 'STOK')
                ->setCellValueByColumnAndRow(5, $i + 1, 'RE STOK')
                ->setCellValueByColumnAndRow(6, $i + 1, 'HARGA BELI')
                ->setCellValueByColumnAndRow(7, $i + 1, 'HARGA JUAL')
                ->setCellValueByColumnAndRow(8, $i + 1, 'TGL. MASUK')
                ->setCellValueByColumnAndRow(9, $i + 1, 'TGL. EXP');
            $objPHPExcel->getActiveSheet()->getRowDimension($i + 1)->setRowHeight(30);
            $objPHPExcel->getActiveSheet()
                ->getStyle('A' . $s . ':J' . ($i + 1))->applyFromArray([
                'fill'      => [
                    'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '6cc644'),
                ],
                'alignment' => [
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ],
                'font'      => [
                    'bold' => true,
                ],
            ]);

            $i++;
            $query = $this->db->order_by('jenis', 'asc')->get('t_jenis_brng');
            $jenis = [];
            if ($query) {
                $jenis = $query->result();
                foreach ($jenis as $j) {
                    $query_ = $this->db
                        ->select('*')
                        ->where('id_jenis_brng', $j->id_jenis_brng)
                        ->where('id_kat_brng', $q->id_kat_brng)
                        ->get('t_brng');
                    if ($query_->num_rows() > 0) {
                        $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(0, $i + 1, 9, $i + 1);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i + 1, $j->jenis);
                        $objPHPExcel->getActiveSheet()->getRowDimension($i + 1)->setRowHeight(20);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 1))->applyFromArray([
                            'fill'      => [
                                'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => 'DEDEDE'),
                            ],
                            'font'      => [
                                'bold' => true,
                            ],
                            'alignment' => [
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            ],
                        ]);
                        $i++;
                        $objbarang = $query_->result();
                        foreach ($objbarang as $barang) {
                            $objPHPExcel->getActiveSheet()
                                ->setCellValueByColumnAndRow(0, $i + 1, $barang->id_brng)
                                ->setCellValueByColumnAndRow(1, $i + 1, $barang->kode)
                                ->setCellValueByColumnAndRow(2, $i + 1, $barang->nama)
                                ->setCellValueByColumnAndRow(3, $i + 1, $barang->supplier)
                                ->setCellValueByColumnAndRow(4, $i + 1, $barang->stok)
                                ->setCellValueByColumnAndRow(6, $i + 1, $barang->h_beli)
                                ->setCellValueByColumnAndRow(7, $i + 1, $barang->h_jual)
                                ->setCellValueByColumnAndRow(8, $i + 1, $barang->tgl)
                                ->setCellValueByColumnAndRow(9, $i + 1, $barang->tgl_ex);
                            $i++;
                        }

                    }
                }
            }
            $objPHPExcel->getActiveSheet()
                ->getStyle('A' . $s . ':J' . $i)->applyFromArray([
                'borders' => [
                    'allborders' => [
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                    ],
                ],
            ]);
        }

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);

        $filename = (isset($get) || $get == '') ? date('Y-m-d his') . '.xls' : $get . '.xls';

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

}
