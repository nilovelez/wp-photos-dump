<?php
include ('./data/photos.php');

$tags = array();
$orphans = 0;

foreach ( $photos as $photo ){
	if ( empty( $photo['tags'] ) ) {
		echo 'https://wordpress.org/photos/wp-admin/post.php?post=' . $photo['id'] .'&action=edit' . "\n";
		$orphans++;
		continue;
	} 

	foreach ( $photo['tags'] as $tag ) {
		if ( ! in_array( $tag , array_keys( $tags ) ) ) {
			$tags[ $tag ] = array('cant' => 1);
		} else {
			$tags[ $tag ]['cant']++;
		}
	}
}

echo "Total: " . $orphans;

//print_r( $tags );