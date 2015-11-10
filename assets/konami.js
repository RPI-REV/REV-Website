$(function() {
    $('#thisTeamisFantastic').hide();
    $('#thisTeamisFantastic').click(function() {
        window.location = 'https://www.youtube.com/watch?v=mJ9K8vHB_Xc&list=PLltmM-AhZeCuZmelCRuBfHydfK6TRGScC';
    });
    var combination = '';

    var keys = {
        37: 'l',
        38: 'u',
        39: 'r',
        40: 'd',
        65: 'a',
        66: 'b'
    };

    $(document).keyup(function(event) {
        combination += key_dict[event.which];
        if (combination === 'uuddlrlrba') {
            $('#thisTeamisFantastic').show();
        }
    });
});
