<?php

$find = smartRouting('pdf', 'filter_data');

if ($find !== 1) {
    ?>
    <script src="<?=BASE_URL."/highcharts/code/highcharts.js";?>"></script>
    <script src="<?=BASE_URL."/highcharts/code/modules/exporting.js";?>"></script>
    <script src="<?=BASE_URL."/highcharts/code/modules/export-data.js";?>"></script>

    <div class="box box-solid box-success">
        <div class="box-header">
            <h3 class=" box-title">
                Cetak Laporan Berdasarkan Pendidikan Terakhir
            </h3>

            <a class="btn btn-default pull-right" href="<?=GENERAL_MODULE_URL.'cetak_lkbpd/pdf.php';?>">
                <i class="fa fa-print"></i> Cetak
            </a>
            <div class="pull-right" style="max-width: 100px">
                <form action="<?=moduleUrlByLevel('cetak/lkbpd', 'aksi=filter_data');?>" method="post">
                    <select name="selected_desa" id="" class="form-control" onchange="changeSelected(event, this)">
                        <?php
                        echo sprintf('<option value="%s" %s>%s</option>', '', 'selected="selected"', '--Pilih Salah Satu--');
                        $selected_desa = @$_SESSION['selected_desa'];
                        $desas = getMultipleDesa();
                        foreach ($desas as $desa) {
                            $desaId = $desa['id'];
                            $name = $desa['nama_desa'];
                            $selected = $selected_desa == $desaId ? 'selected="selected"' : '';
                            echo sprintf('<option value="%s" %s>%s</option>', $desaId, $selected, $name);
                        }
                        ?>
                    </select>
                </form>
                <script>
                    function changeSelected(event, element) {
                        event.preventDefault();
                        var currentElement = $(element);
                        $("form").has(currentElement).submit();
                    }
                </script>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-5">
                    <div id="statistik-pendidikan-terakhir" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                    <script type="text/javascript">
                        $(function () {

                            Highcharts.chart('statistik-pendidikan-terakhir', {
                                chart: {
                                    plotBackgroundColor: null,
                                    plotBorderWidth: 1,//null,
                                    plotShadow: false,
                                },
                                title: {
                                    text: 'Grafik Pendidikan Terakhir'
                                },
                                plotOptions: {
                                    pie: {
                                        dataLabels: {
                                            enabled: true,
                                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',

                                        }

                                    }
                                },
                                series: [{
                                    type: 'pie',
                                    name: 'Data Pendidikan Terakhir ',
                                    data: [
                                        <?php
                                        $desaIds = getMultipleDesaId();
                                        $selected_desa = @$_SESSION['selected_desa'];
                                        if ($selected_desa) $desaIds = array($selected_desa);
                                        if (empty($desaIds)) $desaIds = array("false");
                                        $sql = "SELECT pendidikan, jumlah from statistik_data_pendidikan WHERE desa_id IN ('".implode("','", $desaIds)."') group by pendidikan";
                                        $datas = _fetchMultipleFromSql($sql);
                                        foreach($datas as $data)
                                        { ?>
                                        ['<?php echo $data['pendidikan']?>',   <?php echo $data['jumlah']?>],
                                        <?php
                                        }//end while
                                        ?>
                                    ]
                                }]
                            });
                        });
                    </script>
                </div>
                <div class="col-md-7">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr class="text-red">
                            <th class="col-sm-4">NO</th>
                            <th class="col-sm-4">Pendidikan Terakhir</th>
                            <th class="col-sm-4">Laki-laki</th>
                            <th class="col-sm-4">Perempuan</th>
                            <th class="col-sm-4">Jumlah</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        // Tampilkan data dari Database
                        $desaIds = getMultipleDesaId();
                        $selected_desa = @$_SESSION['selected_desa'];
                        if ($selected_desa) $desaIds = array($selected_desa);
                        if (empty($desaIds)) $desaIds = array("false");
                        $sql = "SELECT pendidikan, laki_laki, perempuan, jumlah from statistik_data_pendidikan WHERE desa_id IN ('".implode("','", $desaIds)."') group by pendidikan";
                        $datas = _fetchMultipleFromSql($sql);
                        $no=1;
                        foreach($datas as $data) { ?>

                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $data['pendidikan']; ?></td>
                            <td><?php echo $data['laki_laki']; ?> org</td>
                            <td><?php echo $data['perempuan']; ?> org</td>
                            <td><?php echo $data['jumlah']; ?> org</td>
                            <?php
                            }
                            ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div><!-- /.box-body -->
    </div>
    <?php
}