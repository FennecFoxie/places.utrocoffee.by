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

      proceed = true;
      var allowed_file_size = "1048576"; //allowed file size
      var allowed_files = ['image/png', 'image/gif', 'image/jpeg'];
      //check file size and type before upload, works in modern browsers
      if (window.File && window.FileReader && window.FileList && window.Blob) {
        var total_files_size = 0;
        $(this.elements['photo'].files).each(function(i, ifile) {
          if (ifile.value !== "") { //continue only if file(s) are selected
            if (allowed_files.indexOf(ifile.type) === -1) { //check unsupported file
              alert(ifile.name + " is unsupported file type!");
              proceed = false;
            }
            total_files_size = total_files_size + ifile.size; //add file size to total size
          }
        });
        if (total_files_size > allowed_file_size) {
          alert("Make sure total file size is less than 1 MB!");
          proceed = false;
        }
      }

      //if everything's ok, continue with Ajax form submit
      if (proceed) {

        var post_url = $(this).attr("action"); //get form action url
        var request_method = $(this).attr("method"); //get form GET/POST method
        var form_data = new FormData(this); //constructs key/value pairs representing fields and values


        $.ajax({
          type: request_method,
          url: post_url,
          data: form_data,
          dataType: "json",
          contentType: false,
          cache: false,
          processData: false,
          // }).done(function(res) { //fetch server "json" messages when done
          //   alert(res);
          //   if (res.type == "error") {
          //   }
          //   if (res.status == 200) {
          //     $('.feedback-form__element').each(function() {
          //       $(this).val("");
          //     })
          //     $('.modal').modal('show');
          //   }
          // });

        }).always(function(data) {
            var answer = JSON.stringify(data);
            $('.js-modal-text').text(data.responseText);
            $('.feedback-form')[0].reset();
            $('.modal').modal('show');
        });
    } else {
      return false;
    }

  });


$('.button--close-modal').on('click', function() {
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
