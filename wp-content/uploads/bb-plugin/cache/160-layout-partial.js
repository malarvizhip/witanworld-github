
(function($){$(function(){var slider=$('.fl-node-575b370c7aa4f .fl-content-slider-wrapper').bxSlider({adaptiveHeight:true,auto:true,autoHover:true,autoControls:false,pause:5000,mode:'fade',speed:500,controls:false,infiniteLoop:true,pager:false,video:true,onSliderLoad:function(currentIndex){$('.fl-node-575b370c7aa4f .fl-content-slider-wrapper').addClass('fl-content-slider-loaded');$('.fl-node-575b370c7aa4f iframe[src*="autoplay"]').each(function(){var src=$(this).attr('src');$(this).attr('data-url',src);if(!$(this).is(':visible')||0===$(this).parents('.fl-slide-0:not(.bx-clone)').length){$(this).attr('src','');}});},onSlideBefore:function(ele,oldIndex,newIndex){$('.fl-node-575b370c7aa4f .fl-content-slider-navigation a').addClass('disabled');$('.fl-node-575b370c7aa4f .bx-viewport > .bx-controls .bx-pager-link').addClass('disabled');},onSlideAfter:function(ele,oldIndex,newIndex){$('.fl-node-575b370c7aa4f .fl-slide-'+newIndex+':not(.bx-clone) iframe[data-url*="autoplay"]:visible').each(function(){var src=$(this).attr('data-url');$(this).attr('src',src);});$('.fl-node-575b370c7aa4f .fl-slide-'+oldIndex+':not(.bx-clone) iframe[src*="autoplay"]:visible').each(function(){var src=$(this).attr('src');$(this).attr('src','');});$('.fl-node-575b370c7aa4f .fl-content-slider-navigation a').removeClass('disabled');$('.fl-node-575b370c7aa4f .bx-viewport > .bx-controls .bx-pager-link').removeClass('disabled');}});slider.data('bxSlider',slider);$('.fl-node-575b370c7aa4f .slider-prev').on('click',function(e){e.preventDefault();slider.goToPrevSlide();});$('.fl-node-575b370c7aa4f .slider-next').on('click',function(e){e.preventDefault();slider.goToNextSlide();});});})(jQuery);(function($){$(function(){var slider=$('.fl-node-575b502740cb4 .fl-content-slider-wrapper').bxSlider({adaptiveHeight:true,auto:true,autoHover:true,autoControls:false,pause:5000,mode:'fade',speed:500,controls:false,infiniteLoop:true,pager:false,video:true,onSliderLoad:function(currentIndex){$('.fl-node-575b502740cb4 .fl-content-slider-wrapper').addClass('fl-content-slider-loaded');$('.fl-node-575b502740cb4 iframe[src*="autoplay"]').each(function(){var src=$(this).attr('src');$(this).attr('data-url',src);if(!$(this).is(':visible')||0===$(this).parents('.fl-slide-0:not(.bx-clone)').length){$(this).attr('src','');}});},onSlideBefore:function(ele,oldIndex,newIndex){$('.fl-node-575b502740cb4 .fl-content-slider-navigation a').addClass('disabled');$('.fl-node-575b502740cb4 .bx-viewport > .bx-controls .bx-pager-link').addClass('disabled');},onSlideAfter:function(ele,oldIndex,newIndex){$('.fl-node-575b502740cb4 .fl-slide-'+newIndex+':not(.bx-clone) iframe[data-url*="autoplay"]:visible').each(function(){var src=$(this).attr('data-url');$(this).attr('src',src);});$('.fl-node-575b502740cb4 .fl-slide-'+oldIndex+':not(.bx-clone) iframe[src*="autoplay"]:visible').each(function(){var src=$(this).attr('src');$(this).attr('src','');});$('.fl-node-575b502740cb4 .fl-content-slider-navigation a').removeClass('disabled');$('.fl-node-575b502740cb4 .bx-viewport > .bx-controls .bx-pager-link').removeClass('disabled');}});slider.data('bxSlider',slider);$('.fl-node-575b502740cb4 .slider-prev').on('click',function(e){e.preventDefault();slider.goToPrevSlide();});$('.fl-node-575b502740cb4 .slider-next').on('click',function(e){e.preventDefault();slider.goToNextSlide();});});})(jQuery);