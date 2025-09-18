/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
//import './styles/app.css';
import './styles/global.scss';

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
    //Při načtení stránky
    toggleScrolledClass();
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

    $(".collapse").on("show.bs.collapse", function () {
        $(this).closest(".casova-osa-element").addClass("casova-osa-zvyrazeny-element");
        $(this).closest(".casova-osa-element-levy").addClass("casova-osa-zvyrazeny-element-levy");
        $(".collapse").not(this).collapse('hide');
        // Změna textu tlačítka na "Zobrazit méně"
        var button = $(this).next(".toggle-btn");
        button.html("&#9650; zobrazit méně");
    });

    $(".collapse").on("hide.bs.collapse", function () {
        $(this).closest(".casova-osa-element").removeClass("casova-osa-zvyrazeny-element");
        $(this).closest(".casova-osa-element-levy").removeClass("casova-osa-zvyrazeny-element-levy");
        // Změna textu tlačítka na "Zobrazit méně"
        var button = $(this).next(".toggle-btn");
        button.html("&#9660; zobrazit více");
    });

    var $carousel = $('#carouselCasovaOsa'); // Výběr carouselu
    var $indicators = $carousel.find('.carousel-item button'); // Všechny indikátory
    var totalItems = $indicators.length; // Počet snímků
    var $prevButton = $carousel.find('.carousel-control-prev'); // Tlačítko "Předchozí"
    var $nextButton = $carousel.find('.carousel-control-next'); // Tlačítko "Další"
    function updateIndicators() {
        var activeIndex = $carousel.find('.carousel-item.active').index(); // Získání aktuálního indexu

        // Skryjeme všechny indikátory
        $indicators.removeClass('active');

        // Zobrazíme jen ten aktuální
        $indicators.eq(activeIndex).addClass('active');
    }

    function updateButtons() {
        var activeIndex = $carousel.find('.carousel-item.active').index(); // Aktuální index

        // Skryj "Předchozí" na prvním snímku
        if (activeIndex === 0) {
            $prevButton.hide();
        } else {
            $prevButton.show();
        }

        // Skryj "Další" na posledním snímku
        if (activeIndex === totalItems - 1) {
            $nextButton.hide();
        } else {
            $nextButton.show();
        }
    }

    // Spustí se při změně snímku
    $carousel.on('slid.bs.carousel', function() {
        updateIndicators();
        updateButtons();
    });

    // Inicializace při načtení stránky
    updateButtons();

});