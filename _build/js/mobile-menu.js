jQuery(document).ready(function(){

	//* Target menu and menu-icon
	var navigation = jQuery("#menu-primary-mobile");
	var responsive_menu_icon = jQuery(".responsive-menu-icon");

	//* Click on show menu icon
	responsive_menu_icon.click(function(){
		if ( jQuery(this).hasClass("expanded") ) {
			jQuery(this).removeClass("expanded");
			// console.log();
			navigation.animate({right: '-' + navigation.outerWidth()});
		} 
		else {
			jQuery(this).addClass("expanded");
			navigation.animate({right: '0'});
		}
	});

	//* Add triangle next to submenu in menu
	jQuery(navigation).find(".sub-menu").before('<span class="touch-button">&#9660;</span>');

	//* Click toggles submenu visibility
	navigation.find(".touch-button").click(function(){
		jQuery(this).closest(".menu-item").toggleClass("expanded");
		jQuery(this).next(".sub-menu").slideToggle();
	});

	//* Reset on resize
	jQuery(window).resize(u_debounce(function(){
		//Remove inline style because that overrules stylesheet
		if(jQuery(window).width() >= 1160) {  
			navigation.removeAttr('style');
			navigation.find(".sub-menu").removeAttr('style');
			navigation.children(".menu-item").removeClass("expanded");
			responsive_menu_icon.removeClass("expanded");
		}  
	}, 250 ));

});