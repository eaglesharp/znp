


<!DOCTYPE html>

<html>

<head> 

<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Google Maps JavaScript API with Places Library Autocomplete Address Field</title> 

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<!-- Google Maps JavaScript library -->



<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyCejQVcKXrBxZGFj0EQpSHkLgOk_Lp6CRI"></script>

 

<style>
  .tooltip{ 
  position:relative;
  float:right;
}
.tooltip > .tooltip-inner {background-color: #eebf3f; padding:5px 15px; color:rgb(23,44,66); font-weight:bold; font-size:13px;}
.popOver + .tooltip > .tooltip-arrow {	border-left: 5px solid transparent; border-right: 5px solid transparent; border-top: 5px solid #eebf3f;}


.progress{
  border-radius:0;
  overflow:visible;
}
.progress-bar{
   background:rgb(23,44,60); 
  -webkit-transition: width 1.5s ease-in-out;
  transition: width 1.5s ease-in-out;
}


#search_input {font-size:18px;}

.form-group{

 margin-bottom: 10px;margin-top:50px;

}

.form-group label{

 font-size:18px;

 font-weight: 600;

}

.form-group input{

    width: 100%;

    padding: .375rem .75rem;

    font-size: 1rem;

    line-height: 1.5;

    color: #495057;

    background-color: #fff;

    background-clip: padding-box;

    border: 1px solid #ced4da;

    border-radius: .25rem;

    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;

}

.form-group input:focus {

    color: #495057;

    background-color: #fff;

    border-color: #80bdff;

    outline: 0;

    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);

}

</style>

</head>
<body class="bg-gray-100 leading-normal text-sm">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>

<script>
    $(document).ready(function(){
        $("#commentForm").validate();
    });

    function addInput() {

        var indexVal = 1;
        var index = parseInt(indexVal) + 1
        var obj = '<input id="list'+index+'" name=list['+index+']  class="required['+index+']" />'
        $("#parent").append(obj);

        $("#list"+index).rules("add", "required");
        $("#index").val(index)
    }
</script>

<form id="commentForm" method="get" action="">
    <input type="hidden" name="index" name="list[1]" id="index" value="1">
    <p id="parent">
        <input id="list1"  class="required" />
    </p>
    <input class="submit" type="submit" value="Submit"/>
    <input type="button" value="add" onClick="addInput()" />
</form>
  {{-- <section>
    <!--<h2 class="text-center">Scroll down the page a bit</h2><br><br> -->

         
  <div class="barWrapper">
   <span class="progressText"><B>HTML5</B></span>
  <div class="progress">
    <div class="progress-bar" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" >   
          <span  class="popOver" data-toggle="tooltip" data-placement="top" title="85%"> </span>     
  </div>
  </div>
  
  </div>
 
    </section>
    <div class="flex justify-center p-8">
        <div class="max-w-sm bg-white shadow-lg rounded overflow-hidden">
            <div class="w-full relative" id="js-preview-map"><img src="https://maps.googleapis.com/maps/api/staticmap?key=AIzaSyCejQVcKXrBxZGFj0EQpSHkLgOk_Lp6CRI&amp;center=52.5219216,13.4110207&amp;zoom=12&amp;size=480x125&amp;maptype=roadmap&amp;sensor=false" width="480" height="125" alt="Google Maps Berlin" /></div>
            <div class="w-full float-left border-b-2 border-gray-400 px-6 py-4"><label class="block text-gray-700 text-sm w-full font-semibold mb-2">Address:</label><input class="w-full bg-gray-200 text-gray-700 appearance-none rounded border-2 border-gray-300 py-2 px-4" type="text" id="address" /></div>
            <pre class="w-full bg-gray-200 text-blue-900 float-left px-6 py-4"><code id="js-preview-json"></code></pre>
        </div>
    </div>
    <div class="text-gray-600 text-xs text-center py-2 px-3 fixed bottom-0 right-0 z-10">Made by <a href="https://hofmannsven.com" target="_blank" rel="external noopener">Sven Hofmann</a>.</div>
    <div class="container">

<div class="row">

    <div class="col-lg-12">

        <p><h1>Google Maps JavaScript API with Places Library Autocomplete Address Field</h1></p>

<!-- Autocomplete location search input --> 

<div class="form-group">

<label>Location:</label>

<input type="text" class="form-control" id="search_input" placeholder="Type address..." />

</div>

 </div>

</div>

</div>

<script type="text/javascript">
  google.maps.event.addDomListener(window, 'load', function () {
      var places = new google.maps.places.Autocomplete(document.getElementById('txtPlace'));
      google.maps.event.addListener(places, 'place_changed', function () {
          var place = places.getPlace();
          var address = place.formatted_address;
          var latitude = place.geometry.location.lat();
          var longitude = place.geometry.location.lng();
          var latlng = new google.maps.LatLng(latitude, longitude);
          var geocoder = geocoder = new google.maps.Geocoder();
          geocoder.geocode({ 'latLng': latlng }, function (results, status) {
              if (status == google.maps.GeocoderStatus.OK) {
                  if (results[0]) {
                      var address = results[0].formatted_address;
                      var pin = results[0].address_components[results[0].address_components.length - 1].long_name;
                      var country = results[0].address_components[results[0].address_components.length - 2].long_name;
                      var state = results[0].address_components[results[0].address_components.length - 3].long_name;
                      var city = results[0].address_components[results[0].address_components.length - 4].long_name;
                      document.getElementById('txtCountry').value = country;
                      document.getElementById('txtState').value = state;
                      document.getElementById('txtCity').value = city;
                      document.getElementById('txtZip').value = pin;
                  }
              }
          });
      });
  });
</script>
<div id="locationField">
  <input id="autocomplete" placeholder="Enter your address" type="text" style="width: 100%"></input>
</div>
<table id="address">
  <tr>
      <td class="label">Street address</td>
      <td class="slimField">
          <input class="field" id="street_number"></input>
      </td>
      <td class="wideField" colspan="2">
          <input class="field" id="route"></input>
      </td>
  </tr>
  <tr>
      <td class="label">City</td>
      <td class="wideField" colspan="3">
          <input class="field" id="locality"></input>
      </td>
  </tr>
  <tr>
      <td class="label">State</td>
      <td class="slimField">
          <input class="field" id="administrative_area_level_1"></input>
      </td>
      <td class="label">Zip code</td>
      <td class="wideField">
          <input class="field" id="postal_code"></input>
      </td>
  </tr>
  <tr>
      <td class="label">Country</td>
      <td class="wideField" colspan="3">
          <input class="field" id="country"></input>
      </td>
  </tr>
  <tr>
      <td class="label">Lat</td>
      <td class="slimField">
          <input type="text" class="field" id="latitude"></input>
      </td>
      <td class="label">Long</td>
      <td class="wideField">
          <input type="text" class="field" id="longitude"></input>
      </td>
  </tr>
</table>


<script>

$(function () { 
  $('[data-toggle="tooltip"]').tooltip({trigger: 'manual'}).tooltip('show');
});  

// $( window ).scroll(function() {   
 // if($( window ).scrollTop() > 10){  // scroll down abit and get the action   
  $(".progress-bar").each(function(){
    each_bar_width = $(this).attr('aria-valuenow');
    $(this).width(each_bar_width + '%');
  });
       
 //  }  
// });



var searchInput = 'search_input';



$(document).ready(function () {

var autocomplete;

autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {

types: ['geocode'],

/*componentRestrictions: {

country: "USA"

}*/

});



google.maps.event.addListener(autocomplete, 'place_changed', function () {

var near_place = autocomplete.getPlace();

});

});

</script>
    <script>
        // Prepare location info object.
var locationInfo = {

  city: null,

  reset: function() {

    this.city = null;

  }
};

googleAutocomplete = {
  autocompleteField: function(fieldId) {
    (autocomplete = new google.maps.places.Autocomplete(
      document.getElementById(fieldId)
    )),
      { types: ["geocode"] };
    google.maps.event.addListener(autocomplete, "place_changed", function() {
      // Segment results into usable parts.
      var place = autocomplete.getPlace(),
        address = place.address_components,
        lat = place.geometry.location.lat(),
        lng = place.geometry.location.lng();

      // Reset location object.
      locationInfo.reset();

      // Save the individual address components.
      locationInfo.geo = [lat, lng];
      for (var i = 0; i < address.length; i++) {
        var component = address[i].types[0];
        switch (component) {
          case "country":
            locationInfo.country = address[i]["long_name"];
            break;
          case "administrative_area_level_1":
            locationInfo.state = address[i]["long_name"];
            break;
          case "locality":
            locationInfo.city = address[i]["long_name"];
           city_value = locationInfo.city;
           alert(city_value);
            break;
          case "postal_code":
            locationInfo.postalCode = address[i]["long_name"];
            break;
          case "route":
            locationInfo.street = address[i]["long_name"];
            break;
          case "street_number":
            locationInfo.streetNumber = address[i]["long_name"];
            break;
          default:
            break;
        }
      }

      // Preview map.
      var src =
          "https://maps.googleapis.com/maps/api/staticmap?key=AIzaSyCejQVcKXrBxZGFj0EQpSHkLgOk_Lp6CRI&center=" +
          lat +
          "," +
          lng +
          "&zoom=14&size=480x125&maptype=roadmap&sensor=false",
        img = document.createElement("img");

      img.src = src;
      img.className = "absolute top-0 left-0 z-20";
      document.getElementById("js-preview-map").appendChild(img);

      // Preview JSON output.
      document.getElementById("js-preview-json").innerHTML = JSON.stringify(
        locationInfo,
        null,
        4
      );
    });
  }
};

// Attach listener to address input field.
googleAutocomplete.autocompleteField("address");









// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

$("#autocomplete").on('focus', function () {
    geolocate();
});

var placeSearch, autocomplete;
var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    country: 'long_name',
    postal_code: 'short_name'
};

function initialize() {
    // Create the autocomplete object, restricting the search
    // to geographical location types.
    var options = {
  types: ['(cities)'],
  componentRestrictions: {country: "in"}
 };

    autocomplete = new google.maps.places.Autocomplete(
    /** @type {HTMLInputElement} */ (document.getElementById('autocomplete')), {
        types: ['geocode'],
        componentRestrictions: {
      		country: 'IN'
    		}
    });
    // When the user selects an address from the dropdown,
    // populate the address fields in the form.
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        fillInAddress();
    });
}

// [START region_fillform]
function fillInAddress() {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();

    document.getElementById("latitude").value = place.geometry.location.lat();
    document.getElementById("longitude").value = place.geometry.location.lng();

    for (var component in componentForm) {
        document.getElementById(component).value = '';
        document.getElementById(component).disabled = false;
    }

    // Get each component of the address from the place details
    // and fill the corresponding field on the form.
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
        }
    }
}
// [END region_fillform]

// [START region_geolocation]
// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var geolocation = new google.maps.LatLng(
            position.coords.latitude, position.coords.longitude);

            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            document.getElementById("latitude").value = latitude;
            document.getElementById("longitude").value = longitude;

            autocomplete.setBounds(new google.maps.LatLngBounds(geolocation, geolocation));
        });
    }

}

initialize();
// [END region_geolocation]
    </script> --}}



</body>

</html>

