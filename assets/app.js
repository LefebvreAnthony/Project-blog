/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

//Attendre que le doc charge avant de lancer les fonctions
document.addEventListener('DOMContentLoaded', () => {
    enableDropDown();
});

const enableDropDown = () => {
    const menu = document.querySelector('header > nav > ul');
    const list = document.querySelectorAll('.dropDown');
    list.forEach(el => {
        el.addEventListener("click", () => {
            menu.classList.toggle('hidden');
        })
    });
};