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
  <h3 class="col-md-12"><i class="fa fa-wifi"></i> Management Hotspot</h3>
  <ol class="breadcrumb text-right">
    <li>
      <a href="<?php echo base_url() ?>" role="button" data-toggle="modal"><i class="fa fa-home fa-fw"></i> Home</a>
    </li>

    <li class="active">
      <i class="fa fa-wifi"></i> Hotspot
    </li>

  </ol>

  <div class="col-md-12">
    <div class="alert-container">

    </div>
    <h4>List Pengguna Hotspot</h4>
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
  <?php $CI->load->view('hotspot/insert');?>
  <?php $CI->load->view('hotspot/edit');?>
  <?php $CI->load->view('hotspot/export');?>
  <?php $CI->load->view('templates/neraca/fscript');?>
  <script type="text/javascript">
    function activeFormatter(val, row) {
    if (val === 0) {
      return '<i class="fa fa-close text-danger"></i>';
    }
    return '<i class="fa fa-check text-success"></i>';
  }

  function actionFormatter(val, row, iRow) {

    return '<div class="btn-group"><button class="btn btn-sm btn-warning btn-group btn-edit" data-toggle="tooltip" data-placement="top" title="Ubah data?" role="group" data-toggle="modal-edit" data-row="' + row.id + '"><i class="fa fa-edit"></i></button> <button data-toggle="tooltip" data-placement="top" title="Hapus data?" class="btn btn-sm btn-danger btn-group btn-delete" role="group" data-url="' + row.delUrl + '" data-toggle="button"><i class="fa fa-trash"></i></button></div>'
  }

  function biayaFormatter(val) {
    return val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  }
  requirejs(['jquery', 'bootstrap', 'validator', 'bootbox', 'pickadate','pickadate-date','mask' ,'bootstrapTable', 'bootstrapTableFC'], function($, bs, bsval, bootbox) {
    $(document).ready(function() {
      $.mask.definitions['h'] = "[A-Fa-f0-9]";

      $('[name="mac"]').mask("hh:hh:hh:hh:hh:hh");

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
      var API_URL = $('#hotspot-grid').attr('data-remote');
      var $table = $('#hotspot-grid').bootstrapTable({
        url: API_URL,
        onPostBody: function(data) {
          $('#hotspot-grid [data-toggle="tooltip"]').tooltip({
            container: '#hotspot-grid'
          });
          $('.btn-edit').click(function() {
            var $row = $('#hotspot-grid').bootstrapTable('getRowByUniqueId', $(this).attr('data-row'));
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
                        $('#hotspot-grid').bootstrapTable('refresh')
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

    var from_$input = $('input.date-start').pickadate({
      container: 'body',
      format: 'yyyy-mm-dd',
      formatSubmit: 'yyyy-mm-dd'
    }),
    from_picker = from_$input.pickadate('picker')

    var to_$input = $('input.date-end').pickadate({
      container: 'body',
      format: 'yyyy-mm-dd',
      formatSubmit: 'yyyy-mm-dd'
    }),
    to_picker = to_$input.pickadate('picker')

    // Check if there’s a “from” or “to” date to start with.
    if ( from_picker.get('value') ) {
    to_picker.set('min', from_picker.get('select'))
    }
    if ( to_picker.get('value') ) {
    from_picker.set('max', to_picker.get('select'))
    }

    // When something is selected, update the “from” and “to” limits.
    from_picker.on('set', function(event) {
    if ( event.select ) {
    to_picker.set('min', from_picker.get('select'))    
    }
    else if ( 'clear' in event ) {
    to_picker.set('min', false)
    }
    })
    to_picker.on('set', function(event) {
    if ( event.select ) {
    from_picker.set('max', to_picker.get('select'))
    }
    else if ( 'clear' in event ) {
    from_picker.set('max', false)
    }
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
            $('#hotspot-grid').bootstrapTable('refresh')
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
            $('#hotspot-grid').bootstrapTable('refresh')
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