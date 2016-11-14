<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Modal -->
<div class="modal fade" id="modal-edit" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
   <form action="<?php echo base_url('kategori/edit') ?>" method="POST" id="form-edit" role="form" class="form form-horizontal">
       <div class="modal-content">
         <div class="modal-header">
           <button aria-label="Close" class="close" data-dismiss="modal" type="button">
             <span aria-hidden="true">
               ×
             </span>
           </button>
           <h4 class="modal-title" id="myModalLabel">
             <i class="fa fa-edit fa-fw">
             </i>
             Ubah Kategori
           </h4>
         </div>
         <div class="modal-body">
           <div id="form-insert-error">
           </div>
           <input type="hidden" name="id_kat_brng">
           <!-- Input Nama -->
           <div class="form-group">
             <label class="control-label col-md-3" for="inputNama">
               Nama
             </label>
             <div class="col-md-9">
               <input class="form-control" id="inputNama" name="kategori" placeholder="Input Kategori" type="text">
               </input>
             </div>
           </div>
           
           <!-- End Modal Body -->
         </div>
         <div class="modal-footer">
           <button class="btn btn-default" data-dismiss="modal" type="button">
             Keluar
           </button>
           <button class="btn btn-primary" type="submit">
             Simpan
           </button>
         </div>
       </div>
    </form>
  </div>
</div>