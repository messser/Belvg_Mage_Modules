/* ------------------------------------------------------------------------
    Class: prettyLoader
    Use: A unified solution for AJAX loader
    Author: Stephane Caron (http://www.no-margin-for-errors.com)
    Version: 1.0.1
------------------------------------------------------------------------- */
;(function($) {
    $.prettyLoader = {version: '1.0.1'};
    
    $.prettyLoader = function(settings) {
        settings = jQuery.extend({
            animation_speed: 'fast', /* fast/normal/slow/integer */
            bind_to_ajax: true, /* true/false */
            delay: false, /* false OR time in milliseconds (ms) */
            loader: '/images/prettyLoader/ajax-loader.gif', /* Path to your loader gif */
            offset_top: 13, /* integer */
            offset_left: 10 /* integer */
        }, settings);
        
        scrollPos = _getScroll();
        var cur_x = 0;
        var cur_y = 0;
        
        /*imgLoader = new Image();
        imgLoader.onerror = function(){
            alert('Preloader image cannot be loaded. Make sure the path is correct in the settings and that the image is reachable.');
        };
        imgLoader.src = settings.loader;*/
        
        if (settings.bind_to_ajax) {
            jQuery(document).ajaxStart(function() {
                $.prettyLoader.show();
            }).ajaxStop(function() {
                $.prettyLoader.hide();
            });
        }
        
        $.prettyLoader.positionLoader = function(e) {
            e = e ? e : window.event;
            
            // Set the cursor pos only if the even is returned by the browser.
            cur_x = (e.clientX) ? e.clientX : cur_x;
            cur_y = (e.clientY) ? e.clientY : cur_y;
            
            left_pos = cur_x + settings.offset_left + scrollPos['scrollLeft'];
            top_pos  = cur_y + settings.offset_top + scrollPos['scrollTop'];
            
            $('.prettyLoader').css({
                'top':top_pos,
                'left':left_pos
            });
        }
        
        $.prettyLoader.show = function(delay) {
            if ($('.prettyLoader').size() > 0) return;
            
            // Get the scroll position
            scrollPos = _getScroll();
            
            // Build the loader container
            $('<div></div>')
                .addClass('prettyLoader')
                .addClass('prettyLoader_' + settings.theme)
                .appendTo('body')
                .hide();
            
            // No png for IE6...sadly :(
            if ($.browser.msie && $.browser.version == 6) {
                $('.prettyLoader').addClass('pl_ie6');
            }
            
            // Build the loader image
            /*$('<img />')
                .attr('src',settings.loader)
                .appendTo('.prettyLoader');*/
            
            // Show it!
            $('.prettyLoader').fadeIn(settings.animation_speed);
            
            $(document).bind('click',$.prettyLoader.positionLoader);
            $(document).bind('mousemove',$.prettyLoader.positionLoader);
            $(window).scroll(function() {
                scrollPos = _getScroll();
                $(document).triggerHandler('mousemove');
            });
            
            delay = (delay) ? delay : settings.delay;
            
            if (delay) {
                setTimeout(function(){ $.prettyLoader.hide() }, delay);
            }
        };
        
        $.prettyLoader.hide = function() {
            $(document).unbind('click',$.prettyLoader.positionLoader);
            $(document).unbind('mousemove',$.prettyLoader.positionLoader);
            $(window).unbind('scroll');
                        
            $('.prettyLoader').fadeOut(settings.animation_speed,function(){
                $(this).remove();
            });
        };
        
        function _getScroll()
        {
            if (self.pageYOffset) {
                return {scrollTop:self.pageYOffset,scrollLeft:self.pageXOffset};
            } else if (document.documentElement && document.documentElement.scrollTop) { // Explorer 6 Strict
                return {scrollTop:document.documentElement.scrollTop,scrollLeft:document.documentElement.scrollLeft};
            } else if (document.body) {// all other Explorers
                return {scrollTop:document.body.scrollTop,scrollLeft:document.body.scrollLeft};
            };
        };
        
        return this;
    };

})(jQuery);

var Ajaxloader = {
    disabled : false,
    overlayColor: null,
    overlayOpacity: 0.6,
    overlayElement: '.main-container',
    overlayLoader: null,
    overlayLoaderOpacity: 0.6,
    animationSpeed: 800,
    isDisabled : function()
    {
        if (this.disabled == true) {
            this.disabled = false;
            return true;
        }
        
        return false;
    },
    disable : function()
    {
        this.disabled = true;
    },
    setOverlaySettings: function(color, opacity, element, loader, loader_opacity)
    {
        this.overlayColor   = color ? color : this.overlayColor;
        this.overlayOpacity = opacity?opacity:this.overlayOpacity;
        this.overlayElement = element?element:this.overlayElement;
        this.overlayLoader  = loader?loader:this.overlayLoader;
        this.overlayLoaderOpacity = loader_opacity?loader_opacity:this.overlayLoaderOpacity;
        
        return this;
    },
    setOverlayElement : function(element)
    {
        this.overlayElement = element ? element : this.overlayElement;
        
        return this;
    },
    setAnimationSpeed : function(speed)
    {
        this.animationSpeed = parseInt(speed);
        
        return this;
    },
    showCursorLoader : function()
    {
        jQuery.prettyLoader.show();
        
        return this;
    },
    hideCursorLoader : function()
    {
        jQuery.prettyLoader.hide();
        
        return this;
    },
    activateOverlay : function()
    {
        if (this.overlayColor) {
            var element = jQuery(this.overlayElement);
            element.append('<div class="belvg-main-overlay"></div>');
            var overlay = jQuery('.belvg-main-overlay');
            overlay.css({
                'position'  : 'absolute',
                'opacity'   : 0,
                'z-index'   : 29999,
                'background': this.overlayColor,
                'width'     : element.outerWidth(true) + 'px',
                'height'    : element.outerHeight(true) + 'px',
                'left'      : element.position().left + 'px',
                'top'       : element.position().top + 'px'
            }).stop().animate({'opacity':this.overlayOpacity}, this.animationSpeed);
        }
        
        return this;    
    },
    disableOverlay : function()
    {
        var overlay = jQuery('.belvg-main-overlay');
        overlay.stop().animate({'opacity':0}, this.animationSpeed, function() {
            overlay.remove();
        });
        
        return this;
    },
    showMainLoader : function()
    {
        if (this.overlayLoader) {
            jQuery('body').append('<div class="belvg-main-loader"></div>');
            background = 'url('+this.overlayLoader+') center center no-repeat transparent';
            jQuery('.belvg-main-loader').css({
                'position':'fixed',
                'opacity':0,
                'z-index':29999,
                'background': background,
                'width': jQuery(window).outerWidth(true)+'px',
                'height': jQuery(window).outerHeight(true)+'px',
                'left': '0',
                'top': '0'
            }).stop().animate({'opacity':this.overlayLoaderOpacity}, this.animationSpeed);
        }
        
        return this;
    },
    hideMainLoader : function()
    {
        jQuery('.belvg-main-loader').stop().animate({'opacity':0}, this.animationSpeed, function() {
            jQuery('.belvg-main-loader').remove();
        });
        
        return this;
    }
};