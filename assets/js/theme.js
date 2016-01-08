jQuery(document).ready(function($){

	//* Target menu and menu-icon
	var navigation = $("#menu-primary-mobile-items");
	var responsive_menu_icon = $(".menu-toggle");

	//* Click on show menu icon
	responsive_menu_icon.click(function(){
		$(this).toggleClass("expanded");
		navigation.slideToggle();
	});

	//* Add triangle next to submenu in menu
	$(navigation).find(".sub-menu").before('<span class="touch-button">&#9660;</span>');

	//* Click toggles submenu visibility
	navigation.find(".touch-button").click(function(){
		$(this).closest(".menu-item").toggleClass("expanded");
		$(this).next(".sub-menu").slideToggle();
	});

	//* Reset on resize
	$(window).resize(u_debounce(function(){
		//Remove inline style because that overrules stylesheet
		if($(window).width() >= 1000) {  
			navigation.removeAttr('style');
			navigation.find(".sub-menu").removeAttr('style');
			navigation.children(".menu-item").removeClass("expanded");
			responsive_menu_icon.removeClass("expanded");
		}  
	}, 250 ));

});
jQuery(document).ready(function($) {

	//* Add class to all anchors which wrap an image (do not wrap image links which are inside content)
	$('a > img').not( $('#content .entry-content a > img') ).parent().addClass('image-wrap');

	// To Top button
	$('#toTop').click(function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
    });
    
});
//* Wait a couple of miniseconds before action. Useful to prevent multiple triggers on resize
//* Underscore-framework functionality
u_debounce = function(func, wait, immediate) {
	var timeout, args, context, timestamp, result;

	var later = function() {
		var last = u_now() - timestamp;

		if (last < wait && last > 0) {
			timeout = setTimeout(later, wait - last);
		} else {
			timeout = null;
			if (!immediate) {
				result = func.apply(context, args);
				if (!timeout) context = args = null;
			}
		}
	};

	return function() {
		context = this;
		args = arguments;
		timestamp = u_now();
		var callNow = immediate && !timeout;
		if (!timeout) timeout = setTimeout(later, wait);
		if (callNow) {
			result = func.apply(context, args);
			context = args = null;
		}

		return result;
	};
};

//* Calculate now
//* Underscore-framework functionality
u_now = Date.now || function() {
	return new Date().getTime();
};