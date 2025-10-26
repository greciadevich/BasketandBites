$(document).ready(function () {
  $('.mi-carrusel').slick({
    slidesToShow: 2,
    arrows: false,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 3000,
  });

  $('.marcas-imagen').slick({
    dots: false,
    infinite: true,
    speed: 300,
    slidesToShow: 5,
    slidesToScroll: 1,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1,
          infinite: true,
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }

    ]
  });

  $('.sidebar-2').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: false,
    autoplaySpeed: 2000,
    dots: false,
    arrows: false,
  });

});


document.addEventListener('DOMContentLoaded', function () {
  var barraInformativa = document.querySelector('.barra-informativa');
  if (barraInformativa) {
    var colores = ['#007bff', '#28a745', '#dc3545', '#ffc107'];
    var indiceActual = 0;

    setInterval(function () {
      barraInformativa.style.backgroundColor = colores[indiceActual];
      indiceActual = (indiceActual + 1) % colores.length;
    }, 3000);
  }
});

document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.menu-padre').forEach(parent => {
    parent.addEventListener('click', function () {
      document.querySelectorAll('.menu-hijo').forEach(menu => {
        menu.style.height = '0';
      });

      const menuHijo = this.querySelector('.menu-hijo');
      if (menuHijo) {
        if (menuHijo.style.height === '0px' || menuHijo.style.height === '') {
          menuHijo.style.height = menuHijo.scrollHeight + 'px';
        } else {
          menuHijo.style.height = '0';
        }
      }
    });
  });
});