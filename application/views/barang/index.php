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
  <?php $CI->load->view('templates/neraca/navbar.php');?>
  <h3 class="col-md-12"><i class="fa fa-archive"></i> Management Barang</h3>
  <ol class="breadcrumb text-right">
    <li>
      <a href="<?php echo base_url() ?>" role="button" data-toggle="modal"><i class="fa fa-home fa-fw"></i> Home</a>
    </li>

    <li class="active">
      <i class="fa fa-archive"></i> barang
    </li>

  </ol>

  <div class="col-md-12">
      <div id="expired-container" data-remote="<?php echo base_url('barang/expired-json') ?>">
          
      </div>
    <div class="alert-container">

    </div>
    <h4>List Barang</h4>
    <div id="toolbar">
      <div class="btn-group">
        <button id="add" data-toggle="modal" data-target="#modal-insert" class="btn btn-success">
          <i class="fa fa-plus-circle"></i> Tambah
        </button>
        <a id="export" class="btn btn-primary" role="button" href="<?php echo base_url('barang/export'); ?>">
          <i class="fa fa-exchange"> Export</i>
        </a>
      </div>

    </div>

    <table class="table table-condensed" id="barang-grid" data-remote="<?=base_url('barang/data-json')?>" data-show-refresh="true" data-show-columns="true" data-search="true" data-page-size="10" data-pagination="true" data-pagination-loop="false" data-toolbar="#toolbar"
      data-unique-id="id_brng" data-filter-show-clear="true" data-filter-control="true">
      <thead>
        <tr>
          <th data-width="150px" data-align="center" data-class="table-button-container" data-formatter="actionFormatter"><i class="fa fa-bolt"></i></th>
          <th data-width="100px" data-field="id_brng" data-filter-control="input" data-sortable="true">ID</th>
          <th data-width="150px" data-field="kategori" data-filter-control="select" data-sortable="true">Kategori</th>
          <th data-width="150px" data-field="jenis" data-filter-control="select" data-sortable="true">Jenis</th>
          <th data-field="nama" data-filter-control="input" data-sortable="true">Nama</th>
          <th data-width="150px" data-field="h_jual" data-filter-control="input" data-formatter="biayaFormatter" data-sortable="true" data-align="right" data-halign="left">Harga Jual</th>
          <th data-width="50px" data-field="stok" data-filter-control="input" data-sortable="true" data-align="right" data-halign="left">Stok</th>
          <th data-width="120px" data-field="tgl_ex" data-filter-control="input" data-sortable="true" data-align="right" data-halign="left">Exp.</th>
        </tr>
      </thead>

    </table>

  </div>
  </div>
  <?php $CI->load->view('barang/insert');?>
  <?php $CI->load->view('barang/edit');?>
  <?php $CI->load->view('templates/neraca/fscript');?>
  <script type="text/javascript">
    function activeFormatter(val, row) {
    if (val === 0) {
      return '<i class="fa fa-close text-danger"></i>';
    }
    return '<i class="fa fa-check text-success"></i>';
  }

  function actionFormatter(val, row, iRow) {

    return '<a href="#show" class="btn-view" data-toggle="tooltip" data-placement="top" title="Lihat data?" role="group" data-toggle="modal-view" data-row="' + row.id_brng + '"><i class="fa fa-eye"></i></a> <a href="#edit" class="btn-edit" data-toggle="tooltip" data-placement="top" title="Ubah data?" role="group" data-toggle="modal-edit" data-row="' + row.id_brng + '"><i class="fa fa-edit"></i></a> <a href="#delete" data-toggle="tooltip" data-placement="top" title="Hapus data?" class="btn-delete" role="group" data-url="' + row.delUrl + '" data-toggle="button"><i class="fa fa-trash"></i></a>'
  }

  function biayaFormatter(val) {
    return val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  }
  requirejs(['jquery', 'bootstrap', 'validator', 'bootbox', 'pickadate','pickadate-date' ,'bootstrapTable', 'bootstrapTableFC'], function($, bs, bsval, bootbox) {
    $(document).ready(function() {
        
      $('input[name="h_beli"], input[name="h_jual"]').on('keyup', function(e){
        $(this).parent().find('.help-block').text('Terbilang Rp. '+ $(this).val().replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,") + ',-');
      });

      // Load required css
      loadCss('assets/animate.css/animate.min');
      $('#modal-edit').on('hidden.bs.modal', function(e) {
        $('#modal-edit form').validator('destroy');
      })
      $('#modal-edit').on('shown.bs.modal', function(e) {
        $('#modal-edit form').validator('update');
      })
      $('#modal-container-insert').on('hidden.bs.modal', function(e) {
        $('#modal-container-insert form').validator('destroy');
      })
      $('#modal-container-insert').on('shown.bs.modal', function(e) {
        $('#modal-container-insert form').validator('update');
      })
      var API_URL = $('#barang-grid').attr('data-remote');
      var $table = $('#barang-grid').bootstrapTable({
        url: API_URL,
        onPostBody: function(data) {
          $('#barang-grid th input, #barang-grid th select').addClass('input-sm')
          $('#barang-grid [data-toggle="tooltip"]').tooltip({
            container: '#barang-grid'
          });
          $('.btn-edit').click(function() {
            var $row = $('#barang-grid').bootstrapTable('getRowByUniqueId', $(this).attr('data-row'));
            $('#form-edit').attr('data-id', $row.id_brng);
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
                        $('#barang-grid').bootstrapTable('refresh')
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

    $('input#inputTglExp').pickadate({
      container: 'body',
      format: 'yyyy-mm-dd'
    })

      $('#form-insert').submit(function(e) {
        e.preventDefault()
        $(this).attr('disabled', 'disabled')
        var formdata = $(this).serializeArray();
        $.post($(this).attr('action'), formdata, function(result) {
          var _alert = $('<div></div>');
          if (result.response) {
            $('#modal-insert').modal('hide');
            _alert.attr('class', 'alert alert-success')
            _alert.html('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + result.message)
            $('#barang-grid').bootstrapTable('refresh')
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
              _alert.html('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + result.message)
            }
            $('#form-insert-error').html(_alert);
          }

        })
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
            $('#barang-grid').bootstrapTable('refresh')
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
  <?php $CI->load->view('templates/neraca/footer.php');?>