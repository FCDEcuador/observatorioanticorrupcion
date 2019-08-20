var FormProfileValidation = function() {

    var handleProfileValidation = function() {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
        var profileForm = $('#profileForm');
        var errorLogin = $('.alert-danger', profileForm);
        var successLogin = $('.alert-success', profileForm);

        function isPasswordRequired(){
           var passblank = $("#password").val().length;
           if(passblank > 0){
              return true;
           }
           return false;
        }

        profileForm.validate({
            errorElement: 'div', //default input error message container
            errorClass: 'form-control-feedback', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
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
                avatar: {
                    accept: "image/*"
                },
                password: {
                    required: isPasswordRequired,
                    minlength: {
                      param: 6,
                      depends: isPasswordRequired
                    }
                },
                password_confirmation: {
                    required:  isPasswordRequired,
                    minlength: {
                      param: 6,
                      depends: isPasswordRequired
                    },
                    equalTo: {
                      param: "#password",
                      depends: isPasswordRequired
                    }
                }
            },
            messages: {
                name: {
                    required: 'Por favor ingrese su nombre',
                    minlength: jQuery.validator.format("Su nombre debe tener al menos {0} caracteres."),
                },
                lastname: {
                    required: 'Por favor ingrese su apellido',
                    minlength: jQuery.validator.format("Su apellido debe tener al menos {0} caracteres."),
                },
                avatar: {
                    accept: "Unicamente archivos de imagenes (PNG, JPG, JPEG, GIF)",
                },
                password: {
                    required: 'Por favor ingrese su clave',
                    minlength: jQuery.validator.format("Por favor ingrese al menos {0} caracteres"),
                },
                password_confirmation: {
                    required: 'Por favor ingrese la confirmación de su clave',
                    minlength: jQuery.validator.format("Por favor ingrese al menos {0} caracteres"),
                    equalTo: 'La clave y la confirmación no coinciden',
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit              
                successLogin.hide();
                errorLogin.show();
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
                successLogin.show();
                errorLogin.hide();
                var laddaProfileBtn = Ladda.create(document.querySelector('#profileBtn'));
                laddaProfileBtn.start();
                laddaProfileBtn.setProgress(0-1);

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
                      laddaProfileBtn.start();
                    },
                    success: function (data) {
                      if(data.status === true){
                          renderSection(urlProfile);
                          swal({
                                title: 'Cuponcity.ec :: Mi Perfil',
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
                              title: 'Cuponcity.ec :: Mi Perfil',
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
                      laddaProfileBtn.stop();
                    },
                    error: function(errors){
                      var resp = '';
                      var errorsHtml = '';
                      var errors = errors.responseJSON;
                      $.each(errors.errors, function (key, value) {
                        errorsHtml += '\n'+value;
                      });
                      if(errorsHtml != ''){
                        resp = 'Ups! no se pudo actualizar su informacion debido a los siguientes errores: '+errorsHtml;
                      }else{
                        resp = 'Ups! parece que de momento el sistema no está disponible, por favor intentalo nuevamente en unos minutos.';
                      }
                      swal({
                              title: 'Cuponcity.ec :: Mi Perfil',
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
                      laddaProfileBtn.stop();
                    }
                });
            }
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handleProfileValidation();
        }
    };
}();