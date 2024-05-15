<?php
$topic=$result["data"]["topic"];
$title=$topic->getTitle();
$category=$result["data"]["category"];
$postTexts=$result["data"]["postTexts"];
?>

<h1><?php echo $title ?></h1>
<p>Catégorie : <?php echo $category->getName() ?></p>

<?php foreach ($postTexts as $postText): ?>
    <p><?php echo $postText ?></p>
<?php endforeach; ?>


