<?php
/*
Plugin Name: Add Thumbnail To Post Table
Description: Adds the featured image as a thumbnail in the post table column
Version: 1.0.0
License: GNU General Public License v2 or later
License URI: LICENSE
Author: Brandon Jones
Author URI: http://www.brandonsj.me/
*/

if( !defined( 'ATTPT_VER' ) )
	define( 'ATTPT_VER', '1.0.0' );
  
class Add_Thumbnail_To_Post_Table {
  
	/**
	 * Static property to hold our singleton instance
	 *
	 */
	static $instance = false;
	
	/**
	 * This is our constructor
	 *
	 * @return void
	 */
	private function __construct() {
		add_filter( 'manage_posts_columns', array( $this, 'attpt_add_thumbnail_column_to_post_table' ) );
		add_action( 'manage_posts_custom_column', array( $this, 'attpt_add_thumbnail_column_to_post_table_row'), 10, 2 );
	}

	/**
	 * If an instance exists, this returns it.  If not, it creates one and
	 * retuns it.
	 *
	 * @return Add_Thumbnail_To_Post_Table
	 */
	public static function getInstance() {
		if ( !self::$instance )
			self::$instance = new self;
		return self::$instance;
	}
	
	/**
	 * Alter the columns to the post table in the admin UI
	 *
	 * @return array $columns Array of all the current columns IDs and titles
	 */
	public function attpt_add_thumbnail_column_to_post_table( $column ) {
		$column['featured_image'] = 'Image';
		return $column;
	}
	
	/**
	 * Render the contents of custom columns for the post table in the admin UI
	 *
	 * @return html for post image and (string|false) Post thumbnail URL or false if no URL is available.
	 */
	public function attpt_add_thumbnail_column_to_post_table_row( $column_name, $post_id ) {
		if ( $column_name == 'featured_image' ) : 
			$thumbnail_url = get_the_post_thumbnail_url( $post_id, 'thumbnail' ); 
			if ( $thumbnail_url ) : ?>
				<img class="wp-post-image" src="<?php echo esc_url( $thumbnail_url ); ?>" height="50" width="50" />
			<?php 
			endif; 
		endif;
	}

// End class
}

// Instantiate our class
$Add_Thumbnail_To_Post_Table = Add_Thumbnail_To_Post_Table::getInstance();
