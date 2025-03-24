/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
//import './styles/app.css';
import './styles/global.scss';
import './styles/clash-display.css';

const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

$(document).ready(function () {
    let navbar = $("#navbar");
    let navbarCollapse = $(".navbar-collapse"); // ID collapsible menu

    function toggleScrolledClass() {
        if ($(window).scrollTop() > 15 || navbarCollapse.hasClass("show")) {
            navbar.addClass("scrolled");
        } else {
            navbar.removeClass("scrolled");
        }
    }

    // Při scrollování
    $(window).scroll(toggleScrolledClass);

    // Při rozbalení menu
    navbarCollapse.on("show.bs.collapse", function () {
        navbar.addClass("toggled");
    });

    // Při sbalení menu (zkontrolujeme i pozici stránky)
    navbarCollapse.on("hide.bs.collapse", function () {
        navbar.removeClass("toggled");
    });
});