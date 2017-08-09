$(document).ready(function() {
  $('.js-slider__content').slick({
    dots: true,
    arrows: false,
    infinite: true,
    speed: 300,
    slidesToShow: 3,
    slidesToScroll: 1,
    responsive: [{
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
          infinite: true,
          dots: true,
          arrows: false,
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
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

  $('.feedback-form').validator().on('submit', function(e) {
    e.preventDefault();
      $.ajax({
        async: "true",
        type: 'post',
        url: 'send.php',
        data: $('.feedback-form').serialize(),
        // cache: false,
        // contentType: false,
        // processData: false,
        success: function(resp) {
          if (resp == 'Success') {
            $('.feedback-form__element').each(function(){
              $(this).val("");
            })
            $('.modal').modal('show');
          }
        }
      });
    return false;
  });


  $('.button--close-modal').on('click', function(){
    $('.modal').modal('hide');
  });

  //smooth scroll to anchor
  $('a[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });

//masking input
  $('.feedback-form__element--phone').mask('+375 (99) 999-99-99');

});
