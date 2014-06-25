/*---------------------*/
$(document).ready(function() {
	$('.image-lightbox').magnificPopup({
        type: 'image',
        closeOnContentClick: true,     
        image: {
			verticalFit: true
        }
	});
});