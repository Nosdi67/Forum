<?php

use App\Session;
$session=new Session();

$topic = $result["data"]["topic"];
$category = $result["data"]["category"];
$posts = $result["data"]["posts"];
$user=Session::getUser();
?>

<h1><?php echo htmlspecialchars($topic->getTitle());?></h1>
<?php if($topic->getStatut()=="0"){?>
    <p>Deverouillé</p>
<?php }else{?>
    <p>Verouillé</p>
<?php } ?>
<p>Catégorie : <?php echo htmlspecialchars($topic->getCategory()->getName()); ?></p>

<div class='session_msg'><p><?php echo  $session->getFlash("message") ?></p></div>

<?php 
    if (empty($posts)) {
        echo "<p>Aucun message dans le topic</p>";
    } else {
        foreach ($posts as $post): ?>
            <p id="post-<?php $post->getId()?>"><?php echo $post->getText()." envoyé par ". $post->getUser()->getNickName()." le ".$post->getCreationDate(); ?> 
            
            <?php if(isset($_SESSION["user"])){if($user->getId()==$post->getUser()->getId()){?>
                <p><a href="index.php?ctrl=forum&action=deletePost&id=<?= $post->getId() ?>">Supprimer le message</a></p>
                <a href="#" class="edit-post" data-post-id="<?= $post->getId()?>">Modifier le Message</a>
                
        <?php }} ?>

        <?php endforeach; 
}?>

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

<?php if($topic->getStatut()=="1"){ echo "Le Topic est verouillé, vous ne pouvez pas envoyer de message";}else{?>
    
    <form action="index.php?ctrl=forum&action=sendMessage&id=<?= htmlspecialchars($topic->getId()) ?>"  method="POST">
        <label for='text'>Message:</label><br>
        <textarea id='text' name='text'></textarea><br>
        <button type='submit' name='submit'>Envoyer</button>
    </form><br>
<?php } ?>
<br>

<a href='index.php?ctrl=forum&action=backHomePage'>Revenir à la page d'accueil</a><br>
<a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= htmlspecialchars($category->getId()) ?>">Revenir en arrière</a>


<script>
    
    document.addEventListener("DOMContentLoaded", function() {
    const editPostButtons = document.querySelectorAll('.edit-post');

    editPostButtons.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const postId = link.dataset.postId;
            const postContentElement = document.getElementById(`post-${postId}`);

            if (postContentElement) {
                const postContent = postContentElement.textContent;

                const postInput = document.createElement('input');
                postInput.value = postContent;
                postContentElement.parentNode.insertBefore(postInput, postContentElement.nextSibling);

                postInput.addEventListener('blur', function() {
                    const updatedContent = postInput.value;

                    postContentElement.textContent = updatedContent;
                    postInput.parentNode.removeChild(postInput);
                });
            } else {
                console.error(`Element with ID 'post-${postId}' not found.`);
            }
        });
    });
});



</script>