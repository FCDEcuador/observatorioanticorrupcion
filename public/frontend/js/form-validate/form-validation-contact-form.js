var contactFormValidation = function() {

    var handleContactFormValidation = function() {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
        var contactForm = $('#contactForm');
        var errorContact = $('.alert-danger', contactForm);
        var successContact = $('.alert-success', contactForm);

        contactForm.validate({
            errorElement: 'div', //default input error message container
            errorClass: 'form-control-feedback', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                subject: {
                    required: true
                },
                message: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: 'Por favor ingrese su nombre'
                },
                email: {
                    required: 'Por favor ingrese su email',
                    email: 'Por favor ingrese un email válido'
                },
                subject: {
                    required: 'Por favor ingrese el asunto'
                },
                message: {
                    required: 'Por favor agregue el mensaje'
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit              
                successContact.hide();
                errorContact.show();
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
                successContact.show();
                errorContact.hide();
                var laddaContactBtn = Ladda.create(document.querySelector('#contactSendBtn'));
                laddaContactBtn.start();
                laddaContactBtn.setProgress(0-1);
                $.ajax({
                    type: $(form).attr('method'),
                    url: $(form).attr('action'),
                    data: $(form).serialize(),
                    dataType: "json",
                    beforeSend: function(){
                      laddaContactBtn.start();
                    },
                    success: function (data) {
                      if(data.status === true){
                        swal({
                              title: 'Observatorio Anti Corrupción :: Contacto',
                              text: data.message,
                              type: 'success',
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
                        $('#contactFormDiv').fadeOut('slow');
                        $('#contactFormThankYouDiv').fadeIn('slow');
                      }else{
                        swal({
                              title: 'Observatorio Anti Corrupción :: Contacto',
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
                      laddaContactBtn.stop();
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
                              title: 'Observatorio Anti Corrupción :: Contacto',
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
                      laddaContactBtn.stop();
                    }
                });
            }
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handleContactFormValidation();
        }
    };
}();

$(document).ready(function() {
    contactFormValidation.init();

    $('#contactFormThankYouDiv').hide();
    $('#contactFormDiv').show();
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

function renderSection(url){
    $.ajax({
        type: 'GET',
        url: url,
        dataType: 'json',
        beforeSend: function(){
            
        },
        success: function (data) {
            if(data.type == 'html'){
                history.pushState(null, null, url);
                $('#mainPanel').empty().append($(data.mainContent));
                $('#scriptsDiv').empty().append($(data.scripts)); 
            }else{
                showAlert(data.title, data.message, data.class);
            }
            
        },
        error: function (data) {
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