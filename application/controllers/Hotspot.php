<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Hotspot Page Controller.
 * @author Adha Bakhtiar adhabakhtiar@gmail.com
 */
class Hotspot extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('sites');
    }

    public function index()
    {
        $data['page_title'] = 'Hotspot';
        $this->load->view('hotspot/index', $data);
    }

    public function data_json()
    {
        $this->db->select('*, DATE_FORMAT(tgl_daftar, "%Y-%m-%d") AS tgl_daftar, DATE_FORMAT(tgl_exp, "%Y-%m-%d") AS tgl_exp, Concat("'.base_url('hotspot/delete/').'", hotspot.id) as delUrl');
        $query = $this->db->get('hotspot');

        $rows = [];
        if ($query->num_rows() > 0) {
            $rows = $query->result();
        }
        $json = $rows;
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json, JSON_NUMERIC_CHECK));

        return;
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
        $post['active'] = 1;
        $post['mac'] = strtoupper($post['mac']);
        $post['nama'] = strtoupper($post['nama']);
        $post['bagian'] = strtoupper($post['bagian']);
        $query = $this->db->insert_string('hotspot', $post);
        $query = $this->db->query($query);
        $error = $this->db->error();
        $json = (!$query) ? ['response' => false, 'message' => 'Terjadi kesalahan database, Gagal menyimpan data.<br>' & $error['message']] : ['response' => true, 'message' => 'Berhasil menyimpan data.<br>'];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json, JSON_NUMERIC_CHECK));

        return;
    }

    private function _mac_validation_callback($value)
    {
        preg_match('/([0-9A-F]{2}:){5}[0-9A-F]{2}/', $value, $res);
        if (count($res) < 1) {
            return false;
        }

        return true;
    }

    private function validation()
    {
        $this->load->library('form_validation');
        $this->load->config('sites_validation');
        $vRule = $this->config->item('hotspot');
        $this->form_validation->set_rules($vRule);
        $this->form_validation->set_message('_mac_validation_callback', '');
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

    public function edit($id)
    {
        // Method Checker
        if (!http_method_checker('post')) {
            return;
        }
        if (!$this->validation()) {
            return;
        }
        $post = $this->input->post();
        $post['mac'] = strtoupper($post['mac']);
        $post['nama'] = strtoupper($post['nama']);
        $post['bagian'] = strtoupper($post['bagian']);
        $json = [];
        if (!$query = $this->db->update('hotspot', $post, 'id = '.$id)) {
            $error = $this->db->error();

            $json = [
                'response' => false,
                'message' => 'Terjadi kesalahan database, Gagal menyimpan data.<br>' & $error['message'],
                'query' => $query,
            ];
        } else {
            $json = [
                'response' => true,
                'message' => 'Berhasil menyimpan data.<br>',
                'query' => $query,
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json, JSON_NUMERIC_CHECK));

        return;
    }

    public function delete($id)
    {
        if (!http_method_checker('get')) {
            return;
        }
        if ($this->db->delete('hotspot', ['id' => $id])) {
            $json = [
                'response' => true,
                'message' => 'Berhasil menghapus data.',
            ];
        } else {
            $json = [
                'response' => false,
                'message' => 'Terjadi kesalahan, server gagal menghapus data.',

            ];
        }
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

        $query = $this->db
            ->select('*,DATE_FORMAT(tgl_daftar, "%d/%m/%y") AS tgl_daftar, DATE_FORMAT(tgl_exp, "%d/%m/%y") AS tgl_exp')
            ->where('tgl_daftar >= ', $get['date-start'])
            ->where('tgl_exp <=', $get['date-end'])
            ->get('hotspot');
        $i = 0;
        $objPHPExcel->getActiveSheet()
            ->mergeCellsByColumnAndRow(0, $i + 1, 6, $i + 1);
        $sDate = DateTime::createFromFormat('Y-m-d', $get['date-start']);
        $sMonth = strtoupper(intToMonth($sDate->format('m')).' '.$sDate->format('Y'));
        $eDate = DateTime::createFromFormat('Y-m-d', $get['date-end']);
        $eMonth = strtoupper(intToMonth($eDate->format('m')).' '.$eDate->format('Y'));
        $resMonth = ($sDate->format('m') == $eDate->format('m')) ? $sMonth : $sMonth.' - '.$eMonth;
        $objPHPExcel->getActiveSheet()
            ->setCellValueByColumnAndRow(0, $i + 1, "LAPORAN PENGGUNA HOTSPOT\nBULAN ".$resMonth);

        $i = 1;
        $objPHPExcel->getActiveSheet()
            ->setCellValueByColumnAndRow(0, $i + 1, 'ID')
            ->setCellValueByColumnAndRow(1, $i + 1, 'NAMA')
            ->setCellValueByColumnAndRow(2, $i + 1, 'BAGIAN')
            ->setCellValueByColumnAndRow(3, $i + 1, 'IP')
            ->setCellValueByColumnAndRow(4, $i + 1, 'MAC')
            ->setCellValueByColumnAndRow(5, $i + 1, 'TANGGAL DAFTAR')
            ->setCellValueByColumnAndRow(6, $i + 1, 'TANGGAL EXP.')
            ->setCellValueByColumnAndRow(7, $i + 1, 'BIAYA');

        $objPHPExcel->getActiveSheet()
            ->getStyle('A1:H2')->getFont()->setBold(true);
        $i = 2;
        if ($query->num_rows() > 0) {
            $objHotspot = $query->result();
            foreach ($objHotspot as $hotspot) {
                $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(0, $i + 1, $hotspot->id)
                    ->setCellValueByColumnAndRow(1, $i + 1, $hotspot->nama)
                    ->setCellValueByColumnAndRow(2, $i + 1, $hotspot->bagian)
                    ->setCellValueByColumnAndRow(3, $i + 1, $hotspot->ip)
                    ->setCellValueByColumnAndRow(4, $i + 1, $hotspot->mac)
                    ->setCellValueByColumnAndRow(5, $i + 1, $hotspot->tgl_daftar)
                    ->setCellValueByColumnAndRow(6, $i + 1, $hotspot->tgl_exp)
                    ->setCellValueByColumnAndRow(7, $i + 1, $hotspot->biaya);
                ++$i;
            }
            $lastID = $i;
            $objPHPExcel->getActiveSheet()
                ->mergeCellsByColumnAndRow(0, $i + 1, 6, $i + 1);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i + 1, 'TOTAL');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $i + 1, '=SUM(H1:H'.$i.')');
            $k = $i + 1;
            $objPHPExcel->getActiveSheet()
                ->getStyle('A'.($k).':H'.($k))->getFont()->setBold(true);
        }
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
        $objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getStyle('A1')
        ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:H2')
            ->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $filename = (isset($get) || $get == '') ? date('Y-m-d his').'.xls' : $get.'.xls'; //save our workbook as this file name

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }
}
