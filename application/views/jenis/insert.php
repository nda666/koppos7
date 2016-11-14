<!-- Modal -->
<div aria-labelledby="myModalLabel" class="modal fade" id="modal-insert" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="<?php echo base_url('jenis/insert') ?>" class="form form-horizontal" id="form-insert" method="POST" role="form">
      <div class="modal-content">
        <div class="modal-header">
          <button aria-label="Close" class="close" data-dismiss="modal" type="button">
            <span aria-hidden="true">
              ×
            </span>
          </button>
          <h4 class="modal-title" id="myModalLabel">
            <i class="fa fa-plus-circle fa-fw">
            </i>
            Tambah Jenis
          </h4>
        </div>
        <div class="modal-body">
          <div id="form-insert-error">
          </div>
          <!-- Input Nama -->
          <div class="form-group">
            <label class="control-label col-md-3" for="inputJenis">
              Nama
            </label>
            <div class="col-md-9">
              <input class="form-control" id="inputJenis" name="jenis" placeholder="Input Jenis" type="text">
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