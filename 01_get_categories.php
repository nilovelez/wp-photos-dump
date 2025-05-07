<?php


/*
https://wordpress.org/photos/wp-json/wp/v2/photo-tags
x-wp-total:
7168

https://wordpress.org/photos/wp-json/wp/v2/photo-categories

https://wordpress.org/photos/wp-json/wp/v2/photo
https://wordpress.org/photos/wp-json/wp/v2/photos?per_page=100

*/


require('./vendor/autoload.php');

function get_categories($base_url) {
	// Get current page from GET parameter, default to 1
	$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	
	echo "<div class='pagination-info'>";
	echo "<h3>Processing Categories Page " . $current_page . "</h3>";
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
		"photo-categories",
		[
			'per_page' => '100',
			'page'     => $current_page
		]
	);

	if($result->info->http_code == 200) {
		$result = $result->decode_response();
		$categories_processed = 0;
		$total_categories = count($result);

		echo "<div style='height: 200px; overflow-y: auto; margin-bottom: 20px; padding: 10px; border: 1px solid #ddd;'>";
		foreach ($result as $categoryObj) {
			// Prepare the data for database insertion
			$category = [
				'id' => $categoryObj->id,
				'name' => $categoryObj->name,
				'slug' => $categoryObj->slug,
				'count' => $categoryObj->count
			];

			// Check if category already exists
			$check = $db->prepare('SELECT id, count FROM categories WHERE id = :id');
			$check->bindValue(':id', $category['id'], PDO::PARAM_INT);
			$check->execute();

			if ($existing = $check->fetch()) {
				if ($existing['count'] == $category['count']) {
					echo "<p>Category " . $category['id'] . " (" . $category['name'] . ") already synced with same count</p>";
					continue;
				}
			}

			// Prepare the SQL statement
			$stmt = $db->prepare('
				INSERT OR REPLACE INTO categories (
					id, name, slug, count
				) VALUES (
					:id, :name, :slug, :count
				)
			');

			// Bind the values
			$stmt->bindValue(':id', $category['id'], PDO::PARAM_INT);
			$stmt->bindValue(':name', $category['name'], PDO::PARAM_STR);
			$stmt->bindValue(':slug', $category['slug'], PDO::PARAM_STR);
			$stmt->bindValue(':count', $category['count'], PDO::PARAM_INT);

			// Execute the statement
			if ($stmt->execute()) {
				$categories_processed++;
			} else {
				echo "<div class='error-message'>";
				echo "<p>Error saving category ID " . $category['id'] . " to database</p>";
				echo "</div>";
			}
		}
		echo "</div>";

		echo "<div class='processing-summary'>";
		echo "<p>Processed " . $categories_processed . " categories from page " . $current_page . "</p>";
		echo "</div>";

		// Add next page button
		echo "<div class='pagination-controls'>";
		$next_page_url = '?step=categories&page=' . ($current_page + 1);
		$is_auto_enabled = isset($_GET['auto']) && $_GET['auto'] === 'true';
		$should_advance = $is_auto_enabled && $total_categories > 0;
		
		echo "<form action='' method='get'>";
		echo "<input type='hidden' name='step' value='categories'>";
		echo "<input type='hidden' name='page' value='" . ($current_page + 1) . "'>";
		echo "<label style='margin-left: 20px;'><input type='checkbox' id='autoAdvance' name='auto' value='true' " . ($is_auto_enabled ? 'checked' : '') . "> Advance automatically</label>";
		echo "<input type='submit' value='Process Next Page' class='next-page-button'>";
		echo "</form>";
		echo "</div>";

		echo "<div style='margin-top: 10px; color: #666;'>";
		echo "Debug: total_categories=" . $total_categories . ", categories_processed=" . $categories_processed . ", auto=" . (isset($_GET['auto']) ? $_GET['auto'] : 'false') . ", should_advance=" . ($should_advance ? 'true' : 'false');
		echo "</div>";

		if ($should_advance) {
			echo "<script>
				document.querySelector('.next-page-button').click();
			</script>";
		}

	} else {
		echo "<div class='error-message'>";
		echo "<p>Error fetching categories: HTTP " . $result->info->http_code . "</p>";
		echo "</div>";
	}

	// Close the database connection
	$db = null;
}

$base_url = 'https://wordpress.org/photos/wp-json/wp/v2/';

if ( $categories = get_categories( $base_url ) ) {
	var_dump( $categories );
}
