
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
</head>
	<body id="master">
		<div class="master-container">

		<nav id="navbar" class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button class="sidebar-toggle" data-toggle="sidebar" data-target="#sidebar"><i class="fa fa-bars fa-lg"></i></button>
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-item">
						<i class="fa fa-ellipsis-h fa-lg"></i>
					</button>
					<a class="navbar-brand active" href="#">
						<div class="brand-icon">
							<i class="fa fa-balance-scale"></i>
						</div>
						<div class="brand-title">
						KOPPOS 7
						<p><?php echo isset($page_title) ? $page_title : 'Home'; ?></p>
						</div>
					</a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="navbar-item">
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Kode Rekening <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?= base_url('koderekening'); ?>"><i class="fa fa-eye fa-fw"></i> Lihat</a></li>
								<li><a href="<?= base_url('koderekening/insert'); ?>"><i class="fa fa-pencil fa-fw"></i> Tambah/Ubah</a></li>
								
							</ul>
						</li>
					</ul>
					
					<ul class="nav navbar-nav navbar-right">
						<li><a href="#" class="red">Log Out</a></li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div>
		</nav>

		<div class="content-container">
		<nav class="sidebar" id="sidebar">
			<div class="container-fluid sidebar-content sidebar-default">
    	<div class="sidebar-main">
      <ul class="nav navbar-nav">
        <li class="active"><a href="<?php echo base_url() ?>">Home<span style="font-size:16px;" class="pull-right showopacity glyphicon glyphicon-home"></span></a></li>
				<li >
					<a href="<?php echo base_url('anggota') ?>" data-toggle="tooltip" data-placement="right" title="Management Anggota">Anggota<i class="pull-right showopacity fa fa-users"></i></a>
				</li>        
        
				<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pinjaman <span class="caret"></span><i style="font-size:16px;" class="pull-right showopacity fa fa-money"></i></a>
          <ul class="dropdown-menu forAnimate" role="menu">
            <li><a href="{{URL::to('createusuario')}}"><i class="fa fa-plus-circle"></i> Crear</a></li>
            <li><a href="#"><i class="fa fa-plus-circle"></i> Modificar</a></li>
            <li><a href="#"><i class="fa fa-plus-circle"></i> Reportar</a></li>
            <li><a href="#"><i class="fa fa-plus-circle"></i> Informes</a></li>
          </ul>
        </li>     
        <li ><a href="<?php echo base_url('hotspot') ?>" data-toggle="tooltip" data-placement="right"  title="Management Hotspot">Hotspot<i class="pull-right showopacity fa fa-wifi"></i></a></li>        
        <li ><a href="#">Tags<span class="pull-right showopacity glyphicon glyphicon-tags"></span></a></li>

      </ul>
      </div>
  </div>
		</nav>
		<div class="content-main">
			