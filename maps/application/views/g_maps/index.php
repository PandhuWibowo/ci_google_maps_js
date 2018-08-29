
<!DOCTYPE html>
<html lang="en" >
    <head>
        <meta charset="utf-8" />
        <title>Google Places API - practice | Script Tutorials</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" charset="utf-8"></script>
        <link href="<?php echo base_url('assets/css/main.css');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyB4wS9TPSIExN2MI6WvJMk8-o6CqXEeTC4"></script>
        <script src="<?php echo base_url('assets/js/script.js');?>"></script>
    </head>
    <body>
        <header>
            <h2>Filter ATM or BANK Artha Graha</h2>
        </header>
        <!-- <div class="form-group">
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
          <select class="varListKabko form-control" name="varListKabko" id="varListKabko">
            <option value="" selected disabled>Pilih Kabupaten/Kota</option>
          </select>
        </div> -->
        <!-- <div class="col-md-6"><h3> Latitude : {{ latitude }}</h3></div>
        <div class="col-md-6"><h3> Longitude : {{ longitude }}</h3></div> -->

        <!-- <div class="form-group">
          <select class="type form-control" name="varType" id="varType">
            <option value="0" >Pilih Jenis ATM atau Bank</option>
            <option value="Artha Graha">Atm Artha Graha</option>
            <option value="Artha Graha">Bank Artha Graha</option>
          </select>
        </div> -->
        <div id="container" class="container">
            <div id="gmap_canvas"></div>
            <div class="actions">
                <div class="button">
                    <label for="gmap_where">Where:</label>
                    <!-- <input id="gmap_where" type="text" name="gmap_where" /> -->
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
                <div class="button">
                  <select class="varListKabko form-control" name="varListKabko" id="varListKabko" onchange="findAddress(); return false;">
                    <option value="" selected disabled>Pilih Kabupaten/Kota</option>
                  </select>
                </div>
                <!-- <div id="button2" class="button" onclick="findAddress(); return false;">Search for address</div> -->
                <!-- <div class="button">
                    <label for="gmap_keyword">Keyword (optional):</label>
                    <input id="gmap_keyword" type="text" name="gmap_keyword" /></div> -->
                <div class="button">
                    <label for="gmap_type">Type:</label>
                    <select id="gmap_type">
                        <option value="atm">atm</option>
                        <option value="bank">bank</option>
                    </select>
                </div>
                <div class="button">
                    <label for="gmap_radius">Radius:</label>
                    <select id="gmap_radius">
                        <option value="500">500</option>
                        <option value="1000">1000</option>
                        <option value="1500">1500</option>
                        <option value="5000">5000</option>
                    </select>
                </div>
                <input type="hidden" id="lat" name="lat" value="-6.21462" />
                <input type="hidden" id="lng" name="lng" value="106.84513" />
                <div id="button1" class="button" onclick="findPlaces(); return false;">Search for objects</div>
            </div>
        </div>
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
        </script>
    </body>
</html>
