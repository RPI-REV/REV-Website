$('.sponsor').click ->
  window.location.replace @attr 'link' ? '#'
