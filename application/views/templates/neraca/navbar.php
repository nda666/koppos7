
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
</head>
<?php $pTitle = ""; ?>
<?php if (isset($page_title)): ?>
	<?php $pTitle = $page_title; ?>
<?php endif ?>
	<body id="master">
		<div class="master-container">

		<nav id="navbar" class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-item">
						<i class="fa fa-ellipsis-h fa-lg"></i>
					</button>
					
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="navbar-item">
					<ul class="nav navbar-nav">

						<li><button class="btn sidebar-toggler" href="#sidebar" data-toggle="sidebar-toggle"><i class="fa fa-bars"></i></button></li>
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
			<div class="sidebar-header">
				<a class="navbar-brand" href="#">
					<div class="brand-icon">
						<i class="fa fa-balance-scale"></i>
					</div>
					<div class="brand-title">
					KOPPOS 7
					<p><?php echo isset($page_title) ? $page_title : 'Home'; ?></p>
					</div>
				</a>
				<div class="sidebar-avatar">
					<img src="https://scontent-sit4-1.xx.fbcdn.net/v/t1.0-1/c0.25.160.160/p160x160/14522947_537150593146176_5188286047847968747_n.jpg?oh=d467ed5b5483a9d94edd223aed2930b0&oe=588D85A9" class="img img-circle" alt="" />
					<div class="user-info">
						<span>
							Wellcome,
						</span>
						 <h2><?php echo 'Adha Bakhtiar' ?></h2>
					</div>
				</div>
				
			</div>
				
    	<div class="sidebar-main">
      <ul class="nav navbar-nav">
        <li><a href="<?php echo base_url() ?>"><span style="font-size:16px;" class="pull-right showopacity glyphicon glyphicon-home"></span>Home</a></li>
        <li <?php echo ($pTitle == 'Transaksi') ? 'class="active"' : ''; ?>><a href="<?php echo base_url('transaksi') ?>"><i class="pull-right showopacity fa fa-shopping-cart"></i>Transaksi</a></li>
				<li <?php echo ($pTitle == 'Anggota') ? 'class="active"' : ''; ?>>
					<a href="<?php echo base_url('anggota') ?>" data-toggle="tooltip" data-placement="right" title="Management Anggota"><i class="pull-right showopacity fa fa-users"></i>Anggota</a>
				</li>        
				<li class="dropdown <?php echo ($pTitle == 'Kategori Barang'||$pTitle == 'Barang' || $pTitle == 'Jenis Barang') ? 'open' : ''; ?>">
          <a href="#barang" class="dropdown-toggle" data-toggle="dropdown-sidebar"><i style="font-size:16px;" class="pull-right showopacity fa fa-archive"></i>Barang<span class="caret"></span></a>
          <ul class="dropdown-menu forAnimate" role="menu">
            <li <?php echo ($pTitle == 'Barang') ? 'class="active"' : ''; ?>><a href="<?php echo base_url('barang') ?>" data-toggle="tooltip" data-placement="right"  title="Management Barang Poserba">Management</a></li>
            <li <?php echo ($pTitle == 'Kategori Barang') ? 'class="active"' : ''; ?>><a href="<?php echo base_url('kategori') ?>">Kategori</a></li>
            <li <?php echo ($pTitle == 'Jenis Barang') ? 'class="active"' : ''; ?>><a href="<?php echo base_url('jenis') ?>">Jenis</a></li>
          </ul>
        </li>

        <li <?php echo ($pTitle == 'Hotspot') ? 'class="active"' : ''; ?>>
			<a href="<?php echo base_url('hotspot') ?>" data-toggle="tooltip" data-placement="right"  title="Management Hotspot"><i class="pull-right showopacity fa fa-wifi"></i>Hotspot</a>
		</li>        
      </ul>
      </div>
	  <div class="clearfix"></div>
	  <div class="sidebar-footer">
		<ul class="nav">
			<li>
				<a href="#"> <i class="fa fa-user fa-fw"></i></a>
			</li>
			<li>
				<a href="#"> <i class="fa fa-wrench fa-fw"></i></a>
			</li>
			<li>
				<a href="#"> <i class="fa fa-user fa-fw"></i></a>
			</li>
			<li>
				<a href="#"> <i class="fa fa-power-off fa-fw"></i></a>
			</li>
		</ul>
	  </div>
  </div>
		</nav>
		<div class="content-main">
			