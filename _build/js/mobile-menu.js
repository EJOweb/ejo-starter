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