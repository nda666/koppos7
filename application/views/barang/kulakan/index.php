<?php
$CI = &get_instance();
$CI->load->view('templates/neraca/header.php');
?>
  <style>
    .datepicker {
      z-index: 1051 !important;
      /* has to be larger than 1050 */
    }
  </style>
  <?php $CI->load->view('templates/neraca/navbar.php'); ?>
  <h3 class="col-md-12"><i class="fa fa-wifi"></i> Kulakan Barang</h3>
  <ol class="breadcrumb text-right">
    <li>
      <a href="<?php echo base_url() ?>" role="button" data-toggle="modal"><i class="fa fa-home fa-fw"></i> Home</a>
    </li>

    <li class="active">
      <i class="fa fa-shopping-cart"></i> Kulakan Barang
    </li>

  </ol>

  <div class="col-md-12">
    <div class="alert-container">

    </div>
    <h4>List Pengguna Kulakan Barang</h4>
    <div id="toolbar">
      <div class="btn-group">
        <button id="add" data-toggle="modal" data-target="#modal-insert" class="btn btn-success">
          <i class="fa fa-plus-circle"></i> Tambah
        </button>
        <button id="export" class="btn btn-primary" data-toggle="modal" data-target='#modal-export'>
          <i class="fa fa-exchange"> Export</i>
        </button>
      </div>

    </div>

    <table class="table" id="hotspot-grid" data-remote="<?=base_url('hotspot/data-json')?>" data-show-refresh="true" data-show-columns="true" data-search="true" data-page-size="10" data-pagination="true" data-pagination-loop="false" data-toolbar="#toolbar"
      data-unique-id="id">
      <thead>
        <tr>
          <th data-align="center" data-class="table-button-container" data-formatter="actionFormatter"><i class="fa fa-bolt"></i></th>
          <th data-field="id" data-sortable="true">ID</th>
          <th data-field="nama" data-sortable="true">Nama</th>
          <th data-field="bagian" data-sortable="true">Bagian</th>
          <th data-field="ip" data-sortable="true">IP</th>
          <th data-field="mac" data-sortable="true">MAC</th>
          <th data-field="tgl_daftar" data-align="center" data-sortable="true">Tgl. Daftar</th>
          <th data-field="tgl_exp" data-align="center" data-sortable="true">Tgl. Exp</th>
          <th data-field="biaya" data-formatter="biayaFormatter" data-sortable="true">Biaya</th>
          <th data-field="active" data-sortable="true" data-formatter="activeFormatter"><i class="fa fa-wifi"></i></th>
        </tr>
      </thead>

    </table>

  </div>
  </div>

  <?php $CI->load->view('templates/neraca/fscript'); ?>
  <?php $CI->load->view('templates/neraca/footer.php'); ?>