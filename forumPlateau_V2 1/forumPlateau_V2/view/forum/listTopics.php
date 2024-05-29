<?php
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics'];
?>
<div class="titleDiv">
    <h1>Liste des topics</h1>
    <h2><?= $category->getName() ?></h2>
</div>
<?php
if($topics==null){
    echo "<p>Pas de Topic dans cette categorie</p>".
    "<a href='index.php?ctrl=forum&action=backHomePage'>revenir a la page d aceuille</a><br>";      
}else{?>
    <div id="topics">
        <?php foreach($topics as $topic ):?>
            <div class="topic">
                <p><a href="index.php?ctrl=forum&action=openTopicByID&id=<?= $topic->getId() ?>"><?= $topic ?></a></p>
                <p class="user">par <?= $topic->getUser()?>
                <p class="date">Crée le <?= $topic->getCreationDate(); ?></p><br>
            </div>
        <?php endforeach; }?>
    </div>

<a class="backBtn" href="index.php?ctrl=forum&action=index">revenir en arriere</a>
