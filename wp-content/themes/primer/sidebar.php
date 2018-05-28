<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/partial-and-miscellaneous-template-files/#sidebar-php
 *
 * @package Primer
 * @since   1.0.0
 */

if ( ! primer_layout_has_sidebar() || ! is_active_sidebar( 'sidebar-1' ) ) {

	return;

}

?>

<div id="secondary" class="widget-area" role="complementary">
	<?php /*get_top_trends_shortcode();*/ ?>
	<?php dynamic_sidebar( 'sidebar-1' ); ?>

</div><!-- #secondary -->


<?php while ( have_posts() ) : the_post(); 

	if(get_field('mi_chart_x_values') != ""){
		 generate_chart('market_indicator_page_chart',"");
	}

	if(get_field('mi2_chart_x_values') != ""){
		 generate_chart('market_indicator_page_chart2',"2");
	}

	if(get_field('mi3_chart_x_values') != ""){
		 generate_chart('market_indicator_page_chart3',"3");
	}

endwhile; ?>