<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

$config = [
    'hotspot' => [
        // Nama Field
        [
            'field' => 'nama',
            'label' => 'Nama',
            'rules' => 'required|min_length[3]',
        ],
        // IP Field
        [
            'field' => 'ip',
            'label' => 'IP Address',
            'rules' => 'required|valid_ip',
        ],
        // Mac Addr
        [
            'field' => 'mac',
            'label' => 'MAC Address',
            'rules' => 'required|max_length[17]|regex_match[/([0-9A-Fa-f]{2}:){5}[0-9A-Fa-f]{2}/]',
        ],
        [
            'field' => 'tgl_daftar',
            'label' => 'Tanggal Daftar',
            'rules' => 'required',
        ],
        [
            'field' => 'tgl_exp',
            'label' => 'Tanggal Exp',
            'rules' => 'required',
        ],
        [
            'field' => 'biaya',
            'label' => 'Biaya',
            'rules' => 'required|numeric',
        ],
    ],
    'anggota' => [
        [
        'field' => 'nama',
        'label' => 'Nama',
        'rules' => 'required',
        ],
        [
        'field' => 'nippos',
        'label' => 'NIPPOS',
        'rules' => 'required|min_length[3]',
    ],
    ],
];

/* End of file sites_validation.php */
/* Location: ./application/controllers/sites_validation.php */
