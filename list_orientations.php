<?php
include ('./data/photos.php');

$orientations = array();
$orphans = 0;

foreach ( $photos as $photo ){
	if ( empty( $photo['orientations'] ) ) {
		echo 'https://wordpress.org/photos/wp-admin/post.php?post=' . $photo['id'] .'&action=edit' . "\n";
		$orphans++;
		continue;
	} 

	/*

	foreach ( $photo['orientations'] as $orientation ) {
		if ( ! in_array( $orientation , array_keys( $orientations ) ) ) {
			$orientations[ $orientation ] = array('cant' => 1);
		} else {
			$orientations[ $orientation ]['cant']++;
		}
	}
	*/
}

echo "Total: " . $orphans;

//print_r( $orientations );