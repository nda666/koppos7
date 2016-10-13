<div class="modal fade" id="modal-container-134751" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <form action="<?php echo base_url('/koderekening/insert-action') ?>" method="POST" class="form-horizontal" id="form_kode_rekening" role="form" data-toggle="validator">
          
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          ×
        </button>
        <h4 class="modal-title" id="myModalLabel">
            <i class="fa fa-fw fa-plus"></i>Tambah Kode Rekening Baru
        </h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
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
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="useKode" id="useKode" value="1"> Auto Kode
                </label>

              </div>
              <p class="help-block">Masukkan digit akhir kode rekening. Hilangkan ceklist checkbox untuk mengisi kode secara manual.</p>
            </div>
            <div class="col-sm-10 col-sm-offset-2">
              <input type="text" name="kode" disabled="disabled" class="form-control" id="inputKode" placeholder="Kode Rekening">
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