<?php
$categories=$result["data"]["categories"];
$users=$result["data"]["users"];
?>

<h1>Page Admin</h1>

<form action="index.php?ctrl=forum&action=addCategory" method="POST">
    <label for="name">Ajouter une Categorie</label><br>
    <input type="text" id="name" name="name" placeholder="Nom de la Categorie">
    <button type="submit" name="submit">Ajouter</button>
</form><br>

<form action="index.php?ctrl=forum&action=addTopicAndFirstMessage" method="POST">
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
    
    <label for="user">Auteur</label><br>
    <select name="user_id" id="user">
        <?php foreach($users as $user): ?>
            <option value="<?php echo $user->getId(); ?>">
                <?php echo htmlspecialchars($user->getNickName()); ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="text">Message</label><br>
    <textarea name="text" id="text" placeholder="Votre message..."></textarea><br><br>

    <button type="submit" name="submit">Ajouter</button>
</form>

