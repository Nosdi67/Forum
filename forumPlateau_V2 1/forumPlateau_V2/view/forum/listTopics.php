<?php
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
?>

<h1>Liste des topics</h1>

<?php
if($topics==null){
    echo "<p>Pas de Topic dans cette categorie</p>".
    "<a href='index.php?ctrl=forum&action=backHomePage'>revenir a la page d aceuille</a>";      
}else{

    foreach($topics as $topic ){ ?>
    <p><a href="index.php?ctrl=forum&action=openTopicByID&id=<?= $topic->getId() ?>"><?= $topic ?></a> par <?= $topic->getUser() ?></p>
    <?php }
}?>
