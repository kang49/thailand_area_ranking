const form = document.querySelector('.search');
const input = form.querySelector('input');

form.addEventListener('submit', function (e) {
  e.preventDefault(); // Prevent the form from submitting

  const searchValue = input.value;

  // Call the function to search for the location on OpenStreetMap API
  searchLocation(searchValue);
});


// Define the Leaflet map instance outside of the displayLocationOnMap function
var map = L.map(
  "map_21a9caeaea6f1d79f9479e397f78d5c4",
  {
    center: [13.7541, 100.5309],
    crs: L.CRS.EPSG3857,
    zoom: 13,
    preferCanvas: false,
    zoomControl: false
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
      displayLocationOnMap(lat, lon, searchValue);
    })
    .catch(error => console.log(error));
}


let lastMarker;

displayLocationOnMap = function (lat, lon, data, multiple=false) {
  // Use the existing Leaflet map instance instead of creating a new one
  map.setView([lat, lon], 13);

  L.tileLayer('https://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; OpenStreetMap contributors',
    maxZoom: 18,
  }).addTo(map);

  // Remove the last marker if it exists
  if (lastMarker) {
    if (lastMarker.isArray()) {
      while (i < lastMarker.length) {
        map.removeLayer(lastMarker[i])
        i++
      }
    } else {
    map.removeLayer(lastMarker);
    }
  }

  if (multiple) {
    var xhr = new XMLHttpRequest();
    var data = { 
      "lat": lat, 
      "lon": lon 
    };
    var json = JSON.stringify(data);

    // open the connection to the server
    xhr.open("POST", "get_locations.php", true);

    // set the content type header to JSON
    xhr.setRequestHeader("Content-type", "application/json");

    // handle the server response
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
        }
    };

    // send the request to the server
    xhr.send(json);

    
  } else {

    const marker = L.marker([lat, lon]).addTo(map);

    // Bind a popup with data to the marker
    marker.bindPopup(`${data} location ${lat} ${lon}`).openPopup();

    // Store the current marker for future removal
    lastMarker = marker;
  }

};

var tile_layer_4b1eafa64c057ad1d516aeb6ba27b84d = L.tileLayer(
  "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
  { "attribution": "Data by \u0026copy; \u003ca target=\"_blank\" href=\"http://openstreetmap.org\"\u003eOpenStreetMap\u003c/a\u003e, under \u003ca target=\"_blank\" href=\"http://www.openstreetmap.org/copyright\"\u003eODbL\u003c/a\u003e.", "detectRetina": false, "maxNativeZoom": 18, "maxZoom": 18, "minZoom": 0, "noWrap": false, "opacity": 1, "subdomains": "abc", "tms": false, }
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

// กำหนดตัวแปร heatMapLayer ให้เป็น global variable
var heatMapLayer;

// เมื่อรับ Event ชื่อ phpData จากไฟล์ get_obj.js
document.addEventListener('phpData', function (event) {
  // ดึงข้อมูลจาก Event.detail
  var phpData = event.detail;

  // ถ้ามี heatmap layer อยู่แล้วให้ลบออกก่อน
  if (heatMapLayer) {
    map.removeLayer(heatMapLayer);
  }

  // สร้าง heatmap layer ใหม่
  heatMapLayer = L.heatLayer(phpData.map(function (arr) {
    return [arr[0], arr[1], arr[2]];
  }), {
    max: 1,
    blur: 15,
    maxZoom: 16,
    minOpacity: 0.3,
    radius: 35
  }).addTo(map);
});


// สร้าง Icon object ด้วย Font Awesome
var faIcon = L.divIcon({
  html: '<i class="fas fa-map-marker-alt"></i>',
  iconSize: [30, 30], // ขนาดของ Icon
  className: "fontawesome-icon" // ชื่อ class สำหรับ Icon
});


map.on("click", function(event) {
  // ลบ Marker ล่าสุดออกจาก Map (หากมี)
  if (lastMarker) {
    map.removeLayer(lastMarker);
  }
  // ดึงตำแหน่งที่คลิกจาก event
  var latlng = event.latlng;
  // สร้าง Marker ในตำแหน่งที่คลิก
  var marker = L.marker(latlng, { icon: faIcon }).addTo(map);
  // เก็บ Marker ในตัวแปร lastMarker
  lastMarker = marker;

  marker.bindPopup('point ' + latlng).openPopup()
  
  // แสดงตำแหน่งที่คลิกใน Console
  console.log(latlng);
});
