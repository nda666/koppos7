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
    
    <div id="toolbar" >
      <div class="btn-group">
        <button id="add" data-toggle="modal" data-target="#modal-insert" class="btn btn-success">
          <i class="fa fa-plus-circle"></i> <span class="hidden-xs hidden-sm">Tambah</span>
        </button>
        
    </div>

    </div>

    <table class="table table-condensed table-striped" id="anggota-grid"  data-remote="<?=base_url('anggota/data-json')?>" data-show-refresh="true" data-search="true" data-page-size="10" data-pagination="true" data-filter-control="true" data-pagination-loop="false" data-toolbar="#toolbar"
      data-unique-id="id" data-filter-show-clear="true">
      <thead>
        <tr>
          <th data-align="center" data-width="100px" data-class="table-button-container" data-formatter="actionFormatter"><i class="fa fa-bolt"></i>
          </th>
          <th data-field="id"  data-filter-control="input" data-sortable="true">ID</th>
          <th data-field="nippos"  data-filter-control="input" data-sortable="true">NIP</th>
          <th data-field="nama" data-filter-control="input" data-sortable="true">Nama</th>
           <th data-field="status" data-sortable="true"  data-filter-control="select">Status</th>
        </tr>
      </thead>

    </table>

  </div>
  </div>
  <?php $CI->load->view('anggota/insert');?>
  <?php $CI->load->view('anggota/edit');?>
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
              onPostBody: function(data){
                  $('.btn-edit').click(function() {
                    var $row = $('#anggota-grid').bootstrapTable('getRowByUniqueId', $(this).attr('data-row'));
                    $('#form-edit').attr('data-id', $row.id);
                    $.each($row, function(index, val) {
                      $('#form-edit [name="' + index + '"]').val(val);
                    });
                    $('#modal-edit').modal('show')
                  });
                  
                  $('.btn-delete').click(function(e) {
                    var deleteButton = $(this);

                    var delMessage = bootbox.dialog({
                      message: "Menghapus data tidak dapat dibatalkan. Anda yakin menghapus data ini?",
                      title: "Konfirmasi",
                      buttons: {
                        error: {
                          label: "Tidak",
                          className: "btn-default"
                        },
                        success: {
                          label: "Ya, Hapus",
                          className: "btn-danger",
                          callback: function(el) {
                            $(el.currentTarget).html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Loading...');
                            $(el.currentTarget).prop('disabled', 'disabled');
                            $.get(deleteButton.attr('data-url'), function(result) {
                              var _alert = $('<div></div>');
                              if (result.response) {
                                _alert.attr('class', 'alert alert-success')
                                _alert.html('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + result.message)
                                $('#anggota-grid').bootstrapTable('refresh')
                              } else {
                                _alert.attr('class', 'alert alert-danger')

                                _alert.html('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + result.message)
                              }
                              $('.alert-container').html(_alert);

                              delMessage.modal('hide');
                            })
                            .fail(function(e){
                              delMessage.find('.bootbox-body').html('<span class="text-danger">Terjadi kesalahan saat menghapus data. Data gagal dihapus</span><br>Silahkan coba lagi, apabila pesan ini masih muncul lagi harap hubungi IT Admin.<br><br>Anda ingin mencoba menghapus data ini lagi?');
                              $(el.currentTarget).html('Ya, Hapus');
                              $(el.currentTarget).removeAttr('disabled');
                            })
                            .always(function() {
                              $(el.currentTarget).html('Ya, Hapus');
                              $(el.currentTarget).removeAttr('disabled');
                            });
                            return false;
                          }
                        }
                      }
                    });
                  });
                
              }
            });
            
            $('#form-insert').on('submit', function(e){
                e.preventDefault();
                $(this).attr('disabled', 'disabled')
                var formdata = $(this).serializeArray();
                $.post($(this).attr('action'), formdata, function(result) {
                  var _alert = $('<div></div>');
                  if (result.response) {
                    $('#modal-insert').modal('hide');
                    _alert.attr('class', 'alert alert-success')
                    _alert.html('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + result.message)
                    $('#anggota-grid').bootstrapTable('refresh')
                    $('.alert-container').html(_alert);
                  } else {
                     _alert.attr('class', 'alert alert-danger')
                    if (typeof result.message === 'object' || result.message === 'array'){
                      var $message = '<ul>';
                      $.each(result.message, function(index, val){
                        $message += '<li>' + val +'</li>';
                      });
                      $message += '</ul>'
                      _alert.html('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + $message)
                    } else if (typeof result.message === 'string' ){
                      _alert.html('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + result.message + result.error.message);
                      
                    }
                    $('#form-insert-error').html(_alert);
                  }

              });
            });
            
            
            $('#form-edit').submit(function(e) {
              e.preventDefault()
              $(this).attr('disabled', 'disabled')
              var formdata = $(this).serializeArray();
              $.post($(this).attr('action') + '/' + $(this).attr('data-id'), formdata, function(result) {
                var _alert = $('<div></div>');
                if (result.response) {
                  $('#modal-edit').modal('hide');
                  _alert.attr('class', 'alert alert-success')
                  _alert.html('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + result.message)
                  $('#anggota-grid').bootstrapTable('refresh')
                } else {
                  _alert.attr('class', 'alert alert-danger')
                  _alert.html('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + result.message)
                }
                $('.alert-container').html(_alert);
              })
            });
        });
      
    });
  </script>
  <?php $CI->load->view('templates/neraca/footer.php'); ?>