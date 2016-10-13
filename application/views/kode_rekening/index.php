
<?php
$CI = &get_instance();
$CI->load->view('templates/neraca/header.php');
$CI->load->view('templates/neraca/navbar.php');
?>
<ol class="breadcrumb text-right">
    <li class="pull-left">
        <a id="modal-134751" href="#modal-container-134751" role="button" class="" data-toggle="modal"><i class="fa fa-plus-circle fa-lg fa-fw"></i> Tambah Kode Rekening Baru</a>
    </li>
<li>
      <a href="#"><i class="fa fa-file-excel-o"></i> Buat Neraca</a>
  </li>
  
  <li>
      <a href="#"><i class="fa fa-user"></i> Buat Neraca</a>
  </li>
  
</ol>

    <div class="col-md-12">
        <div class="alert-container">
            
        </div>
        <h4>Data Kode Rekening</h4>
        <div id="koderekening-grid" class="table-responsive" data-remote="<?= base_url('koderekening/data-json') ?>" class="backgrid-bordered">
        </div>
    </div>
		
<?php
// INSERT MODAL
$CI->load->view('kode_rekening/insert.php');
$CI->load->view('kode_rekening/edit.php');
// $javascript = [
//     base_url('assets/watable/jquery.watable.js'),
//     base_url('/assets/bootstrap-validator/validator.min.js'),
//     base_url('assets/bootbox/bootbox.js'),
//     base_url('assets/sites/js/neraca.min.js')
// ];
$CI->load->view('templates/neraca/fscript');
?>
<script type="text/javascript">
requirejs([
  'jquery', 'bootstrap', 'validator', 'bootbox', 'watable'
], function($,bs,bsval,bootbox) {
  $(document).ready(function(){
    // Load required css
    loadCss('assets/datepicker/css/datepicker');
    loadCss('assets/animate.css/animate.min');
    loadCss('assets/watable/watable');
    $('#modal-container-edit').on('hidden.bs.modal', function (e) {
        $('#modal-container-edit form').validator('destroy');
    })
    $('#modal-container-edit').on('shown.bs.modal', function (e) {
        $('#modal-container-edit form').validator('update');
    })
    $('#modal-container-134751').on('hidden.bs.modal', function (e) {
        $('#modal-container-134751 form').validator('destroy');
    })
    $('#modal-container-134751').on('shown.bs.modal', function (e) {
        $('#modal-container-134751 form').validator('update');
    })
    
    $('#form_kode_rekening').submit(function(e) {
      e.preventDefault()
      $(this).attr('disabled', 'disabled')
      var formdata = $(this).serializeArray();
      $.post($(this).attr('action'), formdata, function(result) {
        var _alert = $('<div></div>');
        if (result.response) {
          _alert.attr('class', 'alert alert-success')
          _alert.html('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><b>Sukses!!</b> ' + result.message)
          w8.update()
        } else {
          _alert.attr('class', 'alert alert-danger')
          _alert.html('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><b>Gagal!!</b> ' + result.message)
        }
        $('.alert-container').html(_alert);
      })
    });

    $('form#edit_kode_rekening').submit(function(e) {
      e.preventDefault()
      $(this).attr('disabled', 'disabled')
      var formdata = $(this).serializeArray();
      $.post($(this).attr('action'), formdata, function(result) {
        var _alert = $('<div></div>');
        if (result.response) {
          _alert.attr('class', 'alert alert-success')
          _alert.html('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><b>Sukses!!</b> ' + result.message)
          w8.update()
        } else {
          _alert.attr('class', 'alert alert-danger')
          _alert.html('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><b>Gagal!!</b> ' + result.message)
        }
        $('#edit-message').html(_alert);
      })
    });
    var _watableFix = 0;
    var w8 = $('#koderekening-grid').WATable({
      url: $('#koderekening-grid').attr('data-remote'),
      preFill: true,
      filter: true,
      transition: 'slide',
      transitionDuration: 0.5,
      tableCreated: function(data){
        
        while (_watableFix > 0) {
            $('[data-toggle="tooltip"]').tooltip();
            _watableFix = 0;
        }
        _watableFix = _watableFix + 1;
      },
      actions: {
        filter: true,
        columnPicker: true,
        custom: [$('<a href="#" class="refresh"><span class="glyphicon glyphicon-refresh"></span>&nbsp;Refresh</a>'), $('<a href="#" class="export_all"><span class="glyphicon glyphicon-share"></span>&nbsp;Export rows</a>')]
      },
      'row-cls': 'col-sm-12'
    }).data('WATable');
    
    $("#useKode").change(function(e) {
      e.preventDefault();
      if (!$(this).is(':checked')) {
        $('#inputKode').removeAttr('disabled').focus();
        $('#inputKode').attr('required', 'required')
      } else {
        $('#inputKode').attr('disabled', 'disabled')
        $('#inputKode').removeAttr('required')
      }
    });
    $("#useKode").prop('checked', 'checked');

    $('#master').on('click', '.edit-btn', function(e) {
      var data = w8.getRow($(this).attr('data-unique'));
      $('#modal-container-edit #inputID').val('').val(data.row.ID)
      $('#modal-container-edit #inputJenis').val(data.row.jenisID)
      var kodeSplit = data.row.Kode.toString().split(" ");
      $('#modal-container-edit #inputKode').val('').val(kodeSplit[2] ?
        kodeSplit[2] :
        data.row.Kode)
      $('#modal-container-edit #inputNama').val('').val(data.row.Nama)
      $('#modal-container-edit #inputKeterangan').val('').val(data.row.Keterangan)
      $('#edit-message').html('');
      
      $('#modal-container-edit').modal('show');
    })

    $('#master').on('click', '.delete-btn', function(e) {
      var deleteButton = $(this);
      var bdialog = bootbox.dialog({
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
                  _alert.html('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><b>Sukses!!!</b> ' + result.message)
                } else {
                  _alert.attr('class', 'alert alert-danger')
                  _alert.html('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><b>Gagal!!</b> ' + result.message)
                }
                $('.alert-container').html(_alert);
                $(el.currentTarget).removeAttr('disabled');
                bdialog.modal('hide');
              });

              return false;
            }
          }
        }

      });
    });

    function ClickHandlerOK(e) {
      e.preventDefault();
    }
  });
});
</script>
<?php
// FOOTER
$CI->load->view('templates/neraca/footer.php');
?>

