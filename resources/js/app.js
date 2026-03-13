import './bootstrap';
import Swal from 'sweetalert2';
import Alpine from 'alpinejs';

window.Swal = Swal;
window.Alpine = Alpine;

Alpine.start();

// Toggle del sidebar en móviles
$(document).ready(function() {
    // Toggle sidebar en móviles
    $('#mobile-sidebar-toggle').click(function() {
        $('#sidebar').toggleClass('-ml-64');
    });
    
    // Cerrar sidebar en móviles
    $('#sidebar-toggle').click(function() {
        $('#sidebar').addClass('-ml-64');
    });
    
    // Toggle submenús
    $('.menu-toggle').click(function() {
        const submenu = $(this).next('.submenu');
        const icon = $(this).find('.fa-chevron-down');
        
        // Cerrar otros submenús
        $(this).parent().siblings().find('.submenu').slideUp();
        $(this).parent().siblings().find('.fa-chevron-down').removeClass('rotate-180');
        
        // Toggle submenu actual
        submenu.slideToggle();
        icon.toggleClass('rotate-180');
    });
    
    // Cerrar sidebar al hacer clic en enlace (solo en móviles)
    if ($(window).width() < 768) {
        $('#sidebar a').click(function() {
            $('#sidebar').addClass('-ml-64');
        });
    }
    
    // Ajustar sidebar en redimensionamiento
    $(window).resize(function() {
        if ($(window).width() >= 768) {
            // En desktop, mostrar sidebar siempre
            $('#sidebar').removeClass('-ml-64');
        } else {
            // En móviles, ocultar sidebar
            $('#sidebar').addClass('-ml-64');
        }
    });
    
    // Estado inicial
    if ($(window).width() < 768) {
        $('#sidebar').addClass('-ml-64');
    }
});