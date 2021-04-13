<?php

// Waktu
if (isset($_GET["timezone"])) {
  $timezone = $_GET["timezone"];
  date_default_timezone_set("Asia/$timezone");
} else {
  $timezone = "Makassar";
  date_default_timezone_set("Asia/$timezone");
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

// Icon Sholat
$sholatIcon = "https://static.thenounproject.com/png/3358992-200.png";
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/css/ol.css" type="text/css">
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/build/ol.js"></script>

    <title>Jadwal Sholat</title>
    <style>
      #jadwal b {
        text-transform: uppercase;
        font-size: 14px;
      }
      .map {
        height: 250px;
        width: 100%;
        border-radius: 5px !important;
      }
    </style>
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
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">INFORMASI</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Secara default Jadwal Sholat saat ini untuk daerah Bulukumba. Oleh karena itu silahkan lengkapi formulir berikut untuk menampilkan Jadwal Sholat di daerah lainnya.
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Saya mengerti</button>
            </div>
          </div>
        </div>
      </div>

    <section class="container">
      <form class="mb-3 needs-validation" action="" method="get">
        <div class="input-group mb-3">
          <label for="kota" class="input-group-text">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path d="M12 0c-3.148 0-6 2.553-6 5.702 0 4.682 4.783 5.177 6 12.298 1.217-7.121 6-7.616 6-12.298 0-3.149-2.851-5.702-6-5.702zm0 8c-1.105 0-2-.895-2-2s.895-2 2-2 2 .895 2 2-.895 2-2 2zm12 16l-6.707-2.427-5.293 2.427-5.581-2.427-6.419 2.427 4-9 3.96-1.584c.38.516.741 1.08 1.061 1.729l-3.523 1.41-1.725 3.88 2.672-1.01 1.506-2.687-.635 3.044 4.189 1.789.495-2.021.465 2.024 4.15-1.89-.618-3.033 1.572 2.896 2.732.989-1.739-3.978-3.581-1.415c.319-.65.681-1.215 1.062-1.731l4.021 1.588 3.936 9z"/></svg>
          </label>
          <?php if (!isset($_GET["kota"])): ?>
            <input required id="kota" name="kota" type="text" class="form-control" placeholder="Masukan nama kota" aria-describedby="basic-addon1">
          <?php else: ?>
            <input required value="<?=$_GET["kota"]?>" id="kota" name="kota" type="text" class="form-control" placeholder="Masukan nama kota" aria-describedby="basic-addon1">
          <?php endif; ?>
          <div class="invalid-feedback">
            Mohon masukan nama kota/kabupaten
          </div>
        </div>
        <div class="input-group mb-3">
          <label for="timezone" class="input-group-text">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm5.848 12.459c.202.038.202.333.001.372-1.907.361-6.045 1.111-6.547 1.111-.719 0-1.301-.582-1.301-1.301 0-.512.77-5.447 1.125-7.445.034-.192.312-.181.343.014l.985 6.238 5.394 1.011z"/></svg>
          </label>
          <select required id="timezone" name="timezone" class="form-select">
            <option selected disabled value="">Pilih Zona Waktu</option>
            <option value="Jakarta">WIB</option>
            <option value="Makassar">WITA</option>
            <option value="Jayapura">WIT</option>
          </select>
        </div>
        <div class="text-end">
          <button class="btn btn-primary" type="submit">
            <svg fill="#ffffff" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M0 12l11 3.1 7-8.1-8.156 5.672-4.312-1.202 15.362-7.68-3.974 14.57-3.75-3.339-2.17 2.925v-.769l-2-.56v7.383l4.473-6.031 4.527 4.031 6-22z"/></svg>
          </button>
        </div>
      </form>
      
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <button class="nav-link" id="nav-one-tab" data-bs-toggle="tab" data-bs-target="#nav-one" type="button">Lokasi</button>
          <button class="nav-link active" id="nav-two-tab" data-bs-toggle="tab" data-bs-target="#nav-two" type="button">Jadwal Sholat</button>
        </div>
      </nav>
      <div class="tab-content">
        <div class="tab-pane fade" id="nav-one">
          <!-- Info Lokasi -->
          <div id="lokasi" class="border border-1 shadow-sm p-3 mt-3 rounded">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path d="M12 0c-3.148 0-6 2.553-6 5.702 0 4.682 4.783 5.177 6 12.298 1.217-7.121 6-7.616 6-12.298 0-3.149-2.851-5.702-6-5.702zm0 8c-1.105 0-2-.895-2-2s.895-2 2-2 2 .895 2 2-.895 2-2 2zm12 16l-6.707-2.427-5.293 2.427-5.581-2.427-6.419 2.427 4-9 3.96-1.584c.38.516.741 1.08 1.061 1.729l-3.523 1.41-1.725 3.88 2.672-1.01 1.506-2.687-.635 3.044 4.189 1.789.495-2.021.465 2.024 4.15-1.89-.618-3.033 1.572 2.896 2.732.989-1.739-3.978-3.581-1.415c.319-.65.681-1.215 1.062-1.731l4.021 1.588 3.936 9z"/></svg>
            <?=$jadwal["data"]["lokasi"]?>
            <hr>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path d="M18 11c-3.313 0-6 2.687-6 6s2.687 6 6 6 6-2.687 6-6-2.687-6-6-6zm-2.888 7.858c.28-.201.147-.446-.025-.649-.073-.086-.474-.5-.519-.426.034-.113-.073-.386-.137-.494-.108-.181-.251-.292-.309-.491-.022-.079-.022-.32-.069-.375l-.158-.117c.139-.828.522-1.572 1.075-2.16l.373-.15c.234-.352.247-.079.458-.17.07 0 .15-.289.226-.334.131-.084.031-.084.006-.123-.051-.083 1.096-.501 1.115-.426.016.063-.567.368-.503.358-.148.02-.176.286-.148.284.074-.002.537-.352.753-.277.211.073.591-.168.74-.291.075-.062.144-.172.242-.172.455 0 1.134.188 1.29.28.237.141-.102.131-.139.223l-.125.206c-.051.066-.199.038-.17-.041.03-.083.174-.115-.043-.135-.222-.021-.284-.17-.506.017-.067.056-.117.143-.161.216l-.272.198c-.06.096.035.256.152.185.031-.019.382.322.337.048-.029-.183.098-.307.101-.444.001-.091.14-.033.103.015-.048.061-.102.267.025.277.055.004.212-.115.23-.026-.026-.086-.177.176-.167.172-.054.024-.117-.01-.075.105.037.113-.204.1-.248.123-.018.01-.208-.057-.204-.014l-.036-.211c-.055.084-.029.256-.147.256-.101 0-.241.115-.301.185-.043.048-.305.153-.333.15.149.016.143.125.13.219-.03.216-.498.016-.478.098.019.079-.054.293-.07.362-.015.062.201.103.188.134l.32-.125.065-.147.175-.089.074-.129c.025-.01.323-.056.344-.046.075.034.213.177.265.242l.114.094-.003.111c.052.097.066-.2.044-.145 0-.095.07.035.086.024l-.329-.327c-.102-.171.272.091.321.123.047.032.142.314.268.251l.053-.115.225-.044c-.178.13.139.301.091.278l.177-.011c.028.011.332.007.283-.041.076.038.041.374-.022.425-.102.084-.591.049-.7-.029-.181-.131-.148.139-.236.176-.171.071-.429-.231-.609-.241.087.014.008-.223.008-.238-.07-.086-.51.009-.626.025-.217.029-.444.026-.611.162l-.238.325-.228.095c-.117.111-.251.276-.317.422l.02.287c-.153.483.038 1.154.625 1.228.143.018.29.095.434.052.115-.035.216-.113.339-.122.171-.011.1.241.335.172.114-.034.166.078.166.163-.038.178-.122.277.041.401.11.085.201.208.221.354.012.083.089.225-.006.273-.068.034-.118.23-.117.295.014.075.166.219.211.282l.072.301.146.293c.051.147.436-.003.525-.003.306.002.461-.429.676-.562l.231-.385c.135-.098.277-.157.289-.337.01-.156-.118-.482-.047-.615.085-.157.985-1.429.717-1.493l-.38.18c-.074.006-.357-.3-.431-.375-.139-.138-.199-.384-.312-.552-.066-.099-.267-.294-.267-.417.009.022.093.164.132.134l.007-.069c-.002.037.235.31.286.339l.229.34c.218.167.158.644.478.354.214-.193.633-.561.521-.896-.059-.178-.33-.047-.413.016-.089-.047-.415-.402-.287-.449.063-.022.202.164.252.192l.238-.003c.068.143.519-.147.625-.105.071.027.126.085.15.157.075.23.149.666.149 1.097 0 2.299-1.864 4.162-4.162 4.162-1.184 0-2.251-.494-3.008-1.286-.09-.094-.158-.318-.009-.409l.151-.039c.116-.096-.112-.501-.022-.566zm4.877-3.974c.18.064.016.188-.088.159-.057-.016-.352-.105-.362.01 0 .069-.28 0-.236-.072l.076-.232c.08-.105.157-.048.159.013 0 .163.165-.154.256-.165l-.044.069c.013.106.09.165.239.218zm-9.93 3.05l-3.059 2.207v-13.068l4-2.886v8.942c.507-.916 1.189-1.719 2-2.37v-6.572l4 2.886v1.997c.328-.042.661-.07 1-.07v-1.929l4-2.479v5.486c.754.437 1.428.992 2 1.642v-10.72l-6.455 4-5.545-4-5.545 4-6.455-4v18l6.455 4 4.137-2.984c-.266-.656-.448-1.354-.533-2.082zm-4.059 2.431l-4-2.479v-13.294l4 2.479v13.294z"/></svg>
            <?=$jadwal["data"]["daerah"]?>
            <hr>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm5.848 12.459c.202.038.202.333.001.372-1.907.361-6.045 1.111-6.547 1.111-.719 0-1.301-.582-1.301-1.301 0-.512.77-5.447 1.125-7.445.034-.192.312-.181.343.014l.985 6.238 5.394 1.011z"/></svg>
            <?php
            if ($timezone == "Jakarta") {
              echo "Waktu Indonesia Barat (WIB)";
            } elseif ($timezone == "Makassar") {
              echo "Waktu Indonesia Tengah (WITA)";
            } elseif ($timezone == "Jayapura") {
              echo "Waktu Indonesia Timur (WIT)";
            } else {
              echo "Zona waktu tidak diketahui";
            }
            ?>
            <hr>
            <div id="map" class="map"></div>
          </div>
        </div>
        
        <div class="tab-pane fade show active" id="nav-two">
          <!-- Jadwal Sholat -->
          <div id="jadwal">
            <div class="row shadow-sm p-3 m-2 rounded">
              <div class="col">
                <b>Imsak</b>
              </div>
              <div class="col text-end">
                <?=$jadwal["data"]["jadwal"]["imsak"]?>
              </div>
            </div>
            <div class="row shadow-sm p-3 m-2 rounded">
              <div class="col">
                <b>Subuh</b>
                <img src="<?=$sholatIcon?>" width="18" height="18">
              </div>
              <div class="col text-end">
                <?=$jadwal["data"]["jadwal"]["subuh"]?>
              </div>
            </div>
            <div class="row shadow-sm p-3 m-2 rounded">
              <div class="col">
                <b>Terbit</b>
              </div>
              <div class="col text-end">
                <?=$jadwal["data"]["jadwal"]["terbit"]?>
              </div>
            </div>
            <div class="row shadow-sm p-3 m-2 rounded">
              <div class="col">
                <b>Dhuha</b>
              </div>
              <div class="col text-end">
                <?=$jadwal["data"]["jadwal"]["dhuha"]?>
              </div>
            </div>
            <div class="row shadow-sm p-3 m-2 rounded">
              <div class="col">
                <b>Dzuhur</b>
                <img src="<?=$sholatIcon?>" width="18" height="18">
              </div>
              <div class="col text-end">
                <?=$jadwal["data"]["jadwal"]["dzuhur"]?>
              </div>
            </div>
            <div class="row shadow-sm p-3 m-2 rounded">
              <div class="col">
                <b>Ashar</b>
                <img src="<?=$sholatIcon?>" width="18" height="18">
              </div>
              <div class="col text-end">
                <?=$jadwal["data"]["jadwal"]["ashar"]?>
              </div>
            </div>
            <div class="row shadow-sm p-3 m-2 rounded">
              <div class="col">
                <b>Maghrib</b>
                <img src="<?=$sholatIcon?>" width="18" height="18">
              </div>
              <div class="col text-end">
                <?=$jadwal["data"]["jadwal"]["maghrib"]?>
              </div>
            </div>
            <div class="row shadow-sm p-3 m-2 rounded">
              <div class="col">
                <b>Isya</b>
                <img src="<?=$sholatIcon?>" width="18" height="18">
              </div>
              <div class="col text-end">
                <?=$jadwal["data"]["jadwal"]["isya"]?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <footer class="p-3 mt-3 text-center">
      &copy; <?=date("Y")?> Made with &hearts; by <a class="text-decoration-none" href="https://feri-irawan.netlify.app">Feri Irawan</a>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script type="text/javascript">
    
    // Run Functions After Loading Page
    window.addEventListener('load', function () {
       getMap();
       showModal();
    }, false); 
    
    // Get Map
    function getMap() {
        var latitude = <?=$jadwal["data"]["koordinat"]["lat"]?>;
        var longitude = <?=$jadwal["data"]["koordinat"]["lon"]?>;
        var map = new ol.Map({
          target: 'map',
          controls: ol.control.defaults({ attribution: false }),
          layers: [
            new ol.layer.Tile({
              source: new ol.source.OSM()
            })
          ],
          interactions: ol.interaction.defaults({
            dragPan: false,
            mouseWheelZoom: false
          }).extend([
            new ol.interaction.DragPan({kinetic: false}),
            new ol.interaction.MouseWheelZoom({duration: 0})
          ]),
          view: new ol.View({
            center: ol.proj.fromLonLat([longitude, latitude]),
            zoom: 12
          })
        });
      }
      
    // Modal Function
    function showModal() {
      var myModal = new bootstrap.Modal(document.getElementById("staticBackdrop"), {});
      myModal.show();
    }
    </script>
  </body>
</html>
