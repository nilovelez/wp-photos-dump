<?php
require 'vendor/autoload.php';

try {
	$db = new PDO('sqlite:wp-photos.db');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	die("Error connecting to database: " . $e->getMessage());
}

// Get tags from database
$stmt = $db->query('SELECT name, count FROM tags ORDER BY count DESC');
$tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
	<title>WordPress Photos Dump - Tags</title>
	<link rel='stylesheet' href='assets/style.css'>
</head>
<body>
	<div class='container'>
		<?php include ('inc/nav.php'); ?>

		<div class='content'>
			<h2>Photo Tags</h2>
			<?php include ('inc/nav_analyze.php'); ?>

			<table class='processing-summary-table'>
				<tr>
					<th>Tag</th>
					<th>Photos</th>
				</tr>
				<?php foreach ($tags as $tag): ?>
					<tr>
						<td><?php echo $tag['name']; ?></td>
						<td><?php echo $tag['count']; ?></td>
					</tr>
				<?php endforeach; ?>
			</table>
			<div class='processing-summary'>
				<p>Total tags: <?php echo count($tags); ?></p>
			</div>
		</div>
	</div>
</body>
</html>