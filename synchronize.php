<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Synchronize - WordPress Photos Dump</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php require 'inc/nav.php'; ?>
    <h1>Synchronize Photos</h1>
    
    <div class="button-group">
        <a href="?step=photos" class="sync-button">1. Fetch Photos</a>
        <a href="?step=categories" class="sync-button">2. Process Categories</a>
        <a href="?step=colors" class="sync-button">3. Process Colors</a>
        <a href="?step=tags" class="sync-button">4. Process Tags</a>
        <a href="?step=orientations" class="sync-button">5. Process Orientations</a>
    </div>

    <?php
    if (isset($_GET['step'])) {
        echo "<div style='margin-top: 20px;'>";
        echo "<h2>Synchronization Process</h2>";
        
        switch ($_GET['step']) {
            case 'photos':
                echo "<p>Fetching photos from WordPress.org...</p>";
                include '00_get_photos.php';
                break;
                
            case 'categories':
                echo "<p>Processing categories...</p>";
                include '01_get_categories.php';
                break;
                
            case 'colors':
                echo "<p>Processing colors...</p>";
                include '02_get_colors.php';
                break;
                
            case 'tags':
                echo "<p>Processing tags...</p>";
                include '03_get_tags.php';
                break;
                
            case 'orientations':
                echo "<p>Processing orientations...</p>";
                include '04_get_orientations.php';
                break;
        }
        
        echo "<p style='color: green;'>Step completed successfully!</p>";
        echo "</div>";
    }
    ?>
</body>
</html> 