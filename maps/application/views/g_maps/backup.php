function initialize() {
  // var map = new google.maps.Map(document.getElementById("googleMap"));
  var geocoder = new google.maps.Geocoder();
  $("#varListKabko").change(function() {
    address = $("#varListKabko :selected")[0].text;
    geocodeAddress(address, geocoder);
  });
  var address = $("#varListKabko :selected")[0].text;
  geocodeAddress(address, geocoder);
}
google.maps.event.addDomListener(window, "load", initialize);

function geocodeAddress(address, geocoder, resultsMap) {
  document.getElementById('info').innerHTML = address;
  geocoder.geocode({
    'address': address
  }, function(results, status) {
    if (status === google.maps.GeocoderStatus.OK) {
      // resultsMap.fitBounds(results[0].geometry.viewport);
      document.getElementById('info').innerHTML += "<br>" + results[0].geometry.location.toUrlValue(6);
    }
    // else {
    //   alert('Geocode was not successful for the following reason: ' + status);
    // }
  });
}
