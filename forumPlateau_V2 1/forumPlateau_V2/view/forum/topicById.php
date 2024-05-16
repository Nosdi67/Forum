<?php
$topic=$result["data"]["topic"];
$title=$topic->getTitle();
$category=$result["data"]["category"];
$posts=$result["data"]["posts"];
$nomUser=$topic->getUser();
$datePost=$topic->getCreationDate();
?>

<h1><?php echo $title ?></h1>
<p>Catégorie : <?php echo $category->getName() ?></p>

<?php 
if (empty($posts)){;
    echo "<p>aucun message dans le topic</p>";
}else{
    foreach ($posts as $post): ?>
    <p><?php echo $post->getText()." envoyé par ". $nomUser." le ".$datePost; ?></p>
<?php endforeach;} ?>

<form action="index.php?ctrl=forum&action=sendMessage&id=<?= $topic->getId() ?>" method="POST">
    <label for="text">Message:</label><br>
    <textarea id="text" name="text"></textarea><br>
    <button type="submit" name="submit">Envoyer</button>
</form>

<a href='index.php?ctrl=forum&action=backHomePage'>revenir a la page d aceuille</a><br>
<a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>">revenir en arriere</a>



