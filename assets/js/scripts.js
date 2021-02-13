
// variables
const formulario = document.getElementById('publication_contenu')
const image = document.getElementById('publication_image')
const botonPublicar = document.querySelector('.btn-public')
const imagenFileInput = $('#publication_imageFile_file')
imagenFileInput.change(function () {
    botonPublicar.removeAttribute('hidden')
    botonPublicar.removeAttribute('disabled')
})


// Events
if (formulario != null && botonPublicar != null) {
    // por le focus
    formulario.addEventListener('focus', function () {

        // Supprimer l'attribut hidden de HTML
        botonPublicar.removeAttribute('hidden')
    })

    // pour le  Blur
    formulario.addEventListener('blur', function () {

        // Si la valeur du  textarea es égal à un string vide, y no hay Imagenes
        if (formulario.value === '') {
            botonPublicar.setAttribute('hidden', true)
        }
    })

    // quand se fais clique sur le bouton
    formulario.addEventListener('keyup', function () {

        // Nous ne pouvons publier que s'il y a du texte dans la zone de texte ou image
        if (formulario.value != '') {
            botonPublicar.removeAttribute('disabled')
        } else {
            botonPublicar.setAttribute('disabled', true)
        }
    })
}


// Events
if (image != null && botonPublicar != null) {
    // por le focus
    image.addEventListener('focus', function () {

        // Supprimer l'attribut hidden de HTML
        botonPublicar.removeAttribute('hidden')
    })

    // pour le  Blur
    image.addEventListener('blur', function () {

        // Si la valeur du  textarea es égal à un string vide, y no hay Imagenes
        if (image.value === '') {
            botonPublicar.setAttribute('hidden', true)
        }
    })

    // quand se fais clique sur le bouton
    formulario.addEventListener('keyup', function () {

        // Nous ne pouvons publier que s'il y a du texte dans la zone de texte, Y hay Imagenes
        if (image.value != '') {
            botonPublicar.removeAttribute('disabled')
        } else {
            botonPublicar.setAttribute('disabled', true)
        }
    })
}


// Commentaires
const postArea = document.getElementsByClassName('post-area')

if (postArea != null) {
    for (let i = 0; i < postArea.length; i++) {
        postArea[i].addEventListener('click', toggleComentaires)
        postArea[i].addEventListener('click', reaccionar)
    }

    // Afficher les commentaires
    function toggleComentaires(e) {
        if (e.target.classList.contains('coment-button')) {
            e.preventDefault()
            let comentairesArea = e.target.parentElement.parentElement.parentElement.parentElement.nextElementSibling
            if (comentairesArea.classList.contains('d-none')) {
                comentairesArea.classList.remove('d-none')
                e.target.style.color = '#246176'
                e.target.style.textShadow = '1px 1px 3px rgba(0, 0, 0, .3)'
            } else {
                comentairesArea.classList.add('d-none')
                e.target.style.color = ''
                e.target.style.textShadow = 'none'
            }
        }

        // Marquer les favoris
        if (e.target.classList.contains('favorite')) {
            if (e.target.style.color === '') {
                e.target.style.color = '#ffd335'
                e.target.style.textShadow = '1px 1px 3px rgba(0, 0, 0, .3)'
            } else {
                e.target.style.color = ''
                e.target.style.textShadow = 'none)'
            }
        }
    }

    // Reaction like not like...
    function reaccionar(e) {
        if (e.target.classList.contains('reaction')) {
            const datos = new FormData();
            datos.append("idpost", e.target.dataset.postid);
            const xhr = new XMLHttpRequest();
            xhr.open('post', 'http://127.0.0.1:8000/likes', true);
            xhr.onreadystatechange = function () {

                if (this.readyState === 4 && this.status === 200) {
                    console.log(this.responseText)
                }
            }
            xml.send(datos);



        }
    }
}


// Sidebar Right , Catégories 
const sidebarPC = document.getElementById('sidebarPostsCategories')
const btnTogglerSPC = document.getElementById('btnTogglePostCategories')

if (btnTogglerSPC) { //comprobar que existe y regresa null si no existe.

    btnTogglerSPC.addEventListener('click', showSidebarPC)
}

let click = true

function showSidebarPC() {
    if (click) {
        sidebarPC.classList.add('showS')
        btnTogglerSPC.querySelector('i').className = 'fa fa-arrow-right'
        click = false
    } else {
        sidebarPC.classList.remove('showS')
        btnTogglerSPC.querySelector('i').className = 'fa fa-arrow-left'
        click = true
    }
}

// Toggle password
const btnTogglePassword = document.getElementById('toggle-password')
const campoPassword = document.getElementById('password')

if (btnTogglePassword != null && campoPassword != null) {
    // Events
    btnTogglePassword.addEventListener('click', changeType)

    // Fonctions
    function changeType(e) {
        if (campoPassword.getAttribute('type') === 'password') {
            campoPassword.setAttribute('type', 'text')
            btnTogglePassword.querySelector('i').className = 'fa fa-eye-slash'
        } else {
            campoPassword.setAttribute('type', 'password')
            btnTogglePassword.querySelector('i').className = 'fa fa-eye'
        }
    }

}

// PHOTO PROFIL OU Avatar , ver  el nombre del fichero que se va a subir

$(document).ready(function () {


    var readURL = function (input) {
        if (input.file && input.file[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.avatar').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }


    $("#registration_form_imageFile_file").on('change', function () {
        readURL(this);
    });
});