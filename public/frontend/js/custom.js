//Llamar a
jQuery('.flotante').mouseover(function(){
    console.log('sadasdasd');
    jQuery(this).animate({
        'right' : "0px" //moves left
    });
});

jQuery('.flotante').mouseout(function(){
    jQuery(this).animate({
        'right' : "-125px" //moves left
    });
});