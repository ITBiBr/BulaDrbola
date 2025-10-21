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
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

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
        $(this).closest(".casova-osa-element").addClass("casova-osa-zvyrazneny-element");
        $(this).closest(".casova-osa-element-levy").addClass("casova-osa-zvyrazneny-element-levy");
        $(".collapse").not(this).collapse('hide');
        // Změna textu tlačítka na "Zobrazit méně"
        var button = $(this).next(".toggle-btn");
        button.html("<svg width=\"12\" height=\"12\" viewBox=\"0 0 100 100\" xmlns=\"http://www.w3.org/2000/svg\"><polygon points=\"50,0 100,90 0,90\" fill=\"rgb(222, 174, 107)\"></polygon></svg>&nbsp;zobrazit méně");
    });

    $(".collapse").on("hide.bs.collapse", function () {
        $(this).closest(".casova-osa-element").removeClass("casova-osa-zvyrazneny-element");
        $(this).closest(".casova-osa-element-levy").removeClass("casova-osa-zvyrazneny-element-levy");
        // Změna textu tlačítka na "Zobrazit méně"
        var button = $(this).next(".toggle-btn");
        button.html("<svg width=\"12\" height=\"12\" viewBox=\"0 0 100 100\" xmlns=\"http://www.w3.org/2000/svg\"><polygon points=\"0,3.4 100,3.4 50,90\" fill=\"rgb(222, 174, 107)\"></polygon></svg>&nbsp;zobrazit více");
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

    let scrollTarget = null;
    let offset = 91; // výška fixed headeru

    // Při kliknutí si uložíme, kam chceme scrollovat
    $('.scroll-top-on-click').on('click', function () {
        scrollTarget = $(this).closest('.scroll-top');
    });

    // Po dokončení otevření collapse sekce provedeme scroll
    $('.collapse').on('shown.bs.collapse', function () {
        if (scrollTarget) {
            $('html, body').animate({
                scrollTop: scrollTarget.offset().top - offset
            }, 300);
            scrollTarget = null; // reset
        }
    });

    // Po zavření collapse (např. druhým klikem)
    $('.collapse').on('hidden.bs.collapse', function () {
        if (scrollTarget) {
            $('html, body').animate({
                scrollTop: scrollTarget.offset().top - offset
            }, 400);
            scrollTarget = null;
        }
    });
});