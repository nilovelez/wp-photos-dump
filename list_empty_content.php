<?php
require('./vendor/autoload.php');

try {
    $db = new PDO('sqlite:wp-photos.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec('PRAGMA foreign_keys = ON;');

    $stmt = $db->query("SELECT id, slug, img_url FROM photos WHERE content IS NULL OR content = '' ORDER BY id");
    $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>WordPress Photos Dump - Empty Descriptions</title>
    <link rel='stylesheet' href='assets/style.css'>
</head>
<body>
    <div class='container'>
        <?php include ('inc/nav.php'); ?>

        <div class='content'>
            <h2>Photos Without Descriptions</h2>
            <?php include ('inc/nav_analyze.php'); ?>

            <?php if (isset($error)): ?>
                <div class='error'>
                    Error: <?php echo $error; ?>
                </div>
            <?php else: ?>
                <table class='processing-summary-table'>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Edit Link</th>
                        <th>Get alt text</th>
                    </tr>
                    <?php foreach ($photos as $photo): ?>
                        <tr>
                            <td><?php echo $photo['id']; ?></td>
                            <td>
                                <a href="https://wordpress.org/photos/photo/<?php echo $photo['slug']; ?>/" target="_blank">
                                    <?php echo $photo['slug']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="https://wordpress.org/photos/wp-admin/post.php?post=<?php echo $photo['id']; ?>&action=edit" target="_blank">
                                    Edit in WordPress
                                </a>
                            </td>
                            <td>
                                <a href="https://thewp.world/ai-alt-text/?imageurl=<?php echo urlencode($photo['img_url']); ?>" target="_blank">
                                    Get alt text
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <div class='processing-summary'>
                    <p>Total photos without descriptions: <?php echo count($photos); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>