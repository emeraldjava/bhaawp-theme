<?php 

// bhaa custom
//remove_action('wp_head','wp_generator');
//remove_action('wp_head','wp_shortlink_wp_head' );
//remove_action('wp_head','adjacent_posts_rel_link_wp_head' );

// [pdf href="xx"]
function pdf_shortcode( $atts ) {
	extract( shortcode_atts( array(
	'href' => ''
			), $atts ) );
			// http://stackoverflow.com/questions/1244788/embed-vs-object
			return '<object data="'.$href.'" width="95%" height="675" type="application/pdf">
    			<embed src="'.$href.'" width="95%" height="675" type="application/pdf" />
			</object>';
}
//add_shortcode( 'pdf', 'pdf_shortcode' );


function count_team_runners( $query ) {
	if ( isset( $query->query_vars['query_id'] ) && 'count_team_runners' == $query->query_vars['query_id'] ) {
		$query->query_from = $query->query_from . ' LEFT OUTER JOIN (
                SELECT COUNT(p2p_id) as runners
                FROM wp_p2p
            ) p2p ON (wp_users.ID = p2p.p2p_from)';
		//$query->query_where = $query->query_where . ' AND rr.races > 0 ';
	}
}
//add_action('pre_user_query', array(&$this,'count_team_runners'));


/**
 * http://wordpress.org/support/topic/image_size_names_choose-not-working
 * http://www.deluxeblogtips.com/2011/06/list-registered-image-sizes.html
 */
function ml_custom_image_choose( $args ) {
	$image_sizes = get_intermediate_image_sizes();
	error_log('ml_custom_image_choose');
//	var_dump(print_r($image_sizes));
	//global $_wp_additional_image_sizes;
	// make the names human friendly by removing dashes and capitalising
	foreach( $image_sizes as $key => $value ) {
		$custom[ $key ] = ucwords( str_replace( '-', ' ', $key ) );
	}
	return array_merge( $args, $custom );
}
//add_filter('image_size_names_choose','ml_custom_image_choose');

?>