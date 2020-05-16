<?php

$k = mysqli_connect('localhost:8889', 'root', 'root', 'fuzzy');

$saw = mysqli_query($k, "SELECT * FROM tb_alternatif");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Final Task - Fuzzy Logic</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="js/Chart.js"></script>
    <link rel="stylesheet" href="gaya.css">
</head>

<body>
    <div class="container-fluid bg">
        <div class="row">
            <div class="bs-example col-sm-12">
                <div class="head">
                    <b>Rekomendasi objek wisata Maluku Utara</b>
                </div>
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Carousel indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                        <li data-target="#myCarousel" data-slide-to="3"></li>
                        <li data-target="#myCarousel" data-slide-to="4"></li>
                    </ol>
                    <!-- Wrapper for carousel items -->
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="assets/sulamadaha.jpg" width="1000" height="500" alt="First Slide" class="clause">
                            <p class="text-white">Pantai Sulamadaha</p>
                        </div>
                        <div class="carousel-item">
                            <img src="assets/tolire.jpg" width="1000" height="500" alt="Second Slide" class="clause">
                            <p class="text-white">Danau Tolire</p>
                        </div>
                        <div class="carousel-item">
                            <img src="assets/maitara.jpg" width="1000" height="500" alt="Third Slide" class="clause">
                            <p class="text-white">Pulau Maitara</p>
                        </div>
                        <div class="carousel-item">
                            <img src="assets/morotai.jpg" width="1000" height="500" alt="Third Slide" class="clause">
                            <p class="text-white">Pulau Morotai</p>
                        </div>
                        <div class="carousel-item">
                            <img src="assets/batu-angus.jpeg" width="1000" height="500" alt="Third Slide" class="clause">
                            <p class="text-white">Batu Angus</p>
                        </div>
                    </div>
                    <!-- Carousel controls -->
                    <a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#myCarousel" data-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </a>
                </div>
            </div>
        </div>
        <?php
        //PROSES NORMALISASI
        $cari_max = [];
        $temp_alter = [];
        $temp_c1 = [];
        $temp_c2 = [];
        $temp_c3 = [];
        $temp_c4 = [];
        $temp_c5 = [];

        $w_c1 = 0.15;
        $w_c2 = 0.3;
        $w_c3 = 0.25;
        $w_c4 = 0.1;
        $w_c5 = 0.2;

        //AMBIL DATA
        $urut = 0;
        foreach ($saw as $s) :
            array_push($temp_c1, $s['c1']);
            array_push($temp_c2, $s['c2']);
            array_push($temp_c3, $s['c3']);
            array_push($temp_c4, $s['c4']);
            array_push($temp_c5, $s['c5']);
            array_push($temp_alter, $s['nama_tempat']);

            $data[$urut]['nama'] = $s['nama_tempat'];
            $data[$urut]['alter'] = $s['alternatif'];
            $data[$urut]['c1'] = $s['c1'];
            $data[$urut]['c2'] = $s['c2'];
            $data[$urut]['c3'] = $s['c3'];
            $data[$urut]['c4'] = $s['c4'];
            $data[$urut]['c5'] = $s['c5'];

            $urut++;
        endforeach;

        $max_c1 = max($temp_c1);
        $min_c2 = min($temp_c2);
        $min_c3 = min($temp_c3);
        $min_c4 = min($temp_c4);
        $max_c5 = max($temp_c5);

        $urut = 0;
        foreach ($data as $d) :
            $data[$urut]['normal_c1'] = round($d['c1'] / $max_c1, 2);
            $data[$urut]['normal_c2'] = round($min_c2 / $d['c2'], 2);
            $data[$urut]['normal_c3'] = round($min_c3 / $d['c3'], 2);
            $data[$urut]['normal_c4'] = round($min_c4 / $d['c4'], 2);
            $data[$urut]['normal_c5'] = round($d['c5'] / $max_c5, 2);

            $urut++;
        endforeach;

        ?>
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-5">
                <!-- DataTales Example -->
                <div class="card shadow my-2">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><span class="badge badge-info">1</span> Kriteria Alternatif</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr align="center">
                                        <th>Nama tempat</th>
                                        <th>Alternatif</th>
                                        <th>C1</th>
                                        <th>C2</th>
                                        <th>C3</th>
                                        <th>C4</th>
                                        <th>C5</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($saw as $s) : ?>
                                        <tr>
                                            <td><?= $s['nama_tempat']; ?></td>
                                            <td align="center"><?= $s['alternatif']; ?></td>
                                            <td align="center"><?= $s['c1']; ?></td>
                                            <td align="center"><?= $s['c2']; ?></td>
                                            <td align="center"><?= $s['c3']; ?></td>
                                            <td align="center"><?= $s['c4']; ?></td>
                                            <td align="center"><?= $s['c5']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card shadow my-2">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><span class="badge badge-info">2</span> Normalisasi</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr align="center">
                                        <!-- <th>Nama tempat</th> -->
                                        <th>Alternatif</th>
                                        <th>C1</th>
                                        <th>C2</th>
                                        <th>C3</th>
                                        <th>C4</th>
                                        <th>C5</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $d) : ?>
                                        <tr>
                                            <!-- <td><?= $d['nama']; ?></td> -->
                                            <td align="center"><?= $d['alter']; ?></td>
                                            <td align="center"><?= $d['normal_c1']; ?></td>
                                            <td align="center"><?= $d['normal_c2']; ?></td>
                                            <td align="center"><?= $d['normal_c3']; ?></td>
                                            <td align="center"><?= $d['normal_c4']; ?></td>
                                            <td align="center"><?= $d['normal_c5']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        //NILAI AKHIR
        $urut = 0;
        foreach ($data as $d) :
            $hasil[$urut]['v'] = round(($w_c1 * $d['normal_c1']) + ($w_c2 * $d['normal_c2']) + ($w_c3 * $d['normal_c3']) + ($w_c4 * $d['normal_c4']) + ($w_c5 * $d['normal_c5']), 3);
            array_push($cari_max, $hasil[$urut]['v']);
            $urut++;
        endforeach;
        $urut = 0;
        foreach ($saw as $s) :
            $hasil[$urut]['nama'] = $s['nama_tempat'];
            $hasil[$urut]['alter'] = $s['alternatif'];
            $urut++;
        endforeach;
        $nilai_graf = json_encode($cari_max);
        $alter_graf = json_encode($temp_alter);
        $rekomen = max($cari_max);
        rsort($hasil);
        ?>

        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-5">
                <div class="card shadow my-1">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><span class="badge badge-info">3</span> Nilai Akhir</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr align="center">
                                        <!-- <th>Nama tempat</th> -->
                                        <th>Rangking</th>
                                        <th>Alternatif</th>
                                        <th>Objek Wisata</th>
                                        <th>Bobot akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $urut = 1;
                                    foreach ($hasil as $h) : ?>
                                        <tr>
                                            <!-- <td><?= $d['nama']; ?></td> -->
                                            <td align="center"><?= $urut++; ?></td>
                                            <td align="center"><?= $h['alter']; ?></td>
                                            <td align="center"><?= $h['nama']; ?></td>
                                            <td align="center"><?= $h['v']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><span class="badge badge-info">4</span> Grafik nilai akhir alternatif</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= $alter_graf; ?>,
                datasets: [{
                    label: '',
                    data: <?= $nilai_graf; ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>

</html>