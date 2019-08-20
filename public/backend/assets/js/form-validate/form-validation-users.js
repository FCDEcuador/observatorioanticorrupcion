function toggle(source, name) {
    checkboxes = document.getElementsByName(name);
    for(var i=0, n=checkboxes.length;i<n;i++) {
        checkboxes[i].checked = source.checked;
    }
}

var FormUserValidation = function() {

    var handleUserValidation = function() {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
        var userForm = $('#userForm');
        var errorUser = $('.alert-danger', userForm);
        var successUser = $('.alert-success', userForm);

        function isPasswordRequired(){
           var passblank = $("#password").val().length;
           if(passblank > 0){
              return true;
           }
           return false;
        }

        userForm.steps({
            headerTag: "h6"
            , bodyTag: "section"
            , transitionEffect: "fade"
            , titleTemplate: '<span class="step">#index#</span> #title#'
            , labels: {
                next: "Siguiente",
                previous: "Anterior",
                finish: "Validar"
            }
            , onStepChanging: function (event, currentIndex, newIndex) {
                return currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) && (currentIndex < newIndex && (userForm.find(".body:eq(" + newIndex + ") label.error").remove(), userForm.find(".body:eq(" + newIndex + ") .error").removeClass("error")), userForm.validate().settings.ignore = ":disabled,:hidden", userForm.valid())
            }
            , onFinishing: function (event, currentIndex) {
                return userForm.validate().settings.ignore = ":disabled", userForm.valid()
            }
            , onFinished: function (event, currentIndex) {
                 $('#userBtn').show();
                 //userForm.submit();
            }
        }), userForm.validate({
            errorElement: 'div', //default input error message container
            errorClass: 'form-control-feedback', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: {
                name: {
                    minlength: 2,
                    required: true
                },
                lastname: {
                    minlength: 2,
                    required: true
                },
                email: {
                    required: true,
                    email: true,
                    remote:{
                      url: urlValidateUser,
                      type: "post",
                      data: {
                        email: function() {
                          return $("#email").val();
                        }
                      }
                    }
                },
                avatar: {
                    accept: "image/*"
                },
                password: {
                    required: isPasswordRequired,
                    minlength: {
                      param: 6,
                      depends: isPasswordRequired
                    },
                    maxlength: {
                        param: 12,
                        depends: isPasswordRequired
                    }
                },
                password_confirmation: {
                    required:  isPasswordRequired,
                    minlength: {
                      param: 6,
                      depends: isPasswordRequired
                    },
                    maxlength: {
                        param: 12,
                        depends: isPasswordRequired
                    },
                    equalTo: {
                      param: "#password",
                      depends: isPasswordRequired
                    }
                },
                'roles[]': {
                    required: true,
                    minlength: 1,
                },
            },
            messages: {
                name: {
                    required: 'El nombre del usuario es obligatorio',
                    minlength: jQuery.validator.format("El nombre del usuario debe tener al menos {0} caracteres."),
                },
                lastname: {
                    required: 'El apellido del usuario es obligatorio',
                    minlength: jQuery.validator.format("El apellido del usuario debe tener al menos {0} caracteres."),
                },
                email: {
                    required: 'Por favor ingrese el email del usuario.',
                    email: 'Por favor ingrese un email válido.',
                    remote: 'Ya existe un usuario con esa direccion de email. Por favor ingrese otra',
                },
                avatar: {
                    accept: "Unicamente se aceptan archivos de imagenes",
                },
                password: {
                    required: 'Por favor ingrese la clave del usuario',
                    minlength: jQuery.validator.format("Por favor ingrese al menos {0} caracteres"),
                },
                password_confirmation: {
                    required: 'Por favor ingrese la confirmación de la clave del usuario',
                    minlength: jQuery.validator.format("Por favor ingrese al menos {0} caracteres"),
                    equalTo: 'La clave y la confirmación no coinciden',
                },
                'roles[]': {
                    required: 'Por favor seleccione el(los) roles para este usuario',
                    minlength: jQuery.validator.format("Seleccione Al menos {0} rol(es)"),
                },
            },

            invalidHandler: function(event, validator) { //display error alert on form submit              
                successUser.hide();
                errorUser.show();
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
                successUser.show();
                errorUser.hide();
                var laddaUserBtn = Ladda.create(document.querySelector('#userBtn'));
                laddaUserBtn.start();
                laddaUserBtn.setProgress(0-1);

                var frmData = new FormData();
                if($("#avatar")[0].files[0]){
                  frmData.append('avatar', $("#avatar")[0].files[0]);
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
                      laddaUserBtn.start();
                    },
                    success: function (data) {
                      if(data.status === true){
                        renderSection(urlUsersList);
                      }else{
                        swal({
                              title: 'BlaudCMS :: Usuarios',
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
                      laddaUserBtn.stop();
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
                              title: 'BlaudCMS :: Usuarios',
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
                      laddaUserBtn.stop();
                    }
                });
            }
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handleUserValidation();
        }
    };
}();

$(document).ready(function() {
    
    var form = $(".validation-wizard").show();

    $('#userBtn').hide();
    FormUserValidation.init();
    
    $('#avatar').dropify({
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