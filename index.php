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
            Jadwal Sholat
          </a>
        </div>
      </nav>
    </header>

  <section class="container">
    <form action="" method="get">
      <div class="row">
        <div class="col-7">
          
          <div class="input-group mb-3">
            <label for="kota" class="input-group-text">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M12 0c-3.148 0-6 2.553-6 5.702 0 4.682 4.783 5.177 6 12.298 1.217-7.121 6-7.616 6-12.298 0-3.149-2.851-5.702-6-5.702zm0 8c-1.105 0-2-.895-2-2s.895-2 2-2 2 .895 2 2-.895 2-2 2zm12 16l-6.707-2.427-5.293 2.427-5.581-2.427-6.419 2.427 4-9 3.96-1.584c.38.516.741 1.08 1.061 1.729l-3.523 1.41-1.725 3.88 2.672-1.01 1.506-2.687-.635 3.044 4.189 1.789.495-2.021.465 2.024 4.15-1.89-.618-3.033 1.572 2.896 2.732.989-1.739-3.978-3.581-1.415c.319-.65.681-1.215 1.062-1.731l4.021 1.588 3.936 9z"/></svg>
            </label>
            <input id="kota" name="kota" type="text" class="form-control" placeholder="Kota..." aria-describedby="basic-addon1">
          </div>
          
        </div>
        <div class="col-5">
          <div class="input-group mb-3">
            <label for="timezone" class="input-group-text">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm1.608 9.476l-1.608-5.476-1.611 5.477c-.429.275-.775.658-1.019 1.107l-5.37 1.416 5.37 1.416c.243.449.589.833 1.019 1.107l1.611 5.477 1.618-5.479c.428-.275.771-.659 1.014-1.109l5.368-1.412-5.368-1.413c-.244-.452-.592-.836-1.024-1.111zm-1.608 4.024c-.828 0-1.5-.672-1.5-1.5s.672-1.5 1.5-1.5 1.5.672 1.5 1.5-.672 1.5-1.5 1.5zm5.25 3.75l-2.573-1.639c.356-.264.67-.579.935-.934l1.638 2.573zm-2.641-8.911l2.64-1.588-1.588 2.639c-.29-.407-.645-.761-1.052-1.051zm-5.215 7.325l-2.644 1.586 1.589-2.641c.29.408.646.764 1.055 1.055zm-1.005-6.34l-1.638-2.573 2.573 1.638c-.357.264-.672.579-.935.935z"/></svg>
            </label>
            <select id="timezone" name="timezone" class="form-select">
              <option value="Jakarta">WIB</option>
              <option value="Makassar">WITA</option>
              <option value="Jayapura">WIT</option>
            </select>
          </div>
        </div>
      </div>
      
      <button type="submit" class="btn btn-primary"><svg fill="#fff" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M20.285 2l-11.285 11.567-5.286-5.011-3.714 3.716 9 8.728 15-15.285z"/></svg></button>
    </form>
    
    <div id="lokasi" class="shadow-sm p-3 mb-3 rounded">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm1.608 9.476l-1.608-5.476-1.611 5.477c-.429.275-.775.658-1.019 1.107l-5.37 1.416 5.37 1.416c.243.449.589.833 1.019 1.107l1.611 5.477 1.618-5.479c.428-.275.771-.659 1.014-1.109l5.368-1.412-5.368-1.413c-.244-.452-.592-.836-1.024-1.111zm-1.608 4.024c-.828 0-1.5-.672-1.5-1.5s.672-1.5 1.5-1.5 1.5.672 1.5 1.5-.672 1.5-1.5 1.5zm5.25 3.75l-2.573-1.639c.356-.264.67-.579.935-.934l1.638 2.573zm-2.641-8.911l2.64-1.588-1.588 2.639c-.29-.407-.645-.761-1.052-1.051zm-5.215 7.325l-2.644 1.586 1.589-2.641c.29.408.646.764 1.055 1.055zm-1.005-6.34l-1.638-2.573 2.573 1.638c-.357.264-.672.579-.935.935z"/></svg>
      <?=$jadwal["data"]["lokasi"]?>
    </div>
    
    <div id="jadwal">
      <div class="row shadow-sm p-3 mb-3 rounded">
        <div class="col">
          <h5>Imsak</h5>
        </div>
        <div class="col">
          <?=$jadwal["jadwal"]["imsak"]?>
        </div>
      </div>
      <div class="row shadow-sm p-3 mb-3 rounded">
        <div class="col">
          <h5>Subuh</h5>
        </div>
        <div class="col">
          <?=$jadwal["jadwal"]["subuh"]?>
        </div>
      </div>
      <div class="row shadow-sm p-3 mb-3 rounded">
        <div class="col">
          <h5>Terbit</h5>
        </div>
        <div class="col">
          <?=$jadwal["jadwal"]["terbit"]?>
        </div>
      </div>
      <div class="row shadow-sm p-3 mb-3 rounded">
        <div class="col">
          <h5>Dhuha</h5>
        </div>
        <div class="col">
          <?=$jadwal["jadwal"]["dhuha"]?>
        </div>
      </div>
      <div class="row shadow-sm p-3 mb-3 rounded">
        <div class="col">
          <h5>Dzuhur</h5>
        </div>
        <div class="col">
          <?=$jadwal["jadwal"]["dzuhur"]?>
        </div>
      </div>
      <div class="row shadow-sm p-3 mb-3 rounded">
        <div class="col">
          <h5>Ashar</h5>
        </div>
        <div class="col">
          <?=$jadwal["jadwal"]["ashar"]?>
        </div>
      </div>
      <div class="row shadow-sm p-3 mb-3 rounded">
        <div class="col">
          <h5>Maghrib</h5>
        </div>
        <div class="col">
          <?=$jadwal["jadwal"]["maghrib"]?>
        </div>
      </div>
      <div class="row shadow-sm p-3 mb-3 rounded">
        <div class="col">
          <h5>Isya</h5>
        </div>
        <div class="col">
          <?=$jadwal["jadwal"]["isya"]?>
        </div>
      </div>
    </div>
    
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
