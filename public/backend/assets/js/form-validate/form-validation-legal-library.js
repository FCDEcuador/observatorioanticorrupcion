var FormLegalLibraryValidation = function() {

    var handleLegalLibraryValidation = function() {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
        var legalLibraryForm = $('#legalLibraryForm');
        var errorLegalLibrary = $('.alert-danger', legalLibraryForm);
        var successLegalLibrary = $('.alert-success', legalLibraryForm);

        legalLibraryForm.validate({
            errorElement: 'div', //default input error message container
            errorClass: 'form-control-feedback', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: {
                title: {
                    required: true
                },
                issue_year: {
                    required: true,
                    digits: true,
                    rangelength: [4, 4]
                },
                pdf_document: {
                    accept: "application/pdf"
                }
            },
            messages: {
                title: {
                    required: "Por favor ingrese el título del artículo de biblioteca legal"
                },
                issue_year: {
                    required: "Por favor ingrese el año de emisión del artículo",
                    digits: "Por favor ingrese un año de emisión válido",
                    rangelength: "Por favor ingrese un año de emisión válido"
                },
                pdf_document: {
                    accept: "Únicamente se aceptan archivos PDF"
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit              
                successLegalLibrary.hide();
                errorLegalLibrary.show();
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

                CKEDITOR.instances.description.updateElement();
                
                successLegalLibrary.show();
                errorLegalLibrary.hide();
                var laddaLegalLibraryBtn = Ladda.create(document.querySelector('#legalLibraryBtn'));
                laddaLegalLibraryBtn.start();
                laddaLegalLibraryBtn.setProgress(0-1);

                var frmData = new FormData();
                if($("#pdf_document")[0].files[0]){
                  frmData.append('pdf_document', $("#pdf_document")[0].files[0]);
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
                      laddaLegalLibraryBtn.start();
                    },
                    success: function (data) {
                      if(data.status === true){
                        renderSection(urlLegalLibrariesList);
                      }else{
                        swal({
                              title: 'BlaudCMS :: Biblioteca Legal',
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
                      laddaLegalLibraryBtn.stop();
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
                              title: 'BlaudCMS :: Biblioteca Legal',
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
                      laddaLegalLibraryBtn.stop();
                    }
                });
            }
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handleLegalLibraryValidation();
        }
    };
}();

$(document).ready(function() {
    FormLegalLibraryValidation.init();

    CKEDITOR.replace('description', CKEditorOptions);

    $('#pdf_document').dropify({
        messages: {
            default: 'Arrastre un archivo hasta este lugar o de un clic para seleccionar uno',
            replace: 'Arrastre un archivo hasta este lugar o de un clic para seleccionar uno',
            remove: 'Quitar',
            error: 'Ups! parece que algo no esta bien'
        },
        error: {
            'fileSize': 'El archivo es demasiado grande. ({{ value }} maximo).',
            'imageFormat': 'Este formato no esta permitido. ({{ value }} unicamente).'
        }
    });
});