$.fn.scrollEnd = function(callback, timeout) {
  $(this).scroll(function(){
    var $this = $(this);
    if ($this.data('scrollTimeout')) {
      clearTimeout($this.data('scrollTimeout'));
    }
    $this.data('scrollTimeout', setTimeout(callback, timeout));
  });
};

/*
  Función que inicializa el elemento Slider
*/
function inicializarSlider() {
  $("#rangoPrecio").ionRangeSlider({
    type: "double",
    grid: false,
    min: 0,
    max: 100000,
    from: 200,
    to: 80000,
    prefix: "$",
    onChange: function (data) {
      // Actualiza los campos ocultos cuando cambia el valor del slider
      $("#minPrecio").val(data.from);
      $("#maxPrecio").val(data.to);

      // Verifica en la consola los valores actuales
      console.log("Min Precio:", data.from);
      console.log("Max Precio:", data.to);
    }
  });
}

/*
  Función que reproduce el video de fondo al hacer scroll, y detiene la reproducción al detener el scroll
*/
function playVideoOnScroll() {
  var ultimoScroll = 0,
      intervalRewind;
  var video = document.getElementById('vidFondo');
  $(window)
    .scroll((event) => {
      var scrollActual = $(window).scrollTop();
      if (scrollActual > ultimoScroll) {
       video.play();
     } else {
        //this.rewind(1.0, video, intervalRewind);
        video.play();
     }
     ultimoScroll = scrollActual;
    })
    .scrollEnd(() => {
      video.pause();
    }, 10)
}

inicializarSlider();
playVideoOnScroll();
