<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Modal -->
<div class="modal fade" id="modal-insert" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
   <form action="<?php echo base_url('anggota/insert') ?>" method="POST" id="form-insert" role="form" class="form form-horizontal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-circle fa-fw"></i>Tambah Anggota</h4>
      </div>
      <div class="modal-body">
        
            <div id="form-insert-error"></div>
        
      		<!-- Masukkan Nippos -->
        	<div class="form-group">
        		<label for="inputNippos" class="control-label col-md-3">NIPPOS</label>
        		<div class="col-md-9">
        			<input type="text"  required class="form-control" id="inputNippos" name="nippos" placeholder="Masukkan NIPPOS">
        		</div>
        	</div>

        	<!-- Masukkan Nama -->
        	<div class="form-group">
        		<label for="inputNama" class="control-label col-md-3">Nama</label>
        		<div class="col-md-9">
        			<input required type="text" class="form-control" id="inputNama" name="nama" placeholder="Masukkan Nama">
        		</div>
        	</div>

        	<!-- Masukkan Status MAC -->
        	<div class="form-group">
        		<label for="inputStatus" class="control-label col-md-3">Status</label>
        		<div class="col-md-9">
                    <select class="form-control" name="status" id="inputStatus" placeholder="Masukkan Status">
                        <option value="Karyawan PT.POS Indonesia">Karyawan PT.POS Indonesia</option>
                        <option value="Karyawan Koppos7">Karyawan Koppos7</option>
                        <option value="Angkutan">Angkutan</option>
                        <option value="CS">CS</option>
                        <option value="Satpam">Satpam</option>
                        <option value="Sopit">Sopit</option>
                    </select>
        			
        		</div>
            </div>
            <div class="form-group">
        		<label for="InputTempat" class="control-label col-md-3 text-left">Tempat, Tgl Lahir</label>
        		
                    <div class="col-md-9">
                        <div class="input-group">
    				    <input type="text" class="form-control" id="InputTempat" name="mac" placeholder="Masukkan Tempat Lahir">
                        <span class="input-group-addon"><i class="fa fa-calendar-check-o"></i></span>
    				    <input type="text" class="form-control pickadate" id="inputTglLahir" name="mac" placeholder="Masukkan Tanggal Lahir">
    				</div>
                        
                    </div>
                    
        		
        	</div>

        	<!-- Masukkan TGL daftar/exp -->
        	<div class="form-group">
        		<label for="inputTglDaftar" class="control-label col-md-3">Gender</label>
        		<div class="col-md-9">
                    <select class="form-control" name="jenis_kelamin" id="inputJenisKelamin">
                        <option value="Pria">Pria</option>
                        <option value="Wanita">Wanita</option>
                    </select>
                </div>
        		
        	</div>

        	<!-- Masukkan Alamat -->
        	<div class="form-group">
        		<label for="inputAlamat" class="control-label col-md-3">Alamat</label>  
        		<div class="col-md-9">
        			<textarea name="alamat" rows="3" style="max-width:100%;" placeholder="Masukkan Alamat" id="inputAlamat" class="form-control"></textarea>
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