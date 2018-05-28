<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/partial-and-miscellaneous-template-files/#footer-php
 *
 * @package Primer
 * @since   1.0.0
 */

?>

		</div><!-- #content -->

		<?php

		/**
		 * Fires before the `<footer>` element.
		 *
		 * @since 1.0.0
		 */
		do_action( 'primer_before_footer' );

		?>

		<footer id="colophon" class="site-footer">

			<div class="site-footer-inner">

				<?php

				/**
				 * Fires inside the `<footer>` element.
				 *
				 * @hooked primer_add_footer_widgets - 10
				 *
				 * @since 1.0.0
				 */
				do_action( 'primer_footer' );

				?>

			</div><!-- .site-footer-inner -->

		</footer><!-- #colophon -->

		<?php

		/**
		 * Fires after the `<footer>` element.
		 *
		 * @hooked primer_add_site_info - 10
		 *
		 * @since 1.0.0
		 */
		do_action( 'primer_after_footer' );

		?>

	</div><!-- #page -->

	<style type="text/css">

		.wnw-icon-linkedin{
			background-image: url(<?php echo get_template_directory_uri() ?>/assets/images/witan/icon-linkedin.jpg);
			width: 36px;
			height: 38px;
		}

		.wnw-icon-facebook{
			background-image: url(<?php echo get_template_directory_uri() ?>/assets/images/witan/icon-facebook.jpg);
			width: 36px;
			height: 38px;
		}

		.wnw-icon-twitter{
			background-image: url(<?php echo get_template_directory_uri() ?>/assets/images/witan/icon-twitter.jpg);
			width: 36px;
			height: 38px;
		}

		.wnw-icon-google-plus{
			background-image: url(<?php echo get_template_directory_uri() ?>/assets/images/witan/icon-google-plus.jpg);
			width: 36px;
			height: 38px;
		}

		.wnw-scroll-up{
			background-image: url(<?php echo get_template_directory_uri() ?>/assets/images/witan/scroll-top.png);
			background-size: 100%;
			width: 50px;
			height: 50px;
    		position: fixed;
    		bottom: 150px;
    		right: 50px;
			display: none;
			z-index: 9999;
		}		

	</style>

	<script type="text/javascript">
	(function($) {
		$(function() {

			/* Smooth scroll */
			$('a[href*="#"]:not([href="#"]):not([class="ys-exclude-smooth-scroll"])').on("click",function() {
			    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			      var target = $(this.hash);
			      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			      //console.log(target);
			      if (target.length) {
			        $('html, body').animate({
			          scrollTop: target.offset().top
			        }, 2500);
			        return false;
			      }
			    }
		    });


			$(document).ready(function(){

				$(".wnw-btn-signup").parent("a").attr("href", '<?php echo site_url(); ?>/wp-login.php?action=register');
				$(".wnw-btn-login").parent("a").attr("href", '<?php echo site_url(); ?>/wp-login.php');

				<?php 
					if(is_user_logged_in() == true){
				?>
						$(".wnw-btn-signup").hide();
				<?php
					}else{
				?>
						$(".wnw-btn-signup").show();
				<?php

					}
				?>

				slideWidth = $("#secondary").width();

				if(slideWidth == undefined || slideWidth == null){
					slideWidth = 350;
				}

				$('.wnw-market-indicator-slider').bxSlider({
	                minSlides: 1,
	                maxSlides: 1,
	                slideMargin: 0,
	                pager: true,
	                autoControls: true,
	                infiniteLoop: false,
	                controls: true,
	                auto: false,
	                speed: 1000,
	                pause: 5000,
	                adaptiveHeight: true,
	                hideControlOnEnd: true
	            });

	            if(document.getElementById("secondary") != null){
					widgetWidth = parseInt($("#secondary").width())-(parseInt($("#secondary").css("padding-left"))+parseInt($("#secondary").css("padding-right")));
				}else{
					widgetWidth = parseInt($(".wnw-article-content-right").width())-(parseInt($(".wnw-article-content-right").css("padding-left"))+parseInt($(".wnw-article-content-right").css("padding-right")));
				}

				if(widgetWidth == undefined || widgetWidth == null){
					widgetWidth = 350;
				}

	            setTimeout(function(){
		            $(".tradingview-widget-container").css("width",widgetWidth+"px");
		            $(".tradingview-widget-container").find("iframe").css("width",widgetWidth+"px");
	            }, 1000);


	        });			

	        $(window).resize(function(){
				if(document.getElementById("secondary") != null){
					widgetWidth = parseInt($("#secondary").width())-(parseInt($("#secondary").css("padding-left"))+parseInt($("#secondary").css("padding-right")));
				}else{
					widgetWidth = parseInt($(".wnw-article-content-right").width())-(parseInt($(".wnw-article-content-right").css("padding-left"))+parseInt($(".wnw-article-content-right").css("padding-right")));
				}

				if(widgetWidth == undefined || widgetWidth == null){
					widgetWidth = 350;
				}
				setTimeout(function(){
		            $(".tradingview-widget-container").css("width",widgetWidth+"px");
		            $(".tradingview-widget-container").find("iframe").css("width",widgetWidth+"px");
	            }, 1000);

	        });

			$(window).scroll(function() {

				// scrolled is new position just obtained
				var curscroll = $(document).scrollTop();

				//console.log(curscroll);

				if(curscroll > 50){
					$(".wnw-scroll-up").fadeIn();
				}else{
					$(".wnw-scroll-up").fadeOut();
				}
			});

		});

	})(jQuery);
	</script>

	<?php wp_footer(); ?>

</body>

</html>
