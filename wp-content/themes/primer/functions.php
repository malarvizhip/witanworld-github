<?php
/**
 * Primer functions and definitions.
 *
 * Set up the theme and provide some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package Functions
 * @since   1.0.0
 */

/**
 * Primer theme version.
 *
 * @since 1.0.0
 *
 * @var string
 */
define( 'PRIMER_VERSION', '1.7.0' );

/**
 * Minimum WordPress version required for Primer.
 *
 * @since 1.0.0
 *
 * @var string
 */
if ( ! defined( 'PRIMER_MIN_WP_VERSION' ) ) {

	define( 'PRIMER_MIN_WP_VERSION', '4.4' );

}

/**
 * Define the Primer child theme version if undefined.
 *
 * @since 1.5.0
 *
 * @var string
 */
if ( ! defined( 'PRIMER_CHILD_VERSION' ) ) {

	define( 'PRIMER_CHILD_VERSION', '' );

}

/**
 * Load theme translations.
 *
 * Translations can be filed in the /languages/ directory. If you're
 * building a theme based on Primer, use a find and replace to change
 * 'primer' to the name of your theme in all the template files.
 *
 * @link  https://codex.wordpress.org/Function_Reference/load_theme_textdomain
 * @since 1.0.0
 */
load_theme_textdomain( 'primer', get_template_directory() . '/languages' );

/**
 * Enforce the minimum WordPress version requirement.
 *
 * @since 1.0.0
 */
if ( version_compare( get_bloginfo( 'version' ), PRIMER_MIN_WP_VERSION, '<' ) ) {

	require_once get_template_directory() . '/inc/compat/wordpress.php';

}

/**
 * Load deprecated hooks and functions for this theme.
 *
 * @since 1.6.0
 */
require_once get_template_directory() . '/inc/compat/deprecated.php';

/**
 * Load functions for handling special child theme compatibility conditions.
 *
 * @since 1.6.0
 */
require_once get_template_directory() . '/inc/compat/child-themes.php';

/**
 * Load custom helper functions for this theme.
 *
 * @since 1.0.0
 */
require_once get_template_directory() . '/inc/helpers.php';

/**
 * Load custom template tags for this theme.
 *
 * @since 1.0.0
 */
require_once get_template_directory() . '/inc/template-tags.php';

/**
 * Load custom primary nav menu walker.
 *
 * @since 1.0.0
 */
require_once get_template_directory() . '/inc/walker-nav-menu.php';

/**
 * Load template parts and override some WordPress defaults.
 *
 * @since 1.0.0
 */
require_once get_template_directory() . '/inc/hooks.php';

/**
 * Load Beaver Builder compatibility file.
 *
 * @since 1.0.0
 */
if ( class_exists( 'FLBuilder' ) ) {

	require_once get_template_directory() . '/inc/compat/beaver-builder.php';

}

/**
 * Load Jetpack compatibility file.
 *
 * @since 1.0.0
 */
if ( class_exists( 'Jetpack' ) ) {

	require_once get_template_directory() . '/inc/compat/jetpack.php';

}

/**
 * Load WooCommerce compatibility file.
 *
 * @since 1.0.0
 */
if ( class_exists( 'WooCommerce' ) ) {

	require_once get_template_directory() . '/inc/compat/woocommerce.php';

}

/**
 * Load Customizer class (must be required last).
 *
 * @since 1.0.0
 */
require_once get_template_directory() . '/inc/customizer.php';

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the 'after_setup_theme' hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @global array $primer_image_sizes
 * @since  1.0.0
 */
function primer_setup() {

	global $primer_image_sizes;

	/**
	 * Filter registered image sizes.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	$primer_image_sizes = (array) apply_filters( 'primer_image_sizes',
		array(
			'primer-featured' => array(
				'width'  => 1600,
				'height' => 9999,
				'crop'   => false,
				'label'  => esc_html__( 'Featured', 'primer' ),
			),
			'primer-hero' => array(
				'width'  => 2400,
				'height' => 1300,
				'crop'   => array( 'center', 'center' ),
				'label'  => esc_html__( 'Hero', 'primer' ),
			),
		)
	);

	foreach ( $primer_image_sizes as $name => &$args ) {

		if ( empty( $name ) || empty( $args['width'] ) || empty( $args['height'] ) ) {

			unset( $primer_image_sizes[ $name ] );

			continue;

		}

		$args['crop']  = ! empty( $args['crop'] ) ? $args['crop'] : false;
		$args['label'] = ! empty( $args['label'] ) ? $args['label'] : ucwords( str_replace( array( '-', '_' ), ' ', $name ) );

		add_image_size(
			sanitize_key( $name ),
			absint( $args['width'] ),
			absint( $args['height'] ),
			$args['crop']
		);

	}

	if ( $primer_image_sizes ) {

		add_filter( 'image_size_names_choose', 'primer_image_size_names_choose' );

	}

	/**
	 * Enable support for Automatic Feed Links.
	 *
	 * @link  https://developer.wordpress.org/reference/functions/add_theme_support/#feed-links
	 * @since 1.0.0
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for plugins and themes to manage the document title tag.
	 *
	 * @link  https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
	 * @since 1.0.0
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link  https://developer.wordpress.org/reference/functions/add_theme_support/#post-thumbnails
	 * @since 1.0.0
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * Enable support for customizer selective refresh.
	 *
	 * @link  https://developer.wordpress.org/reference/functions/add_theme_support/#customize-selective-refresh-widgets
	 * @since 1.0.0
	 */
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Register custom Custom Navigation Menus.
	 *
	 * @link  https://developer.wordpress.org/reference/functions/register_nav_menus/
	 * @since 1.0.0
	 */
	register_nav_menus(
		/**
		 * Filter registered nav menus.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		(array) apply_filters( 'primer_nav_menus',
			array(
				'primary' => esc_html__( 'Primary Menu', 'primer' ),
				'social'  => esc_html__( 'Social Menu', 'primer' ),
				'footer'  => esc_html__( 'Footer Menu', 'primer' ),
			)
		)
	);

	/**
	 * Enable support for HTML5 markup.
	 *
	 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
	 * @since 1.0.0
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);

	/**
	 * Enable support for Post Formats.
	 *
	 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Formats
	 * @since 1.0.0
	 */
	add_theme_support(
		'post-formats',
		array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		)
	);

}
add_action( 'after_setup_theme', 'primer_setup' );

/**
 * Register image size labels.
 *
 * @filter image_size_names_choose
 * @since  1.0.0
 *
 * @param  array $size_names Array of image sizes and their names.
 *
 * @return array
 */
function primer_image_size_names_choose( $size_names ) {

	global $primer_image_sizes;

	$labels = array_combine(
		array_keys( $primer_image_sizes ),
		wp_list_pluck( $primer_image_sizes, 'label' )
	);

	return array_merge( $size_names, $labels );

}

/**
 * Sets the content width in pixels, based on the theme layout.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @action after_setup_theme
 * @global int $content_width
 * @since  1.0.0
 */
function primer_content_width() {

	$layout        = primer_get_layout();
	$content_width = ( 'one-column-wide' === $layout ) ? 1068 : 688;

	/**
	 * Filter the content width in pixels.
	 *
	 * @since 1.0.0
	 *
	 * @param string $layout
	 *
	 * @var int
	 */
	$GLOBALS['content_width'] = (int) apply_filters( 'primer_content_width', $content_width, $layout );

}
add_action( 'after_setup_theme', 'primer_content_width', 0 );

/**
 * Enable support for custom editor style.
 *
 * @link  https://developer.wordpress.org/reference/functions/add_editor_style/
 * @since 1.0.0
 */
add_action( 'admin_init', 'add_editor_style', 10, 0 );

/**
 * Register sidebar areas.
 *
 * @link  http://codex.wordpress.org/Function_Reference/register_sidebar
 * @since 1.0.0
 */
function primer_register_sidebars() {

	/**
	 * Filter registered sidebars areas.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	$sidebars = (array) apply_filters( 'primer_sidebars',
		array(
			'sidebar-1' => array(
				'name'          => esc_html__( 'Sidebar', 'primer' ),
				'description'   => esc_html__( 'The primary sidebar appears alongside the content of every page, post, archive, and search template.', 'primer' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			),
			'sidebar-2' => array(
				'name'          => esc_html__( 'Secondary Sidebar', 'primer' ),
				'description'   => esc_html__( 'The secondary sidebar will only appear when you have selected a three-column layout.', 'primer' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			),
			'footer-1' => array(
				'name'          => esc_html__( 'Footer 1', 'primer' ),
				'description'   => esc_html__( 'This sidebar is the first column of the footer widget area.', 'primer' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			),
			'footer-2' => array(
				'name'          => esc_html__( 'Footer 2', 'primer' ),
				'description'   => esc_html__( 'This sidebar is the second column of the footer widget area.', 'primer' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			),
			'footer-3' => array(
				'name'          => esc_html__( 'Footer 3', 'primer' ),
				'description'   => esc_html__( 'This sidebar is the third column of the footer widget area.', 'primer' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			),
			'hero' => array(
				'name'          => esc_html__( 'Hero', 'primer' ),
				'description'   => esc_html__( 'Hero widgets appear over the header image on the front page.', 'primer' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			),
		)
	);

	foreach ( $sidebars as $id => $args ) {

		register_sidebar( array_merge( array( 'id' => $id ), $args ) );

	}

}
add_action( 'widgets_init', 'primer_register_sidebars' );

/**
 * Register Primer widgets.
 *
 * @link  http://codex.wordpress.org/Function_Reference/register_widget
 * @since 1.6.0
 */
function primer_register_widgets() {

	require_once get_template_directory() . '/inc/hero-text-widget.php';

	register_widget( 'Primer_Hero_Text_Widget' );

}
add_action( 'widgets_init', 'primer_register_widgets' );

/**
 * Enqueue theme scripts and styles.
 *
 * @link  https://codex.wordpress.org/Function_Reference/wp_enqueue_style
 * @link  https://codex.wordpress.org/Function_Reference/wp_enqueue_script
 * @since 1.0.0
 */
function primer_scripts() {

	$stylesheet = get_stylesheet();
	$suffix     = SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_style( $stylesheet, get_stylesheet_uri(), false, defined( 'PRIMER_CHILD_VERSION' ) ? PRIMER_CHILD_VERSION : PRIMER_VERSION );

	wp_style_add_data( $stylesheet, 'rtl', 'replace' );

	$nav_dependencies = ( is_front_page() && has_header_video() ) ? array( 'jquery', 'wp-custom-header' ) : array( 'jquery' );

	wp_enqueue_script( 'primer-navigation', get_template_directory_uri() . "/assets/js/navigation{$suffix}.js", $nav_dependencies, PRIMER_VERSION, true );
	wp_enqueue_script( 'primer-skip-link-focus-fix', get_template_directory_uri() . "/assets/js/skip-link-focus-fix{$suffix}.js", array(), PRIMER_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {

		wp_enqueue_script( 'comment-reply' );

	}

	if ( primer_has_hero_image() ) {

		$css = sprintf(
			SCRIPT_DEBUG ? '%s { background-image: url(%s); }' : '%s{background-image:url(%s);}',
			primer_get_hero_image_selector(),
			esc_url( primer_get_hero_image() )
		);

		wp_add_inline_style( $stylesheet, $css );

	}

}
add_action( 'wp_enqueue_scripts', 'primer_scripts' );

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call `the_post()` and `rewind_posts()`
 * in an author template to print information about the author.
 *
 * @action wp
 * @global WP_Query $wp_query
 * @global WP_User  $authordata
 * @since  1.0.0
 */
function primer_setup_author() {

	global $wp_query, $authordata;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {

		$authordata = get_userdata( $wp_query->post->post_author ); // override ok.

	}

}
add_action( 'wp', 'primer_setup_author' );

/**
 * Reset the transient for the active categories check.
 *
 * @action create_category
 * @action edit_category
 * @action delete_category
 * @action save_post
 * @see    primer_has_active_categories()
 * @since  1.0.0
 */
function primer_has_active_categories_reset() {

	delete_transient( 'primer_has_active_categories' );

}
add_action( 'create_category', 'primer_has_active_categories_reset' );
add_action( 'edit_category',   'primer_has_active_categories_reset' );
add_action( 'delete_category', 'primer_has_active_categories_reset' );
add_action( 'save_post',       'primer_has_active_categories_reset' );



add_shortcode('show_search_form', 'show_search_form_shortcode' );

function show_search_form_shortcode(){
	get_search_form();
}

/**
 * This creates the [witan_wisdom_list] shortcode and calls the
 * my_list_categories_shortcode() function.
 */
add_shortcode( 'witan_wisdom_list', 'my_list_categories_shortcode' );

/**
 * this function outputs your category list where you
 * use the [witan_wisdom_list] shortcode.
 */
function my_list_categories_shortcode() {
  echo '<span class="wnw-content-title wnw-margin-bottom-15px">Witan Sapience';
  echo '<span class="wnw-content-subtitle">"Knowledge Speaks & Wisdom Listens"</span>';
  echo '</span>';

  echo '<div class="wnw-category-wrapper">';
  wp_list_categories();   
/*    $categories =  get_categories();  
	foreach  ($categories as $category) {
	    //Display the sub category information using $category values like $category->cat_name
	    echo '<span>'.$category->name.'</span>';
	    //echo '<ul>';

	    foreach (get_posts('cat='.$category->term_id) as $post) {
	        setup_postdata( $post );
	        //echo '<li><a href="'.get_permalink($post->ID).'">'.get_the_title().'</a></li>';   
	    }  
	   // echo '</ul>';"
    }*/
    echo '</div>';
    echo '<div class="wnw-category-view-all">Show All</div>';
    echo '<div class="wnw-category-view-less">Show Less</div>';
}

add_shortcode('popular_posts' , 'get_popular_posts_shortcode');

function get_popular_posts_shortcode(){
	// args
	$args = array(
		'numberposts'	=> -1,
		'post_type'		=> 'post',
		'meta_key'		=> 'is_popular',
		'meta_value'	=> '1',
		'posts_per_page' => 5,
		'orderby'  		=> 'date',
		'order'			=> 'DESC'
	);


	// query
	$the_query = new WP_Query( $args );

	echo '<span class="wnw-content-title">Popular Articles</span>';

	if( $the_query->have_posts() ): 
		echo '<ul class="wnw-article-block">';
		while( $the_query->have_posts() ) : $the_query->the_post(); 
			echo '<li>';
				//the_field('main_image');
				/*$featured_image = get_metadata('post', get_the_ID(),'main_image');*/
				//$featured_image =  @implode(",",get_field('featured_image'));
				//$image_info = @explode(",",$featured_image);
				//$post_image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()));
				$post_image = get_the_post_thumbnail_url(null, array(150, 150));
				echo '<img src="';
				if($post_image == ""){
					echo './wp-content/themes/primer/assets/images/witan/image-placeholder.png';
				}else{
					echo $post_image;
				}
				echo '">';
				

				echo '<a class="ellipsis" href="';
				echo the_permalink(); 
				echo '">';
					echo the_title();
				echo '</a>	';				
/*				if(get_field('open_for_adding_content') == 'yes'){
					echo '<i class="fas fa-chart-bar" style="color:red;font-size:20px;margin-left:5px"></i>';
				}
				if(get_field('open_for_market_indicator_data') == 'yes'){
					echo '<i class="far fa-edit" style="color:green;font-size:20px;margin-left:5px"></i>';
				}*/
			echo '</li>';
		endwhile;
		echo '</ul>';
	endif;

	 wp_reset_query();	 // Restore global post data stomped by the_post(). 
}

function wpb_widgets_init() {
 
    register_sidebar( array(
        'name'          => 'Custom Header Widget Area',
        'id'            => 'custom-header-widget',
        'before_widget' => '<div class="chw-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="chw-title">',
        'after_title'   => '</h2>',
    ) );
 
}
add_action( 'widgets_init', 'wpb_widgets_init' );

add_shortcode('show_geolocation', 'get_geolocation');

function get_geolocation(){
    $user_ip = getenv('REMOTE_ADDR');
    
    //$geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
    $geo = json_decode(file_get_contents("http://freegeoip.net/json/$user_ip"), true);
    $country = $geo["country_name"];
    $city = $geo["city"];
    $state = $geo["region_name"];
    $region = $city;
    if($region == ""){
    	$region = $state;
    }

    echo "<span id='wnw-geolocation' style='height:0px;overflow:hidden;display:block'>";
	printf("%s, %s", $city, $country);
	echo "</span>";
}


// NOTE: Be sure to uncomment the following line in your php.ini file.
// ;extension=php_openssl.dll

// **********************************************
// *** Update or verify the following values. ***
// **********************************************


function BingNewsSearch ($url, $key, $query, $count, $market) {
    // Prepare HTTP request
    // NOTE: Use the key 'http' even if you are making an HTTPS request. See:
    // http://php.net/manual/en/function.stream-context-create.php
    $headers = "Ocp-Apim-Subscription-Key: $key\r\n";
    $options = array ('http' => array (
                          'header' => $headers,
                          'method' => 'GET' ));

    // Perform the Web request and get the JSON response
    $context = stream_context_create($options);
    $result = file_get_contents($url . "?q=" . urlencode($query) . "&count=" . urlencode($count) . "&mkt=" . urlencode($market) , false, $context);

    // Extract Bing HTTP headers
    $headers = array();
    foreach ($http_response_header as $k => $v) {
        $h = explode(":", $v, 2);
        if (isset($h[1]))
            if (preg_match("/^BingAPIs-/", $h[0]) || preg_match("/^X-MSEdge-/", $h[0]))
                $headers[trim($h[0])] = trim($h[1]);
    }

    return array($headers, $result);
}


add_shortcode('newsfeed_bing_api', 'call_BingNewsSearch');

function call_BingNewsSearch($atts){
	// Replace the accessKey string value with your valid access key.
	$accessKey = '84f8760a2b76401a92f93f9301932dc2';

	// Verify the endpoint URI.  At this writing, only one endpoint is used for Bing
	// search APIs.  In the future, regional endpoints may be available.  If you
	// encounter unexpected authorization errors, double-check this value against
	// the endpoint for your Bing Search instance in your Azure dashboard.
	$endpoint = 'https://api.cognitive.microsoft.com/bing/v7.0/news/search';

	$term = $atts['key'];

	$cnt = $atts['count'];

	$market = $atts['market'];

	$containerID = $atts['cid'];


	if(! empty( $term ) ){
	      if(strpos($term, "**location**") >= 0){
	        $user_ip = getenv('REMOTE_ADDR');
	        //$user_ip = "148:66:136:8";
	        $geo = json_decode(file_get_contents("http://freegeoip.net/json/$user_ip"), true);
	        $country = $geo["country_name"];
	        $city = $geo["city"];
	        $state = $geo["region_name"];

	        if($city != ""){
	          $str = $city;
	        }elseif($state != ""){
	          $str = $state;
	        }elseif($country != ""){
	          $str = $country;
	        }

	        $term = str_replace("**location**",$str ,$term);
	      }
    }
//echo $term;
	list($headers, $json) = BingNewsSearch($endpoint, $accessKey, $term, $cnt, $market);

	

/*	print "\nRelevant Headers:\n\n";
	foreach ($headers as $k => $v) {
	    print $k . ": " . $v . "\n";
	}*/

/*	print "\nJSON Response:\n\n";
	echo json_encode(json_decode($json), JSON_PRETTY_PRINT);*/

	$newsResult = json_decode($json, true);

	echo "<div id='" . $containerID . "'>";

	foreach($newsResult["value"] as $item){
		echo '<div class="row row-size1"> ';
		echo	'<div class="column small-3 medium-2"> ';
		if($item['image']["thumbnail"]["contentUrl"] != ""){
			echo	'<img src="'. $item['image']["thumbnail"]["contentUrl"] .'" alt="" role="presentation"> ';
		}else{
			echo	'<img src="'. get_template_directory_uri() .'/assets/images/witan/image-placeholder.png" width="100" height="100" alt="" role="presentation"> ';
		}
		echo	'</div> ';
		echo	'<div class="column small-9 medium-10"> ';
		if($item["datePublished"] != ""){
			$date_arr = explode("T", $item["datePublished"]);	
		}
		if($date_arr[0] != ""){
			$date=date_create($date_arr[0]);
			$date_published =  date_format($date,"D, d M Y");	
		}else{
			$date_published = "";
		}


		echo		'<span>' . $date_published . '</span> ';
		echo		'<a href="'. $item["url"] .'" target="_blank">' . $item["name"] . '</a> ';		
		echo		'<span class="description">' . $item["description"] . '</span> ';
		echo	'</div> ';
		echo '</div>';
	}

	echo "</div>";

}

add_shortcode('generate-chart', 'generate_chart');

function generate_chart($elmID, $chartNo){
	$pageid = get_the_ID();

	//$elmID = $elmID.$chartNo;

	$chart_type = get_field('mi'.$chartNo.'_chart_type');
	$chart_title = get_field('mi'.$chartNo.'_chart_title');
	$chart_x_vals = get_field('mi'.$chartNo.'_chart_x_values');
	$chart_y_vals = get_field('mi'.$chartNo.'_chart_y_values');
	$chart_x_axes_title = get_field('mi'.$chartNo.'_chart_x_axes_title');
	$chart_y_axes_title = get_field('mi'.$chartNo.'_chart_y_axes_title');
	$chart_legend_label = get_field('mi'.$chartNo.'_chart_legend_label');

	$chart_x_arr = explode(",", $chart_x_vals);
	$chart_y_arr = explode(",", $chart_y_vals);

	$chart_dataset = '[';
	$chart_labels = '[';

	$chartYcount = 1;

	if(get_field('mi'.$chartNo.'_chart_y_values2') != ""){
		$chart_y_vals2 = get_field('mi'.$chartNo.'_chart_y_values2');
		$chart_legend_label2 = get_field('mi'.$chartNo.'_chart_legend_label2');
		$chart_y_arr2 = explode(",", $chart_y_vals2);
		$chart_dataset2 = '[';
		$chartYcount++;
	}
	if(get_field('mi'.$chartNo.'_chart_y_values3') != ""){
		$chart_y_vals3 = get_field('mi'.$chartNo.'_chart_y_values3');
		$chart_legend_label3 = get_field('mi'.$chartNo.'_chart_legend_label3');
		$chart_y_arr3 = explode(",", $chart_y_vals3);
		$chart_dataset3 = '[';
		$chartYcount++;
	}	
	if(get_field('mi'.$chartNo.'_chart_y_values4') != ""){
		$chart_y_vals4 = get_field('mi'.$chartNo.'_chart_y_values4');
		$chart_legend_label4 = get_field('mi'.$chartNo.'_chart_legend_label4');
		$chart_y_arr4 = explode(",", $chart_y_vals4);
		$chart_dataset4 = '[';
		$chartYcount++;
	}	
	if(get_field('mi'.$chartNo.'_chart_y_values5') != ""){
		$chart_y_vals5 = get_field('mi'.$chartNo.'_chart_y_values5');
		$chart_legend_label5 = get_field('mi'.$chartNo.'_chart_legend_label5');
		$chart_y_arr5 = explode(",", $chart_y_vals5);
		$chart_dataset5 = '[';
		$chartYcount++;
	}	

	if($chart_x_vals != ""){
		foreach ($chart_x_arr as $k => $v) {
			if($chart_dataset == "["){
				//$chart_dataset .= "{x:'".trim($v," ")."',y:".trim($chart_y_arr[$k]," ")."}";
				$chart_dataset .= trim($chart_y_arr[$k]," ");
			}
			else{
				//$chart_dataset .= ",{x:'".trim($v," ")."',y:".trim($chart_y_arr[$k]," ")."}";
				$chart_dataset .= ",".trim($chart_y_arr[$k]," ");	
			}
			if($chart_y_vals2 != ""){
				if($chart_dataset2 == "["){	$chart_dataset2 .= trim($chart_y_arr2[$k]," ");	}
				else{$chart_dataset2 .= ",".trim($chart_y_arr2[$k]," ");}
			}
			if($chart_y_vals3 != ""){
				if($chart_dataset3 == "["){	$chart_dataset3 .= trim($chart_y_arr3[$k]," ");	}
				else{$chart_dataset3 .= ",".trim($chart_y_arr3[$k]," ");}
			}
			if($chart_y_vals4 != ""){
				if($chart_dataset4 == "["){	$chart_dataset4 .= trim($chart_y_arr4[$k]," ");	}
				else{$chart_dataset4 .= ",".trim($chart_y_arr4[$k]," ");}
			}
			if($chart_y_vals5 != ""){
				if($chart_dataset5 == "["){	$chart_dataset5 .= trim($chart_y_arr5[$k]," ");	}
				else{$chart_dataset5 .= ",".trim($chart_y_arr5[$k]," ");}
			}						


			if($chart_labels == "["){
				$chart_labels .= '"'.trim($v, " ").'"';
			}else{
				$chart_labels .= ',"'.trim($v, " ").'"';
			}

		}
	}
	$chart_labels .= ']';
	$chart_dataset .= ']';

	if($chart_y_vals2 != ""){
		$chart_dataset2 .= ']';
	}
	if($chart_y_vals3 != ""){
		$chart_dataset3 .= ']';
	}
	if($chart_y_vals4 != ""){
		$chart_dataset4 .= ']';
	}
	if($chart_y_vals5 != ""){
		$chart_dataset5 .= ']';
	}		

	//$chart_dataset = json_decode($chart_dataset);
	//$chart_labels = json_decode($chart_labels);


if($chart_type == 'bar' || $chart_type == 'line'){
	$chart_data = '\'{';
	$chart_data .= '"labels": '.$chart_labels.',';
	$chart_data .= '"datasets": [';
	$chart_data .= '{"label": "' . $chart_legend_label . '",';
	$chart_data .= '"data": '. $chart_dataset .',';
	$chart_data .= '"fill": true,';
	$chart_data .= '"backgroundColor": "rgba(255, 99, 132, 0.2)",';
	$chart_data .= '"borderColor": "rgb(255, 99, 132)",';
	$chart_data .= '"borderWidth": 1}';
	if($chart_y_vals2 != ""){
		$chart_data .= ',{"label": "' . $chart_legend_label2 . '",';
		$chart_data .= '"data": '. $chart_dataset2 .',';
		$chart_data .= '"fill": true,';
		$chart_data .= '"backgroundColor": "rgba(75, 192, 192, 0.2)",';
		$chart_data .= '"borderColor": "rgb(75, 192, 192)",';
		$chart_data .= '"borderWidth": 1}';
	}
	if($chart_y_vals3 != ""){
		$chart_data .= ',{"label": "' . $chart_legend_label3 . '",';
		$chart_data .= '"data": '. $chart_dataset3 .',';
		$chart_data .= '"fill": true,';
		$chart_data .= '"backgroundColor": "rgba(255, 159, 64, 0.2)",';
		$chart_data .= '"borderColor": "rgb(255, 159, 64)",';
		$chart_data .= '"borderWidth": 1}';
	}	
	if($chart_y_vals4 != ""){
		$chart_data .= ',{"label": "' . $chart_legend_label4 . '",';
		$chart_data .= '"data": '. $chart_dataset4 .',';
		$chart_data .= '"fill": true,';
		$chart_data .= '"backgroundColor": "rgba(255, 205, 86, 0.2)",';
		$chart_data .= '"borderColor": "rgb(255, 205, 86)",';
		$chart_data .= '"borderWidth": 1}';
	}	
	if($chart_y_vals5 != ""){
		$chart_data .= ',{"label": "' . $chart_legend_label5 . '",';
		$chart_data .= '"data": '. $chart_dataset5 .',';
		$chart_data .= '"fill": true,';
		$chart_data .= '"backgroundColor": "rgba(54, 162, 235, 0.2)",';
		$chart_data .= '"borderColor": "rgb(54, 162, 235)",';
		$chart_data .= '"borderWidth": 1}';
	}	
	$chart_data .= ']';
	$chart_data .= '}\'';
}elseif($chart_type == "pie"){
	$chart_data = '\'{';
	$chart_data .= '"labels": '.$chart_labels.',';
	$chart_data .= '"datasets": [';
	$chart_data .= '{"label": "' . $chart_legend_label . '",';
	$chart_data .= '"data": '. $chart_dataset .',';
	$chart_data .= '"fill": true,';
	$chart_data .= '"backgroundColor": ["rgba(255, 99, 132, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)","rgba(153, 102, 255, 0.2)","rgba(201, 203, 207, 0.2)","rgba(255, 111, 123, 0.2)","rgba(120, 230, 132, 0.2)","rgba(190, 99, 30, 0.2)"],';
		$chart_data .= '"borderColor": ["rgb(255, 99, 132)","rgb(255, 159, 64)","rgb(255, 205, 86)","rgb(75, 192, 192)","rgb(54, 162, 235)","rgb(153, 102, 255)","rgb(201, 203, 207)","rgb(255, 111, 123)","rgb(120, 230, 132)","rgb(190, 99, 30)"],';
	$chart_data .= '"borderWidth": 1}';
	if($chart_y_vals2 != ""){
		$chart_data .= ',{"label": "' . $chart_legend_label2 . '",';
		$chart_data .= '"data": '. $chart_dataset2 .',';
		$chart_data .= '"fill": true,';
		$chart_data .= '"backgroundColor": ["rgba(255, 99, 132, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)","rgba(153, 102, 255, 0.2)","rgba(201, 203, 207, 0.2)","rgba(255, 111, 123, 0.2)","rgba(120, 230, 132, 0.2)","rgba(190, 99, 30, 0.2)"],';
		$chart_data .= '"borderColor": ["rgb(255, 99, 132)","rgb(255, 159, 64)","rgb(255, 205, 86)","rgb(75, 192, 192)","rgb(54, 162, 235)","rgb(153, 102, 255)","rgb(201, 203, 207)","rgb(255, 111, 123)","rgb(120, 230, 132)","rgb(190, 99, 30)"],';
		$chart_data .= '"borderWidth": 1}';
	}
	if($chart_y_vals3 != ""){
		$chart_data .= ',{"label": "' . $chart_legend_label3 . '",';
		$chart_data .= '"data": '. $chart_dataset3 .',';
		$chart_data .= '"fill": true,';
		$chart_data .= '"backgroundColor": ["rgba(255, 99, 132, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)","rgba(153, 102, 255, 0.2)","rgba(201, 203, 207, 0.2)","rgba(255, 111, 123, 0.2)","rgba(120, 230, 132, 0.2)","rgba(190, 99, 30, 0.2)"],';
		$chart_data .= '"borderColor": ["rgb(255, 99, 132)","rgb(255, 159, 64)","rgb(255, 205, 86)","rgb(75, 192, 192)","rgb(54, 162, 235)","rgb(153, 102, 255)","rgb(201, 203, 207)","rgb(255, 111, 123)","rgb(120, 230, 132)","rgb(190, 99, 30)"],';
		$chart_data .= '"borderWidth": 1}';
	}	
	if($chart_y_vals4 != ""){
		$chart_data .= ',{"label": "' . $chart_legend_label4 . '",';
		$chart_data .= '"data": '. $chart_dataset4 .',';
		$chart_data .= '"fill": true,';
		$chart_data .= '"backgroundColor": ["rgba(255, 99, 132, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)","rgba(153, 102, 255, 0.2)","rgba(201, 203, 207, 0.2)","rgba(255, 111, 123, 0.2)","rgba(120, 230, 132, 0.2)","rgba(190, 99, 30, 0.2)"],';
		$chart_data .= '"borderColor": ["rgb(255, 99, 132)","rgb(255, 159, 64)","rgb(255, 205, 86)","rgb(75, 192, 192)","rgb(54, 162, 235)","rgb(153, 102, 255)","rgb(201, 203, 207)","rgb(255, 111, 123)","rgb(120, 230, 132)","rgb(190, 99, 30)"],';
		$chart_data .= '"borderWidth": 1}';
	}		
	if($chart_y_vals5 != ""){
		$chart_data .= ',{"label": "' . $chart_legend_label5 . '",';
		$chart_data .= '"data": '. $chart_dataset5 .',';
		$chart_data .= '"fill": true,';
		$chart_data .= '"backgroundColor": ["rgba(255, 99, 132, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)","rgba(153, 102, 255, 0.2)","rgba(201, 203, 207, 0.2)","rgba(255, 111, 123, 0.2)","rgba(120, 230, 132, 0.2)","rgba(190, 99, 30, 0.2)"],';
		$chart_data .= '"borderColor": ["rgb(255, 99, 132)","rgb(255, 159, 64)","rgb(255, 205, 86)","rgb(75, 192, 192)","rgb(54, 162, 235)","rgb(153, 102, 255)","rgb(201, 203, 207)","rgb(255, 111, 123)","rgb(120, 230, 132)","rgb(190, 99, 30)"],';
		$chart_data .= '"borderWidth": 1}';
	}	
	$chart_data .= ']';
	$chart_data .= '}\'';	
		
}
	//echo $chart_data;

	$chart_options = '\'{';
	$chart_options .= '"title":{';
	$chart_options .= 		'"display":true,';
	$chart_options .=		'"text": "'.$chart_title.'"';
	$chart_options .=  '}';

	if($chartYcount == 1){
		$chart_options .= ',"legend":{';
		$chart_options .=		'"display":false';
		$chart_options .= '}';
	}

	if($chart_type == 'bar' || $chart_type == 'line'){
		$chart_options .= ',"scales":{';
		$chart_options .= 		'"yAxes":[';
		$chart_options .=				'{"ticks":';
		$chart_options .=					'{"beginAtZero": true}';
		$chart_options .=				',"scaleLabel":';
		$chart_options .=					'{"display": true,';
		$chart_options .=					'"labelString":"' .$chart_y_axes_title.'",';
		$chart_options .=					'"padding": 1}';
		$chart_options .=				'}';
		$chart_options .=		']';
		$chart_options .= 		',"xAxes":[';
		$chart_options .=				'{"scaleLabel":';
		$chart_options .=					'{"display": true,';
		$chart_options .=					'"labelString":"' .$chart_x_axes_title.'",';
		$chart_options .=					'"padding": 1}';
		$chart_options .=				'}';
		$chart_options .=		']';		
		$chart_options .=	'}';
	}elseif($chart_type == "pie"){
		
	}

	$chart_options .= '}\'';

	//$chart_data = json_decode($chart_data);

	if($chart_x_vals != "" && $chart_y_vals != ""){

		echo '<script type="text/javascript">';
		echo '	(function($) {';
		echo  		'$(function() {';
		echo			'$("#'.$elmID.'").show();';
		echo			'$("#'.$elmID.'").parent("li").show();';
		echo    		'draw_graph("'. $elmID . '","' . $chart_type . '",' . $chart_data . ',"' . $chart_title . '",' .$chart_options . ');';
		echo			'$("#'.$elmID.'").parent("li").appendTo(".wnw-mi-slider");';
		echo		'});';
		echo    '})(jQuery);';
		echo '</script>';

	}


	echo '<script type="text/javascript">';
	echo	'function draw_graph(canId, type, dataString, title, optionsString){';
//				echo		'alert(canId);';
	echo 		'var data = jQuery.parseJSON(dataString);';
	echo  		'var options = jQuery.parseJSON(optionsString);';
	echo		'var ctx = document.getElementById(canId).getContext("2d");';
	echo		'var myChart = new Chart(ctx, {';
	echo			'type: type,';
	echo			'data: data,';
	echo			'options: options';
	echo		'});';
	echo	'}';


	echo  '</script>';

}

add_shortcode('top_trends' , 'get_top_trends_shortcode');

function get_top_trends_shortcode(){
	// args
	$args = array(
		'numberposts'	=> -1,
		'post_type'		=> 'post',
		'meta_key'		=> 'open_for_adding_content',
		'meta_value'	=> 'yes',
		'posts_per_page' => 25,
		'orderby'  		=> 'date',
		'order'			=> 'DESC'
	);


	// query
	$the_query = new WP_Query( $args );

	if( $the_query->have_posts() ): 

		echo '<div class="wnw-section-wrapper">';
		echo 	'<h4 class="widget-title">Top Trends</h4>';
		echo 	'<ul class="wnw-section-block">';
		while( $the_query->have_posts() ) : $the_query->the_post(); 
			echo '<li>';
				//the_field('main_image');
				/*$featured_image = get_metadata('post', get_the_ID(),'main_image');*/
				//$featured_image =  @implode(",",get_field('featured_image'));
				//$image_info = @explode(",",$featured_image);
				/*$post_image = get_the_post_thumbnail_url();
				echo '<img style="max-height:132px;margin-top:10px;" src="';
				//echo $image_info[6];
				if($post_image == ""){
					echo './wp-content/themes/primer/assets/images/witan/image-placeholder.png';
				}else{
					echo $post_image;
				}
				echo '">';*/

				echo '<a href="';
				echo the_permalink(); 
				echo '">';
					echo the_title();
				echo '</a>	';				
				if(get_field('open_for_adding_content') == 'yes'){
					echo '<i class="far fa-edit" style="color:green;font-size:16px;margin-left:5px"></i>';				
				}
				if(get_field('open_for_market_indicator_data') == 'yes'){
					echo '<i class="fas fa-chart-bar" style="color:red;font-size:16px;margin-left:5px"></i>';
				}
			echo '</li>';
		endwhile;
		echo '</ul>';
		echo '</div>';
	endif;

	 wp_reset_query();	 // Restore global post data stomped by the_post(). 
}