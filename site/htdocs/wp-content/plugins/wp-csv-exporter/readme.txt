=== WP CSV Exporter ===
Contributors: kanakogi
Donate link: http://www.amazon.co.jp/registry/wishlist/2TUGZOYJW8T4T/?_encoding=UTF8&camp=247&creative=7399&linkCode=ur2&tag=wpccc-22
Tags: : csv, custom post, export, extract, import, csv import, csv importer, csv to custom post type, import, import CSV, wordpress csv import
Requires at least: 3.0 or higher
Tested up to: 4.4.2
Stable tag: 1.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

You can export posts in CSV format for each post type. It is compatible with posts' custom fields and custom taxonomies. 

== Description ==
You can export posts in CSV format for each post type.
It is compatible with posts' custom fields and custom taxonomies.
It is also possible to set the number or date range of posts to download.


== Installation ==
1. Upload the entire `wp-csv-exporter` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. The control panel of WP CSV Exporter is in 'Tools > CSV Export'.

== Frequently Asked Questions ==

= How to import CSV? =
Maybe You should use "<a href="https://wordpress.org/plugins/really-simple-csv-importer/" target="_blank">Really Simple CSV Importer</a>" plugin.

== Screenshots ==
1. `/assets/screenshot-1.png`


== How to customize export post data == 

This plugin has below filters.

* wp_csv_exporter_post_name
* wp_csv_exporter_post_title
* wp_csv_exporter_post_content
* wp_csv_exporter_post_excerpt
* wp_csv_exporter_post_status
* wp_csv_exporter_post_author
* wp_csv_exporter_post_date
* wp_csv_exporter_post_modified
* wp_csv_exporter_thumbnail_url
* wp_csv_exporter_post_tags
* wp_csv_exporter_post_category
* wp_csv_exporter_tax_{taxonomy}
* wp_csv_exporter_{custom_field_key}


= wp_csv_exporter_post_name =

Parameters:

* `$post_name` - (required) post slug
* `$post_id` - (int) post id

Example:
`
add_filter( 'wp_csv_exporter_post_name', 'wp_csv_exporter_post_name_filter', 10, 3 );
function wp_csv_exporter_post_name_filter( $post_name, $post_id  ) {
    return $post_name;
}
`


= wp_csv_exporter_post_title =

Parameters:

* `$post_title` - (required) post title
* `$post_id` - (int) post id

Example:
`
add_filter( 'wp_csv_exporter_post_title', 'wp_csv_exporter_post_title_filter', 10, 3 );
function wp_csv_exporter_post_title_filter( $post_title, $post_id  ) {
    $post_title = $post_id . ':' . $post_title;
    return $post_title;
}
`


= wp_csv_exporter_post_content =

Parameters:

* `$post_content` - (required) post content
* `$post_id` - (int) post id


= wp_csv_exporter_post_excerpt =

Parameters:

* `$post_excerpt` - (required) post excerpt
* `$post_id` - (int) post id


= wp_csv_exporter_post_status =

Parameters:

* `$post_status` - (required) post status
* `$post_id` - (int) post id


= wp_csv_exporter_post_author =

Parameters:

* `$post_author` - (required) post author
* `$post_id` - (int) post id


= wp_csv_exporter_post_date =

Parameters:

* `$post_date` - (required) post date
* `$post_id` - (int) post id


= wp_csv_exporter_post_modified =

Parameters:

* `$post_modified` - (required) post modified date
* `$post_id` - (int) post id


= wp_csv_exporter_post_thumbnail_url =

Parameters:

* `$post_thumbnail_url` - (required) post thumbnail_url
* `$post_id` - (int) post id


= wp_csv_exporter_post_tags =

Parameters:

* `$post_tags` - (array)(required) post tags
* `$post_id` - (int) post id

Example:
`
add_filter( 'wp_csv_exporter_post_tags', 'wp_csv_exporter_post_tags_filter', 10, 3 );
function wp_csv_exporter_post_tags_filter( $post_tags, $post_id  ) {
    $_post_tags = array();
    foreach ( $post_tags as $key => $tag ) {
        $_post_tags[] = 'Tag:'.$tag;
    }
    return $_post_tags;
}
`


= wp_csv_exporter_category =

Parameters:

* `$category` - (array)(required) post category
* `$post_id` - (int) post id

Example:
`
add_filter( 'wp_csv_exporter_category', 'wp_csv_exporter_category_filter', 10, 3 );
function wp_csv_exporter_post_category_filter( $category, $post_id  ) {
    $_category = array();
    foreach ( $category as $key => $value ) {
        $_category[] = 'Category:'.$value;
    }
    return $_category;
}
`


= wp_csv_exporter_tax_{taxonomy} =

Parameters:

* `$term_values` - (array)(required) post taxonomy
* `$post_id` - (int) post id

Example: taxonomy = "dogs"
`
add_filter( 'wp_csv_exporter_tax_dogs', 'wp_csv_exporter_tax_dogs_filter', 10, 3 );
function wp_csv_exporter_tax_dogs_filter( $term_values, $post_id ) {
    $_term_values = array();
    foreach ( $term_values as $key => $term_value ) {
        $_term_values[] = 'Dog:'.$term_value;
    }
    return $_term_values;
}
`


= wp_csv_exporter_{custom_field_key} =

Parameters:

* `$field` - (required) post custom field
* `$post_id` - (int) post id

Example: custom field key = "price"
`
add_filter( 'wp_csv_exporter_price', 'wp_csv_exporter_price_filter', 10, 3 );
function wp_csv_exporter_price_filter( $field, $post_id ) {
    return 'Price:'.$field;
}
`


== Changelog ==
**1.1.1 - Aug 7, 2016**  
Fix Use posts_tag

**1.1.0 - Aug 1, 2016**  
Add offset feature

**1.0.9 - Aug 1, 2015**  
Add Russian translate local. 
Thanks! COMPAZ(https://profiles.wordpress.org/compaz/)

**1.0.8 - May 11, 2015**  
fix Gumload link.

**1.0.7 - April 10, 2015**  
Bug fix for taxsonomy empty

**1.0.6 - April 7, 2015**  
Bug fix 'wp_csv_exporter_{custom_field_key}'.

**1.0.4 - February 9, 2015**  
Change to class file name.

**1.0.3 - December 21, 2014**  
Bug fix.

**1.0.0 - December 10, 2014**  
Initial release.