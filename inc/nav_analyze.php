<?php
$steps = [
    'Authors' => 'list_authors.php',
    'Categories' => 'list_categories.php',
    'Colors' => 'list_colors.php',
    'Orientations' => 'list_orientations.php',
    'Tags' => 'list_tags.php',
    'Empty Descriptions' => 'list_empty_content.php',
    'Empty Categories' => 'list_empty_categories.php',
    'Empty Colors' => 'list_empty_colors.php',
    'Empty Tags' => 'list_empty_tags.php',
];
?>
<div class='button-group'>
    <?php foreach ($steps as $label => $url): ?>
        <a href='<?php echo $url; ?>' class='sync-button'><?php echo $label; ?></a>
    <?php endforeach; ?>
</div> 