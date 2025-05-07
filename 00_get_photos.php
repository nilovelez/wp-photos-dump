<?php


/*
https://github.com/tcdent/php-restclient

per_page=100
page=1
_fields=author,id,excerpt,title,link
*/

/*
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

function get_photos($base_url) {
	global $webp2jpeg;

	// Get current page from GET parameter, default to 1
	$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	
	echo "<div class='pagination-info'>";
	echo "<h3>Processing Page " . $current_page . "</h3>";
	echo "</div>";

	// Connect to SQLite database
	try {
		$db = new PDO('sqlite:wp-photos.db');
		// Enable foreign keys
		$db->exec('PRAGMA foreign_keys = ON;');
		// Set error mode to throw exceptions
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// Set default fetch mode to associative array
		$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		echo "<div class='error-message'>";
		echo "<p>Error connecting to database: " . $e->getMessage() . "</p>";
		echo "</div>";
		return;
	}

	$api = new RestClient([
		'base_url' => $base_url,
	]);

	$result = $api->get(
		"photos",
		[
			'status' => "publish",
			'_fields' => "id,slug,author,content,modified_gmt,featured_media,photo-thumbnail-url,photo-categories,photo-colors,photo-orientations,photo-tags,_links.author",
			'orderby'  => 'modified',
			'order'    => 'desc',
			'per_page' => '100',
			'page'     => $current_page
		]
	);

	if($result->info->http_code == 200) {
		$result = $result->decode_response();
		$photos_processed = 0;
		$photos_skipped = 0;
		$total_photos = count($result);

		echo "<div class='scrollable-content'>";
		foreach ($result as $photoObj) {
			$img_url = preg_replace('/-.*?(?=\.)/', '', $photoObj->{'photo-thumbnail-url'});

			if ("webp" == substr($img_url, -4)) {
				if (in_array($img_url, $webp2jpeg)) {
					$img_url = str_replace('.webp', '.jpeg', $img_url);
				} else {
					$img_url = str_replace('.webp', '.jpg', $img_url);
				}
			}
			
			// Prepare the data for database insertion
			$photo = [
				'id' => $photoObj->id,
				'slug' => $photoObj->slug,
				'date' => strtotime(date($photoObj->modified_gmt)),
				'img_id' => $photoObj->featured_media,
				'img_url' => $img_url,
				'author' => $photoObj->author,
				'author_href' => $photoObj->{'_links'}->author[0]->href,
				'categories' => empty($photoObj->{'photo-categories'}) ? null : serialize($photoObj->{'photo-categories'}),
				'colors' => empty($photoObj->{'photo-colors'}) ? null : serialize($photoObj->{'photo-colors'}),
				'orientations' => empty($photoObj->{'photo-orientations'}) ? null : serialize($photoObj->{'photo-orientations'}),
				'tags' => empty($photoObj->{'photo-tags'}) ? null : serialize($photoObj->{'photo-tags'}),
				'content' => str_replace(
					array('<p>', '</p>', "\n", "'"),
					array('',    '',     '',   "\'"),
					$photoObj->content->rendered
				)
			];

			// Check if photo already exists with same id and date
			$check = $db->prepare('SELECT id FROM photos WHERE id = :id AND date = :date');
			$check->bindValue(':id', $photo['id'], PDO::PARAM_INT);
			$check->bindValue(':date', $photo['date'], PDO::PARAM_INT);
			$check->execute();

			if ($check->fetch()) {
				$photos_skipped++;
				continue;
			}

			// Prepare the SQL statement
			$stmt = $db->prepare('
				INSERT OR REPLACE INTO photos (
					id, slug, date, img_id, img_url, author, author_href,
					categories, colors, orientations, tags, content
				) VALUES (
					:id, :slug, :date, :img_id, :img_url, :author, :author_href,
					:categories, :colors, :orientations, :tags, :content
				)
			');

			// Bind the values
			$stmt->bindValue(':id', $photo['id'], PDO::PARAM_INT);
			$stmt->bindValue(':slug', $photo['slug'], PDO::PARAM_STR);
			$stmt->bindValue(':date', $photo['date'], PDO::PARAM_INT);
			$stmt->bindValue(':img_id', $photo['img_id'], PDO::PARAM_INT);
			$stmt->bindValue(':img_url', $photo['img_url'], PDO::PARAM_STR);
			$stmt->bindValue(':author', $photo['author'], PDO::PARAM_STR);
			$stmt->bindValue(':author_href', $photo['author_href'], PDO::PARAM_STR);
			$stmt->bindValue(':categories', $photo['categories'], PDO::PARAM_STR);
			$stmt->bindValue(':colors', $photo['colors'], PDO::PARAM_STR);
			$stmt->bindValue(':orientations', $photo['orientations'], PDO::PARAM_STR);
			$stmt->bindValue(':tags', $photo['tags'], PDO::PARAM_STR);
			$stmt->bindValue(':content', $photo['content'], PDO::PARAM_STR);

			// Execute the statement
			if ($stmt->execute()) {
				echo "<p>Photo " . $photo['id'] . " processed</p>";
				$photos_processed++;
			} else {
				echo "<div class='error-message'>";
				echo "<p>Error saving photo ID " . $photo['id'] . " to database</p>";
				echo "</div>";
			}
		}
		echo "</div>";

		echo "<div class='processing-summary'>";
		echo "<p>Retrieved " . $total_photos . " photos and processed " . $photos_processed . " photos from page " . $current_page . "</p>";
		echo "</div>";

		// Add next page button
		echo "<div class='pagination-controls'>";
		$next_page_url = '?step=photos&page=' . ($current_page + 1);
		$is_auto_enabled = isset($_GET['auto']) && $_GET['auto'] === 'true';
		$should_advance = $is_auto_enabled && $total_photos > 0;
		
		echo "<form action='' method='get'>";
		echo "<input type='hidden' name='step' value='photos'>";
		echo "<input type='hidden' name='page' value='" . ($current_page + 1) . "'>";
		echo "<label style='margin-left: 20px;'><input type='checkbox' id='autoAdvance' name='auto' value='true' " . ($is_auto_enabled ? 'checked' : '') . "> Advance automatically</label>";
		echo "<input type='submit' value='Process Next Page' class='next-page-button'>";
		echo "</form>";
		echo "</div>";

		if ($should_advance) {
			echo "<script>
				document.querySelector('.next-page-button').click();
			</script>";
		}

	} else {
		echo "<div class='error-message'>";
		echo "<p>Error fetching photos: HTTP " . $result->info->http_code . "</p>";
		echo "<p>Response: " . $result->response . "</p>";
		echo "</div>";
	}

	// Close the database connection
	$db = null;
}

$base_url = 'https://wordpress.org/photos/wp-json/wp/v2/';

if ( $photos = get_photos( $base_url ) ) {
	var_dump( $photos );
}
