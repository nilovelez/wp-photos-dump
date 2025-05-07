<?php


/*
https://github.com/tcdent/php-restclient

per_page=100
page=1
_fields=author,id,excerpt,title,link
*/

/*
https://zaragoza.wordcamp.org/2025/wp-json/wp/v2/

https://zaragoza.wordcamp.org/2025/

wp-json/wp/v2/sessions?status=publish&_fields=title,meta._wcpt_session_time,meta._wcpt_speaker_id?per_page=100

wp-json/wp/v2/speakers?status=publish&_fields=id,title?per_page=100


error: "SSL certificate problem: unable to get local issuer certificate"

http://curl.haxx.se/docs/caextract.html

curl.cainfo="c:\php-8.3.4-nts-Win32-vs16-x64\cacert.pem"
openssl.cafile="c:\php-8.3.4-nts-Win32-vs16-x64\cacert.pem"

https://wordpress.org/photos/wp-json/wp/v2/photo-tags
x-wp-total:
7168

https://wordpress.org/photos/wp-json/wp/v2/photo
https://wordpress.org/photos/wp-json/wp/v2/photos?per_page=100

*/

// estos son los archivos .webp que en realidad son .jpeg
// el resto de los .webp son .jpg
$webp2jpeg = array(
'https://pd.w.org/2022/09/1796327fdf0c584f9.49384969.webp',
'https://pd.w.org/2022/09/604632853df916a49.17922989.webp',
'https://pd.w.org/2022/09/2616328534c50db88.54744045.webp',
'https://pd.w.org/2022/09/50863282f1cbb3958.99191360.webp',
'https://pd.w.org/2022/09/2746327f806ea65f5.49396411.webp',
'https://pd.w.org/2022/09/464632088cd749f76.20560440.webp',
'https://pd.w.org/2022/09/60963208785736fb0.09990812.webp',
'https://pd.w.org/2022/09/2963208767ef8e38.35873431.webp',
'https://pd.w.org/2022/09/215632086fce78aa2.68754863.webp',
'https://pd.w.org/2022/09/585632086e0bb14c8.41285582.webp',
'https://pd.w.org/2022/09/133632086c8b71794.70595558.webp',
'https://pd.w.org/2022/09/886320869bc384e5.13384582.webp',
'https://pd.w.org/2022/09/8646320867ca152a9.82057452.webp',
'https://pd.w.org/2022/09/134632086455cf867.93555850.webp',
'https://pd.w.org/2022/09/36631f68efca5bb0.77728871.webp',
'https://pd.w.org/2022/09/117631f3d7765e450.77617628.webp',
'https://pd.w.org/2022/09/70631f3cf48f73f8.47356746.webp',
'https://pd.w.org/2022/09/28631f3cc07fbf22.96698282.webp',
'https://pd.w.org/2022/09/879631f3c828f7162.57430935.webp',
'https://pd.w.org/2022/09/141631f3aaea0e6c9.67390019.webp',
'https://pd.w.org/2022/09/122631f39b5301182.39394253.webp',
'https://pd.w.org/2022/09/442631f3999d9f970.72258643.webp',
'https://pd.w.org/2022/09/209631f38c953d750.42158638.webp',
'https://pd.w.org/2022/09/447631f386e54a9c5.90282758.webp',
'https://pd.w.org/2022/09/743631ece5d534637.58690479.webp',
'https://pd.w.org/2022/09/314631ece35b0f0d7.02388999.webp',
'https://pd.w.org/2022/09/944631ec505dede61.12616172.webp',
'https://pd.w.org/2022/09/139631ec4be3ebb57.93076821.webp',
'https://pd.w.org/2022/09/619631ec45d520fd3.40128139.webp',
'https://pd.w.org/2022/09/775631e6c4129ebb2.75882894.webp',
'https://pd.w.org/2022/09/227631e6bec113f25.65340669.webp',
'https://pd.w.org/2022/09/237631e6cbdd1fa19.06637905.webp',
'https://pd.w.org/2022/09/371631e4f22c49596.02033040.webp',
'https://pd.w.org/2022/09/839631e4eb884c1b7.93875392.webp',
'https://pd.w.org/2022/09/468631e4e0e271835.30102552.webp',
'https://pd.w.org/2022/09/181631e4d3d8ab854.38119057.webp',
'https://pd.w.org/2022/09/390631e3f0822d512.58319260.webp',
'https://pd.w.org/2022/09/425631e3eb9d16815.36088151.webp',
'https://pd.w.org/2022/09/499631e3d6a10a907.42400777.webp',
'https://pd.w.org/2022/09/780631e3d0ee13b91.59644060.webp',
'https://pd.w.org/2022/09/388631e2452c49931.35930115.webp',
'https://pd.w.org/2022/09/734631e51f9849ff3.78296875.webp',
'https://pd.w.org/2022/09/156318b47c8d2da5.64442716.webp',
'https://pd.w.org/2022/09/2506319bbb6bc90c0.56803421.webp',
'https://pd.w.org/2022/09/5696318b4045c8792.08898201.webp',
'https://pd.w.org/2022/09/882631804d1c51ad9.85524942.webp',
'https://pd.w.org/2022/09/65363246cba50a746.23542750.webp',
'https://pd.w.org/2022/09/64263246c1d637ed4.98743053.webp',
'https://pd.w.org/2022/09/4116327fe7b1c37d7.35235776.webp',
'https://pd.w.org/2022/09/3766323b9e4aa9ed4.24357357.webp',
'https://pd.w.org/2022/09/7606323b31ded1330.41596262.webp',
'https://pd.w.org/2022/09/4196321635f49fc00.01119508.webp',
'https://pd.w.org/2022/09/732632162fa6425e3.75098072.webp',
'https://pd.w.org/2022/09/96663216289c2eca7.30986551.webp',
'https://pd.w.org/2022/09/6216321d556284699.47023750.webp',
'https://pd.w.org/2022/09/801632088e56aef81.21260772.webp',
'https://pd.w.org/2022/09/39763208916a09dc2.01879071.webp',
'https://pd.w.org/2022/09/4986320896d139246.08253775.webp',
'https://pd.w.org/2022/09/4266320149263e336.68079247.webp'
);

require('./vendor/autoload.php');

function get_photos( $base_url ) {

	global $webp2jpeg;

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
		// 'format' => "json", 
		// https://dev.twitter.com/docs/auth/application-only-auth
		//'headers' => ['Authorization' => 'Bearer '.OAUTH_BEARER], 
	]);

	
	$result = $api->get(
		"photos",
		[
			'status' => "publish",
			//'_fields' => "title,wp:featured_media,_links.wp:featuredmedia,_embedded",
			'_fields' => "id,slug,author,content,date_gmt,featured_media,photo-thumbnail-url,photo-categories,photo-colors,photo-orientations,photo-tags,_links.author",
			'orderby'  => 'date',
			'order'    => 'asc',
			'per_page' => '100',
			'page'     => $current_page
		]);
	// GET http://api.twitter.com/1.1/search/tweets.json?q=%23php
	if($result->info->http_code == 200) {

	    $result = $result->decode_response();
	    foreach ($result as $photoObj) {

	    	//print_r ( $photoObj );
	    	//exit();

	    	$img_url = preg_replace('/-.*?(?=\.)/', '', $photoObj->{'photo-thumbnail-url'});

	    	if ( "webp" == substr( $img_url, -4 ) ) {

				echo substr( $img_url, -4 ) . "\n";

				if ( in_array( $img_url , $webp2jpeg) ) {
					$img_url = str_replace('.webp', '.jpeg', $img_url);
				} else {
					$img_url = str_replace('.webp', '.jpg', $img_url);
				}
				echo $img_url . "\n";
			}
	    	
	    	$photo = array();
			$photo['id'] = $photoObj->id;
			$photo['date'] = strtotime(date($photoObj->date_gmt));
			$photo['slug'] = $photoObj->slug;
			$photo['author'] = $photoObj->author;
			$photo['author_href'] = $photoObj->{'_links'}->author[0]->href;
			$photo['featured_media'] = $photoObj->featured_media;
			$photo['content'] = strip_tags($photoObj->content->rendered);
			$photo['content'] = str_replace(
				array('<p>', '</p>', "\n", "'"),
				array('',    '',     '',   "\'"),
				$photoObj->content->rendered
			);
			$photo['img_url'] = $img_url;

			$photo['photo-categories'] = $photoObj->{'photo-categories'};
			$photo['photo-colors'] = $photoObj->{'photo-colors'};
			$photo['photo-orientations'] = $photoObj->{'photo-orientations'};
			$photo['photo-tags'] = $photoObj->{'photo-tags'};

			//print_r($photo);

			$photo_html  = "'". $photo['slug'] . "' => array("."\n";
			$photo_html .= "	'id'           => " . $photo['id'] . ",\n";
			$photo_html .= "	'slug'         => '" . $photo['slug'] . "',\n";
			$photo_html .= "	'date'         => " . $photo['date'] . ",\n";
			$photo_html .= "	'img_id'       => " . $photo['featured_media'] . ",\n";
			$photo_html .= "	'img_url'      => '" . $img_url . "',\n";
			$photo_html .= "	'author'       => " . $photo['author'] . ",\n";
			$photo_html .= "	'author_href'  => '" . $photo['author_href'] . "',\n";
			$photo_html .= "	'categories'   => array(" . implode(',', $photo['photo-categories']) . "),\n";
			$photo_html .= "	'colors'       => array(" . implode(',', $photo['photo-colors']) . "),\n";
			$photo_html .= "	'orientations' => array(" . implode(',', $photo['photo-orientations']) . "),\n";
			$photo_html .= "	'tags'         => array(" . implode(',', $photo['photo-tags']) . "),\n";
			$photo_html .= "	'content'      => '" . $photo['content'] . "',\n";
			$photo_html .= '),'."\n";

			file_put_contents('./data/photos.php', $photo_html, FILE_APPEND);

		

	    }




	} else {
		var_dump($result);
	}

	/*
	if ( $sessions ) {
	    // Work with the returned content
	    foreach ($content as $post) {
	        $sessions[] = $post->title->rendered;
	    }
	    return $sessions;
	}
	*/
}

$base_url = 'https://wordpress.org/photos/wp-json/wp/v2/';

if ( $photos = get_photos( $base_url ) ) {
	var_dump( $photos );
}
