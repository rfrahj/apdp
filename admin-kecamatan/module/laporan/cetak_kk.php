<?php 
include "head.php";
?>
          <section class="content-header">
            <h1>
             Laporan
              <small>Data Kepala Keluarga Kecamatan Tawang Kota Tasikmalaya</small>
            </h1>
            <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-dashboard"></i> Laporan</a></li>
              <li class="active">Data Kepala Keluarga Kecamatan Tawang Kota Tasikmalaya</li>
            </ol>
          </section>

           
        <section class="content">
            <div class="text-center">
			<h3><img src="inc/tasik.png"/></h3>
			<b>Jl. Siliwangi No.72 <br/>
			Tasikmalaya, Jawa Barat, Indonesia</b>
			</div><br/>
             
            <div class="box box-default">
              <div class="box-header with-border">
                <h3 class="box-title center">Data Kepala Keluarga</h3>
				<span class="pull-right">
				Tasikmalaya, <?php echo Indonesia2Tgl(date('Y-m-d'));?> 
				</span>					
              </div>
              <div class="box-body">
<table class="table table-bordered table-striped">
<thead>
	<tr class="text-red">
		<th class="col-sm-1">NO</th>	
		<th class="col-sm-1">NO KK</th>	
		<th class="col-sm-1">NIK</th>
        <th class="col-sm-2">NAMA</th>
		<th class="col-sm-1">JENIS KELAMIN</th>
		<th class="col-sm-1">AGAMA</th>
		<th class="col-sm-1">PEKERJAAN</th>
		<th class="col-sm-1">STATUS KELUARGA</th>
		<th class="col-sm-2">ALAMAT</th>
		<th class="col-sm-1">DESA</th>
		<th class="col-sm-1">RT</th>
		<th class="col-sm-1">RW</th>
	</tr>
</thead>

<tbody>
<?php 
// Tampilkan data dari Database
$desaId = buildQueryDesaId(NULL, "dw");
$sql =  "SELECT dw.*, p.nama_pendidikan, pk.nama_pekerjaan, a.nama_agama, dd.name as nama_desa FROM data_warga dw
  left join daerah_desa dd on dd.id=dw.desa_id
  left join pendidikan p on p.id_pendidikan=dw.pendidikan  
  left join pekerjaan pk on pk.id_pekerjaan=dw.pekerjaan  
  left join agama a on a.id_agama=dw.agama 
  where dw.status_keluarga='Kepala Keluarga' and $desaId
  ";
$tampil = _query($sql);
$no=1;
while ($data = _fetch_array($tampil)) { ?>

	<tr>
	<td><?php echo $no++; ?></td>
	<td><?php echo $data['no_kk']; ?></td>
	<td><?php echo $data['nik']; ?></td>
	<td> <?php echo $data['nama']; ?></td>
	<td> <?php echo $data['jk']; ?></td>
	<td> <?php echo $data['nama_agama']; ?></td>
	<td> <?php echo $data['nama_pekerjaan']; ?></td>
	<td> <?php echo $data['status_keluarga']; ?></td>
	<td> <?php echo $data['alamat']; ?></td>
	<td> <?php echo $data['nama_desa']; ?></td>
	<td> <?php echo $data['rt']; ?></td>
	<td> <?php echo $data['rw']; ?></td>
	
<?php
}
?>
	</tr>
			</tbody>
		</table>	
              </div><!-- /.box-body -->
            </div>
          </section><!-- /.content -->

        <?php

        $desas = getMultipleDesa();
        $selected_desa = @$_SESSION['selected_desa'];
        if ($selected_desa) {
            $desas = array_values(array_filter($desas, function ($desa) use($selected_desa) {
                return $desa['id'] == $selected_desa;
            }));
        }
        $only_one = count($desas) == 1;
        $have_desa = count($desas) > 0;

        if ($only_one) {
            $is_desa = 1;
            $desa = $desas[0];
            $profile = getProfileDesa($desa['id']);
        } else {
            $is_desa = 0;
            $desa = $desas[0];
            $profile = getProfileKecamatan(substr($desa['id'], 0, 7));
        }


        if ($only_one) {
            echo sprintf(
                "Lurah Desa %s Kecamatan %s %s",
                ucwords(strtolower($desa['nama_desa'])),
                ucwords(strtolower($desa['nama_kecamatan'])),
                ucwords(strtolower($desa['nama_kabupaten']))
            );
            echo sprintf("<br/><br/><br/><span class='pejabat'>%s</span><br/><br/>", $profile['nama_lurah']);
        } else {
            echo sprintf(
                "Camat Kecamatan %s %s",
                ucwords(strtolower($desa['nama_kecamatan'])),
                ucwords(strtolower($desa['nama_kabupaten']))
            );
            echo sprintf("<br/><br/><br/><span class='pejabat'>%s</span><br/><br/>", $profile['nama_camat']);
        }

        ?>
		  
<?php
include "tail.php";
?>
