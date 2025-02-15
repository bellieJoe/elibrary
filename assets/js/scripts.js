/*!
    * Start Bootstrap - SB Admin v7.0.7 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2023 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    // 
// Scripts
// 
$(function(){

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

    $(".toggle-loader").click(function(e){
        // e.preventDefault();
        console.log("clicked")
        $(this).prop("disabled", true);
        $(this).addClass("disabled");
        $(this).prepend(`<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span</div>`);
        $(this).closest("form").submit();
    });

    const datatablesSimple = $('.data-table');

    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple);
    }
});




