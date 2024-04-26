/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';
import './styles/adminSidebar.scss';
import {Modal, Tooltip, Toast} from "bootstrap";
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

var toastElList = [].slice.call(document.querySelectorAll('.toast'))
var toastList = toastElList.map(function (toastEl) {
    return new Toast(toastEl)
})

toastList.forEach(toast => {
    toast.show();
})

const modalButtonTriggers = document.querySelectorAll('[data-modal-toggle="form"]');
const modalElement = document.getElementById('globalModal');

const bootstrapModal = new Modal(modalElement);

modalButtonTriggers.forEach((modalButtonTrigger) => {
    modalButtonTrigger.addEventListener('click', async function () {

        const modalTitle = modalButtonTrigger.getAttribute('data-modal-title');
        const modalHref = modalButtonTrigger.getAttribute('data-modal-href');

        if (bootstrapModal === null || bootstrapModal === undefined) {
            return
        }

        const modalLoader = modalElement.querySelector('#modal-loader');
        const modalError = modalElement.querySelector('#modal-error');
        const modalCustomContent = modalElement.querySelector('#modal-custom-content');

        modalLoader.classList.remove('d-none');
        modalError.classList.add('d-none');
        modalCustomContent.innerHTML = '';

        if (modalTitle) {
            modalElement.querySelector('.modal-title').innerHTML = modalTitle;
        }

        bootstrapModal.show();

        if (modalHref) {
            const response = await fetch(modalHref)

            modalLoader.classList.add('d-none');

            if (response.status === 200) {
                modalCustomContent.innerHTML = await response.text();
            } else {
                modalError.classList.remove('d-none');
            }
        }
    });
});
