<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Artha Graha</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
  </head>
  <body>
      <div class="form-group">
        <select class="varListPorpinsi form-control" name="varListPorpinsi" id="varListPorpinsi">
          <option value="0">Pilih Provinsi</option>
          <?php
            foreach ($varListPorpinsi as $vlpro) {
              // code...
              ?>
                <option value="<?=$vlpro->lokasi_propinsi;?>"><?=$vlpro->lokasi_nama;?></option>
              <?php
            }
          ?>
        </select>
      </div>

      <div class="form-group">
        <select class="varListKabko form-control" name="varListKabko" id="varListKabko">
          <option value="">Pilih Kabupaten/Kota</option>
        </select>
      </div>

      <div id="info"></div>
      <div id="googleMap" style="width:100%;height:380px;"></div>

      <!-- <form action="" method="post">
        <input type="text" id="lat" name="lat" value="">
        <input type="text" id="lng" name="lng" value="">
      </form> -->

      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" charset="utf-8"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.js" charset="utf-8"></script>
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDLaln3IEmJGbVRl7_1rkgwft1zEOMJ6fo&libraries=places&v=3.exp"></script>
      <script type="text/javascript">

      $(function(){
        $.ajaxSetup({
          type:"POST",
          url: "<?php echo base_url('maps/m_list_kabupaten') ?>",
          cache: false,
        });

        $("#varListPorpinsi").change(function(){
            var value=$(this).val();
            if(value>0){
              $.ajax({
              data:{modul:'kabupaten',id:value},
              success: function(respond){
                $("#varListKabko").html(respond);
              }
              })
            }
        });
      });

      var geocoder;
      var map;
      var geoMarker;

      function initialize() {
        var map = new google.maps.Map(
          document.getElementById("googleMap"), {
            center: new google.maps.LatLng(37.4419, -122.1419),
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP
          });
        geoMarker = new google.maps.Marker();
        geoMarker.setPosition(map.getCenter());
        geoMarker.setMap(map);

        $("#varListKabko").change(function() {
          var addr = ($('#varListKabko').val());

          var geocoder = new google.maps.Geocoder();
          geocoder.geocode({
            'address': addr
          }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              map.setCenter(results[0].geometry.location);
              geoMarker.setOptions({
                position: results[0].geometry.location,
              });
            } else {
              alert("Something got wrong " + status);
            }
          });
        });

      }
      google.maps.event.addDomListener(window, "load", initialize);

      </script>
  </body>
</html>
