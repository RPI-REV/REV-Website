$(function() {
	$('#thisTeamisFantastic').hide();
	$('#thisTeamisFantastic').click(function() {
		window.location = "https://www.youtube.com/watch?v=mJ9K8vHB_Xc&list=PLltmM-AhZeCuZmelCRuBfHydfK6TRGScC"
	});
	var combination = ''

	var key_dict = {
		37: 'left',
		38: 'up',
		39: 'right',
		40: 'down',
		65: 'a',
		66: 'b'
	};

	$(document).keyup(function(event) {
		combination += key_dict[event.which];
		checkCombo();
	});

	function checkCombo() {
		if (combination == 'upupdowndownleftrightleftrightba') {
			$('#thisTeamisFantastic').show();
		}
	}
});