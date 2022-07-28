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
    new App();
});

class App {
    constructor() {
        this.enableDropDowns();
        this.handleCommentForm();
    }
    enableDropDowns() {

        const btnToggle = document.getElementById('btn-toggle');
        const nav = document.getElementById('nav');
        btnToggle.addEventListener("click", () => { nav.classList.toggle('hidden') });
    }

    handleCommentForm() {
        const commentForm = document.querySelector('form.comment-form');

        if (null == commentForm) return;

        commentForm.addEventListener("submit", async (e) => {
            e.preventDefault();

            const response = await fetch('/ajax/comments', {
                method: 'POST',
                body: new FormData(e.target),
            });

            if (!response.ok) return;

            const json = await response.json();

            console.log(json);
        })

    }
}
