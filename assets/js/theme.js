/* ========= INFORMATION ============================
 
 - document:  Slick Modals - HTML5 and CSS3 powered modal popups
 - author:    Capelle @ Codecanyon
 - profile:   http://codecanyon.net/user/Capelle
 - version:   3.0
 
 ==================================================== */

jQuery(function($) {
    $.fn.slickModals = function (options) {

        // Settings
        settings = $.extend({

            // Functionality
            popupType: null,
            delayTime: null,
            exitTopDistance: null,
            scrollTopDistance: null,
            setCookie: false,
            cookieDays: null,
            cookieTriggerClass: "setSlickCookie",
            cookieName: "slickCookie",

            // Overlay options
            overlayBg: false,
            overlayBgColor: null,
            overlayTransition: null,
            overlayTransitionSpeed: null,

            // Background effects
            bgEffect: null,
            blurBgRadius: null,
            scaleBgValue: null,

            // Window options
            windowLocation: null,
            windowTransition: null,
            windowTransitionSpeed: null,
            windowTransitionEffect: null,

            // Close and open button
            closeButton: null,
            reopenClass: null,

        }, options);

        return this.each( function (){
            var self = this;

            //* For debugging
            // Cookies.remove( settings.cookieName );

            // Popup types
            function showModal() {
                $(self).addClass("isActive");
            }
            function hideModal() {
                $(self).removeClass("isActive");
            }
            if (settings.popupType === "delayed") {
                if ( !Cookies.get(settings.cookieName)) {
                    setTimeout(showModal, settings.delayTime + 200);
                    setTimeout(beginBgEffects, settings.delayTime);
                }
            }
            if (settings.popupType === "exit") {
                $(document).mousemove(function(e) {
                    if ( !Cookies.get(settings.cookieName) && (e.clientY <= settings.exitTopDistance)) {
                        showModal();
                        beginBgEffects();
                    }
                });
            }
            if (settings.popupType === "scrolled") {
                $(document).scroll(function() {
                    var y = $(this).scrollTop();
                    if ( !Cookies.get(settings.cookieName) && (y > settings.scrollTopDistance)) {
                        showModal();
                        beginBgEffects();
                    }
                });
            }

            // Background Effects
            var page = "body > *";
            function beginBgEffects() {
                function beginBluring() {
                    $(page).not(".slickModal").addClass("blurred").css({
                        "-webkit-filter" : "blur" + "(" + settings.blurBgRadius + ")",
                        "-moz-filter" : "blur" + "(" + settings.blurBgRadius + ")",
                        "-ms-filter" : "blur" + "(" + settings.blurBgRadius + ")",
                        "filter" : "blur" + "(" + settings.blurBgRadius + ")",
                    });
                }
                function beginScaling() {
                    $(page).not(".slickModal").addClass("scaled").css({
                        "-webkit-transform" : "scale" + "(" + settings.scaleBgValue + ")",
                        "-moz-transform" : "scale" + "(" + settings.scaleBgValue + ")",
                        "-ms-transform" : "scale" + "(" + settings.scaleBgValue + ")",
                        "transform" : "scale" + "(" + settings.scaleBgValue + ")",
                    });
                }
                if (settings.bgEffect === "blur") {
                    beginBluring();
                }
                if (settings.bgEffect === "scale") {
                    beginScaling();
                }
                if (settings.bgEffect === "both") {
                    beginBluring();
                    beginScaling();
                }
                // $(page).not(".slickModal").css({
                //    "-webkit-transition-duration" : settings.overlayTransitionSpeed + "s",
                //    "-moz-transition-duration" : settings.overlayTransitionSpeed + "s",
                //    "-ms-transition-duration" : settings.overlayTransitionSpeed + "s",
                //    "transition-duration" : settings.overlayTransitionSpeed + "s",
                // });
            }
            function endBgEffects() { 
                $(page).removeClass("blurred scaled").css({
                    "-webkit-transform" : "",
                    "-moz-transform" : "",
                    "-ms-transform" : "",
                    "transform" : "",
                    "-webkit-filter" : "",
                    "-moz-filter" : "",
                    "-ms-filter" : "",
                    "filter" : "",
                });
            }

            // Overlay styling
            function showOverlay() {
                $(self).prepend("<div class='overlay closeModal'>" + "</div>");
                $(self).children(".overlay").addClass(settings.overlayTransition + " " + settings.cookieTriggerClass).css({
                    "background" : settings.overlayBgColor,
                    "-webkit-transition-duration" : settings.overlayTransitionSpeed + "s",
                    "-moz-transition-duration" : settings.overlayTransitionSpeed + "s",
                    "-ms-transition-duration" : settings.overlayTransitionSpeed + "s",
                    "transition-duration" : settings.overlayTransitionSpeed + "s",
                });
            }
            if (settings.overlayBg === true) {
                showOverlay();
            }

            // Add close button
            $(self).children(".window").prepend("<div class='close closeModal'>" + "</div>");
            $(self).find(".window").children(".closeModal").addClass(settings.closeButton + " " + settings.cookieTriggerClass);

            // Window styling
            function windowStyling() {
                $(self).children(".window").addClass(settings.windowLocation + " " + settings.windowTransitionEffect + " " + settings.windowTransition).css({
                    "-webkit-transition-duration" : settings.windowTransitionSpeed + "s",
                    "-moz-transition-duration" : settings.windowTransitionSpeed + "s",
                    "-ms-transition-duration" : settings.windowTransitionSpeed + "s",
                    "transition-duration" : settings.windowTransitionSpeed + "s",
                });
                if (settings.windowLocation === "center") {
                    $(self).children(".window").css({
                        "margin" : "auto",
                    });
                }
            }
            windowStyling();

            function setSlickCookie() {
                days = settings.cookieDays;
                
                if ( Cookies.get(settings.cookieName) == 'submitted' )
                    return;

                if (days > 0) {
                    Cookies.remove( settings.cookieName );
                    Cookies.set( settings.cookieName, 'closed', { expires: days });
                }
                else if (days === 0) {
                    Cookies.remove( settings.cookieName );
                    Cookies.set( settings.cookieName, 'closed' );
                }

                // console.log( days );
                // console.log( settings.cookieName + ': ' + Cookies.get( settings.cookieName ) );
            }

            // Set a cookie to prevent modal from popping up again
            if (settings.setCookie === true) {
                $("." + settings.cookieTriggerClass).on("click", function () {
                    setSlickCookie();
                });
            }

            // Close modal
            $(".closeModal").on("click", function () {
                hideModal();
                endBgEffects();
            });

            // Open modal after closing
            $("." + settings.reopenClass).on("click", function () {
                showModal();
                beginBgEffects();
            });

        });
    };
});

// Plugin invoke
jQuery(document).ready(function($){
    var settings = 'test';
    $("#popup-1").slickModals({
        // Functionality
        popupType: "scrolled",
        delayTime: 1000,
        exitTopDistance: 40,
        scrollTopDistance: 400,
        setCookie: true,
        cookieDays: 1,
        cookieTriggerClass: "set-newsletter-cookie",
        cookieName: "studioredd-newsletter-popup",

        // Overlay options
        overlayBg: false,
        overlayBgColor: "rgba(0,0,0,0.5)",
        overlayTransition: "ease",
        overlayTransitionSpeed: "0.4",

        // Background effects
        bgEffect: null,
        blurBgRadius: "2px",
        scaleBgValue: "1",

        // Window options
        windowLocation: "bottomRight",
        windowTransition: "ease",
        windowTransitionSpeed: "0.4",
        windowTransitionEffect: "slideBottom",

        // Close and reopen button
        closeButton: "icon",
        reopenClass: "openSlickModal-1",
    });
});
/*!
 * JavaScript Cookie v2.0.4
 * https://github.com/js-cookie/js-cookie
 *
 * Copyright 2006, 2015 Klaus Hartl & Fagner Brack
 * Released under the MIT license
 */
(function (factory) {
	if (typeof define === 'function' && define.amd) {
		define(factory);
	} else if (typeof exports === 'object') {
		module.exports = factory();
	} else {
		var _OldCookies = window.Cookies;
		var api = window.Cookies = factory();
		api.noConflict = function () {
			window.Cookies = _OldCookies;
			return api;
		};
	}
}(function () {
	function extend () {
		var i = 0;
		var result = {};
		for (; i < arguments.length; i++) {
			var attributes = arguments[ i ];
			for (var key in attributes) {
				result[key] = attributes[key];
			}
		}
		return result;
	}

	function init (converter) {
		function api (key, value, attributes) {
			var result;

			// Write

			if (arguments.length > 1) {
				attributes = extend({
					path: '/'
				}, api.defaults, attributes);

				if (typeof attributes.expires === 'number') {
					var expires = new Date();
					expires.setMilliseconds(expires.getMilliseconds() + attributes.expires * 864e+5);
					attributes.expires = expires;
				}

				try {
					result = JSON.stringify(value);
					if (/^[\{\[]/.test(result)) {
						value = result;
					}
				} catch (e) {}

				value = encodeURIComponent(String(value));
				value = value.replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g, decodeURIComponent);

				key = encodeURIComponent(String(key));
				key = key.replace(/%(23|24|26|2B|5E|60|7C)/g, decodeURIComponent);
				key = key.replace(/[\(\)]/g, escape);

				return (document.cookie = [
					key, '=', value,
					attributes.expires && '; expires=' + attributes.expires.toUTCString(), // use expires attribute, max-age is not supported by IE
					attributes.path    && '; path=' + attributes.path,
					attributes.domain  && '; domain=' + attributes.domain,
					attributes.secure ? '; secure' : ''
				].join(''));
			}

			// Read

			if (!key) {
				result = {};
			}

			// To prevent the for loop in the first place assign an empty array
			// in case there are no cookies at all. Also prevents odd result when
			// calling "get()"
			var cookies = document.cookie ? document.cookie.split('; ') : [];
			var rdecode = /(%[0-9A-Z]{2})+/g;
			var i = 0;

			for (; i < cookies.length; i++) {
				var parts = cookies[i].split('=');
				var name = parts[0].replace(rdecode, decodeURIComponent);
				var cookie = parts.slice(1).join('=');

				if (cookie.charAt(0) === '"') {
					cookie = cookie.slice(1, -1);
				}

				try {
					cookie = converter && converter(cookie, name) || cookie.replace(rdecode, decodeURIComponent);

					if (this.json) {
						try {
							cookie = JSON.parse(cookie);
						} catch (e) {}
					}

					if (key === name) {
						result = cookie;
						break;
					}

					if (!key) {
						result[name] = cookie;
					}
				} catch (e) {}
			}

			return result;
		}

		api.get = api.set = api;
		api.getJSON = function () {
			return api.apply({
				json: true
			}, [].slice.call(arguments));
		};
		api.defaults = {};

		api.remove = function (key, attributes) {
			api(key, '', extend(attributes, {
				expires: -1
			}));
		};

		api.withConverter = init;

		return api;
	}

	return init();
}));

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
jQuery(document).ready(function(){

	//* Make all paragraphed image full-width, except when normal-width is applied
	// jQuery('#content .entry-content').find( 'p:not([class="normal-width"]) > img').parent().addClass('full-width');
	jQuery('#content > .entry .entry-content, #content .widget_black_studio_tinymce .textwidget').find( 'img, iframe' ).parent('p, div').not('[class="normal-width"]').addClass('full-width');

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