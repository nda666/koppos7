
<div class="modal fade" role="dialog" id="modal-export" aria-labelledby="modal-export">
	<div class="modal-dialog">
		<div class="modal-content">
	<form id="form-export" action="<?php echo base_url('hotspot/export') ?>" class="form-horizontal" method="GET" role="form">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-exchange"></i> Export</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="inputStartDate" class="col-sm-2 control-label">Tanggal</label>
					<div class="col-sm-10">
						<div class="input-group input-daterange">
				    <input type="text" class="form-control date-start" required id="inputTglDaftar" name="date-start" value="<?php echo date('Y-m-d') ?>">
				    <?php $expDate = strtotime("+1 day");?>
				    <span class="input-group-addon"><i class="fa fa-calendar-check-o"></i></span>
				    <input type="text" class="form-control date-end" id="inputTglExp" required name="date-end" value="<?php echo date('Y-m-d', $expDate); ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="Submit" class="btn btn-primary">Export</button>
			</div>
		</form>
		</div>

	</div>
</div>