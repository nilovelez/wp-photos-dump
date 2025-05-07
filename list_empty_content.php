<?php
include ('./data/photos.php');

$categories = array();
$orphans = 0;

foreach ( $photos as $photo ){
	if ( empty( $photo['content'] ) ) {
		echo 'https://wordpress.org/photos/wp-admin/post.php?post=' . $photo['id'] .'&action=edit' . "\n";
		$orphans++;
		continue;
	} 

	/*

	foreach ( $photo['categories'] as $category ) {
		if ( ! in_array( $category , array_keys( $categories ) ) ) {
			$categories[ $category ] = array('cant' => 1);
		} else {
			$categories[ $category ]['cant']++;
		}
	}
	*/
}

echo "Total: " . $orphans;
//print_r( $categories );