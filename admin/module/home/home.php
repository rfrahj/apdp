<?php
include ("../inc/koneksi.php"); 
include ("../inc/fungsi_hdt");  ?>
<br/>
<div style="margin-right:10%;margin-left:15%" class="alert alert-success alert-dismissable">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<p><i class="icon fa fa-info"></i>
Welcome <?php echo $_SESSION['nama']; ?>! &nbsp;&nbsp;
Anda berada di halaman "<?php echo $_SESSION['level']; ?>"
</p>
</div> 
<div class="box box-solid box-success">
<div class="box-header">
<i class="fa fa-info"></i>Informasi
</div>

<div class="box-body">
		<div class="row">
			<div class="callout callout-success "  style="margin:20px 20px 20px 20px">
				<h4><?php echo "Hai $_SESSION[nama]"; ?> </h4>
				<p><?php echo "Selamat datang di halaman Administrator Kelurahan Aplikasi Sistem Informasi Kependudukan! "; ?></p>
			</div>							
		<div class="col-lg-3 col-xs-6">
		<div class="small-box bg-aqua">
						<div class="inner">
							<?php $siswa = mysql_num_rows(mysql_query("SELECT * FROM data_warga")); ?>
							<h3><?php echo $siswa; ?></h3>
							<p>Data Warga</p>
						</div>
						<div class="icon">
							<i class="fa fa-graduation-cap"></i>
						</div>
						<a href="?module=warga" class="small-box-footer">Klik disini <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div><!-- ./col -->
				
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-red">
						<div class="inner">
							<?php $kematian = mysql_num_rows(mysql_query("SELECT * FROM kematian")); ?>
							<h3><?php echo $kematian; ?></h3>
							<p>Kematian</p>
						</div>
						<div class="icon">
							<i class="fa fa-institution"></i>
						</div>
						<a href="?module=kematian" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div><!-- ./col -->
				
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-green">
						<div class="inner">
							<?php $pindah = mysql_num_rows(mysql_query("SELECT * FROM pindah")); ?>
							<h3><?php echo $pindah; ?></h3>
							<p>Pindah</p>
						</div>
						<div class="icon">
							<i class="fa fa-street-view"></i>
						</div>
						<a href="?module=pindah" class="small-box-footer">Klik Disini <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div><!-- ./col -->
				
		
		<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-purple">
						<div class="inner">
							<?php $user = mysql_num_rows(mysql_query("SELECT * FROM user")); ?>
							<h3><?php echo $user; ?></h3>
							<p>Pengguna</p>
						</div>
						<div class="icon">
							<i class="fa fa-user-md"></i>
						</div>
						<a href="?module=user" class="small-box-footer">Klik Disini <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div><!-- ./col -->
				
		</div>
		
	



		