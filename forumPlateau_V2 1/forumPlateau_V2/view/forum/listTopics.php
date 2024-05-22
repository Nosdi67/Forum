<?php
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics'];
?>

<h1>Liste des topics</h1>

<h2><?= $category->getName() ?></h2>

<?php
if($topics==null){
    echo "<p>Pas de Topic dans cette categorie</p>".
    "<a href='index.php?ctrl=forum&action=backHomePage'>revenir a la page d aceuille</a><br>";      
}else{

    foreach($topics as $topic ){?>
        <p><a href="index.php?ctrl=forum&action=openTopicByID&id=<?= $topic->getId() ?>"><?= $topic ?></a> par <?= $topic->getUser(). " Crée le ". $topic->getCreationDate(); ?></p><br>
    <?php }
}?>

<a href="index.php?ctrl=forum&action=index">revenir en arriere</a>
