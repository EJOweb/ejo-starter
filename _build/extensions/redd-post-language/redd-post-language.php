<?php

class Redd_Post_Language
{
    //* Holds the instance of this class.
    protected static $_instance = null;

    //* Returns the instance.
    public static function init() 
    {
        if ( !self::$_instance )
            self::$_instance = new self;
        return self::$_instance;
    }

    //* Plugin setup.
    protected function __construct() 
    {
        add_action( 'add_meta_boxes', array( $this, 'add_post_language_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'save_post_language_meta_data' ) );
    }


    // Add Taal Module Meta Boxes to relevant post_types
    public function add_post_language_meta_boxes() 
    {
        add_meta_box( 'post_language_metabox', 'Taal Module', array( $this, 'render_post_language_metabox' ), 'post', 'side', 'default' );
        add_meta_box( 'post_language_metabox', 'Taal Module', array( $this, 'render_post_language_metabox' ), 'page', 'side', 'default' );
    }

    // The Taal Module Metabox
    public function render_post_language_metabox( $post ) 
    {
        // Noncename needed to verify where the data originated
        wp_nonce_field( 'redd-post-language-metabox-' . $post->ID, 'redd-post-language-meta-nonce' );

        $post_language_enabled = get_post_meta( $post->ID, '_redd-post-language-enabled', true );
        $post_language = get_post_meta( $post->ID, '_redd-post-language', true );
        $post_language_linked_post = get_post_meta( $post->ID, '_redd-post-language-linked-post', true );

        ?>
        <p>
            <input type="checkbox" name="redd-post-language-enabled" id="redd-post-language-enabled" <?php checked($post_language_enabled, true); ?> value="enabled" /><label for="redd-post-language-enabled">Inschakelen voor deze pagina</label>
        </p>

        <p>
            <strong>Taal van deze pagina</strong>
        </p>
        <p>
            <input type="checkbox" name="redd-post-language" id="redd-post-language-nl" <?php checked($post_language, 'NL'); ?> value="NL" /><label for="redd-post-language-nl" style="margin-right: 20px;">NL</label>
            <input type="checkbox" name="redd-post-language" id="redd-post-language-en" <?php checked($post_language, 'EN'); ?> value="EN" /><label for="redd-post-language-en">EN</label>
        </p>

        
        <p>
            <strong>Link naar andere vertaling</strong>
        </p>
        <p>
            <?php 

            $language_query_args = array(
                'post_type' => $post->post_type,
                'post__not_in' => array( $post->ID ),
                'posts_per_page' => -1
            );

            $language_posts = get_posts($language_query_args);

            ?>
            <select class="widefat" name="redd-post-language-linked-post" id="redd-post-language-linked-post">
                <option value="">Geen andere vertaling</option>

                <?php foreach ( $language_posts as $language_post ) : ?>

                    <option value="<?php echo $language_post->ID; ?>" <?php selected($post_language_linked_post, $language_post->ID, true); ?>><?php echo $language_post->post_title; ?></option>

                <?php endforeach; ?>

            </select>
                <?php /**/ ?>
        </p>

        <?php
    }

    // Manage saving Metabox Data
    public function save_post_language_meta_data($post_id) 
    {
        //* Don't try to save the data under autosave, ajax, or future post.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return;
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
            return;
        if ( defined( 'DOING_CRON' ) && DOING_CRON )
            return;

        //* Don't save if WP is creating a revision (same as DOING_AUTOSAVE?)
        if ( wp_is_post_revision( $post_id ) )
            return;

        //* Check that the user is allowed to edit the post
        if ( ! current_user_can( 'edit_post', $post_id ) )
            return;

        // Verify where the data originated
        if ( !isset($_POST['redd-post-language-meta-nonce']) || !wp_verify_nonce( $_POST['redd-post-language-meta-nonce'], 'redd-post-language-metabox-' . $post_id ) )
            return;


        //* Post Language Module Enabled
        $meta_key = '_redd-post-language-enabled';

        if ( isset( $_POST['redd-post-language-enabled'] ) )
            update_post_meta( $post_id, $meta_key, true );
        else 
            delete_post_meta( $post_id, $meta_key );

        //* Post Language
        $meta_key = '_redd-post-language';

        if ( isset( $_POST['redd-post-language'] ) )
            update_post_meta( $post_id, $meta_key, $_POST['redd-post-language'] );
        else 
            delete_post_meta( $post_id, $meta_key );
        

        //* Post Language Linked Post
        $meta_key = '_redd-post-language-linked-post';

        if ( !empty( $_POST['redd-post-language-linked-post'] ) )
            update_post_meta( $post_id, $meta_key, $_POST['redd-post-language-linked-post'] );
        else 
            delete_post_meta( $post_id, $meta_key );
    }
}

Redd_Post_Language::init();