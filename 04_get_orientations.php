<?php
require('./vendor/autoload.php');

function get_orientations($base_url) {
    // Get current page from GET parameter, default to 1
    $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    
    echo "<div class='pagination-info'>";
    echo "<h3>Processing Orientations Page " . $current_page . "</h3>";
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
        "photo-orientations",
        [
            'per_page' => '100',
            'page'     => $current_page
        ]
    );

    if($result->info->http_code == 200) {
        $result = $result->decode_response();
        $orientations_processed = 0;
        $total_orientations = count($result);

        echo "<div style='height: 200px; overflow-y: auto; margin-bottom: 20px; padding: 10px; border: 1px solid #ddd;'>";
        foreach ($result as $orientationObj) {
            // Prepare the data for database insertion
            $orientation = [
                'id' => $orientationObj->id,
                'name' => $orientationObj->name,
                'slug' => $orientationObj->slug,
                'count' => $orientationObj->count
            ];

            // Check if orientation already exists
            $check = $db->prepare('SELECT id, count FROM orientations WHERE id = :id');
            $check->bindValue(':id', $orientation['id'], PDO::PARAM_INT);
            $check->execute();

            if ($existing = $check->fetch()) {
                if ($existing['count'] == $orientation['count']) {
                    echo "<p>Orientation " . $orientation['id'] . " (" . $orientation['name'] . ") already synced with same count</p>";
                    continue;
                }
            }

            // Prepare the SQL statement
            $stmt = $db->prepare('
                INSERT OR REPLACE INTO orientations (
                    id, name, slug, count
                ) VALUES (
                    :id, :name, :slug, :count
                )
            ');

            // Bind the values
            $stmt->bindValue(':id', $orientation['id'], PDO::PARAM_INT);
            $stmt->bindValue(':name', $orientation['name'], PDO::PARAM_STR);
            $stmt->bindValue(':slug', $orientation['slug'], PDO::PARAM_STR);
            $stmt->bindValue(':count', $orientation['count'], PDO::PARAM_INT);

            // Execute the statement
            if ($stmt->execute()) {
                $orientations_processed++;
            } else {
                echo "<div class='error-message'>";
                echo "<p>Error saving orientation ID " . $orientation['id'] . " to database</p>";
                echo "</div>";
            }
        }
        echo "</div>";

        echo "<div class='processing-summary'>";
        echo "<p>Processed " . $orientations_processed . " orientations from page " . $current_page . "</p>";
        echo "</div>";

        // Add next page button
        echo "<div class='pagination-controls'>";
        $next_page_url = '?step=orientations&page=' . ($current_page + 1);
        $is_auto_enabled = isset($_GET['auto']) && $_GET['auto'] === 'true';
        $should_advance = $is_auto_enabled && $total_orientations > 0;
        
        echo "<form action='' method='get'>";
        echo "<input type='hidden' name='step' value='orientations'>";
        echo "<input type='hidden' name='page' value='" . ($current_page + 1) . "'>";
        echo "<label style='margin-left: 20px;'><input type='checkbox' id='autoAdvance' name='auto' value='true' " . ($is_auto_enabled ? 'checked' : '') . "> Advance automatically</label>";
        echo "<input type='submit' value='Process Next Page' class='next-page-button'>";
        echo "</form>";
        echo "</div>";

        echo "<div style='margin-top: 10px; color: #666;'>";
        echo "Debug: total_orientations=" . $total_orientations . ", orientations_processed=" . $orientations_processed . ", auto=" . (isset($_GET['auto']) ? $_GET['auto'] : 'false') . ", should_advance=" . ($should_advance ? 'true' : 'false');
        echo "</div>";

        if ($should_advance) {
            echo "<script>
                document.querySelector('.next-page-button').click();
            </script>";
        }

    } else {
        echo "<div class='error-message'>";
        echo "<p>Error fetching orientations: HTTP " . $result->info->http_code . "</p>";
        echo "</div>";
    }

    // Close the database connection
    $db = null;
}

$base_url = 'https://wordpress.org/photos/wp-json/wp/v2/';

if ( $orientations = get_orientations( $base_url ) ) {
    var_dump( $orientations );
} 