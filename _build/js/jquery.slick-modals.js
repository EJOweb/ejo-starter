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