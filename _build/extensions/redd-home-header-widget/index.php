<?php

//*
final class Redd_Home_Header_Widget extends WP_Widget
{
    //* Constructor. Set the default widget options and create widget.
    function __construct() 
    {
        $widget_title = 'StudioRedd Home Header Widget';

        $widget_info = array(
            'classname'   => 'redd-home-header-widget',
            'description' => 'Choose image and link',
        );

        parent::__construct( 'redd-home-header-widget', $widget_title, $widget_info );

        add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts_styles' ) );
    }

    /**
     * Registers and enqueues admin-specific JavaScript and CSS only on widgets page.
     */ 
    public function register_admin_scripts_styles($hook) {

        wp_enqueue_style( 'redd-home-header-widget-admin-styles', THEME_LIB_URI . 'extensions/redd-home-header-widget/css/admin.css' );
        
        // Image Widget
        wp_enqueue_media();     
        wp_enqueue_script( 'redd-home-header-widget-admin-script', THEME_LIB_URI . 'extensions/redd-home-header-widget/js/admin.js', array('jquery'), false, true );

    }

    public function widget( $args, $instance ) {

        $image_id = isset( $instance['image_id'] ) ? $instance['image_id'] : '';
        $selected_post_id = isset( $instance['selected_post_id'] ) ? $instance['selected_post_id'] : '';
        $custom_title = isset( $instance['custom_title'] ) ? $instance['custom_title'] : '';

        if (empty($selected_post_id))
            return;

        //* Retrieve post data
        $featured_post = get_post($selected_post_id);

        //* Get image if no custom image selected
        if (empty($image_id)) {
            $query_args = array(
                'post_id'       => $selected_post_id,
                'size'          => 'large',
                'link'          => false,
                'image_class'   => 'header-image',
                'width'         => 'auto',
                'height'        => 'auto',
                'echo'          => false
            );
            $image = get_the_image($query_args);
        }
        else {
            $image = wp_get_attachment_image( $image_id, 'large', false, array('class'=>'header-image') );
        }

        //* Get featured post title if no custom title
        $featured_post_title = empty($custom_title) ? $featured_post->post_title : $custom_title;

        //* Create link button to last post
        $featured_post_button =   sprintf( '<a class="%s" href="%s" title="%s">%s</a>',
                                     'button-alt',
                                     get_the_permalink($selected_post_id),
                                     $featured_post_title,
                                     $featured_post_title );
        ?>

        <div class="header-image-container">

            <?php echo $image; ?>

            <div class="logo-post-container">
        
                <img class="logo" src="<?php echo THEME_IMG_URI . 'logo.png'; ?>" title="StudioRedd Logo">

                <?php echo $featured_post_button; ?>

            </div>

        </div>

    <?php
    }

    public function form( $instance ) 
    {
        $image_id = isset( $instance['image_id'] ) ? $instance['image_id'] : '';
        $selected_post_id = isset( $instance['selected_post_id'] ) ? $instance['selected_post_id'] : '';
        $custom_title = isset( $instance['custom_title'] ) ? $instance['custom_title'] : '';
        

        ?>
        <p class="redd-hhi-image-upload">

            <?php if ( $image_id ) : ?>

                <?php echo wp_get_attachment_image( $image_id, 'thumbnail', false ); ?>

            <?php endif; ?>

            <input id="<?php echo $this->get_field_id('image_id'); ?>" name="<?php echo $this->get_field_name('image_id'); ?>" type="hidden" value="<?php echo $image_id; ?>" class="redd-hhi-image-id" />
            <a class="button redd-hhi-upload-button" href="#">Kies een afbeelding</a>
            <a class="button redd-hhi-remove-button" href="#">Verwijder</a>
        </p>

        <?php

        //* Get project pages, projectoverzichtpages and blog posts

        $query_args = array(
            'posts_per_page' => -1,
            'post_type' => 'page',
            'meta_key' => '_wp_page_template',
            'meta_value' => 'template-projectoverzicht.php'
        );

        //* Get all projects
        $projectoverzicht_pages = get_posts($query_args);

        $query_args = array(
            'posts_per_page' => -1,
            'post_type' => 'page',
            'meta_key' => '_wp_page_template',
            'meta_value' => 'template-project.php'
        );

        //* Get all projects
        $project_pages = get_posts($query_args);

        $query_args = array(
            'posts_per_page' => -1,
        );

        //* Get all projects
        $blog_posts = get_posts($query_args);

        //* Merge all
        $all_posts = array_merge($projectoverzicht_pages, $project_pages, $blog_posts);

        ?>
        <p>
            <label>Kies een project of blogitem</label>

            <select name="<?php echo $this->get_field_name('selected_post_id'); ?>" class="widefat">
                
                <?php foreach ($all_posts as $post) : ?>

                    <option value="<?php echo $post->ID; ?>" <?php selected($selected_post_id, $post->ID); ?>>
                        <?php echo $post->post_title; ?>
                    </option>

                <?php endforeach; ?>

            </select>
        </p>

        <p>
            <label>Eventueel custom titel</label>
            <input type="text" name="<?php echo $this->get_field_name('custom_title'); ?>" value="<?php echo $custom_title; ?>" class="widefat">
        </p>

        <?php
    }

    public function update( $new_instance, $old_instance ) 
    {
        //* Store old instance as defaults
        $instance = $old_instance;

        //* Store 
        $instance['image_id'] = $new_instance['image_id'];
        $instance['selected_post_id'] = $new_instance['selected_post_id'];
        $instance['custom_title'] = $new_instance['custom_title'];
        
        return $instance;
    }
}


add_action( 'widgets_init', 'register_redd_home_header_widget' );

//* Register Widget
function register_redd_home_header_widget() 
{ 
    register_widget( 'Redd_Home_Header_Widget' ); 
}

// include_once( __FILE__ . '/functions.php' );