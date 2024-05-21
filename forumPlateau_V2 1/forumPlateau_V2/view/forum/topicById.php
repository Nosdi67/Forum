<?php
$topic = $result["data"]["topic"];
$category = $result["data"]["category"];
$posts = $result["data"]["posts"];
$users = $result["data"]["user"];
$datePost = $topic->getCreationDate();
?>

<h1><?php echo htmlspecialchars($topic->getTitle()); ?></h1>
<p>Catégorie : <?php echo htmlspecialchars($topic->getCategory()->getName()); ?></p>

<?php 
if (empty($posts)) {
    echo "<p>Aucun message dans le topic</p>";
} else {
    foreach ($posts as $post): ?>
        <p><?php echo $post->getText()." envoyé par ". $users->getNickName()." le ".$datePost; ?></p>
    <?php endforeach; 
}
?>

<form action="index.php?ctrl=forum&action=sendMessage&id=<?= htmlspecialchars($topic->getId()) ?>" method="POST">
    <label for="text">Message:</label><br>
    <textarea id="text" name="text"></textarea><br>
    <button type="submit" name="submit">Envoyer</button>
</form>

<a href='index.php?ctrl=forum&action=backHomePage'>Revenir à la page d'accueil</a><br>
<a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= htmlspecialchars($category->getId()) ?>">Revenir en arrière</a>
