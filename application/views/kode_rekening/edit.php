<div class="modal fade" id="modal-container-edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <form action="<?php echo base_url('/koderekening/edit-action') ?>" method="POST" class="form-horizontal" id="edit_kode_rekening" role="form" data-toggle="validator">
          
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          ×
        </button>
        <h4 class="modal-title" id="myModalLabel">
            <i class="fa fa-fw fa-plus"></i>Ubah Data Kode Rekening
        </h4>
      </div>
      <div class="modal-body">
          <div id="edit-message"></div>
          <div class="form-group">
              <input type="hidden" name="id" id="inputID" value="">
            <label for="inputKode" class="col-sm-2 control-label">Jenis</label>
            <div class="col-sm-10">
              <div class="col-sm-12 input-group">
                <select name="jenis_id" required="required" id="inputJenis" class="form-control">
                  <?php foreach ($jenisRekening as $j): ?>
                  <option data-kode="<?php echo $j->kode ?>" value="<?=$j->id?>">
                    <?=$j->jenis?>
                  </option>
                  <?php endforeach?>
                </select>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              </div>
              <div class="help-block with-errors"></div>
            </div>
          </div>

          <div class="form-group">
            <label for="inputKode" class="col-sm-2 control-label">Kode</label>
            <div class="col-sm-10">
              <input type="text" name="kode" required="required" class="form-control" id="inputKode" placeholder="Kode Rekening">
              <div class="help-block">Masukkan digit akhir kode rekening</div>
              <div class="help-block with-errors"></div>
            </div>
          </div>

          <div class="form-group has-feedback">
            <label for="inputNama" class="col-sm-2 control-label">Nama</label>
            <div class="col-sm-10">
              <div class="col-sm-12 input-group">
                <input type="text" class="form-control" name="nama" id="inputNama" maxlength="50" minlength="3" required="required" placeholder="Nama Rekening">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              </div>
              <div class="help-block with-errors"></div>
            </div>
          </div>

          <div class="form-group">
            <label for="inputKeterangan" class="col-sm-2 control-label">Keterangan</label>
            <div class="col-sm-10">
              <textarea class="form-control" placeholder="Keterangan Rekening" name="keterangan" id="inputKeterangan"></textarea>
            </div>
          </div>


        
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">
          Close
        </button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
    </form>
  </div>

</div>