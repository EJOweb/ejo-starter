jQuery(document).ready(function($) {

	//* Add class to all anchors which wrap an image (do not wrap image links which are inside content)
	$('a > img').not( $('#content .entry-content a > img') ).parent().addClass('image-wrap');

	// To Top button
	$('#toTop').click(function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
    });
    
});