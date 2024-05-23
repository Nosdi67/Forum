<?php
$users=$result["data"]["user"];
$topics=$result["data"]["topics"];

use App\Session;
$session=new Session();
?>
<h1>Binevenue, <?= $users->getNickName(); ?></h1>

<img src="<?= Session::getUser()->getImage(); ?>" alt="Image de <?= $users->getNickName(); ?>">

<h2>Mes topics</h2>

<?php if (!empty($topics)): ?>
    <?php foreach($topics as $topic): ?>
        <p><a href="index.php?ctrl=forum&action=openTopicByID&id=<?= $topic->getId() ?>"><?= $topic->getTitle() ?></a> Crée le  <?= $topic->getCreationDate(); ?></p><br>
    <?php endforeach; ?>
<?php else: ?>
    <p>Vous n'avez pas encore créé de topics.</p>
<?php endif; ?>


<h3>Modifier le Profil</h3>
<button id="afficherDivNickName">Changer le Pseudo</button>
<button id="afficherDivEmail">Changer Email</button>
<button id="afficherDivMdp">Changer le Mot de Passe</button>
<button id="afficherDivImage">Changer la photo de Profil</button>

<div id="changerNickName" style="display: none;">
    <form action="index.php?ctrl=security&action=editProfile" method="POST">
        <label for="nickName">Nouveau NickName:</label><br>
        <input type="text" id="nickName" name="nickName" placeholder="Nouveau NickName"><br>

        <button type="submit" name="submit">Modifier</button>
    </form>
</div>

<div id="changerMdp" style="display:none;">
    <form action="index.php?ctrl=security&action=editProfile" method="POST">
        <label for="mdp">Nouveau Mot de Passe:</label><br>
        <input type="password" id="mdp" name="mdp"><br>

        <label for="mdp2">Confirmez le nouveau Mot de Passe</label><br>
        <input type="password" id="mdp2" name="mdp2"> 

        <button type="submit" name="submit">Modifier</button>
    </form>    
</div>

<div id="changerEmail" style="display:none;">
    <form action="index.php?ctrl=security&action=editProfile" method="POST">
        <label for="email">Nouveau Email:</label><br>
        <input type="email" id="email" name="email" placeholder="Nouveau Email"><br>

        <button type="submit" name="submit">Modifier</button>
    </form>

</div><br>


<div id="changerImg" style="display:none;">
    <form action="index.php?ctrl=security&action=editProfile" method="POST" enctype="multipart/form-data">
        
        <label for="image">Ajouter une Image:</label><br>
        <input type="file" id="image" name="image"><br>
        
        <button type="submit" name="submit">Modifier</button>
    </form>
</div><br>

<div class='session_msg'><p><?php echo $session->getFlash("message") ?></p></div>


<script>
 document.getElementById("afficherDivNickName").onclick = function() {

    document.getElementById("changerNickName").style.display = "block";
    document.getElementById("changerMdp").style.display = "none";
    document.getElementById("changerEmail").style.display = "none";
    document.getElementById("changerImg").style.display = "none";
    };
    document.getElementById("afficherDivMdp").onclick = function() {
        document.getElementById("changerNickName").style.display = "none";
        document.getElementById("changerMdp").style.display = "block";
        document.getElementById("changerEmail").style.display = "none";
        document.getElementById("changerImg").style.display = "none";
    };
    document.getElementById("afficherDivEmail").onclick = function() {
        document.getElementById("changerNickName").style.display = "none";
        document.getElementById("changerMdp").style.display = "none";
        document.getElementById("changerEmail").style.display = "block";
        document.getElementById("changerImg").style.display = "none";
    };
    document.getElementById("afficherDivImage").onclick = function() {
        document.getElementById("changerNickName").style.display = "none";
        document.getElementById("changerMdp").style.display = "none";
        document.getElementById("changerEmail").style.display = "none";
        document.getElementById("changerImg").style.display = "block";
    };
</script>
