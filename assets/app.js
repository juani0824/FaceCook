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

// amcharts
//import '@amcharts/amcharts4';
//import '@amcharts/amcharts4-fonts';
// import '@amcharts/amcharts4-geodata';

import Scrollbar from 'smooth-scrollbar';

import './scripts';
import './custom';

if ($('#sidebar-scrollbar').length) {
    Scrollbar.init(document.querySelector('#sidebar-scrollbar'));
}

if ($('#right-sidebar-scrollbar').length) {
    Scrollbar.init(document.querySelector('#right-sidebar-scrollbar'));
}

$(".custom-file-input").on("change", function () {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
