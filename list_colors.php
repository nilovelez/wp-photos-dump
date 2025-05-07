<?php
require('./vendor/autoload.php');

try {
    $db = new PDO('sqlite:wp-photos.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec('PRAGMA foreign_keys = ON;');

    $stmt = $db->query('SELECT id, name, slug, count FROM colors ORDER BY count DESC');
    $colors = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>WordPress Photos Dump - Colors</title>
    <link rel='stylesheet' href='assets/style.css'>
</head>
<body>
    <div class='container'>
        <?php include ('inc/nav.php'); ?>

        <div class='content'>
            <h2>Photo Colors</h2>
            <?php include ('inc/nav_analyze.php'); ?>

            <?php if (isset($error)): ?>
                <div class='error'>
                    Error: <?php echo $error; ?>
                </div>
            <?php else: ?>
                <table class='processing-summary-table'>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Count</th>
                    </tr>
                    <?php foreach ($colors as $color): ?>
                        <tr>
                            <td><?php echo $color['id']; ?></td>
                            <td><?php echo $color['name']; ?></td>
                            <td><?php echo $color['slug']; ?></td>
                            <td><?php echo $color['count']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>