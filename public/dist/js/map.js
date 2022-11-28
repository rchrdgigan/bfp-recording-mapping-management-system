//Render the irosin map
var map = L.map('map').setView([12.6999972, 124.0333332], 15);
L.tileLayer( 'https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=CxC7aDuJcG77pDH5yjGS', {
    minZoom: 15,
    maxZoom: 22,
    attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>'
}).addTo(map);
