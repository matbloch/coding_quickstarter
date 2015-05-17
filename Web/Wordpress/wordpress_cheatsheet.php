<?php


/*------------------------------------*\
	SANITIZING
\*------------------------------------*/

sanitize_text_field() // Checks for invalid UTF-8, Convert single < characters to entity, strip all tags, remove line breaks, tabs and extra white space, strip octets. 
sanitize_key() // alphanumeric lowercase key
sanitize_title() // suitable for use in a URL, not as a human-readable title

esc_url_raw() // For inserting an URL in the database. This function does not encode characters as HTML entities

/* numbers */

intval($int)
floatval($float)

absint($int) // nonnegative



/*------------------------------------*\
	ESCAPING
\*------------------------------------*/

// esc_html() we should use anytime our HTML element encloses a section of data we’re outputting.
esc_html() // html strings

esc_url() // url strings
esc_attr() // attributes
esc_textarea() // for textareas

/*------------------------------------*\
	ENCODING
\*------------------------------------*/


/*------------------------------------*\
	JQUERY
\*------------------------------------*/

jQuery(document).ready(function($) {
    // Inside of this function, $() will work as an alias for jQuery()
    // and other libraries also using $ will not be accessible under this shortcut
});

/*------------------------------------*\
	POST STATUS
\*------------------------------------*/


// post type
$rls_type =  get_post_type( $rls_id );

// post does not exist
if ( !get_post_status ( $id ) ) {
	return;
}

/*------------------------------------*\
	POST META
\*------------------------------------*/

// get
$meta_values = get_post_meta( $post_id, 'my_meta_name' , true); // true to get value directly

// update
update_post_meta(76, 'my_key', 'Steve');


/*------------------------------------*\
	(SQL) QUERIES
\*------------------------------------*/

// always needed
global $wpdb;

/* --------------- INSERT */

/*
s: string (also for comma values)
d: decimal
f: float
*/

/* as a query */

$metakey	= "Harriet's Adages";
$metavalue	= "WordPress' database interface is like Sunday Morning: Easy.";

$wpdb->query( $wpdb->prepare( 
	"
		INSERT INTO $wpdb->postmeta
		( post_id, meta_key, meta_value )
		VALUES ( %d, %s, %s )
	", 
    10, // first: decimal
	$metakey, // second
	$metavalue 	// third
) );

/* directly */


/* with the insert function: $wpdb->insert($table, $data, $format) */
 
$wpdb->insert(
    'mytable',
    array(
        'fruit' => 'apple',
        'year' => 2012
    ),
    array(
        '%s',
        '%d'
    )
);


/* --------------- UPDATE */

/* as a query - directly */

$wpdb->query(
	"
	UPDATE $wpdb->posts 
	SET post_parent = 7
	WHERE ID = 15 
		AND post_status = 'static'
	"
);

/* with the update function */
/*
parameters:

table name
data
where conditions
format
where_format

*/

$wpdb->update(
    'mytable',
    array(
        'fruit' => 'apple',  // string
        'year' =>  'value2'  // integer (number)
    ),
    array( 'ID' => 1 ),
	
    array(
        '%s',   // value1
        '%d'    // value2
    ),
    array( '%d' )
);

/* --------------- GET */

/* get specific row */

$mylink = $wpdb->get_row("SELECT * FROM $wpdb->links WHERE link_id = 10"); /* gibt objekt zurück */
$mylink = $wpdb->get_row("SELECT * FROM $wpdb->links WHERE link_id = 10", ARRAY_A); /* gibt associative array zurück */

/* get specific fields */

$fivesdrafts = $wpdb->get_results( 
	"
	SELECT ID, post_title 
	FROM $wpdb->posts
	WHERE post_status = 'draft' 
		AND post_author = 5
	"
);

/* get all data */

global $wpdb;

$query = $wpdb->prepare( 
	"
		SELECT *
		FROM ".$wpdb->prefix.self::$table_name."
		WHERE survey_id = %d
	", 
	array(
	$survey_id
	)
);

$result = $wpdb->get_results($query, ARRAY_A);


/* --------------- DELETE */

// Using where formatting.
$wpdb->delete( 'table', array( 'ID' => 1 ), array( '%d' ) );

/*------------------------------------*\
	ESCAPING & debugging
\*------------------------------------*/

$query = $wpdb->prepare( 'query', '%s', '%d');
$query = $wpdb->prepare( 'query', array('%s', '%d'));


var_dump($wpdb->last_query);

/*------------------------------------*\
	MIGRATION
\*------------------------------------*/

1. Duplicator Backup erstellen


2.1.A Duplicator Backup auf localhost einspielen mit URL der neuen Seite (Bsp: http://assetis.ch)
2.2.A DB Anpassen:
		- wp_options: "siteurl" und ("home") anpassen
		
2.1.B Datenbank als .sql exportieren und mit dem Texteditor search&replace URLS ersetzen
4 wp-config: 
	- db name, db host, db passwort, db username
	- DB Host Name: auf phpMyAdmin einloggen - oben links: Sever: .... (meist localhost)
4.2 .htaccess rewrite base überprüfen
5. Alle files per FTP auf Server transferieren
6. Datenbank exportieren und auf neuem Host importieren
7. Falls Seitenlinks nicht funktionieren: Dashboard > Lesen > Permalinks kurz wechseln oder flush_rewrite_rule() integrieren


/*------------------------------------*\
	POST-TYPE REGISTRATION
\*------------------------------------*/

	register_post_type( 'sponsor',
	array(
	'labels' => array(
	'name' => 'Sponsoren',
	'singular_name' => 'Sponsor',
	'add_new' => 'hinzufügen',
	'add_new_item' => 'Neuer Sponsor hinzufügen',
	'edit' => 'Bearbeiten',
	'edit_item' => 'Sponsor bearbeiten',
	'new_item' => 'Neuer Sponsor',
	'view' => 'Ansehen',
	'view_item' => 'Sponsor ansehen',
	'search_items' => 'Sponsor suchen',
	'not_found' => 'Kein Sponsor gefunden',
	'not_found_in_trash' => 'Kein Sponsor im Papierkorb gefunden',
	),
	'public' => false, // no individual page
	'show_ui' => true, // display in admin menu
	'supports' => array('title'),
	'menu_icon' => get_bloginfo('template_directory').'/img/icons/i_sponsor.png', //icon
	'has_archive' => false // no archive page
	)
	);

/*------------------------------------*\
	ACP REGISTRATIONS
\*------------------------------------*/

/* top-level page */

add_action( 'admin_menu', 'cs_register_custom_menu' ); //register new pages
function cs_register_custom_menu(){
    add_menu_page(
        'Topreleases verwalten', // page title
        'Topreleases',     // menu title
        'cs_manage_topreleases',   //capability
        'cs_topreleases',     // The ID used to bind submenu items to this menu 
        'cs_render_topreleases_page', // callback function
		plugins_url( 'cs-upload-publisher/img/icons/i_toprelease.png' ), //icon
		'120' //menu position
      );
}

/* under a CPT (survey) */

add_action( 'admin_menu', 'cs_register_custom_menu' ); //register new pages
function cs_register_custom_menu(){
	add_submenu_page(
	'edit.php?post_type=survey', 
	'Mange survey results',  
	'Results', 
	'manage_options', 
	'survey_results',
	'render_survey_results'
  );
}	
/*------------------------------------*\
	OOP
\*------------------------------------*/

// add actions
add_action('wp_ajax_some_method', array($this,'some_method'));
	
/*------------------------------------*\
	ACTIONS
\*------------------------------------*/


// funktioniert nicht von includes (siehe assetis)!!!
add_action('init', 'myfunc'));


/*------------------------------------*\
	SIDEBAR
\*------------------------------------*/

function sidebar_shortcode($atts, $content="null"){
  extract(shortcode_atts(array('name' => ''), $atts));

  ob_start();
  get_sidebar($name);
  $sidebar= ob_get_contents();
  ob_end_clean();

  return $sidebar;
}

/*------------------------------------*\
	SHORTCODES
\*------------------------------------*/

function crosswind_register_shortcode()
{
    add_shortcode( 'crosswind_disp_news', 'crosswind_sc_disp_news' ); // news
}

/* news: [crosswind_disp_news nr=3] */
/* use return, not echo! */
function crosswind_sc_disp_news( $args ){

    $a = shortcode_atts( array('nr' => -1), $args );

	$a['nr'] = intval($a['nr']);
	
	if($a['nr'] == 0){
		return;
	}

    // get the posts
    $results = get_posts(array('numberposts'   => $a['nr']) );
	
    // no posts
    if( empty( $results ) ) return '';

    $out = '<ul class="news_posts">';
    foreach( $results as $post ){$out .= '<li><b><i>'.esc_html($post->post_title).'</i></b>: &nbsp'.$post->post_content.'</li>';}
    $out .= '</ul>';
	
    return $out;
}

// --------- enclosing shortcodes

/*
input:   [caption]My Caption[/caption]
return:  <span class="caption">My Caption</span>

*/
function caption_shortcode( $atts, $content = null ) {
	return '<span class="caption">' . $content . '</span>';
}
add_shortcode( 'caption', 'caption_shortcode' );


// --------- nested shortcodes

/*
Example: [callout]For more information [button]contact us today[/button][/callout]
*/

// first callback function

function callout_sc($params, $content = null){

	return '<div class="outer">'.do_shortcode($content).'</div>';

}

function button_sc($params, $content = null){

	return '<div class="button">'.do_shortcode($content).'</div>';

}

/*------------------------------------*\
	Shortcodes manipulation: outside loop
\*------------------------------------*/

/* FUNCTIONS.PHP */

/* extract shortcode attributes */
function crosswind_parse_sc($sc_name) {
    global $post;
    $pattern = get_shortcode_regex();
	
	$args = array();

    if (   preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches )
        && array_key_exists( 2, $matches )
        && in_array( $sc_name, $matches[2] ) )
    {
		// parse
		$args = shortcode_parse_atts($matches[3][0]);
    }
	
	$a = shortcode_atts( array('dl_category' => '', 'contact' => ''), $args );
	return $a;
}
/* filter to rerun shortcode in different location */
function crosswind_array_to_sc_attr($arr_attr){

	$out = '';
	foreach($arr_attr as $attr_name => $value){
		if($value != ''){
			$out .= ' '. $attr_name . '=' .$value;
		}
	}
	return $out;
}

/* remove shortcode from content */
function crosswind_remove_sc($content) {  
    return remove_shortcode('crosswind_disp_sidebar', $content);  
}  
add_filter( 'the_content', 'crosswind_remove_sc', 6);


/* template.PHP */

/* detect sc data */
$sidebar_attr = crosswind_parse_sc('crosswind_disp_sidebar');
echo do_shortcode('[crosswind_disp_sidebar'.crosswind_array_to_sc_attr($sidebar_attr).']');



/*------------------------------------*\
	Admin menu manipulation
\*------------------------------------*/

/* remove pages */
remove_menu_page('upload.php'); // Media
remove_menu_page('link-manager.php'); // Links
remove_menu_page('edit-comments.php'); // Comments
remove_menu_page('edit.php?post_type=page'); // Pages
remove_menu_page('plugins.php'); // Plugins
remove_menu_page('themes.php'); // Appearance
remove_menu_page('users.php'); // Users
remove_menu_page('tools.php'); // Tools
remove_menu_page('options-general.php'); // Settings

/* conditional removal */
add_action( 'admin_init', 'my_remove_menu_pages' );
function my_remove_menu_pages() {
 
    global $user_ID;
 
    if ( current_user_can( 'wpmayorauthor' ) ) {
    remove_menu_page( 'edit.php?post_type=thirstylink' );
    remove_menu_page( 'edit.php?post_type=wprss_feed' );
        remove_menu_page( 'authorhreview' );
    }
}


/* only view own posts */

add_action( 'load-edit.php', 'posts_for_current_contributor' );
function posts_for_current_contributor() {
    global $user_ID;
 
    if ( current_user_can( 'contributor' ) ) {
       if ( ! isset( $_GET['author'] ) ) {
          wp_redirect( add_query_arg( 'author', $user_ID ) );
          exit;
       }
   }
 
}


/*------------------------------------*\
	Normal Post querying
\*------------------------------------*/

/* content by id */
$content = get_post_field('post_content', $my_postid);

/* by taxonomy value */
$posts = get_posts(array(
	'showposts' => -1,
	'post_type' => 'gericht',
	'tax_query' => array(
		array(
			'taxonomy' => 'genre',
			'field' => 'slug',
			'terms' => 'jazz'
		)
	)
));

/* by meta value */
$args = array(
	'post_type' => 'product',
	'meta_query' => array(
		array(
			'key' => 'featured',
			'value' => 'yes',
		)
	)
 );
 
 /*------------------------------------*\
	ACF
\*------------------------------------*/
 
 
 /* remove surrounding p-tags when doing the_field('field_name'); */
 remove_filter ('acf_the_content', 'wpautop');
 
 
 
 

?>