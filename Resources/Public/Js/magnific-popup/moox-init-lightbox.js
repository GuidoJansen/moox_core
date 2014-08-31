/*---------------------*/
$(document).ready(function() {
	/*$('.image-lightbox').magnificPopup({
		type: 'image',
		closeOnContentClick: true,     
		image: {
				verticalFit: true
		}
	});*/
	$('.lightbox-gallery').each(function() { // the containers for all your galleries
		$(this).magnificPopup({
		    delegate: 'a', // the selector for gallery item
		    type: 'image',
		    gallery: {
		      enabled:true
		    }
		});
	}); 
});