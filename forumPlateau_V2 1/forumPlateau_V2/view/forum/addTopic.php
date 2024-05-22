<?php
$categories=$result["data"]["categories"];
?>

<h1>Ajoutez Votre Topic a Vous</h1>


<form action="index.php?ctrl=forum&action=addTopicAndPostByUser" method="POST">
    <label for="title">Ajouter un Topic</label><br>
    <input type="text" id="title" name="title" placeholder="Titre du Topic"><br>
    
    <label for="category">Catégorie</label><br>
    <select name="category_id" id="category">
        <?php foreach($categories as $category): ?>
            <option value="<?php echo $category->getId(); ?>">
                <?php echo htmlspecialchars($category->getName()); ?>
            </option>
        <?php endforeach; ?>
    </select><br>
    
    <label for="text">Message</label><br>
    <textarea name="text" id="text" placeholder="Votre message..."></textarea><br><br>

    <button type="submit" name="submit">Ajouter</button>
</form>

