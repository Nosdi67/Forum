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
        <div class="post-wrapper">
            <p id="post-<?php echo $post->getId() ?>">
                <span class="text"><?php echo $post->getText() ?></span>
                envoyé par <?php echo $post->getUser()->getNickName() ?>
                le <?php echo $post->getCreationDate(); ?>
            </p>
            <?php if (isset($_SESSION["user"]) && $user->getId() == $post->getUser()->getId()): ?>
                <p><a href="index.php?ctrl=forum&action=deletePost&id=<?php echo $post->getId() ?>">Supprimer le message</a></p>
                <a href="#" class="edit-post" data-post-id="<?php echo $post->getId() ?>">Modifier le Message</a>
            <?php endif; ?>
        </div>
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

<?php var_dump($_POST);
error_log(print_r($_POST, true)); ?>
<script>
 document.addEventListener("DOMContentLoaded", function() {
    const editPostButtons = document.querySelectorAll('.edit-post');

    editPostButtons.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const postId = link.dataset.postId;
            const postContentElement = document.getElementById(`post-${postId}`);
            
            if (postContentElement) {
                const postTextElement = postContentElement.querySelector('.text');

                if (postTextElement) {
                    const postContent = postTextElement.textContent;

                    // Créer les éléments de formulaire
                    const postForm = document.createElement('form');
                    const postInput = document.createElement('input');
                    const postSubmit = document.createElement('button');
                    const postHiddenSubmit = document.createElement('input');

                    // Configurer les éléments
                    postInput.type = 'text';
                    postInput.name = 'text';
                    postInput.value = postContent;
                    postSubmit.type = 'submit';
                    postSubmit.textContent = 'Enregistrer';
                    postHiddenSubmit.type = 'hidden';
                    postHiddenSubmit.name = 'submit';
                    postHiddenSubmit.value = '1';

                    // Ajouter les éléments au formulaire
                    postForm.appendChild(postInput);
                    postForm.appendChild(postHiddenSubmit);
                    postForm.appendChild(postSubmit);
                    postContentElement.parentNode.insertBefore(postForm, postContentElement.nextSibling);

                    // Cacher le contenu original temporairement
                    postContentElement.style.display = 'none';

                    // Focus sur le champ de saisie
                    postInput.focus();

                    // Gestion de la soumission du formulaire
                    postForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const updatedContent = postInput.value;

                        // Envoie des données via POST
                        fetch(`index.php?ctrl=forum&action=modifyPost&id=${postId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `text=${encodeURIComponent(updatedContent)}&submit=1`
                        }).then(response => response.text()).then(data => {
                            console.log(`Response: ${data}`); // Debug: Log la réponse du serveur
                            if (data.trim() === 'success') {
                                // Mise à jour du contenu sur succès
                                postTextElement.textContent = updatedContent;
                                postContentElement.style.display = 'inline';
                                postForm.remove();
                            } else {
                                console.error('Erreur lors de la mise à jour du message:', data);
                            }
                        }).catch(error => {
                            console.error('Erreur lors de la mise à jour du message:', error);
                        });
                    });

                    // Gestion du blur de l'input pour supprimer le formulaire si nécessaire
                    postInput.addEventListener('blur', function() {
                        setTimeout(() => {
                            if (!postForm.contains(document.activeElement)) {
                                postContentElement.style.display = 'inline';
                                postForm.remove();
                            }
                        }, 200);
                    });
                } else {
                    console.error(`Element with class 'text' not found in post-${postId}.`);
                }
            } else {
                console.error(`Element with ID 'post-${postId}' not found.`);
            }
        });
    });
});
</script>

