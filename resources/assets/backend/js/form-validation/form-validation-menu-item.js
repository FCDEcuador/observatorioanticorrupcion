function loadMenuItems(urlJson, sMenuItemId){
  var sMenuId = $('#menu_id').val();
  var url = '';
  if(sMenuId != ''){
    url = urlJson + "/" + sMenuId;
  }else{
    url = urlJson;
  }
  $.get(url, function(menuItems){
    var menuItemCmb = $("#menu_item_id");
    menuItemCmb.empty();
    menuItemCmb.append("<option value=''>Seleccione el item de menu de nivel superior</option>");
    if(menuItems.status === true){
      $.each(menuItems.menuItems, function(index,menuItem){
        if(menuItem.id == (sMenuItemId ? sMenuItemId : 0)){
          menuItemCmb.append("<option value='" + menuItem.id + "' selected='selected'>" + menuItem.name + "</option>");
        }else{
          menuItemCmb.append("<option value='" + menuItem.id + "'>" + menuItem.name + "</option>");
        }
      });
    }
  });
}


function internalLinks(){
  var type = $("#type").val();
  if(type == 'I'){
    $('#internal_links').removeAttr('disabled');
    $('#target').val('_self');
    $('#link').attr('readonly', 'readonly');
  }else if(type == 'E'){
    $('#internal_links').attr('disabled', 'disabled');
    $('#target').val('_blank');
    $('#link').removeAttr('readonly');
  }else{
    $('#internal_links').removeAttr('disabled');
    $('#target').val('_self');
    $('#link').attr('readonly', 'readonly');
  }
}

function loadLink(){
  $('#link').val($('#internal_links').val());
}



var FormMenuItemValidation = function() {

    var handleMenuItemValidation = function() {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
        var menuItemForm = $('#menuItemForm');
        var errorMenuItem = $('.alert-danger', menuItemForm);
        var successMenuItem = $('.alert-success', menuItemForm);

        menuItemForm.validate({
            errorElement: 'div', //default input error message container
            errorClass: 'form-control-feedback', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: {
                
            },
            messages: {
                
            },

            invalidHandler: function(event, validator) { //display error alert on form submit              
                successMenuItem.hide();
                errorMenuItem.show();
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
                successMenuItem.show();
                errorMenuItem.hide();
                var laddaMenuItemBtn = Ladda.create(document.querySelector('#menuItemBtn'));
                laddaMenuItemBtn.start();
                laddaMenuItemBtn.setProgress(0-1);
                $.ajax({
                    type: $(form).attr('method'),
                    url: $(form).attr('action'),
                    data: $(form).serialize(),
                    dataType: "json",
                    beforeSend: function(){
                      laddaMenuItemBtn.start();
                    },
                    success: function (data) {
                      if(data.status === true){
                        renderSection(urlMenuItemsList);
                      }else{
                        swal({
                              title: 'BlaudCMS :: Items de Menú',
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
                      laddaMenuItemBtn.stop();
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
                              title: 'BlaudCMS :: Items de Menú',
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
                      laddaMenuItemBtn.stop();
                    }
                });
            }
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handleMenuItemValidation();
        }
    };
}();

$(document).ready(function() {
    FormMenuItemValidation.init();
    loadMenuItems(urlMenuItemsListJson, sMenuItemId);
    internalLinks();
});