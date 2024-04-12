/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';
import './styles/adminSidebar.scss';
import { Toast, Collapse, Tooltip, Button} from "bootstrap";
import L from 'leaflet';

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new Tooltip(tooltipTriggerEl))

document.addEventListener('DOMContentLoaded', function() {
    var map = L.map('mapid').setView([51.505, -0.09], 13);
  
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
  });

const buttonsLoader = document.querySelectorAll('.btn-loader');

buttonsLoader.forEach(button => {
    button.addEventListener('click', (event) => {
        const parentForm = button.form;

        if (parentForm && parentForm.checkValidity()) {
            button.innerHTML = `
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Chargement...
        `;
            button.classList.toggle("disabled")
        }
    });
});
