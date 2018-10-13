<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 10/11/18
 * Time: 7:30 PM
 */

?>
<style>
    #container {
        min-width: 310px;
        /*max-width: 800px;*/
        height: 400px;
        margin: 0 auto;
    }
</style>
<script src="<?=BASE_URL."/highcharts.js";?>"></script>
<script src="<?=BASE_URL."/modules/series-label.js";?>"></script>
<script src="<?=BASE_URL."/modules/exporting.js";?>"></script>
<script src="<?=BASE_URL."/modules/export-data.js";?>"></script>

<div class="text-center">
    <?php
    $current_selected_year = GetSetVar('current_selected_year');
    if (!$current_selected_year) $current_selected_year = date('Y');

    $selected_bottom_range_year = $current_selected_year-4;
    $selected_top_range_year = $current_selected_year+4;

    for ($i=$selected_bottom_range_year;$i<=$selected_top_range_year;$i++) {
        if ($i==$current_selected_year) {
            $active = 'btn-primary';
        } else {
            $active = 'btn-default';
        }
        ?>
        <a class="btn <?=$active;?> submit-me" href="<?=moduleUrlByLevel('cetak/lampid', 'current_selected_year='.$i);?>">
            <?=$i;?>
        </a>
        <?php
    }

    ?>
</div>
<div id="container"></div>

<?php
$dataLampids = array(
    array('name' => 'Lahir', 'data'=> array()),
    array('name' => 'Mati', 'data' => array()),
    array('name' => 'Pindah', 'data' => array()),
    array('name' => 'Datang', 'data' => array()),
);
$dataUnfiltered = getDataLampid($selected_top_range_year, $selected_bottom_range_year);
for ($i=$selected_top_range_year;$i<=$selected_bottom_range_year;$i++) {
    $dataFiltered = array_filter($dataUnfiltered, function ($d) use ($i) {
        return $d['tahun'] == $i;
    });
    if (!$dataFiltered) {
        $dataFiltered = array();
    } else {
        $dataFiltered = array_values($dataFiltered);
        $dataFiltered = @$dataFiltered[0];
    }
    $dataLampids[0]['data'][] = (int) (@$dataFiltered['jumlah_lahir'] ? @$dataFiltered['jumlah_lahir'] : 0);
    $dataLampids[1]['data'][] = (int) (@$dataFiltered['jumlah_wafat'] ? @$dataFiltered['jumlah_wafat'] : 0);
    $dataLampids[2]['data'][] = (int) (@$dataFiltered['jumlah_pindah'] ? @$dataFiltered['jumlah_pindah'] : 0);
    $dataLampids[3]['data'][] = (int) (@$dataFiltered['jumlah_datang'] ? @$dataFiltered['jumlah_datang'] : 0);
}

?>
<script>

    Highcharts.chart('container', {

        title: {
            text: 'Grafik LAMPID Tahun <?=$current_selected_year;?>'
        },

        // subtitle: {
        //     text: 'Source: thesolarfoundation.com'
        // },

        yAxis: {
            title: {
                text: 'Jumlah (Orang)'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },

        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
                pointStart: <?=$selected_top_range_year;?>
            }
        },

        series: <?=json_encode($dataLampids);?>,

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }

    });
</script>
