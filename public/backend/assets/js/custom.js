/*
Template Name: Admin Pro Admin
Author: Wrappixel
Email: niravjoshi87@gmail.com
File: js
*/
$(function() {
    "use strict";
    $(function() {
        $(".preloader").fadeOut();
    });
    jQuery(document).on('click', '.mega-dropdown', function(e) {
        e.stopPropagation()
    });
    // ============================================================== 
    // This is for the top header part and sidebar part
    // ==============================================================  
    var set = function() {
        var width = (window.innerWidth > 0) ? window.innerWidth : this.screen.width;
        var topOffset = 0;
        if (width < 1170) {
            $("body").addClass("mini-sidebar");
            $('.navbar-brand span').hide();
            $(".sidebartoggler i").addClass("ti-menu");
        } else {
            $("body").removeClass("mini-sidebar");
            $('.navbar-brand span').show();
        }

        var height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $(".page-wrapper").css("min-height", (height) + "px");
        }

    };
    $(window).ready(set);
    $(window).on("resize", set);

    // ============================================================== 
    // Theme options
    // ==============================================================     
    $(".sidebartoggler").on('click', function() {
        if ($("body").hasClass("mini-sidebar")) {
            $("body").trigger("resize");
            $("body").removeClass("mini-sidebar");
            $('.navbar-brand span').show();
            
        } else {
            $("body").trigger("resize");
            $("body").addClass("mini-sidebar");
            $('.navbar-brand span').hide();
            
        }
    });

    // this is for close icon when navigation open in mobile view
    $(".nav-toggler").click(function() {
        $("body").toggleClass("show-sidebar");
        $(".nav-toggler i").toggleClass("ti-menu");
        $(".nav-toggler i").addClass("ti-close");
    });

    $(".search-box a, .search-box .app-search .srh-btn").on('click', function() {
        $(".app-search").toggle(200);
    });
    // ============================================================== 
    // Right sidebar options
    // ============================================================== 
    $(".right-side-toggle").click(function() {
        $(".right-sidebar").slideDown(50);
        $(".right-sidebar").toggleClass("shw-rside");
    });
    // ============================================================== 
    // This is for the floating labels
    // ============================================================== 
    $('.floating-labels .form-control').on('focus blur', function(e) {
        $(this).parents('.form-group').toggleClass('focused', (e.type === 'focus' || this.value.length > 0));
    }).trigger('blur');

    // ============================================================== 
    // Auto select left navbar
    // ============================================================== 
    $(function() {
        var url = window.location;
        var element = $('ul#sidebarnav a').filter(function() {
            return this.href == url;
        }).addClass('active').parent().addClass('active');
        while (true) {
            if (element.is('li')) {
                element = element.parent().addClass('in').parent().addClass('active');
            } else {
                break;
            }
        }

    });
    // ============================================================== 
    //tooltip
    // ============================================================== 
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
    // ============================================================== 
    //Popover
    // ============================================================== 
    $(function() {
        $('[data-toggle="popover"]').popover()
    })
    // ============================================================== 
    // Sidebarmenu
    // ============================================================== 
    $(function() {
        $('#sidebarnav').AdminMenu();
    });

    // ============================================================== 
    // Perfact scrollbar
    // ============================================================== 
    $('.scroll-sidebar, .right-side-panel, .message-center, .right-sidebar').perfectScrollbar();
    
    // ============================================================== 
    // Resize all elements
    // ============================================================== 
    $("body").trigger("resize");
    // ============================================================== 
    // To do list
    // ============================================================== 
    $(".list-task li label").click(function() {
        $(this).toggleClass("task-done");
    });

    

    // ============================================================== 
    // Collapsable cards
    // ==============================================================
    $('a[data-action="collapse"]').on('click', function(e) {
        e.preventDefault();
        $(this).closest('.card').find('[data-action="collapse"] i').toggleClass('ti-minus ti-plus');
        $(this).closest('.card').children('.card-body').collapse('toggle');

    });
    // Toggle fullscreen
    $('a[data-action="expand"]').on('click', function(e) {
        e.preventDefault();
        $(this).closest('.card').find('[data-action="expand"] i').toggleClass('mdi-arrow-expand mdi-arrow-compress');
        $(this).closest('.card').toggleClass('card-fullscreen');
    });

    // Close Card
    $('a[data-action="close"]').on('click', function() {
        $(this).closest('.card').removeClass().slideUp('fast');
    });

    $('.pagination a').on('click', function(event) {
        event.preventDefault();
        renderSection($(this).attr('href'));
    });

});

function showAlert(title, message, type){
    swal({   
        title: title,   
        text: message,   
        type: type,
        confirmButtonText: "OK",   
        closeOnConfirm: true 
    });
}

function confirmDelete(formId, btnId, titleAlert, textAlert, urlRender, render) {
    swal({
            title: titleAlert,
            text: textAlert,
            type: 'warning',
            allowOutsideClick: true,
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonClass: 'success',
            cancelButtonClass: 'danger',
            closeOnConfirm: true,
            closeOnCancel: true,
            confirmButtonText: 'Si, Eliminar',
            cancelButtonText: 'No, Cancelar',
          },
          function(isConfirm){
              if (isConfirm) {
                  var laddaBtn = Ladda.create(document.querySelector('#'+btnId));
                  laddaBtn.start();
                  laddaBtn.setProgress(0-1);
                  $.ajax({
                      type: $("#"+formId).attr('method'),
                      url: $("#"+formId).attr('action'),
                      data: $("#"+formId).serialize(),
                      dataType: "json",
                      beforeSend: function(){
                        laddaBtn.start();
                        laddaBtn.setProgress(0-1);
                      },
                      success: function (data) {
                        if(data.status === true){
                            swal({
                                title: titleAlert,
                                text: data.message,
                                type: 'success',
                                allowOutsideClick: true,
                                showConfirmButton: true,
                                showCancelButton: false,
                                confirmButtonClass: 'success',
                                cancelButtonClass: '',
                                closeOnConfirm: true,
                                closeOnCancel: true,
                                confirmButtonText: 'OK',
                                cancelButtonText: '',
                              },
                              function(){
                                if(render === true){
                                    renderSection(urlRender);
                                }else{
                                    location.href = urlRender;
                                }
                              }
                          );
                        }else{
                          swal({
                                title: titleAlert,
                                text: data.message,
                                type: 'error',
                                allowOutsideClick: true,
                                showConfirmButton: true,
                                showCancelButton: false,
                                confirmButtonClass: 'error',
                                cancelButtonClass: '',
                                closeOnConfirm: true,
                                closeOnCancel: true,
                                confirmButtonText: 'OK',
                                cancelButtonText: '',
                              }
                          );
                        }
                        laddaBtn.stop();
                      },
                      error: function(errors){
                        swal({
                                title: titleAlert,
                                text: 'No se pudo eliminar el registro, por favor intentelo nuevamente luego de unos minutos',
                                type: 'error',
                                allowOutsideClick: true,
                                showConfirmButton: true,
                                showCancelButton: false,
                                confirmButtonClass: 'error',
                                cancelButtonClass: '',
                                closeOnConfirm: true,
                                closeOnCancel: true,
                                confirmButtonText: 'OK',
                                cancelButtonText: '',
                              }
                          );
                        laddaBtn.stop();
                      }
                  });
                  return false;
              }
          }
    );
  }


  function renderSection(url){
    $.ajax({
        type: 'GET',
        url: url,
        dataType: 'json',
        beforeSend: function(){
            $(".preloader").show();
        },
        success: function (data) {
            if(data.type == 'html'){
                history.pushState(null, null, url);
                $('#mainPanel').empty().append($(data.mainContent));
                $('#scriptsDiv').empty().append($(data.scripts)); 
            }else{
                showAlert(data.title, data.message, data.class);
            }
            $(".preloader").fadeOut();
        },
        error: function (data) {
            $(".preloader").fadeOut();
            var errors = data.responseJSON;
            if (errors) {
                $.each(errors, function (i) {
                    console.log(errors[i]);
                });
            }
            showAlert('ERROR', 'Ups!. Parece que por el momento el sistema no esta disponible, por favor intentelo nuevamente luego de unos minutos', 'error');
        }
    });
  }

$(document).ready(function(){
    $(function() {
        $(".preloader").fadeOut();
    });
});