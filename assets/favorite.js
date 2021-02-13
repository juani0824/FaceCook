/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/favorite.scss';

let favoriteButtons = Array.from(document.getElementsByClassName('favorite-data'));

favoriteButtons.forEach(favoriteButton => {
    favoriteButton.addEventListener('click', e => {
        e.preventDefault();
        let btn = e.currentTarget;
        let path = btn.dataset.path;
        let target = btn.dataset.target;
        fetch(path, {
            method: 'POST'
        })
            .then(response => {
                const favorite = document.getElementById(`${target}`);
                if (favorite.classList.contains('ri-heart-fill')) {
                    favorite.classList.replace('ri-heart-fill', 'ri-heart-line');
                } else {
                    favorite.classList.replace('ri-heart-line', 'ri-heart-fill');
                }
            })
    });
})
