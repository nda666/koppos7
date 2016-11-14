<?php $CI = &get_instance();
$CI->load->view('templates/neraca/header.php');?>
<style>
  .datepicker {
      z-index: 1051 !important;
      /* has to be larger than 1050 */
    }
</style>
<?php $CI->load->view('templates/neraca/navbar.php');?>
<h3 class="col-md-12">
  <i class="fa fa-shopping-cart">
  </i>
  Transaksi
</h3>
<ol class="breadcrumb text-right">
  <li>
    <a data-toggle="modal" href="<?php echo base_url() ?>" role="button">
      <i class="fa fa-home fa-fw">
      </i>
      Home
    </a>
  </li>
  <li class="active">
    <i class="fa fa-shopping-cart">
    </i>
    transaksi
  </li>
</ol>
<div class="col-md-5 col-lg-5">
  <div class="well">
    <h3 class="devided">
      <i class="fa fa-wpforms fa-fw">
      </i>
      Form Transaksi
    </h3>
    <span class="help-block">
      Masukkan transaksi di form ini. List akan tampil pada tabel.
    </span>
    <form action="<?php echo base_url('transaksi/insert') ?>" id="form_transaksi" method="POST" role="form">
      <div class="form-group">
        <input name="id_penjualan" type="hidden" value="<?php echo $CI->session->userdata('id_penjualan') ?>">
          <label for="list_kategori_dropdown">
            Kategori
          </label>
          <select class="form-control" data-ajax="<?php echo base_url('transaksi/kategori-json') ?>" id="list_kategori_dropdown">
          </select>
        </input>
      </div>
      <div class="form-group">
        <label for="list_jenis_dropdown">
          Jenis
        </label>
        <select class="form-control" data-ajax="<?php echo base_url('transaksi/jenis-json') ?>" id="list_jenis_dropdown">
        </select>
      </div>
      <div class="form-group">
        <label for="list_brng_dropdown">
          Pilih Barang
        </label>
        <select class="form-control" data-ajax="<?php echo base_url('transaksi/data-json') ?>" id="list_brng_dropdown" name="id_brng" required="required">
        </select>
      </div>
      <div class="form-group">
        <label for="list_brng_dropdown">
          Qty
        </label>
        <input class="form-control" min="1" value="1" name="qty" placeholder="Quantity" required="required" type="text">
        </input>
      </div>
      <div class="form-group">
        <button class="btn btn-primary btn-block" type="submit">
          <i class="fa fa-arrow-right">
          </i>
          Insert
        </button>
      </div>
    </form>
  </div>
</div>
<div class="col-md-7 col-lg-7">
  <div class="well">
    <h3 class="devided">
      <i class="fa fa-shopping-basket fa-fw">
      </i>
      List Transaksi
    </h3>
    <table class="table table-condensed table-middle" data-filter-control="false" data-filter-show-clear="true" data-pagination="false" data-pagination-loop="false" data-penjualan="<?php echo $CI->session->userdata('id_penjualan') ?>" data-remote="<?=base_url('transaksi/transaksi-json')?>" data-search="false" data-show-columns="false" data-show-refresh="true" data-t="" data-unique-id="id_troli" data-update="<?=base_url('transaksi/update')?>" id="transaksi-grid" oolbar="#toolbar">
      <thead>
        <tr>
          <th data-field="id_brng" data-sortable="false">
            ID
          </th>
          <th data-field="nama" data-sortable="false">
            Nama
          </th>
          <th data-field="h_jual" data-sortable="false">
            Harga
          </th>
          <th data-field="qty" data-formatter="qtyFormatter" data-sortable="false">
            Qty
          </th>
          <th data-field="subtotal" data-formatter="subtotalFormatter" data-sortable="false">
            Sub Total
          </th>
        </tr>
      </thead>
      <tbody>
      </tbody>
      <tfoot>
        <tr>
          <th class="text-right" colspan="4">
            Total:
          </th>
          <th id="total">
          </th>
        </tr>
      </tfoot>
    </table>
    
  <hr>
  <div class="form-horizontal">
    <div class="form-group">
      <label class="col-sm-2 control-label" for="inputBayar">
        Bayar:
      </label>
      <div class="col-sm-5">
        <input class="form-control" id="inputBayar" name="" type="text">
        </input>
      </div>
       <div class="col-sm-5">
        <p class="help-block">-</p>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label" for="inputKembali">
        Kembali:
      </label>
      <div class="col-sm-5">
        <input class="form-control" readonly="readonly" id="inputKembali" name="" type="text">
        </input>
      </div>
      <div class="col-sm-5">
        <p class="help-block">-</p>
      </div>
    </div>
  </div>  
    <div class="clearfix"></div>

    <div style="margin: 20px 0px 40px 0px;">
      <button class="btn btn-success btn-block" role="button" type="button">
        <i class="fa fa-send fa-fw">
        </i>
        Submit
      </button>
    </div>
  </div>
</div>
<div class="clearfix">

</div>
<?php $CI->load->view('templates/neraca/fscript');?>
<script type="text/javascript">
  function subtotalFormatter(val, row) {
    return row.h_jual * row.qty;
  }
  function qtyFormatter(val, row){
    return '<input type="number" value="'+ row.qty +'" class="form-control" data-penjualan="'+ row.id_penjualan +'" data-barang="'+ row.id_brng +'" min="1">';
  }
  requirejs(['jquery', 'bootstrap', 'validator', 'bootbox','toastr', 'select2', 'pickadate', 'pickadate-date', 'bootstrapTable', 'bootstrapTableFC'], function($, bs, bsval, bootbox, toastr) {
  $(document).ready(function() {
    var $total = 0;
    $('#inputBayar').keyup(function(event) {
      var $val = $(this).val();
      $(this).parents('.form-group').find('.help-block').text('#' + Number($val).toLocaleString());
      $('#inputKembali').val($(this).val() - $total);
      $('#inputKembali').trigger('change');
    });
    $('#inputKembali').on('change',function(event) {
      var $val = $(this).val();
      $(this).parents('.form-group').find('.help-block').text('#' + Number($val).toLocaleString());
    });
    $('#form_transaksi').submit(function(e){
      e.preventDefault();
      var formData = $(this).serialize(),
      ele = $(this);
      ele.find('[type="submit"]').attr('disabled','disabled');
      var $div = $('<div></div>');
      $.ajax({
        url: ele.attr('action'),
        type: ele.attr('method'),
        dataType: 'json',
        data: formData,
      })
      .done(function(res) {

        if (res.res){
          $div.addClass('alert alert-success').append('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>');
          toastr.success(res.message, 'Sukses!')
         // $.notify(res.message, 'success');
        } else {
          $div.addClass('alert alert-warning').append('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>');
          if (typeof res.message == 'array' || typeof res.message == 'object'){
            $div.append('<ul></ul>');
            $.each(res.message, function(index, val) {
               $div.find('ul').append('<li>' + val + '</li>');
            });
            toastr.warning($div.html(), 'Gagal!')
          } else {
            toastr.warning(res.message, 'Gagal!');
          }
        }

      })
      .fail(function(res) {
        toastr.error(res.statusText, 'Error '+ res.status);
      })
      .always(function() {
       ele.find('[type="submit"]').removeAttr('disabled');
      });

    });

    function update_keranjang(e){
      var $url = $('#transaksi-grid').attr('data-update'),
              ele = $('#transaksi-grid');
              var formData = {
                'id_brng': e.attr('data-barang'),
                'qty': e.val(),
                'id_penjualan': e.attr('data-penjualan')
              };
              $.post($url, formData, function(res) {
                if (!res.res){
                  toastr.error(res.message);
                }
              })
              .fail(function(res) {
                toastr.error(res.statusText, 'Error '+ res.status);
              })
              .done(function(){
                 $(ele).removeAttr('disabled');
                 $($table).bootstrapTable('refresh');
              });
    }
    var $table = $('#transaksi-grid').bootstrapTable({
        url: $('#transaksi-grid').attr('data-remote') + '/' + $('#transaksi-grid').attr('data-penjualan') ,
        onLoadSuccess: function(data){
          
          $.each(data,function(index, el) {
              $total += el.h_jual * el.qty;
          });

          $($table).find('#total').html(Number($total.toFixed(1)).toLocaleString())
        },
        onPostBody: function(data) {
          // when data success loaded

          $('#transaksi-grid input').on('change', function(e){
            var ele = $(this);
            window.clearTimeout("timeout");
            $(this).data("timeout", setTimeout(function () {
                $(this).prop('disabled', 'disabled');
                update_keranjang(ele);
            }, 2000));


          });
        }
      });


    // select2 Barang
    $("#list_brng_dropdown").select2({
      theme: "bootstrap",
      width: "100%",
      tags: false,
      ajax: {
        url: $("#list_brng_dropdown").attr('data-ajax'),
        dataType: 'json',
        delay: 1000,
        data: function(term) {
          return {
            find: term.term,
            kat: $("#list_brng_dropdown").attr('data-kategori'),
            jenis: $("#list_brng_dropdown").attr('data-transaksi')
          };
        },
        processResults: function(data) {
          return {
            results: $.map(data, function(item) {
              return {
                text: item.text,
                id: item.id_brng
              }
            })
          };
        }
      },
    });

    $("#list_brng_dropdown").on("select2:select", function (e) { 
      $('input[name="qty"]').val('1');
    });

    // select2 Kategori
    $("#list_kategori_dropdown").select2({
      theme: "bootstrap",
      placeholder:"Kategori Barang (Opsional)",
       allowClear: true,
      width: "100%",
      tags: false,
      ajax: {
        url: $("#list_kategori_dropdown").attr('data-ajax'),
        dataType: 'json',
        delay: 1000,
        data: function(term, q) {
          return {

            find: term.term
          };
        },
        processResults: function(data) {
          return {
            results: $.map(data, function(item) {
              return {
                text: item.text,
                id: item.id_kat_brng
              }
            })
          };
        }
      },
    });
    $("#list_kategori_dropdown").on('change', function(){
      $("#list_brng_dropdown").attr('data-kategori',$(this).val());
      $("#list_brng_dropdown option[value]").remove();
    });

    // select2 transaksi
    $("#list_jenis_dropdown").select2({
      theme: "bootstrap",
      minimumResultsForSearch: Infinity,
      placeholder:"Jenis Barang (Opsional)",
       allowClear: true,
      width: "100%",
      tags: false,
      ajax: {
        url: $("#list_jenis_dropdown").attr('data-ajax'),
        dataType: 'json',
        delay: 1000,
        data: function(term, q) {
          return {
            find: term.term
          };
        },
        processResults: function(data) {
          return {
            results: $.map(data, function(item) {
              return {
                text: item.text,
                id: item.id_jenis_brng
              }
            })
          };
        }
      },
    });
    $("#list_jenis_dropdown").on('change', function(){
      $("#list_brng_dropdown").attr('data-transaksi',$(this).val());
      $("#list_brng_dropdown option[value]").remove();
    });


  });
});
</script>
<?php $CI->
    load->view('templates/neraca/footer.php');?>
