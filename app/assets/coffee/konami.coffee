$ ->
  $('#thisTeamisFantastic').hide()
  $('#thisTeamisFantastic').click ->
    window.location = 'https://www.youtube.com/watch?v=mJ9K8vHB_Xc&list=PLltmM-AhZeCuZmelCRuBfHydfK6TRGScC'

  combination = ''
  keys =
    37: 'l'
    38: 'u'
    39: 'r'
    40: 'd'
    65: 'a'
    66: 'b'

  $(document).keyup (event) ->
    combination += key_dict[event.which]
    $('#thisTeamisFantastic').show() if combination is 'uuddlrlrba'
