//root

//sliderObj = document.getElementById("carouselExampleIndicators");

//valueObj = "#carouselExampleIndicators";

carouselitem = valueObj + " .carousel-item";

carouselinner = valueObj + " .carousel-inner";


carouselitemactive = valueObj + ".active";
carouselitemprev = valueObj + ".prev";
carouselitemnext = valueObj + ".next";

carouselcontrolleft = valueObj + " .carousel-control.left";

carouselcontrolright = valueObj + " .carousel-control.right";

console.log(carouselitem);

var mc = new Hammer(sliderObj);

//mouse pointer state
var pointerXCoord = 0;
//image lefting
var imageLeftCord = 0;
//carousel width
var carouselWidth = $(carouselinner).width();
//lastmove
var lastMove = "";

$(valueObj).carousel(
  {
    //interval: false
  }
);

function initialize() {
  $(valueObj).carousel("cycle");
  carouselWidth = $(carouselinner).width();
  imageLeftCord = 0;
  pointerXCoord = 0;
  lastMove = "";
}

function snapLeft() {
  $(carouselitem).css({ transition: "", transform: "" });
  $(carouselitem).removeClass("prev");
  $(carouselitem).removeClass("next");
  $(valueObj).carousel("prev");
  setTimeout(function() {
    initialize();
  }, 600);
}

function snapRight() {
  $(carouselitem).css({ transition: "", transform: "" });
  $(carouselitem).removeClass("prev");
  $(carouselitem).removeClass("next");
  $(valueObj).carousel("next");
  setTimeout(function() {
    initialize();
  }, 600);
}

$(carouselcontrolleft).click(function() {
  snapLeft();
});

$(carouselcontrolright).click(function() {
  snapRight();
});

//CATCH PANNING EVENTS
mc.on("panstart panend panleft panright", function(ev) {
  //PAUSE THE CAROUSEL
  $(valueObj).carousel("pause");

  //set next and prev with circular searching
  var prev = $(carouselitemactive).prev();
  if (prev[0] === undefined) {
    prev = $(carouselinner).children().last();
  }
  prev.addClass("prev");

  var next = $(carouselitemactive).next();
  if (next[0] === undefined) {
    next = $(carouselinner).children().first();
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
    $(carouselitemactive).css({
      transition: "initial",
      transform: "translate3d(" + (imageLeftCord + diff) + "px, 0, 0)"
    });
    $(carouselitemnext).css({
      transition: "initial",
      transform:
        "translate3d(" + (imageLeftCord + diff + carouselWidth) + "px, 0, 0)"
    });
    $(carouselitemprev).css({
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
    $(carouselitem).css({ transition: "", transform: "" });
    initialize();
  }
});