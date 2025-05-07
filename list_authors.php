<?php
require 'vendor/autoload.php';

/*
https://wordpress.org/photos/wp-json/wp/v2/users/3606
https://wordpress.org/photos/wp-json/wporg/v1/users/shamalisulakhe

* Checks if the given username exists on WordPress.org
*
* grav-redirect.php will redirect to a Gravatar image URL. If the WordPress.org username exists, the `d` parameter
* will be 'retro', and if it doesn't it'll be 'mm'.

if ( !empty( $response['location'] ) ) {
	if ( false === strpos( $response['location'], 'd=mm' ) ) {
		$username_exists = true;
	}
}

https://wordpress.org/grav-redirect.php?user=nilovelez
*/

$user_slugs = array(
'3606'     => 'coffee2code',
'71962'    => 'otto42',
'3353157'  => 'roytanck',
'6250429'  => 'topher1kenobe',
'8209942'  => 'mkrndmane',
'9239930'  => 'mbigul',
'9338005'  => 'ajithrn',
'9439376'  => 'gagan0123',
'13234268' => 'michelleames',
'13612362' => 'm_butcher',
'13613184' => 'codente',
'13994457' => 'nilovelez',
'14176245' => 'chrisedwardsce',
'14467238' => 'kafleg',
'14487311' => 'deadpool76',
'14501907' => 'yamchhetri',
'15051834' => 'katiejrichards',
'15103754' => 'ugyensupport',
'15524609' => 'webcommsat',
'15602155' => 'mdburnette',
'15653534' => 'roblesloaiza',
'15739638' => 'smhsmh',
'15981130' => 'angelasjin',
'16080500' => 'kartiks16',
'17578268' => 'passoniate',
'17711991' => 'chaion07',
'18280574' => 'cagrimmett',
'18639962' => 'markmemayank',
'18712198' => 'krysal',
'18747845' => 'iqbalpb',
'20063661' => 'samalderson',
'20420018' => 'benniledl',
'20548266' => 'anish29',
'21001864' => 'soycelycruz',
'21053005' => 'hellosatya',
'14757013' => 'mujuonly',
'15276210' => 'vatoyiit',
'14986584' => 'anil04',
'12738898' => 'bijayyadav',
'12087296' => 'hardeepasrani',
'3543235' => 'snilesh',
'14584016' => 'jhimross',
'10392652' => 'weiko',
'13668985' => 'pablo-moratinos',
);

try {
	$db = new PDO('sqlite:wp-photos.db');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	die("Error connecting to database: " . $e->getMessage());
}

$authors = array();
$orphans = array();

// Get photos from database
$stmt = $db->query('SELECT author, author_href FROM photos');
$photos = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ( $photos as $photo ){
	if ( ! in_array( $photo['author'] , array_keys( $authors ) ) ) {
		$author = array(
			'id'   => $photo['author'],
			'slug' => '', 
			'href' => $photo['author_href'],
			'cant' => 1
		);
		if ( substr( $photo['author_href'], 0, 52) == "https://wordpress.org/photos/wp-json/wporg/v1/users/" ) {
			$author['slug'] = substr( $photo['author_href'], 52 );
		}

		$authors[ $photo['author'] ] = $author;

	} else {
		$authors[ $photo['author'] ]['cant']++;
	}
}

// Comparison function
function cmp($a, $b) {
	if ($a['cant'] == $b['cant']) {
		return 0;
	}
	return ($a['cant'] > $b['cant']) ? -1 : 1;
}
uasort($authors, 'cmp');

foreach ($authors as $id => $author) {
	if ( empty( $author['slug'] ) ) {
		$user_id = substr( $author['href'], 49 );
		if ( ! empty( $user_slugs[ $user_id ] ) ) {
			$author['slug'] = $user_slugs[ $user_id ];
			$authors[ $user_id ]['slug'] = $author['slug'];
		} else {
			$orphans[] = $user_id;
		}
	}
	unset( $authors[$id]['href'] );
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>WordPress Photos Dump - Authors</title>
	<link rel='stylesheet' href='assets/style.css'>
</head>
<body>
	<div class='container'>
		<?php include ('inc/nav.php'); ?>

		<div class='content'>
			<h2>Photo Authors</h2>
			<?php include ('inc/nav_analyze.php'); ?>

			<table class='processing-summary-table'>
				<tr>
					<th>ID</th>
					<th>Slug</th>
					<th>Photos</th>
				</tr>
				<?php foreach ($authors as $id => $author): ?>
					<tr>
						<td><?php echo $id; ?></td>
						<td><?php echo $author['slug'] ?: 'N/A'; ?></td>
						<td><?php echo $author['cant']; ?></td>
					</tr>
				<?php endforeach; ?>
			</table>
			<div class='processing-summary'>
				<p>Total authors: <?php echo count($authors); ?></p>
			</div>

			<?php if (!empty($orphans)): ?>
				<h3>Orphan User IDs</h3>
				<table class='processing-summary-table'>
					<tr>
						<th>ID</th>
						<th>REST API</th>
					</tr>
					<?php foreach ($orphans as $id): ?>
						<tr>
							<td><?php echo $id; ?></td>
							<td>
								<a href="https://wordpress.org/photos/wp-json/wp/v2/users/<?php echo $id; ?>?_fields=id,slug" target="_blank">
									REST API
								</a>
							</td>
						</tr>
					<?php endforeach; ?>
				</table>
			<?php else: ?>
				<p>No orphan user ids found</p>
			<?php endif; ?>
		</div>
	</div>
</body>
</html>