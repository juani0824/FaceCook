/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

import $ from 'jquery';
global.$ = global.jQuery = $;

import 'popper.js';
import 'bootstrap';

import 'magnific-popup';
import 'select2';
import 'slick-carousel';
import 'jquery-appear-original';
import 'jquery.counterup';

import 'lottie-web';

import SideclickModal from '../public/bundles/sideclickbootstrapmodal/javascript/sideclick_modal';
new SideclickModal();

// amcharts
//import '@amcharts/amcharts4';
//import '@amcharts/amcharts4-fonts';
// import '@amcharts/amcharts4-geodata';

import Scrollbar from 'smooth-scrollbar';

import './js/scripts';
import './js/panel_right';

// dropdown
$('.dropdown-toggle').dropdown();

$('[data-toggle="tooltip"]').tooltip();
$('[data-toggle="collapse"]').collapse({ toggle: false });

// Page loader
$("#load").fadeOut();
$("#loading").delay().fadeOut("");

// Scrollbar
if ($('#sidebar-scrollbar').length) {
    Scrollbar.init(document.querySelector('#sidebar-scrollbar'));
}

if ($('#right-sidebar-scrollbar').length) {
    Scrollbar.init(document.querySelector('#right-sidebar-scrollbar'));
}

// Select2
$('.select2jsMultiSelect').select2({
    tags: true
});

$(".custom-file-input").on("change", function () {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

// menu gauche
$(document).on('click', 'a.wrapper-menu', function() {
    $(this).toggleClass('open');
});

$(document).on('click', "a.wrapper-menu", function() {
    $("body").toggleClass("sidebar-main");
});


// Effet sur les liens du menu
$(document).on('click', ".iq-waves-effect", function(e) {
    // Remove any old one
    $('.ripple').remove();
    // Setup
    let posX = $(this).offset().left,
        posY = $(this).offset().top,
        buttonWidth = $(this).width(),
        buttonHeight = $(this).height();

    // Add the element
    $(this).prepend("<span class='ripple'></span>");


    // Make it round!
    if (buttonWidth >= buttonHeight) {
        buttonHeight = buttonWidth;
    } else {
        buttonWidth = buttonHeight;
    }

    // Get the center of the element
    let x = e.pageX - posX - buttonWidth / 2;
    let y = e.pageY - posY - buttonHeight / 2;


    // Add the ripples CSS and start the animation
    $(".ripple").css({
        width: buttonWidth,
        height: buttonHeight,
        top: y + 'px',
        left: x + 'px'
    }).addClass("rippleEffect");
});

// Suprimer une publication et supprimir un commentaire
function ConfirmDelete() {
    var resp = confirm("Etes-vous sûr de vouloir supprimer?");
    return resp === true;
}

function ConfirmDeletePublication() {
    var response = confirm("Etes-vous sûr de vouloir supprimer?");
    return response === true;
}

console.debug('app.js');

