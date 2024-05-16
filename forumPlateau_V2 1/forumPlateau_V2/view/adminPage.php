<?php

?>

<h1>Page Admin</h1>

<form action="index.php?ctrl=forum&action=addCategory" method="POST">
    <label for="name">Nom</label><br>
    <input type="text" id="name" name="name" placeholder="Nom de la Categorie">
    <button type="submit" name="submit">Ajouter</button>
</form><br>

<form action="index.php?ctrl=forum&action=addTopic" method="POST">
    <label for="title">Titre du Topic</label><br>
    <input type="text" id="title" name="title" placeholder="Titre du Topic">
    
    <label for="category">Catégorie</label>
    <select name="category">
        <?php
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->findAll();
        foreach($categories as $category):?>
        <select name="" id="">
           <option value= <?php echo $category->getId(). $category->getName(); ?> </option>;
            <?php endforeach;?>
            </select>
    <button type="submit" name="submit">Ajouter</button>
</form>