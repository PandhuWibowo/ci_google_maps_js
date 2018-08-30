var geocoder;
var map;
var markers = Array();
var infos = Array();
var gmarkers = Array();

function initialize() {
    // prepare Geocoder
    geocoder = new google.maps.Geocoder();

    // set initial position (New York)
    var myLatlng = new google.maps.LatLng(-6.21462,106.84513);

    var myOptions = { // default map options
        zoom: 14,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);
}

//Remove Marker
// function removeMarkers(){
//     for(i=0; i<gmarkers.length; i++){
//         gmarkers[i].setMap(null);
//     }
// }

// clear overlays function
function clearOverlays() {
    if (markers) {
        for (i in markers) {
            markers[i].setMap(null);
        }
        markers = [];
        infos = [];
    }
}

// clear infos function
function clearInfos() {
    if (infos) {
        for (i in infos) {
            if (infos[i].getMap()) {
                infos[i].close();
            }
        }
    }
}
var addrMarker;
// find address function
function findAddress() {
    // var contentTitle;
    var address = '<b style="color:black;">'+document.getElementById("varListKabko").value+'</b>';
    var infowindow;
    // script uses our 'geocoder' in order to find location by address name
    geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) { // and, if everything is ok

            // we will center map
            // console.log(results)
            var addrLocation = results[0].geometry.location;
            map.setCenter(addrLocation);

            // store current coordinates into hidden variables
            document.getElementById('lat').value = results[0].geometry.location.lat();
            document.getElementById('lng').value = results[0].geometry.location.lng();

            // membuat objek info window
            infowindow = new google.maps.InfoWindow({
              content: address,
              position: addrLocation
            });

            // and then - add new custom marker
            addrMarker = new google.maps.Marker({
                position: addrLocation,
                map: map,
                // draggable: true,
                title: results[0].formatted_address,
                // icon: 'assets/image/marker.png',

                icon: {
                  labelOrigin: new google.maps.Point(45, 60),
                  url: 'assets/image/agi.png',
                  // size: new google.maps.Size(22, 40),
                  origin: new google.maps.Point(0, 0),
                  anchor: new google.maps.Point(30, 40),
                },
                animation: google.maps.Animation.DROP,
            });
            addrMarker.setMap(null);
            // addrMarker.addListener('click', toggleBounce);
            // Push your newly created marker into the array:
            // gmarkers.push(addrMarker);
            // event saat marker diklik
            addrMarker.addListener('click', function() {
              // tampilkan info window di atas marker
              infowindow.open(map, addrMarker);
            });

            //Clear for losing marker in location center
            //=========================================//
            if (gmarkers) {
                for (i in gmarkers) {
                    gmarkers[i].setMap(null);
                }
                gmarkers = [];
            }

            gmarkers.push(addrMarker);
            //=========================================//

        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}

//Icon Marker
function toggleBounce() {
  if (addrMarker.getAnimation() !== null) {
    addrMarker.setAnimation(null);
  } else {
    addrMarker.setAnimation(google.maps.Animation.BOUNCE);
  }
}

// find custom places function
function findPlaces() {

    // prepare variables (filter)
    var type = document.getElementById('gmap_type').value;
    var radius = document.getElementById('gmap_radius').value;
    // var keyword = document.getElementById('gmap_keyword').value;
    var keyword = 'artha graha';

    var lat = document.getElementById('lat').value;
    var lng = document.getElementById('lng').value;
    var cur_location = new google.maps.LatLng(lat, lng);
    // alert(cur_location);

    // prepare request to Places
    var request = {
        location: cur_location,
        radius: radius,
        types: [type]
    };
    if (keyword) {
        request.keyword = [keyword];
    }

    // send request
    service = new google.maps.places.PlacesService(map);
    service.search(request, createMarkers);
}




// create markers (from 'findPlaces' function)
function createMarkers(results, status) {
    if (status == google.maps.places.PlacesServiceStatus.OK) {
      // console.log(results);

        // if we have found something - clear map (overlays)
        clearOverlays();

        // and create new markers by search result
        for (var i = 0; i < results.length; i++) {
            createMarker(results[i]);
        }
    } else if (status == google.maps.places.PlacesServiceStatus.ZERO_RESULTS) {
        alert('Sorry, nothing is found');
    }
}

// creare single marker function
function createMarker(obj) {

    // prepare new Marker object
    var mark = new google.maps.Marker({
        position: obj.geometry.location,
        map: map,
        title: obj.name,
        icon:'assets/image/agi.png'
    });
    markers.push(mark);

    // prepare info window
    var infowindow = new google.maps.InfoWindow({
        content: '<img src="' + obj.icon + '" /><font style="color:#000;">' + obj.name +
        '<br />Rating: ' + obj.rating + '<br />Vicinity: ' + obj.vicinity + '</font>'
    });

    // add event handler to current marker
    google.maps.event.addListener(mark, 'click', function() {
        clearInfos();
        infowindow.open(map,mark);
    });
    infos.push(infowindow);
}

// initialization
google.maps.event.addDomListener(window, 'load', initialize);
