<?php
include ('./data/photos.php');

$colors = array();
$orphans = 0;

foreach ( $photos as $photo ){
	if ( empty( $photo['colors'] ) ) {
		echo 'https://wordpress.org/photos/wp-admin/post.php?post=' . $photo['id'] .'&action=edit' . "\n";
		$orphans++;
		continue;
	} 

	

	foreach ( $photo['colors'] as $color ) {
		if ( ! in_array( $color , array_keys( $colors ) ) ) {
			$colors[ $color ] = array('cant' => 1);
		} else {
			$colors[ $color ]['cant']++;
		}
	}
	
}

echo "Total: " . $orphans;

//print_r( $colors );