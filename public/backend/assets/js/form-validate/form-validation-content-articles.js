var FormContentArticlesValidation = function() {

    var handleContentArticlesValidation = function() {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
        var contentArticleForm = $('#contentArticleForm');
        var errorContentArticle = $('.alert-danger', contentArticleForm);
        var successContentArticle = $('.alert-success', contentArticleForm);

        contentArticleForm.validate({
            errorElement: 'div', //default input error message container
            errorClass: 'form-control-feedback', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: {
              title: {
                required: true
              },
              summary: {
                required: true
              },
              main_multimedia: {
                accept: "image/*"
              },
              author_email: {
                email: true
              },
              content_category_id: {
                required: true
              }
            },
            messages: {
               title: {
                  required: "Por favor ingrese el título del artículo de contenido"
                },
                summary: {
                  required: "Por favor ingrese el resumen del artículo de contenido"
                },
                main_multimedia: {
                  accept:  "Unicamente se aceptan imágenes"
                },
                author_email: {
                  email: "Por favor ingrese un e-mail válido"
                },
                content_category_id: {
                  required: "Por favor selecciona una categoría de contenido"
                } 
            },

            invalidHandler: function(event, validator) { //display error alert on form submit              
                successContentArticle.hide();
                errorContentArticle.show();
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

                CKEDITOR.instances.content.updateElement();

                successContentArticle.show();
                errorContentArticle.hide();
                var laddaContentArticleBtn = Ladda.create(document.querySelector('#contentArticleBtn'));
                laddaContentArticleBtn.start();
                laddaContentArticleBtn.setProgress(0-1);

                var frmData = new FormData();
                if($("#main_multimedia")[0].files[0]){
                  frmData.append('main_multimedia', $("#main_multimedia")[0].files[0]);
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
                      laddaContentArticleBtn.start();
                    },
                    success: function (data) {
                      if(data.status === true){
                        renderSection(urlContentArticlesList);
                      }else{
                        swal({
                              title: 'BlaudCMS :: Artículos de Contenido',
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
                      laddaContentArticleBtn.stop();
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
                              title: 'BlaudCMS :: Artículos de Contenido',
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
                      laddaContentArticleBtn.stop();
                    }
                });
            }
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handleContentArticlesValidation();
        }
    };
}();

$(document).ready(function() {
    FormContentArticlesValidation.init();
    CKEDITOR.replace('content', CKEditorOptions);
    $(".select2").select2();

    $('#main_multimedia').dropify({
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