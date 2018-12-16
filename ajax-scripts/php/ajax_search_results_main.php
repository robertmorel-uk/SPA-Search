<?php 
/*
Basic WordPress Ajax search response
Filename: ajax_get_search.php
Use only in plugin or modify for theme
*/


add_action( 'wp_enqueue_scripts', 'amw_spa_search_enqueue_assets_main' );

function amw_spa_search_enqueue_assets_main(){

    wp_enqueue_script( 'amwspasearch-ajax-get-search-handle_main', plugins_url( 'js/ajax_search_results_main.js', dirname(__FILE__) ), array('jquery'), '1.0', true );

					global $wp_query;
    				wp_localize_script( 'amwspasearch-ajax-get-search-handle_main', 'amwspasearchconf', array(
						'ajax_url' => admin_url( 'admin-ajax.php' )
					));
			}

	add_action( 'wp_ajax_nopriv_spasearch_ajax_get_search_main', 'isearch_func_main' );
	add_action( 'wp_ajax_spasearch_ajax_get_search_main', 'isearch_func_main' );

	function isearch_func_main() {

		$posts = new WP_Query( array(
		    'post_type' => array('any'),
		    'posts_per_page' => 5,
        	'order' => 'ASC',
        	'post_status' => 'publish',
		    's'=> esc_attr( $_POST['igetsearchresultsmain'] )
));

/*
if user clicks on link
get name of post
ajax search name of post
display content
*/


// The Loop
if ( $posts->have_posts() ) {

    while ( $posts->have_posts() ) : $posts->the_post(); ?>	
				<div <?php post_class( 'spasearch-ft-ajax-post-container-main' ); ?>>
				<h2 class="spasearch-ft-ajax-post-title-main" id="<?php the_ID(); ?>"><?php the_title(); ?>
				</h2>
			</div>

    <?php endwhile;

} else {
       echo "<h6 class='spasearch-ajax-search-form-text-main'>Sorry, no definitions found for that search term.</h6>";
}
/* Restore original Post Data */
wp_reset_postdata();

		die();
	}



add_action( 'wp_ajax_nopriv_spasearch_ajax_get_post_main', 'isearch_post_func_main' );
	add_action( 'wp_ajax_spasearch_ajax_get_post_main', 'isearch_post_func_main' );

	function isearch_post_func_main() {

$post_id = esc_attr( $_POST['igetsearchpostmain'] );
$queried_post = get_post($post_id);
$title = $queried_post->post_title;
echo"<div id='spasearch-wrap'><div id='spasearch-wrap-inner'>";
echo "<h2 class='spasearch-ft-ajax-post-content-title-main'>". $title."</h2>";



$content_post = get_post($post_id);
$content = $content_post->post_content;
$content = apply_filters('the_content', $content);
$content = str_replace(']]>', ']]&gt;', $content);
$content = str_replace("\r", "<br />", $content);
echo $content;
echo"</div></div>";



//$my_id_7 = get_post($post_id); 
//echo $my_id_7->post_content;

//wpautop($post->post_content)

//$content = apply_filters('the_content', $content);
//echo "<p class='spasearch-ft-ajax-post-content-main'>". $content."<p></div></div>";
wp_reset_postdata();

		die();
	}