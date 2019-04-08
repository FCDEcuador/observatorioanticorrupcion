var FormCorruptionCaseValidation = function() {

    var handleCorruptionCaseValidation = function() {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
        var corruptionCaseForm = $('#corruptionCaseForm');
        var errorCorruptionCase = $('.alert-danger', corruptionCaseForm);
        var successCorruptionCase = $('.alert-success', corruptionCaseForm);

        corruptionCaseForm.steps({
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
                return currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) && (currentIndex < newIndex && (corruptionCaseForm.find(".body:eq(" + newIndex + ") label.error").remove(), corruptionCaseForm.find(".body:eq(" + newIndex + ") .error").removeClass("error")), corruptionCaseForm.validate().settings.ignore = ":disabled,:hidden", corruptionCaseForm.valid())
            }
            , onFinishing: function (event, currentIndex) {
                return corruptionCaseForm.validate().settings.ignore = ":disabled", corruptionCaseForm.valid()
            }
            , onFinished: function (event, currentIndex) {
                 $('#corruptionCaseBtn').show();
            }
        }), corruptionCaseForm.validate({
            errorElement: 'div', //default input error message container
            errorClass: 'form-control-feedback', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: {
                case_stage: {
                    required: true
                },
                province: {
                    required: true
                },
                state_function: {
                    required: true
                },
                involved_number:{
                    required: true,
                    digits: true
                },
                'linked_institutions[]': {
                    required: true,
                    minlength: 1,
                },
                'public_officials_involved[]': {
                    required: true,
                    minlength: 1,
                },
                summary: {
                    required: function() {
                         CKEDITOR.instances.summary.updateElement();
                    }
                },
                main_multimedia: {
                    accept: "image/*"
                },
                home_image: {
                    accept: "image/*"
                },
                title: {
                    required: true
                },
                history: {
                    required: function() {
                         CKEDITOR.instances.history.updateElement();
                    }
                },
                history_image: {
                    accept: "image/*"
                },
                consequences_image: {
                    accept: "image/*"
                }
            },
            messages: {
                case_stage: {
                    required: "Por favor seleccione la Etapa Actual del Caso"
                },
                province: {
                    required: "Por favor seleccione la provincia"
                },
                state_function: {
                    required: "Por favor seleccione la Función del Estado"
                },
                involved_number:{
                    required: "Por favor ingrese el número de funcionarios involucrados",
                    digits: "Por favor ingrese un número válido"
                },
                'linked_institutions[]': {
                    required: "Por favor seleccione al menos 1 Institución Vinculada",
                    minlength: "Por favor seleccione al menos 1 Institución Vinculada",
                },
                'public_officials_involved[]': {
                    required: "Por favor seleccione al menos 1 Funcionario involucrado",
                    minlength: "Por favor seleccione al menos 1 Funcionario involucrado",
                },
                summary: {
                    required: "Por favor ingrese el resumen del caso"
                },
                main_multimedia: {
                    accept: "Unicamente se aceptan imágenes"
                },
                home_image: {
                    accept: "Unicamente se aceptan imágenes"
                },
                title: {
                    required: "Por favor ingrese el título del Caso de Corrupción"
                },
                history: {
                    required: "Por favor ingrese los antecedentes del caso"
                },
                history_image: {
                    accept: "Unicamente se aceptan imágenes"
                },
                consequences_image: {
                    accept: "Unicamente se aceptan imágenes"
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit              
                successCorruptionCase.hide();
                errorCorruptionCase.show();
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
                CKEDITOR.instances.summary.updateElement();
                CKEDITOR.instances.history.updateElement();
                CKEDITOR.instances.legal_causes.updateElement();
                CKEDITOR.instances.political_causes.updateElement();
                CKEDITOR.instances.economic_consequences.updateElement();
                CKEDITOR.instances.social_consequences.updateElement();
                CKEDITOR.instances.sources.updateElement();

                successCorruptionCase.show();
                errorCorruptionCase.hide();
                var laddaCorruptionCaseBtn = Ladda.create(document.querySelector('#corruptionCaseBtn'));
                laddaCorruptionCaseBtn.start();
                laddaCorruptionCaseBtn.setProgress(0-1);

                var frmData = new FormData();
                if($("#main_multimedia")[0].files[0]){
                  frmData.append('main_multimedia', $("#main_multimedia")[0].files[0]);
                }

                if($("#home_image")[0].files[0]){
                  frmData.append('home_image', $("#home_image")[0].files[0]);
                }

                if($("#history_image")[0].files[0]){
                  frmData.append('history_image', $("#history_image")[0].files[0]);
                }

                if($("#consequences_image")[0].files[0]){
                  frmData.append('consequences_image', $("#consequences_image")[0].files[0]);
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
                      laddaCorruptionCaseBtn.start();
                    },
                    success: function (data) {
                      if(data.status === true){
                        renderSection(urlCorruptionCasesList);
                      }else{
                        swal({
                              title: 'BlaudCMS :: Casos de Corrupción',
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
                      laddaCorruptionCaseBtn.stop();
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
                              title: 'BlaudCMS :: Casos de Corrupción',
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
                      laddaCorruptionCaseBtn.stop();
                    }
                });
            }
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handleCorruptionCaseValidation();
        }
    };
}();

$(document).ready(function() {
    
    $('#corruptionCaseBtn').hide();
    FormCorruptionCaseValidation.init();
    $(".select2").select2();
    $("#involved_number").TouchSpin();

    CKEDITOR.replace('summary', CKEditorOptions);
    CKEDITOR.replace('history', CKEditorOptions);
    CKEDITOR.replace('legal_causes', CKEditorOptions);
    CKEDITOR.replace('political_causes', CKEditorOptions);
    CKEDITOR.replace('economic_consequences', CKEditorOptions);
    CKEDITOR.replace('social_consequences', CKEditorOptions);
    CKEDITOR.replace('sources', CKEditorOptions);

    
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

    $('#home_image').dropify({
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

    $('#history_image').dropify({
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

    $('#consequences_image').dropify({
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


function loadCaseStageDetail(caseStagesDetailUrl, caseStageDetailSelect) {
  var caseStage = $("#case_stage").val();
  if(caseStage != ''){
    $.get(caseStagesDetailUrl+'/'+caseStage,function(caseStageDetails){
      var caseStageDetailCmb = $("#case_stage_detail");
      caseStageDetailCmb.empty();
      caseStageDetailCmb.append("<option value=''>Seleccione un detalle de etapa</option>");
      $.each(caseStageDetails,function(index,caseStageDetail){
        if(caseStageDetail.description == caseStageDetailSelect){
          caseStageDetailCmb.append("<option value='" + caseStageDetail.description + "' selected='selected'>" + caseStageDetail.description + "</option>");
        }else{
          caseStageDetailCmb.append("<option value='" + caseStageDetail.description + "'>" + caseStageDetail.description + "</option>");
        }
      });
    });
  }else{
    console.log("No se ha seleccionado ninguna etapa del caso");
    var caseStageDetailCmb = $("#case_stage_detail");
    caseStageDetailCmb.empty();
    caseStageDetailCmb.append("<option value=''>Seleccione un detalle de etapa</option>");
  }    
}

function addWhatHappened(){
    nextWH++;
    var row = '<div class="row" id="whatHappenedDiv_'+nextWH+'"><div class="col-md-1"><label for="order"> Orden: </label><input type="number" name="order[]" id="order_'+nextWH+'" class="form-control" value="" /></div><div class="col-md-6"><div class="row"><div class="col-md-4"><label for="year"> Año Inicio: </label><input type="number" name="year[]" id="year_1" class="form-control" /></div><div class="col-md-4"><label for="year"> Mes Inicio: </label><select name="month[]" id="month_'+nextWH+'" class="form-control"><option value="" selected="selected">Mes</option><option value="Enero">Enero</option><option value="Febrero">Febrero</option><option value="Marzo">Marzo</option><option value="Abril">Abril</option><option value="Mayo">Mayo</option><option value="Junio">Junio</option><option value="Julio">Julio</option><option value="Agosto">Agosto</option><option value="Septiembre">Septiembre</option><option value="Octubre">Octubre</option><option value="Noviembre">Noviembre</option><option value="Diciembre">Diciembre</option></select></div><div class="col-md-4"><label for="day"> Día Inicio: </label><input type="number" name="day[]" id="day_'+nextWH+'" class="form-control" /></div><div class="col-md-4"><label for="year_end"> Año Fin: </label><input type="number" name="year_end[]" id="year_end_'+nextWH+'" class="form-control" /></div><div class="col-md-4"><label for="month_end"> Mes Fin: </label><select name="month_end[]" id="month_end_'+nextWH+'" class="form-control"><option value="" selected="selected">Mes</option><option value="Enero">Enero</option><option value="Febrero">Febrero</option><option value="Marzo">Marzo</option><option value="Abril">Abril</option><option value="Mayo">Mayo</option><option value="Junio">Junio</option><option value="Julio">Julio</option><option value="Agosto">Agosto</option><option value="Septiembre">Septiembre</option><option value="Octubre">Octubre</option><option value="Noviembre">Noviembre</option><option value="Diciembre">Diciembre</option></select></div><div class="col-md-4"><label for="day_end"> Día Fin: </label><input type="number" name="day_end[]" id="day_end_'+nextWH+'" class="form-control" /></div></div></div><div class="col-md-3"><label for="day"> Descripción: </label><textarea name="description[]" id="description_'+nextWH+'" class="form-control"></textarea></div><div class="col-md-2"><a class="btn btn-danger" style="cursor: pointer; color:#FFF;" onclick="javascript: $(\'#whatHappenedDiv_'+nextWH+'\').remove();" title="Eliminar linea"><i class="fa fa-trash"></i></a></div></div>';
    $("#whatHappenedDiv").append(row);
}

function deleteWhatHappened(urlDeleteWH, nextWH){
  swal({
            title: 'Casos de Corrupción',
            text: 'Está seguro que desea eliminar éste registro?',
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
                  $.ajax({
                      type: 'GET',
                      url: urlDeleteWH,
                      dataType: 'json',
                      beforeSend: function(){
                          $(".preloader").show();
                      },
                      success: function (data) {
                          $(".preloader").fadeOut();
                          if(data.status == true){
                              $('#whatHappenedDiv_'+nextWH).remove();
                              showAlert('Casos de Corrupción', data.message, 'success');
                          }else{
                              showAlert('Casos de Corrupción', data.message, 'error');
                          }
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
                  return false;
              }
          }
    );
  
}