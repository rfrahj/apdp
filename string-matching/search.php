<?php
$post = strtoupper(@$_SERVER['REQUEST_METHOD'])=="POST";
$q = $post ? $_POST['q'] : $_GET['q'];

include STRING_MATCHING_DIR.'string-matching.lib.php';
include STRING_MATCHING_DIR.'simple_form.php';


if ($q) {

    ?>
    <br>
    <div class="box box-solid box-info">
    <div class="box-body">
    <table class="table table-bordered table-striped">
        <thead>
        <tr class="text-red">
            <th class="col-sm-2">Hasil Pencarian Horspool</th>
        </tr>
        </thead>

        <tbody>
        <?php
        // Tampilkan data dari Database
        $sql = "SELECT * FROM data_warga";
        $no=1;
        $tampil = _query($sql);
        $count = 0;

        while ($tampilkan = _fetch_array($tampil)) {
            $datas[] = $tampilkan;
            $Kode = $tampilkan['id'];
            $nama = $tampilkan['nama'];
            $start = microtime(true);
            $find = process_bmh($q, $nama);
            $end = microtime(true);
            $selisih = $end-$start;
            if ($find !== false) {
                ?>
                <tr>
                    <td><a href="?module=warga&aksi=detail_warga&id=<?php echo $tampilkan['id']; ?>"><?php echo $tampilkan['nama']; ?> (<?=number_format($selisih*1000, 5, ".", ",");?> ms.) </a> </td>
                </tr>

                <?php
                $count++;
            }
        }

        ?>
        </tbody>
    </table>
   
   </div>
    </div>
    <div class="box box-solid box-info">
    <div class="box-body">
    <table class="table table-bordered table-striped">
        <thead>
        <tr class="text-red">
            <th class="col-sm-2">Hasil Pencarian KMP (Knuth Morris Pratt)</th>
        </tr>
        </thead>

        <tbody>
        <?php
        // Tampilkan data dari Database
        $sql = "SELECT * FROM data_warga";
        $no=1;
        $tampil = _query($sql);
        $count = 0;

        while ($tampilkan = _fetch_array($tampil)) {
            $datas[] = $tampilkan;
            $Kode = $tampilkan['id'];
            $nama = $tampilkan['nama'];
            $start = microtime(true);
            $find = process_kmp($q, $nama);
            $end = microtime(true);
            $selisih = $end-$start;
            if ($find !== false) {
                ?>
                <tr>
                    <td><a href="?module=warga&aksi=detail_warga&id=<?php echo $tampilkan['id']; ?>"><?php echo $tampilkan['nama']; ?> (<?=number_format($selisih*1000, 5, ".", ",");?> ms.) </a> </td>
                </tr>
                <?php
                $count++;
            }
        }

//        var_dump(process_kmp());

        ?>
        </tbody>
    </table>

   </div>
    </div>
    <?php

//    echo "Ditemukan $count data. Lama Pencarian $end s";

}