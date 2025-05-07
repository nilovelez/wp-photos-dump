<?php
$menu_items = [
    'Home' => 'index.php',
    'Synchronize' => 'synchronize.php',
    'Analyze Content' => 'analyze_content.php',
];
?>
<nav>
    <ul>
        <?php foreach ($menu_items as $label => $url): ?>
            <li><a href="<?php echo $url; ?>"><?php echo $label; ?></a></li>
        <?php endforeach; ?>
    </ul>
</nav> 