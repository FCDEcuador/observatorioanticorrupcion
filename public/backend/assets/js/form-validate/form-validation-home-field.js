$(document).ready(function() {
    FormHomeFieldsValidation.init();

    $('#legal_library_image').dropify({
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

var FormHomeFieldsValidation = function() {

    var handleHomeFieldsValidation = function() {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
        var homeFieldsForm = $('#homeFieldsForm');
        var errorHomeFields = $('.alert-danger', homeFieldsForm);
        var successHomeFields = $('.alert-success', homeFieldsForm);

        homeFieldsForm.validate({
            errorElement: 'div', //default input error message container
            errorClass: 'form-control-feedback', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: {
                legal_library_image: {
                  accept: "image/*"
                }
            },
            messages: {
                legal_library_image: {
                  accept: "Unicamente se aceptan archivos de imagenes (JPG, PNG, GIF)"
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit              
                successHomeFields.hide();
                errorHomeFields.show();
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
                successHomeFields.show();
                errorHomeFields.hide();
                var laddaHomeFieldsBtn = Ladda.create(document.querySelector('#homeFieldsBtn'));
                laddaHomeFieldsBtn.start();
                laddaHomeFieldsBtn.setProgress(0-1);

                var frmData = new FormData();
                if($("#legal_library_image")[0].files[0]){
                  frmData.append('legal_library_image', $("#legal_library_image")[0].files[0]);
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
                      laddaHomeFieldsBtn.start();
                    },
                    success: function (data) {
                      if(data.status === true){
                          renderSection($(form).attr('action'));
                          swal({
                                title: 'BlaudCMS :: Elementos de Home',
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
                              title: 'BlaudCMS :: Elementos de Home',
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
                      laddaHomeFieldsBtn.stop();
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
                              title: 'BlaudCMS :: Elementos de Home',
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
                      laddaHomeFieldsBtn.stop();
                    }
                });
            }
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handleHomeFieldsValidation();
        }
    };
}();