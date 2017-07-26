<?php
function nguoimientay_search_filter( $query ) {
    if ( $query->is_search ) {
        $query->set( 'post_type', array('post','video') );
    }
    return $query;
}
add_filter('pre_get_posts','nguoimientay_search_filter');
