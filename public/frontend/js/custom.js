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

jQuery('#emailDenuncia').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var recipient = button.data('whatever') // Extract info from data-* attributes
	  var receptor = button.data('receptor') // Valor email
	  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
	  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
	  var modal = $(this)
	  modal.find('.modal-title').html('<i class="fas fa-envelope mr-3 fz32 text-warning"></i> Envía un mensaje a ' + recipient)
	  modal.find('.modal-body #receptor').val(receptor)
});


//root
var mc = new Hammer(document.getElementById("carouselExampleIndicators"));

//mouse pointer state
var pointerXCoord = 0;
//image lefting
var imageLeftCord = 0;
//carousel width
var carouselWidth = $(".carousel-inner").width();
//lastmove
var lastMove = "";

$("#carouselExampleIndicators").carousel(
  {
    //interval: false
  }
);

function initialize() {
  $("#carouselExampleIndicators").carousel("cycle");
  carouselWidth = $(".carousel-inner").width();
  imageLeftCord = 0;
  pointerXCoord = 0;
  lastMove = "";
}

function snapLeft() {
  $(".item").css({ transition: "", transform: "" });
  $(".item").removeClass("prev");
  $(".item").removeClass("next");
  $("#carouselExampleIndicators").carousel("prev");
  setTimeout(function() {
    initialize();
  }, 600);
}

function snapRight() {
  $(".item").css({ transition: "", transform: "" });
  $(".item").removeClass("prev");
  $(".item").removeClass("next");
  $("#carouselExampleIndicators").carousel("next");
  setTimeout(function() {
    initialize();
  }, 600);
}

$(".carousel-control.left").click(function() {
  snapLeft();
});

$(".carousel-control.right").click(function() {
  snapRight();
});

//CATCH PANNING EVENTS
mc.on("panstart panend panleft panright", function(ev) {
  //PAUSE THE CAROUSEL
  $("#carouselExampleIndicators").carousel("pause");

  //set next and prev with circular searching
  var prev = $(".item.active").prev();
  if (prev[0] === undefined) {
    prev = $(".carousel-inner").children().last();
  }
  prev.addClass("prev");

  var next = $(".item.active").next();
  if (next[0] === undefined) {
    next = $(".carousel-inner").children().first();
  }
  next.addClass("next");

  //if is panstart set position of cursor for calculationg different positions
  if (ev.type === "panstart") {
    pointerXCoord = ev.pointers[0].pageX;
    return 0;
  }

  //MOVING
  if (pointerXCoord !== ev.pointers[0].pageX) {
    //set last action [left-right]
    lastMove = ev.type;

    //how much do you move?
    var diff = ev.pointers[0].pageX - pointerXCoord;
    $(".item.active").css({
      transition: "initial",
      transform: "translate3d(" + (imageLeftCord + diff) + "px, 0, 0)"
    });
    $(".item.next").css({
      transition: "initial",
      transform:
        "translate3d(" + (imageLeftCord + diff + carouselWidth) + "px, 0, 0)"
    });
    $(".item.prev").css({
      transition: "initial",
      transform:
        "translate3d(" + (imageLeftCord + diff - carouselWidth) + "px, 0, 0)"
    });

    //set variables for next turn
    imageLeftCord += diff;
    pointerXCoord = ev.pointers[0].pageX;
  }

  //end
  if (ev.type === "panend") {
    if (imageLeftCord > carouselWidth / 2) {
      if (lastMove === "panright") {
        snapLeft();
        return 0;
      }
    }

    if (imageLeftCord < -(carouselWidth / 2)) {
      if (lastMove === "panleft") {
        snapRight();
        return 0;
      }
    }

    //return to the start position
    $(".item").css({ transition: "", transform: "" });
    initialize();
  }
});


//Get the button:
mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}