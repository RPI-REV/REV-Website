$ () ->
  $('ul.scroll-buttons li a').click (event) ->
    event.preventDefault()
    if this.hash isnt ''
      $('body').animate {scrollTop: $(this.hash).offset().top - 50}, 400
    else
      $('body').animate {scrollTop: 0}, 400