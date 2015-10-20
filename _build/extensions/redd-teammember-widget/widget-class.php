<?php

//*
final class Redd_Teammember_Widget extends WP_Widget
{
    //* Constructor. Set the default widget options and create widget.
    function __construct() 
    {
        $widget_title = 'StudioRedd Teammember Widget';

        $widget_info = array(
            'classname'   => 'redd-teammember-widget',
            'description' => 'Teammember Widget',
        );

        parent::__construct( 'redd-teammember-widget', $widget_title, $widget_info );

        add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts_styles' ) );
    }

    /**
     * Registers and enqueues admin-specific JavaScript and CSS only on widgets page.
     */ 
    public function register_admin_scripts_styles($hook) {

        wp_enqueue_style( 'redd-teammember-widget-admin-styles', THEME_LIB_URI . 'extensions/redd-teammember-widget/css/admin.css' );
        
        // Image Widget
        wp_enqueue_media();     
        wp_enqueue_script( 'redd-teammember-widget-admin-script', THEME_LIB_URI . 'extensions/redd-teammember-widget/js/admin.js', array('jquery'), false, true );

    }

    public function widget( $args, $instance ) {

        //* Defaults
        $instance = wp_parse_args( (array) $instance, array( 
            'title' => '',
            'image-id' => '', 
            'image-id-action' => '', 
            'name' => '',
            'description' => '',
            'page-id' => '',
            'custom-link-text' => ''
        ));
        
        $title = $instance['title'];
        
        $image_id = $instance['image-id'];
        $image_id_action = $instance['image-id-action'];

        $name = $instance['name'];
        $description = $instance['description'];
        $page_id = $instance['page-id'];
        $custom_link_text = esc_attr( $instance['custom-link-text'] );

        $image = wp_get_attachment_image( $image_id, 'medium', false );
        $image_action = wp_get_attachment_image( $image_id_action, 'medium', false );

        ?>

        <div class="teammember">

            <?php echo $image; ?>
            <?php echo $image_action; ?>

        </div>

    <?php
    }

    public function form( $instance ) 
    {
        //* Defaults
        $instance = wp_parse_args( (array) $instance, array( 
            'title' => '',
            'image-id' => '', 
            'image-id-action' => '', 
            'name' => '',
            'description' => '',
            'page-id' => '',
            'custom-link-text' => ''
        ));
        
        $title = $instance['title'];
        
        $image_id = $instance['image-id'];
        $image_id_action = $instance['image-id-action'];

        $name = $instance['name'];
        $description = $instance['description'];
        $page_id = $instance['page-id'];
        $custom_link_text = esc_attr( $instance['custom-link-text'] );

        write_log($instance);

        ?>

        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <div class="image-upload">
            <label>Standaard afbeelding</label>
            <p class="image-container">
                <?php if ( $image_id ) : ?>

                    <?php echo wp_get_attachment_image( $image_id, 'thumbnail', false ); ?>

                <?php endif; ?>
            </p>

            <input type="hidden" id="<?php echo $this->get_field_id('image-id'); ?>" name="<?php echo $this->get_field_name('image-id'); ?>" value="<?php echo $image_id; ?>" class="image-id" />
            <a class="button upload-button" href="#">Kies een afbeelding</a>
            <a class="button remove-button" href="#">Verwijder</a>
        </div>

        <div class="image-upload">
            <label>Actie afbeelding</label>
            <p class="image-container">
                <?php if ( $image_id_action ) : ?>

                    <?php echo wp_get_attachment_image( $image_id_action, 'thumbnail', false ); ?>

                <?php endif; ?>
            </p>

            <input type="hidden" id="<?php echo $this->get_field_id('image-id-action'); ?>" name="<?php echo $this->get_field_name('image-id-action'); ?>" value="<?php echo $image_id_action; ?>" class="image-id" />
            <a class="button upload-button" href="#">Kies een afbeelding</a>
            <a class="button remove-button" href="#">Verwijder</a>
        </div>

        <p>
            <label>Naam</label>
            <input type="text" name="<?php echo $this->get_field_name('name'); ?>" value="<?php echo $name; ?>" class="widefat">
        </p>

        <p>
            <label>Beschrijving</label>
            <textarea name="<?php echo $this->get_field_name('description'); ?>" class="widefat"><?php echo $description; ?></textarea>
        </p>

        <?php

        //* Query all pages
        $query_args = array(
            'posts_per_page' => -1,
            'post_type' => 'page',
        );

        //* Get all pages
        $all_pages = get_posts($query_args);

        ?>
        <p>
            <label>Pagina</label>

            <select name="<?php echo $this->get_field_name('page-id'); ?>" class="widefat">
                
                <?php foreach ($all_pages as $page) : ?>

                    <option value="<?php echo $page->ID; ?>" <?php selected($page_id, $page->ID); ?>>
                        <?php echo $page->post_title; ?>
                    </option>

                <?php endforeach; ?>

            </select>
        </p>

        <p>
            <label>Eventueel custom link tekst</label>
            <input type="text" name="<?php echo $this->get_field_name('custom-link-text'); ?>" value="<?php echo $custom_link_text; ?>" class="widefat">
        </p>

       <?php
    }

    public function update( $new_instance, $old_instance )
    {
        //* Store old instance as defaults
        $instance = $old_instance;

        //* Store 
        $instance['title'] = strip_tags( $new_instance['title'] );

        $instance['image-id'] = $new_instance['image-id'];
        $instance['image-id-action'] = $new_instance['image-id-action'];

        $instance['name'] = strip_tags( $new_instance['name'] );
        $instance['description'] = $new_instance['description'];
        $instance['page-id'] = $new_instance['page-id'];
        $instance['custom-link-text'] = strip_tags( $new_instance['custom-link-text'] );

        
        return $instance;
    }
}


add_action( 'widgets_init', 'register_redd_teammember_widget' );

//* Register Widget
function register_redd_teammember_widget() 
{ 
    register_widget( 'Redd_Teammember_Widget' ); 
}

// include_once( __FILE__ . '/functions.php' );