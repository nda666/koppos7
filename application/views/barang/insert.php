<!-- Modal -->
<div aria-labelledby="myModalLabel" class="modal fade" id="modal-insert" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="<?php echo base_url('barang/insert') ?>" class="form form-horizontal" id="form-insert" method="POST" role="form">
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
            Tambah Pengguna barang
          </h4>
        </div>
        <div class="modal-body">
          <div id="form-insert-error">
          </div>
          <!-- Input Nama -->
          <div class="form-group">
            <label class="control-label col-md-3" for="inputNama">
              Nama
            </label>
            <div class="col-md-9">
              <input class="form-control" id="inputNama" name="nama" placeholder="Input nama" type="text">
              </input>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3" for="inputKategori">
              Kategori
            </label>
            <div class="col-md-9">
              <select class="form-control" id="inputKategori" name="id_kat_brng">
                <?php if (isset($data_kategori)): ?>
                <?php foreach ($data_kategori as $kategori): ?>
                <option value="<?php echo $kategori->id_kat_brng ?>">
                  <?php echo $kategori->kategori ?>
                </option>
                <?php endforeach;?>
                <?php endif;?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3" for="inputJenis">
              Jenis
            </label>
            <div class="col-md-9">
              <select class="form-control" id="inputJenis" name="id_jenis_brng">
                <?php if (isset($data_jenis)): ?>
                <?php foreach ($data_jenis as $jenis): ?>
                <option value="<?php echo $jenis->id_jenis_brng ?>">
                  <?php echo $jenis->jenis ?>
                </option>
                <?php endforeach;?>
                <?php endif;?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3" for="inputHargaBeli">
              Harga Beli
            </label>
            <div class="col-md-9">
              <input class="form-control" id="inputHargaBeli" name="h_beli" placeholder="Input IP" required="" type="number">
                <p class="help-block">
                  Terbilang: Rp. ,-
                </p>
              </input>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3" for="inputHargaJual">
              Harga Jual
            </label>
            <div class="col-md-9">
              <input class="form-control" id="inputHargaJual" name="h_jual" placeholder="Input IP" required="" type="number">
                <p class="help-block">
                 Terbilang: Rp. ,-
                </p>
              </input>
            </div>
          </div>

          <!-- Input Stok -->
          <div class="form-group">
            <label class="control-label col-md-3 text-left" for="InputStok">
              Stok
            </label>
            <div class="col-md-9">
              <input class="form-control" id="InputStok" name="stok" placeholder="Input Stok" type="number">
              </input>
            </div>
          </div>
          
          <div class="form-group">
            <label for="inputTglExp" class="col-sm-3 control-label">Tanggal Exp</label>
            <div class="col-sm-9">
            <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
              <input type="text" name="tgl_exp" id="inputTglExp" class="form-control" title="Input Tanggal Masuk">
            </div>  
              <p class="help-block">Tanggal Barang Expired.</p>
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