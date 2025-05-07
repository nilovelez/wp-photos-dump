<?php


/*
https://wordpress.org/photos/wp-json/wp/v2/photo-tags
x-wp-total:
7168

https://wordpress.org/photos/wp-json/wp/v2/photo-categories
https://wordpress.org/photos/wp-json/wp/v2/photo-colors

https://wordpress.org/photos/wp-json/wp/v2/photo
https://wordpress.org/photos/wp-json/wp/v2/photos?per_page=100

*/


require('./vendor/autoload.php');

function get_categories( $base_url ) {

	$last_page = @file_get_contents('./data/page.txt');

	if ( !intval( $last_page ) ) {
		$last_page = 0;
	}
	$current_page = $last_page + 1;
	echo "Page " . $current_page . "\n\n";
	file_put_contents('./data/page.txt', $current_page);
	//return;

	$api = new RestClient([
		'base_url' => $base_url, 
	]);

	
	$result = $api->get(
		"photo-colors",
		[
			'status' => "publish",
			//'_fields' => "title,wp:featured_media,_links.wp:featuredmedia,_embedded",
			//'_fields' => "id,slug,author,content,date_gmt,featured_media,photo-thumbnail-url,photo-categories,photo-colors,photo-orientations,photo-tags",
			'per_page' => '100',
			//'page'     => $current_page
		]);
	// GET http://api.twitter.com/1.1/search/tweets.json?q=%23php
	if($result->info->http_code == 200) {

	    $result = $result->decode_response();
	    foreach ($result as $resObj) {

	    	//print_r ( $resObj );
	    	//exit;

	    	
	    	
	    	$item = array();
			$item['id'] = $resObj->id;
			$item['name'] = $resObj->name;
			$item['slug'] = $resObj->slug;
			$item['count'] = $resObj->count;



			print_r($item);

			$item_html  = "'". $item['slug'] . "' => array("."\n";
			$item_html .= "	'id'           => " . $item['id'] . ",\n";
			$item_html .= "	'name'         => '" . $item['name'] . "',\n";
			$item_html .= "	'slug'         => '" . $item['slug'] . "',\n";
			$item_html .= "	'count'         => " . $item['count'] . ",\n";
			$item_html .= '),'."\n";

			file_put_contents('./data/colors.php', $item_html, FILE_APPEND);

		

	    }


	} else {
		var_dump($result);
	}

}

$base_url = 'https://wordpress.org/photos/wp-json/wp/v2/';

get_categories( $base_url );
