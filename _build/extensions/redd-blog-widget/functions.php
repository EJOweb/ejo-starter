<?php

function get_category_color($id = null)
{
    if (!$id) {
        global $post;
        $id = $post->ID;
    }

    //* Get category id
    $category = get_the_category();
    $category_id = $category[0]->cat_ID;

    //* Get category_colors
    $category_colors = get_option( "_category_colors", array() );

    //* Get current category color
    return isset($category_colors[$category_id]) ? $category_colors[$category_id] : '';
}

?>