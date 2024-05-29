<?php
    $categories = $result["data"]['categories'];
    
?>

<div class="titleDiv">
    <h1>Liste des catégories</h1>
</div>
<div id="categories">
    <?php foreach($categories as $category ): ?>
        <div id="categorie">
            <p><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getName() ?></a></p>
        </div>
    <?php endforeach; ?><br>   
</div>
  
