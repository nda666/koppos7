<!-- Modal -->
<div class="modal fade" id="modal-edit" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
   <form action="<?php echo base_url('hotspot/edit') ?>" data-id="" method="POST" id="form-edit" role="form" class="form form-horizontal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-circle fa-fw"></i>Tambah Data Pengguna Hotspot</h4>
      </div>
      <div class="modal-body">
      		<!-- Input Nama -->
        	<div class="form-group">
        		<label for="inputNama" class="control-label col-md-3">Nama</label>
        		<div class="col-md-9">
        			<input type="text" class="form-control" id="inputNama" name="nama" placeholder="Input nama">
        		</div>
        	</div>

        	<!-- Input Bagian -->
        	<div class="form-group">
        		<label for="inputBagian" class="control-label col-md-3">Bagian</label>
        		<div class="col-md-9">
        			<input type="text" class="form-control" id="inputBagian" name="bagian" placeholder="Input bagian">
        		</div>
        	</div>

        	<!-- Input IP MAC -->
        	<div class="form-group">
        		<label for="inputIP" class="control-label col-md-3">IP</label>
        		<div class="col-md-9">
        			<input type="text" class="form-control" id="inputIP" name="ip" placeholder="Input IP">
        		</div>
            </div>
            <div class="form-group">
        		<label for="InputMAC" class="control-label col-md-3 text-left">MAC</label>
        		<div class="col-md-9">
        			<input type="text" class="form-control" id="InputMAC" name="mac" placeholder="Input MAC">
        		</div>
        	</div>

        	<!-- Input TGL daftar/exp -->
        	<div class="form-group">
        		<label for="inputTglDaftar" class="control-label col-md-3">Tgl. Dftr</label>
        		<div class="col-md-9">
        			<div class="input-group input-daterange">
				    <input type="text" class="form-control date-start" required id="inputTglDaftar" name="tgl_daftar" value="<?php echo date('Y-m-d') ?>">
                    <?php $expDate = strtotime("+1 day");?>
                    <span class="input-group-addon"><i class="fa fa-calendar-check-o"></i></span>
                    <input type="text" class="form-control date-end" id="inputTglExp" required name="tgl_exp" value="<?php echo date('Y-m-d', $expDate); ?>">
				</div>
        		</div>
        		
        	</div>

        	<!-- Input Biaya -->
        	<div class="form-group">
        		<label for="inputBiaya" class="control-label col-md-3">Biaya</label>
        		<div class="col-md-9">
        			<input type="text" class="form-control" id="inputBiaya" name="biaya" placeholder="Input biaya.">
        		</div>
        	</div>

            <!-- Input Biaya -->
            <div class="form-group">
                <label for="inputActive" class="control-label col-md-3">Active?</label>
                <div class="col-md-9">
                    <select name="active" id="inputActive" class="form-control" required="required">
                        <option value="1">Iya</option>
                        <option value="0">Tidak</option>
                    </select>
                </div>
            </div>

        	<!-- End Modal Body -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
       <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </div>
    </form>
  </div>
</div>