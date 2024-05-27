<?php
use App\Session;

$session = new Session();
$topics=$result["data"]['topic'];
?>

<div class='session_msg'><p><?php echo  $session->getFlash("message") ?></p></div>

<div class="welcomeDiv">
    <div class="welcomeMsg">
        <h1>BIENVENUE SUR LE FORUM</h1>

        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit ut nemo quia voluptas numquam, itaque ipsa soluta ratione eum temporibus aliquid, facere rerum in laborum debitis labore aliquam ullam cumque.</p>

        <h3 class="titreTopics">En ce moment:</h3>
        <div id="topics">
            <?php foreach($topics as $topic):?>
                <div class="topic">
                    <p><a href="index.php?ctrl=forum&action=openTopicByID&id=<?= $topic->getId() ?>"><?= $topic->getTitle() ?></a></p>
                </div>
            <?php endforeach?>
</div>
    </div>
    
    <div class="welcomeForm">
        <h2>Pas de compte encore? Inscrivez-vous</h2>
        <form action="index.php?ctrl=security&action=addRegistration" method="POST" enctype="multipart/form-data">
            <label for="nickName">Pseudo</label><br>
            <input type="text" id="nickName" name="nickName" placeholder="Pseudo" value="NickNameTest"><br>

            <label for="password">Mot de passe</label><br>
            <input type="password" id="password" name="mdp" placeholder="mot de passe" value="Testmdp22&"><br>

            <label for="mdpdVerif">Confirmez le mot de passe</label><br>
            <input type="password" id="mdpdVerif" name="mdpdVerif" placeholder="Confirmez le mot de passe" value="Testmdp22&"><br>

            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" placeholder="Email" value="mail@test.com"><br>
            <br>

            <label for="image">Photo de Profil</label><br>
            <input type="file" name="image" id="image"><br>
            <br>
            
            <button type="submit" name="submit">S'inscrire</button>
        </form>
    </div>

</div>

