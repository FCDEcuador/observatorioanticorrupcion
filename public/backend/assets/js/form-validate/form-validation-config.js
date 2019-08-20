$(document).ready(function() {
    FormConfigValidation.init();

    $('#backend_logo').dropify({
        messages: {
            default: 'Arrastre un archivo hasta este lugar o de un clic para seleccionar uno',
            replace: 'Arrastre un archivo hasta este lugar o de un clic para seleccionar uno',
            remove: 'Quitar',
            error: 'Ups! parece que algo no esta bien'
        },
        error: {
            'fileSize': 'El archivo es demasiado grande. ({{ value }} maximo).',
            'minWidth': 'La imagen es muy pequeña. ({{ value }}}px minimo).',
            'maxWidth': 'El ancho de la imagen es muy grande. ({{ value }}}px maximo).',
            'minHeight': 'El alto de la imagen es muy pequeño. ({{ value }}}px minimo).',
            'maxHeight': 'El alto de la imagen es muy grande. ({{ value }}px maximo).',
            'imageFormat': 'Este formato no esta permitido. ({{ value }} unicamente).'
        }
    });

    $('#frontend_logo').dropify({
        messages: {
            default: 'Arrastre un archivo hasta este lugar o de un clic para seleccionar uno',
            replace: 'Arrastre un archivo hasta este lugar o de un clic para seleccionar uno',
            remove: 'Quitar',
            error: 'Ups! parece que algo no esta bien'
        },
        error: {
            'fileSize': 'El archivo es demasiado grande. ({{ value }} maximo).',
            'minWidth': 'La imagen es muy pequeña. ({{ value }}}px minimo).',
            'maxWidth': 'El ancho de la imagen es muy grande. ({{ value }}}px maximo).',
            'minHeight': 'El alto de la imagen es muy pequeño. ({{ value }}}px minimo).',
            'maxHeight': 'El alto de la imagen es muy grande. ({{ value }}px maximo).',
            'imageFormat': 'Este formato no esta permitido. ({{ value }} unicamente).'
        }
    });
});

var FormConfigValidation = function() {

    var handleConfigValidation = function() {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
        var configForm = $('#configForm');
        var errorConfig = $('.alert-danger', configForm);
        var successConfig = $('.alert-success', configForm);

        configForm.validate({
            errorElement: 'div', //default input error message container
            errorClass: 'form-control-feedback', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: {
                facebook_account: {
                    url: true
                },
                twitter_account: {
                    url: true
                },
                instagram_account: {
                    url: true
                },
                googleplus_account: {
                    url: true
                },
                pinterest_account: {
                    url: true
                },
                linkedin_account: {
                    url: true
                },
                youtube_account: {
                    url: true
                },
                vimeo_account: {
                    url: true
                },
                admin_email: {
                    email: true
                },
                backend_logo: {
                  accept: "image/*"
                },
                frontend_logo: {
                  accept: "image/*"
                }
            },
            messages: {
                facebook_account: {
                    url: 'Por favor ingrese una direccion de Facebook valida. (Recuerde agregar http:// o https:// al inicio de la URL)'
                },
                twitter_account: {
                    url: 'Por favor ingrese una direccion de Twitter valida. (Recuerde agregar http:// o https:// al inicio de la URL)'
                },
                instagram_account: {
                    url: 'Por favor ingrese una direccion de Instagram valida. (Recuerde agregar http:// o https:// al inicio de la URL)'
                },
                googleplus_account: {
                    url: 'Por favor ingrese una direccion de Google+ valida. (Recuerde agregar http:// o https:// al inicio de la URL)'
                },
                pinterest_account: {
                    url: 'Por favor ingrese una direccion de Pinterest valida. (Recuerde agregar http:// o https:// al inicio de la URL)'
                },
                linkedin_account: {
                    url: 'Por favor ingrese una direccion de Linkedin valida. (Recuerde agregar http:// o https:// al inicio de la URL)'
                },
                youtube_account: {
                    url: 'Por favor ingrese una direccion de Youtube valida. (Recuerde agregar http:// o https:// al inicio de la URL)'
                },
                vimeo_account: {
                    url: 'Por favor ingrese una direccion de Vimeo valida. (Recuerde agregar http:// o https:// al inicio de la URL)'
                },
                admin_email: {
                    email: 'Por favor ingrese una cuenta de email válida.'
                },
                backend_logo: {
                  accept: "Unicamente se aceptan archivos de imagenes (JPG, PNG, GIF)"
                },
                frontend_logo: {
                  accept: "Unicamente se aceptan archivos de imagenes (JPG, PNG, GIF)"
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit              
                successConfig.hide();
                errorConfig.show();
            },

            errorPlacement: function(error, element) {
                if (element.is(':checkbox')) {
                    error.insertAfter(element.closest(".md-checkbox-list, .md-checkbox-inline, .checkbox-list, .checkbox-inline"));
                } else if (element.is(':radio')) {
                    error.insertAfter(element.closest(".md-radio-list, .md-radio-inline, .radio-list,.radio-inline"));
                } else {
                    error.insertAfter(element); // for other inputs, just perform default behavior
                }
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-danger'); // set error class to the control group
                $(element)
                    .closest('.form-control').addClass('form-control-danger'); // set error class to the control group
            },

            unhighlight: function(element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-danger'); // set error class to the control group
                $(element)
                    .closest('.form-control').removeClass('form-control-danger'); // set error class to the control group
            },

            success: function(label) {
                label
                    .closest('.form-group').removeClass('has-danger'); // set success class to the control group
                label
                    .closest('.form-control').removeClass('form-control-danger'); // set success class to the control group
            },

            submitHandler: function(form) {
                successConfig.show();
                errorConfig.hide();
                var laddaConfigBtn = Ladda.create(document.querySelector('#configBtn'));
                laddaConfigBtn.start();
                laddaConfigBtn.setProgress(0-1);

                var frmData = new FormData();
                if($("#backend_logo")[0].files[0]){
                  frmData.append('backend_logo', $("#backend_logo")[0].files[0]);
                }

                if($("#frontend_logo")[0].files[0]){
                  frmData.append('frontend_logo', $("#frontend_logo")[0].files[0]);
                }

                var other_data = $(form).serializeArray();
                $.each(other_data,function(key,input){
                    frmData.append(input.name,input.value);
                });

                $.ajax({
                    type: $(form).attr('method'),
                    url: $(form).attr('action'),
                    data: frmData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                      laddaConfigBtn.start();
                    },
                    success: function (data) {
                      if(data.status === true){
                          renderSection($(form).attr('action'));
                          swal({
                                title: 'BlaudCMS :: Configuration',
                                text: data.message,
                                type: 'success',
                                allowOutsideClick: true,
                                showConfirmButton: true,
                                showCancelButton: false,
                                confirmButtonClass: 'text-success',
                                cancelButtonClass: '',
                                closeOnConfirm: true,
                                closeOnCancel: true,
                                confirmButtonText: 'OK',
                                cancelButtonText: '',
                              }
                          );
                      }else{
                        swal({
                              title: 'BlaudCMS :: Configuration',
                              text: data.message,
                              type: 'error',
                              allowOutsideClick: true,
                              showConfirmButton: true,
                              showCancelButton: false,
                              confirmButtonClass: 'text-danger',
                              cancelButtonClass: '',
                              closeOnConfirm: true,
                              closeOnCancel: true,
                              confirmButtonText: 'OK',
                              cancelButtonText: '',
                            }
                        );
                      }
                      laddaConfigBtn.stop();
                    },
                    error: function(errors){
                      var resp = '';
                      var errorsHtml = '';
                      var errors = errors.responseJSON;
                      $.each(errors.errors, function (key, value) {
                        errorsHtml += '\n'+value;
                      });
                      if(errorsHtml != ''){
                        resp = 'Ups! no se pudo actualizar la informacion debido a los siguientes errores: '+errorsHtml;
                      }else{
                        resp = 'Ups! parece que de momento el sistema no está disponible, por favor intentalo nuevamente en unos minutos.';
                      }
                      swal({
                              title: 'BlaudCMS :: Configuration',
                              text: resp,
                              type: 'error',
                              allowOutsideClick: true,
                              showConfirmButton: true,
                              showCancelButton: false,
                              confirmButtonClass: 'text-danger',
                              cancelButtonClass: '',
                              closeOnConfirm: true,
                              closeOnCancel: true,
                              confirmButtonText: 'OK',
                              cancelButtonText: '',
                            }
                        );
                      laddaConfigBtn.stop();
                    }
                });
            }
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handleConfigValidation();
        }
    };
}();