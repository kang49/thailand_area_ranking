const form = document.querySelector('.search');
const input = form.querySelector('input');

form.addEventListener('submit', function(e) {
  e.preventDefault(); // Prevent the form from submitting

  const searchValue = input.value;
  
  // Call the function to search for the location on OpenStreetMap API
  searchLocation(searchValue);
});

// Define the Leaflet map instance outside of the displayLocationOnMap function
var map = L.map(
    "map_21a9caeaea6f1d79f9479e397f78d5c4",
    {
        center: [13.7541,100.5309],
        crs: L.CRS.EPSG3857,
        zoom: 13,
        zoomControl: true,
        preferCanvas: false,
    }
);

function searchLocation(searchValue) {
    const url = `https://nominatim.openstreetmap.org/search?q=${searchValue}&format=json`;
  
    fetch(url)
        .then(response => response.json())
        .then(data => {
        // The location data is returned as an array of objects
        const firstResult = data[0];
        const lat = firstResult.lat;
        const lon = firstResult.lon;
        // Call the function to display the location on the map
        displayLocationOnMap(lat, lon ,searchValue,null );
        })
        .catch(error => console.log(error));
}


let lastMarker;

displayLocationOnMap = function(lat, lon ,data)  {
    // Use the existing Leaflet map instance instead of creating a new one
    map.setView([lat, lon], 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; OpenStreetMap contributors',
        maxZoom: 18,
    }).addTo(map);
    
   // Remove the last marker if it exists
    if (lastMarker) {
        map.removeLayer(lastMarker);
    }
    
    const marker = L.marker([lat, lon]).addTo(map);
    
    // Bind a popup with data to the marker
    marker.bindPopup(`${data} location ${lat} ${lon}`).openPopup();
    
    // Store the current marker for future removal
    lastMarker = marker;
};

var tile_layer_4b1eafa64c057ad1d516aeb6ba27b84d = L.tileLayer(
    "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
    {"attribution": "Data by \u0026copy; \u003ca target=\"_blank\" href=\"http://openstreetmap.org\"\u003eOpenStreetMap\u003c/a\u003e, under \u003ca target=\"_blank\" href=\"http://www.openstreetmap.org/copyright\"\u003eODbL\u003c/a\u003e.", "detectRetina": false, "maxNativeZoom": 18, "maxZoom": 18, "minZoom": 0, "noWrap": false, "opacity": 1, "subdomains": "abc", "tms": false, }
).addTo(map);

const currentLocationButton = document.querySelector('#current-location-button');
currentLocationButton.addEventListener('click', () => {
  navigator.geolocation.getCurrentPosition(position => {
    const lat = position.coords.latitude;
    const lon = position.coords.longitude;
    // Call the function to display the location on the map
    displayLocationOnMap(lat, lon, "Current ");
  }, error => {
    console.log(error);
  });
});

var arlocations;
$(document).ready(function() {
  $.ajax({
    url: 'https://tar.tensormik.com/thailand_area_ranking/HeatMap_web/sql_get_data.php',
    type: 'POST',
    success: function(response) {
      arlocations = JSON.parse(response);
      var heatMap = L.heatLayer(arlocations.map(function(arr) {
        var latlng = arr[0].split(",");
        return [latlng[0], latlng[1], arr[1]];
      }), {
        max: 1,
        blur: 15,
        maxZoom: 16,
        minOpacity: 0.3,
        radius: 35
      }).addTo(map);
    },
  });
});


