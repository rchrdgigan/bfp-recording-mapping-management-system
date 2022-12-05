var LeafIcon = L.Icon.extend({
    options: {
        iconSize:     [64, 64],
        iconAnchor:   [33, 55],
        popupAnchor:  [0, -40]
    }
});

var office = new LeafIcon({iconUrl: '/image/office.png'}),
    store = new LeafIcon({iconUrl: '/image/store.png'});

L.icon = function (options) {
    return new L.Icon(options);
};

//Render the irosin map
var map = L.map('map').setView([12.703562025451129, 124.03654038906099], 15);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    minZoom: 15,
    maxZoom: 22,
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);
