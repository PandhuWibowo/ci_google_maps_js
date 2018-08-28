<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Artha Graha</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
  </head>
  <body>
    <div id="app">


      <div class="form-group">
        <select class="varListPorpinsi form-control" name="varListPorpinsi" id="varListPorpinsi">
          <option value="0" selected disabled>Pilih Provinsi</option>
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
        <select class="varListKabko form-control" name="varListKabko" id="varListKabko" v-model="place">
          <option value="" selected disabled>Pilih Kabupaten/Kota</option>
        </select>
      </div>
      <div class="col-md-6"><h3> Latitude : {{ latitude }}</h3></div>
      <div class="col-md-6"><h3> Longitude : {{ longitude }}</h3></div>

      <div class="form-group">
        <select class="type form-control" name="varType" id="varType">
          <option value="0" selected disabled>Pilih Jenis ATM atau Bank</option>
          <option value="Atm Artha Graha">Atm Artha Graha</option>
          <option value="Atm Artha Graha">Bank Artha Graha</option>
        </select>
      </div>
      <div class="col-md-12"  v-bind:class="{ 'not-visible' : active }" >
          <iframe frameborder="0" style="width: 100%; height: 350px; border:0" v-bind:src="'https://www.google.com/maps/embed/v1/place?key=AIzaSyCSdxjuCPhzR8BbQe3-crU3qoSC-_ymQBg&q='+ place+'&zoom=11'" allowfullscreen></iframe>
      </div>
      <!-- <div id="info"></div>
      <div id="googleMap" style="width:50%;height:380px;"></div> -->

      <!-- <form action="" method="post">
        <input type="text" id="lat" name="lat" value="">
        <input type="text" id="lng" name="lng" value="">
      </form> -->
</div>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" charset="utf-8"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.js" charset="utf-8"></script>
      <script src="https://unpkg.com/vue@2.0.3/dist/vue.js"></script>
      <script src="https://unpkg.com/axios@0.12.0/dist/axios.min.js"></script>
      <script src="https://unpkg.com/lodash@4.13.1/lodash.min.js"></script>
      <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJxBram_TlXO62Q0QzroUxP3Jq7BzKoRM&libraries=places&v=3.exp"></script> -->
      <!-- <script src="http://maps.googleapis.com/maps/api/js"></script> -->
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

      // var geocoder;
      // var map;
      // var geoMarker;
      //
      // function initialize() {
      //   var map = new google.maps.Map(
      //     document.getElementById("googleMap"), {
      //       center: new google.maps.LatLng(-6.21462, 106.84513),
      //       zoom: 13,
      //       mapTypeId: google.maps.MapTypeId.ROADMAP
      //     });
      //   geoMarker = new google.maps.Marker();
      //   geoMarker.setPosition(map.getCenter());
      //   geoMarker.setMap(map);
      //
      //   $("#varListKabko").change(function() {
      //     var addr = ($('#varListKabko').val());
      //
      //     var geocoder = new google.maps.Geocoder();
      //     geocoder.geocode({
      //       'address': addr
      //     }, function(results, status) {
      //       if (status == google.maps.GeocoderStatus.OK) {
      //         map.setCenter(results[0].geometry.location);
      //         geoMarker.setOptions({
      //           position: results[0].geometry.location,
      //         });
      //       } else {
      //         alert("Something got wrong " + status);
      //       }
      //     });
      //   });
      //
      // }
      // google.maps.event.addDomListener(window, "load", initialize);

      var app = new Vue({
        el: '#app',
        data: {
          place: '',
          latitude: '',
          longitude: '',
          active : true
        },
        watch: {
          place: function() {
            this.latitude = '';
            this.longitude = '';
            this.active = true;
            if (this.place.length >= 3) {
              this.active = false;
              this.lookupCoordinates();
            }
          }
        },
        methods: {
          lookupCoordinates: _.debounce(function() {
            var app = this;
            app.latitude = "Searching...";
            app.longitude = "Searching...";
            axios.get('https://maps.googleapis.com/maps/api/geocode/json?address=' + app.place)
                  .then(function (response) {
                    app.latitude = response.data.results[0].geometry.location.lat;
                    app.longitude = response.data.results[0].geometry.location.lng;
                  })
                  .catch(function (error) {
                    app.latitude = "Invalid place";
                    app.longitude = "Invalid place";
                  })
          }, 500)
        }
      });
      </script>
  </body>
</html>
