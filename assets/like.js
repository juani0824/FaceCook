/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/like.scss';

let likeButtons = Array.from(document.getElementsByClassName('like-data'));

likeButtons.forEach(btn => {
    btn.addEventListener('click', e => {
        e.preventDefault();
        let btn = e.currentTarget;
        let path = btn.dataset.path;
        let target = btn.dataset.target;
        let nbLikes = Number(btn.dataset.nblikes);
        fetch(path, {
            method: 'POST'
        })
            .then(response => response.json())
            .then(data => {
                const likesText = document.getElementById(`nb_likes_${target}`);
                data.toString() === '-' ? nbLikes-- : nbLikes++;

                const thumb = document.getElementById(`thumb_${target}`);
                if (thumb.classList.contains('ri-thumb-up-fill')) {
                    thumb.classList.replace('ri-thumb-up-fill', 'ri-thumb-up-line');
                } else {
                    thumb.classList.replace('ri-thumb-up-line', 'ri-thumb-up-fill');
                }

                likesText.innerText = `${nbLikes} J'aime`;
                btn.dataset.nblikes = nbLikes;
            })
    })
});
