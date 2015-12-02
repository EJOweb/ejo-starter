# EJO Starter theme

# Gulp
Open command window in your theme root and run the following code (Node should be installed already)
npm install gulp gulp-util gulp-rename gulp-concat gulp-sourcemaps gulp-sass gulp-uglify gulp-jshint  --save-dev

# .htaccess
- Protect
- Cache
- Redirect

http://www.catswhocode.com/blog/10-useful-htaccess-snippets-to-have-in-your-toolbox
http://www.wpexplorer.com/htaccess-wordpress-security/

# Wp-config

Tip: add the following code to wp-config.php (Wordpress root folder)

/**
 * Limit number of revisions.
 *
 * Old revisions are automatically deleted
 */
define( 'WP_POST_REVISIONS', 3 );

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);

if (WP_DEBUG) {
	define('SCRIPT_DEBUG', true);
	define('WP_DEBUG_LOG', true);
	define('SAVEQUERIES', false); // Only activate when researching
}