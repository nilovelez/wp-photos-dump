<?php
require('./vendor/autoload.php');

try {
    $db = new PDO('sqlite:wp-photos.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec('PRAGMA foreign_keys = ON;');

    $stmt = $db->query('SELECT id, name, slug, count FROM orientations ORDER BY count DESC');
    $orientations = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>WordPress Photos Dump - Orientations</title>
    <link rel='stylesheet' href='assets/style.css'>
</head>
<body>
    <div class='container'>
        <?php include ('inc/nav.php'); ?>

        <div class='content'>
            <h2>Photo Orientations</h2>
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
                    <?php foreach ($orientations as $orientation): ?>
                        <tr>
                            <td><?php echo $orientation['id']; ?></td>
                            <td><?php echo $orientation['name']; ?></td>
                            <td><?php echo $orientation['slug']; ?></td>
                            <td><?php echo $orientation['count']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>