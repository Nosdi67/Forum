<?php

use App\Session;
$session=new Session();

$topic = $result["data"]["topic"];
$category = $result["data"]["category"];
$posts = $result["data"]["posts"];
$user=Session::getUser();
?>
<div class="topicTitle">
    <h1><?php echo htmlspecialchars($topic->getTitle());?></h1>
        <?php if($topic->getStatut()=="0"){?>
            <p>Discussion Ouverte</p>
        <?php }else{?>
            <p>Verouillé</p>
        <?php } ?>
        <p>Catégorie : <?php echo htmlspecialchars($topic->getCategory()->getName()); ?></p>
        <p>Cree par : <?php echo htmlspecialchars($topic->getUser())?></p>

    <?php if(isset($_SESSION["user"])){

    if($user->getId()==$topic->getUser()->getId()){?>
    
    <form action="index.php?ctrl=forum&action=lockTopic&id=<?= htmlspecialchars($topic->getId()) ?>" method="POST">
            <select name='verrouillage' id='statut'>
            <option value='1' id='statut'>Verouiller</option>
            <option value='0' id='statut'>Deverouiller</option>
            </select>
    
            <button type='submit' name='submit'>Changer</button>
        </form>

    <?php }}?>

</div>
<div class='session_msg'><p><?php echo  $session->getFlash("message") ?></p></div>

<div id="postSection">
<?php if (empty($posts)) {
    echo "<p>Aucun message dans le topic</p>";
} else { ?>
        <?php foreach ($posts as $post): ?>
    <div class="post-wrapper" id="post-wrapper-<?php echo $post->getId() ?>">
        <p id="post-<?php echo $post->getId() ?>">
            <span class="text"><?php echo $post->getText() ?></span>
        </p>
        <p id="postDetails"> envoyé par <?php echo $post->getUser()->getNickName() ?>
            le <?php echo $post->getCreationDate(); ?>
        </p>
        <?php if (isset($_SESSION["user"]) && $user->getId() == $post->getUser()->getId()): ?>
            <p>
                <a href="index.php?ctrl=forum&action=deletePost&id=<?php echo $post->getId() ?>">Supprimer le message</a>
            </p>
            <a href="#" class="edit-post" data-post-id="<?php echo $post->getId() ?>">Modifier le Message</a>
            <form action="index.php?ctrl=forum&action=modifyPost&id=<?php echo $post->getId() ?>" method="post" class="edit-form" style="display: none;">
                <textarea name="text"><?php echo $post->getText() ?></textarea>
                <button type="submit" name="submit">Sauvegarder</button>
            </form>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
<?php } ?>




   
    <?php if($topic->getStatut()=="1"){ echo "Le Topic est verouillé, vous ne pouvez pas envoyer de message";}else{?>
        
        <form action="index.php?ctrl=forum&action=sendMessage&id=<?= htmlspecialchars($topic->getId()) ?>"  method="POST">
            <label for='text'>Message:</label><br>
            <textarea id='text' name='text'></textarea><br>
            <button type='submit' name='submit'>Envoyer</button>
        </form><br>
    <?php } ?>
    <br>
</div>

<a href='index.php?ctrl=forum&action=backHomePage'>Revenir à la page d'accueil</a><br>
<a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= htmlspecialchars($category->getId()) ?>">Revenir en arrière</a>


 <script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".edit-post").forEach(function(button) {
            button.addEventListener("click", function(event) {
                event.preventDefault();
                
                // Trouver les éléments concernés
                var postId = this.getAttribute("data-post-id");
                var postWrapper = document.getElementById("post-wrapper-" + postId);
                var textElement = postWrapper.querySelector("p .text");
                var editForm = postWrapper.querySelector(".edit-form");
                var textarea = editForm.querySelector("textarea");

                // Pré-remplir le textarea avec le texte actuel du message
                textarea.value = textElement.innerText;

                // Afficher le formulaire d'édition et masquer le texte actuel
                textElement.style.display = "none";
                editForm.style.display = "block";
            });
        });
    });
</script>


