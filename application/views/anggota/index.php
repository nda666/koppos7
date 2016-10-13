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
  <h3 class="col-md-12"><i class="fa fa-users"></i> Management Anggota</h3>
  <ol class="breadcrumb text-right">
    <li>
      <a href="<?php echo base_url() ?>" role="button" class="" data-toggle="modal"><i class="fa fa-home fa-fw"></i> Home</a>
    </li>

    <li class="active">
      <i class="fa fa-users"></i> Anggota
    </li>

  </ol>

  <div class="col-md-12">
    <div class="alert-container">

    </div>
    <h4>List Anggota</h4>
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

    <table class="table table-condensed table-striped" id="anggota-grid"  data-remote="<?=base_url('anggota/data-json')?>" data-show-refresh="true" data-show-columns="true" data-search="true" data-page-size="10" data-pagination="true" data-filter-control="true" data-pagination-loop="false" data-toolbar="#toolbar"
      data-unique-id="id" data-filter-show-clear="true">
      <thead>
        <tr>
          <th data-align="center" data-width="100px" data-class="table-button-container" data-formatter="actionFormatter"><i class="fa fa-bolt"></i>
          </th>
          <th data-field="id" data-sortable="true">ID</th>
          <th data-field="nippos"  data-filter-control="input" data-sortable="true">NIP</th>
          <th data-field="nama" data-filter-control="input" data-sortable="true">Nama</th>
           <th data-field="status" data-sortable="true"  data-filter-control="select">Status</th>
        </tr>
      </thead>

    </table>

  </div>
  </div>
  <?php $CI->load->view('anggota/insert');?>
  <?php $CI->load->view('templates/neraca/fscript'); ?>
  <script type="text/javascript">
  function actionFormatter(val, row, iRow) {

  return '<div class="btn-group"><button class="btn btn-sm btn-warning btn-group btn-edit" data-toggle="tooltip" data-placement="top" title="Ubah data?" role="group" data-toggle="modal-edit" data-row="' + row.id + '"><i class="fa fa-edit"></i></button> <button data-toggle="tooltip" data-placement="top" title="Hapus data?" class="btn btn-sm btn-danger btn-group btn-delete" role="group" data-url="' + row.delUrl + '" data-toggle="button"><i class="fa fa-trash"></i></button></div>'
}
    requirejs(['jquery', 'bootstrap', 'validator', 'bootbox', 'pickadate', 'pickadate-date', 'mask', 'bootstrapTable', 'bootstrapTableFC'], function($, bs, bsval, bootbox) {
        $(document).ready(function(){
            var API_URL = $('#anggota-grid').attr('data-remote');
            $('#anggota-grid').bootstrapTable({
              url: API_URL,
            });
        })
      
    });
  </script>
  <?php $CI->load->view('templates/neraca/footer.php'); ?>