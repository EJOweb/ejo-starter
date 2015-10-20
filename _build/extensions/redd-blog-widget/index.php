<?php

//*
final class Redd_Blog_Widget extends WP_Widget
{
    //* Constructor. Set the default widget options and create widget.
    function __construct() 
    {
        $widget_title = 'StudioRedd Blog Widget';

        $widget_info = array(
            'classname'   => 'redd-blog-widget',
            'description' => 'Show last three blog items',
        );

        parent::__construct( 'redd-blog-widget', $widget_title, $widget_info );
    }

    public function widget( $args, $instance ) {

        $post_ids = array( $instance['blog1'], $instance['blog2'], $instance['blog3'] );

        if (empty($post_ids))
            return;

        echo $args['before_widget'];

        echo $args['before_title'] . $instance['title'] . $args['after_title'];

        //* Defaults?! ?>

        <div class="blog-posts columns columns-3">

            <?php foreach ($post_ids as $post_id) : ?>

                <?php $post = get_post( $post_id ); ?>
                <div class="entry">
                    <?php get_the_image( array( 'post_id' => $post_id, 'size' => 'thumbnail', 'link_class' => 'thumbnail-wrap' ) ); ?>
                    <header>
                        <h4 class="entry-title"><a href="<?php echo get_the_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a></h4>
                    </header>
                </div>

            <?php endforeach; ?>

        </div>

        <?php echo $args['after_widget'];
    }

    public function form( $instance ) 
    {
        $title = isset( $instance['title'] ) ? $instance['title'] : '';
        $blog1 = isset( $instance['blog1'] ) ? $instance['blog1'] : '';
        $blog2 = isset( $instance['blog2'] ) ? $instance['blog2'] : '';
        $blog3 = isset( $instance['blog3'] ) ? $instance['blog3'] : '';

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
        </p>
        <?php

        $query_args = array(
            'posts_per_page'   => -1,
        );

        //* Get all blog
        $all_blog_posts = get_posts($query_args);

        //* Show blog_post dropdowns
        ?>
        <p>
            <label>Artikel 1:</label> <?php $this->post_select('blog1', $blog1, $all_blog_posts); ?>
        </p>
        <p>
            <label>Artikel 2:</label> <?php $this->post_select('blog2', $blog2, $all_blog_posts); ?>
        </p>
        <p>
            <label>Artikel 3:</label> <?php $this->post_select('blog3', $blog3, $all_blog_posts); ?>
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) 
    {
        //* Store old instance as defaults
        $instance = $old_instance;

        //* Store new title
        $instance['title'] = strip_tags( $new_instance['title'] );

        //* Store blogs
        $instance['blog1'] = $new_instance['blog1'];
        $instance['blog2'] = $new_instance['blog2'];
        $instance['blog3'] = $new_instance['blog3'];
        
        return $instance;
    }

    public function post_select( $field_name, $field_value, $all_posts = null, $args = array() )
    {
        if (!isset($all_posts)) 
            $all_posts = get_posts($args);

        ?>
        <select name="<?php echo $this->get_field_name($field_name); ?>" class="widefat">
            
            <?php foreach ($all_posts as $post) : ?>

                <option value="<?php echo $post->ID; ?>" <?php selected($field_value, $post->ID); ?>>
                    <?php echo $post->post_title; ?>
                </option>

            <?php endforeach; ?>

        </select>
        <?php
    }
}


add_action( 'widgets_init', 'register_redd_blog_widget' );

//* Register Widget
function register_redd_blog_widget() 
{ 
    register_widget( 'Redd_Blog_Widget' ); 
}

// include_once( __FILE__ . '/functions.php' );