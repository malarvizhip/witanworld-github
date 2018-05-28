<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Primer
 * @since   1.0.0
 */

get_header(); ?>

<div id="primary" class="content-area">

	<main id="main" class="site-main" role="main">

	<?php while ( have_posts() ) : the_post(); ?>

		<div class="wnw-article-content-left">

			<?php get_template_part( 'content' ); ?>

			<div class="wnw-custom-field-container">
				<p><?php the_field('management_subtitle'); ?></p>
				<p><?php the_field('management'); ?></p>
				<p><?php the_field('future_trends_subtitle'); ?></p>
				<p><?php the_field('future_trends'); ?></p>
				<p><?php the_field('sources_title'); ?></p>
				<p><?php the_field('sources'); ?></p>
			</div>

		<?php primer_post_nav(); ?>

		<?php if ( comments_open() || get_comments_number() ) : ?>

			<?php comments_template(); ?>

		<?php endif; ?>

		</div>
		<div class="wnw-article-content-right">
			<?php 
			$bidding = get_field('bidding_section');
			if( !empty($bidding) ): ?>
				<p><strong>Bidding:</strong></p>
				<div class="wnw-chart_wrapper">
					<?php echo $bidding; ?>
					<!-- <div class="wnw-hide-chart-ctrls">
						<div class="wnw-border-bottom-outer">
							<div class="wnw-border-bottom-inner"></div>
						</div>
					</div> -->
				</div>
			<?php endif; ?>		
			<!-- TradingView Widget BEGIN -->
			<p><strong>Market Trends:</strong></p>
			<div class="tradingview-widget-container">
				<div class="tradingview-widget-container__widget"></div>
				<!--<div class="tradingview-widget-copyright"><a href="https://in.tradingview.com" rel="noopener" target="_blank"><span class="blue-text">Market Data</span></a> by TradingView</div>-->
				<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-market-overview.js" async>
			  {
			  "showChart": true,
			  "locale": "in",
			  "largeChartUrl": "",
			  "width": "290",
			  "height": "660",
			  "plotLineColorGrowing": "rgba(60, 188, 152, 1)",
			  "plotLineColorFalling": "rgba(255, 74, 104, 1)",
			  "gridLineColor": "rgba(233, 233, 234, 1)",
			  "scaleFontColor": "rgba(233, 233, 234, 1)",
			  "belowLineFillColorGrowing": "rgba(60, 188, 152, 0.05)",
			  "belowLineFillColorFalling": "rgba(255, 74, 104, 0.05)",
			  "symbolActiveColor": "rgba(242, 250, 254, 1)",
			  "tabs": [
			    {
			      "title": "Indices",
			      "symbols": [
			        {
			          "s": "USI:TICK",
			          "d": "NYSE Cumulative Tick"
			        },
			        {
			          "s": "INDEX:TIKI",
			          "d": "Dow 30"
			        },
			        {
			          "s": "LSE:LSE",
			          "d": "LSE"
			        },
			        {
			          "s": "INDEX:NKY",
			          "d": "Nikke 225"
			        },
			        {
			          "s": "OTC:EUXTF",
			          "d": "Euronext"
			        },
			        {
			          "s": "OTC:DBORY",
			          "d": "Deutsche Borse AG"
			        },
			        {
			          "s": "INDEX:XLY0",
			          "d": "Shanghai"
			        },
			        {
			          "s": "NASDAQ:NDX",
			          "d": "Nasdaq 100"
			        },
			        {
			          "s": "NSE:NIFTY",
			          "d": "Nifty 50"
			        },
			        {
			          "s": "BSE:BSE100",
			          "d": "BSE 100 Index"
			        }
			      ],
			      "originalTitle": "Indices"
			    },
			    {
			      "title": "Commodities",
			      "symbols": [
			        {
			          "s": "CME_MINI:ES1!",
			          "d": "E-Mini S&P"
			        },
			        {
			          "s": "CME:E61!",
			          "d": "Euro"
			        },
			        {
			          "s": "COMEX:GC1!",
			          "d": "Gold"
			        },
			        {
			          "s": "NYMEX:CL1!",
			          "d": "Crude Oil"
			        },
			        {
			          "s": "NYMEX:NG1!",
			          "d": "Natural Gas"
			        },
			        {
			          "s": "CBOT:ZC1!",
			          "d": "Corn"
			        }
			      ],
			      "originalTitle": "Commodities"
			    },
			    {
			      "title": "Bonds",
			      "symbols": [
			        {
			          "s": "CME:GE1!",
			          "d": "Eurodollar"
			        },
			        {
			          "s": "CBOT:ZB1!",
			          "d": "T-Bond"
			        },
			        {
			          "s": "CBOT:UD1!",
			          "d": "Ultra T-Bond"
			        },
			        {
			          "s": "EUREX:GG1!",
			          "d": "Euro Bund"
			        },
			        {
			          "s": "EUREX:II1!",
			          "d": "Euro BTP"
			        },
			        {
			          "s": "EUREX:HR1!",
			          "d": "Euro BOBL"
			        }
			      ],
			      "originalTitle": "Bonds"
			    },
			    {
			      "title": "Forex",
			      "symbols": [
			        {
			          "s": "FX:EURUSD"
			        },
			        {
			          "s": "FX:GBPUSD"
			        },
			        {
			          "s": "FX:USDJPY"
			        },
			        {
			          "s": "FX:USDCHF"
			        },
			        {
			          "s": "FX:AUDUSD"
			        },
			        {
			          "s": "FX:USDCAD"
			        }
			      ],
			      "originalTitle": "Forex"
			    }
			  ]
			}
			  </script>
			</div>
			<!-- TradingView Widget END -->
			<?php
				if(get_field('mi_chart_x_values') != "" && get_field('mi_chart_y_values') != ""){
			?>
			<p><strong>Market Indicator:</strong></p>
			<ul class="bxslider wnw-market-indicator-slider">
			<li>
			<canvas class="wnw-chart-canvas" id="market_indicator_post_chart" width="300" height="280"></canvas>
			<?php					
				generate_chart('market_indicator_post_chart',"");
			?>
			</li>
			<?php				
				}
			?>
			
			<?php
				if(get_field('mi2_chart_x_values') != "" && get_field('mi2_chart_y_values') != ""){
			?>
			<li>
			<canvas class="wnw-chart-canvas" id="market_indicator_post_chart2" width="300" height="280"></canvas>
			<?php					
				generate_chart('market_indicator_post_chart2',"2");
			?>
			</li>
			<?php
				}
			?>

			<?php
				if(get_field('mi3_chart_x_values') != "" && get_field('mi3_chart_y_values') != ""){
			?>
			<li>
			<canvas class="wnw-chart-canvas" id="market_indicator_post_chart3" width="300" height="280"></canvas>
			<?php					
				generate_chart('market_indicator_post_chart3',"3");
			?>
			</li>
			<?php				
				}
			?>			

			<?php
				if(get_field('mi_chart_x_values') != "" && get_field('mi_chart_y_values') != ""){
			?>			
			</ul>
			<?php 
				}
			?>

			<?php 
			$image = get_field('product_indicator');
			if( !empty($image) ): ?>
				<p><strong>Product Indicator:</strong></p>
				<a href="<?php the_field('product_indicator_url') ?>" target="_blank"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" /></a>
			<?php endif; ?>

			<?php 
			$image = get_field('product_indicator2');
			if( !empty($image) ): ?>
				<a href="<?php the_field('product_indicator_url2') ?>" target="_blank"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" /></a>
			<?php endif; ?>			
			<?php 
			$image = get_field('product_indicator3');
			if( !empty($image) ): ?>
				<a href="<?php the_field('product_indicator_url3') ?>" target="_blank"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" /></a>
			<?php endif; ?>		
			<?php 
			$image = get_field('product_indicator4');
			if( !empty($image) ): ?>
				<a href="<?php the_field('product_indicator_url4') ?>" target="_blank"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" /></a>
			<?php endif; ?>		
			<?php 
			$image = get_field('product_indicator5');
			if( !empty($image) ): ?>
				<a href="<?php the_field('product_indicator_url5') ?>" target="_blank"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" /></a>
			<?php endif; ?>		
			<?php 
			$image = get_field('product_indicator6');
			if( !empty($image) ): ?>
				<a href="<?php the_field('product_indicator_url6') ?>" target="_blank"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" /></a>
			<?php endif; ?>				
			<?php 
			$image = get_field('product_indicator7');
			if( !empty($image) ): ?>
				<a href="<?php the_field('product_indicator_url7') ?>" target="_blank"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" /></a>
			<?php endif; ?>		
			<?php 
			$image = get_field('product_indicator8');
			if( !empty($image) ): ?>
				<a href="<?php the_field('product_indicator_url8') ?>" target="_blank"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" /></a>
			<?php endif; ?>			
			<?php 
			$image = get_field('product_indicator9');
			if( !empty($image) ): ?>
				<a href="<?php the_field('product_indicator_url9') ?>" target="_blank"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" /></a>
			<?php endif; ?>
			<?php 
			$image = get_field('product_indicator10');
			if( !empty($image) ): ?>
				<a href="<?php the_field('product_indicator_url10') ?>" target="_blank"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" /></a>
			<?php endif; ?>

			<div class="wnw-advertisement-wrapper">
				<p><strong>Advertisement:</strong></p>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 wnw-padding-left-0 wnw-padding-right-0 wnw-margin-bottom-10px">
					<img src="<?php echo get_template_directory_uri() ?>/assets/images/witan/ad1.jpg" class="img-responsive" alt="advertisement" />
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 wnw-padding-left-0 wnw-padding-right-0">
					<img src="<?php echo get_template_directory_uri() ?>/assets/images/witan/ad2.jpg" class="img-responsive" alt="advertisement" />
				</div>
			</div>

		</div>



	<?php endwhile; ?>

	</main><!-- #main -->

</div><!-- #primary -->

<?php get_sidebar(); ?>

<?php get_sidebar( 'tertiary' ); ?>

<?php get_footer(); ?>

<script type="text/javascript">

(function($) {
	$(function() {

		
    });
})(jQuery);
</script>