import './styles/app.scss';
import './styles/adminSidebar.scss';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

// Assurez-vous que ces URL correspondent à l'emplacement réel des images sur votre serveur
L.Icon.Default.mergeOptions({
    iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
    iconUrl: require('leaflet/dist/images/marker-icon.png'),
    shadowUrl: require('leaflet/dist/images/marker-shadow.png')
});

document.addEventListener('DOMContentLoaded', function() {
    var map = L.map('mapid').setView([51.505, -0.09], 13);
  
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
});
