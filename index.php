<?php

// Waktu
if (isset($_GET["timezone"])) {
  $timezone = $_GET["timezone"];
  date_default_timezone_set("Asia/$timezone");
} else {
  date_default_timezone_set("Asia/Makassar");
}

$waktu = date("Y/m/d");

// Mengambil ID Kota
if (isset($_GET["kota"])) {
  $getKota = $_GET["kota"];
  $cari = file_get_contents("https://api.myquran.com/v1/sholat/kota/cari/$getKota");
} else {
  $cari = file_get_contents("https://api.myquran.com/v1/sholat/kota/cari/bulukumba");
}
$cari = json_decode($cari, true);
$idKota = $cari["data"][0]["id"];

// Mendapatkan Jadwal Sholat
$jadwal = file_get_contents("https://api.myquran.com/v1/sholat/jadwal/$idKota/$waktu");
$jadwal = json_decode($jadwal, true);
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Jadwal Sholat</title>
  </head>
  <body>
    
  <header>
      <nav class="navbar navbar-light bg-light mb-3">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-alarm" viewBox="0 0 16 16">
              <path d="M8.5 5.5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9V5.5z"/>
              <path d="M6.5 0a.5.5 0 0 0 0 1H7v1.07a7.001 7.001 0 0 0-3.273 12.474l-.602.602a.5.5 0 0 0 .707.708l.746-.746A6.97 6.97 0 0 0 8 16a6.97 6.97 0 0 0 3.422-.892l.746.746a.5.5 0 0 0 .707-.708l-.601-.602A7.001 7.001 0 0 0 9 2.07V1h.5a.5.5 0 0 0 0-1h-3zm1.038 3.018a6.093 6.093 0 0 1 .924 0 6 6 0 1 1-.924 0zM0 3.5c0 .753.333 1.429.86 1.887A8.035 8.035 0 0 1 4.387 1.86 2.5 2.5 0 0 0 0 3.5zM13.5 1c-.753 0-1.429.333-1.887.86a8.035 8.035 0 0 1 3.527 3.527A2.5 2.5 0 0 0 13.5 1z"/>
            </svg>
            Jadwal Sholat
          </a>
        </div>
      </nav>
    </header>

  <section class="container">
    <form action="" method="get">
      <div class="row">
        <div class="col-8">
          
          <div class="input-group">
            <span class="input-group-text">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M12 0c-3.148 0-6 2.553-6 5.702 0 4.682 4.783 5.177 6 12.298 1.217-7.121 6-7.616 6-12.298 0-3.149-2.851-5.702-6-5.702zm0 8c-1.105 0-2-.895-2-2s.895-2 2-2 2 .895 2 2-.895 2-2 2zm12 16l-6.707-2.427-5.293 2.427-5.581-2.427-6.419 2.427 4-9 3.96-1.584c.38.516.741 1.08 1.061 1.729l-3.523 1.41-1.725 3.88 2.672-1.01 1.506-2.687-.635 3.044 4.189 1.789.495-2.021.465 2.024 4.15-1.89-.618-3.033 1.572 2.896 2.732.989-1.739-3.978-3.581-1.415c.319-.65.681-1.215 1.062-1.731l4.021 1.588 3.936 9z"/></svg>
            </span>
            <input id="kota" type="text" name="kota" class="form-control mb-3" placeholder="Kab/Kota..." autofocus required/>
          </div>
          
        </div>
        <div class="col-4">
          <label for="zona">Zona Waktu</label>
          <select id="zona" name="timezone" class="form-select mb-3">
            <option value="Jakarta">WIB</option>
            <option value="Makassar">WITA</option>
            <option value="Jayapura">WIT</option>
          </select>
        </div>
      </div>
      
      <button type="submit" class="btn btn-primary"><svg fill="#fff" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M20.285 2l-11.285 11.567-5.286-5.011-3.714 3.716 9 8.728 15-15.285z"/></svg></button>
    </form>
    <pre>
      <code>
        <?php
        print_r($cari);
        print_r("=================\n");
        print_r($jadwal);
        ?>
      </code>
    </pre>
  </section>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>
