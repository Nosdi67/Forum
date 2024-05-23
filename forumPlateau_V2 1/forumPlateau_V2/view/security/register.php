<?php
use App\Session;



$session = new Session();

?>

<div class='session_msg'><p><?php echo  $session->getFlash("message") ?></p></div>




<h1>Inscrivez vous</h1>

<form action="index.php?ctrl=security&action=addRegistration" method="POST" enctype="multipart/form-data">
    <label for="nickName">Pseudo</label><br>
    <input type="text" id="nickName" name="nickName" placeholder="Pseudo" value="NickNameTest"><br>

    <label for="password">Mot de passe</label><br>
    <input type="password" id="password" name="mdp" placeholder="mot de passe" value="Testmdp22&"><br>

    <label for="mdpdVerif">Confirmation du mot de passe</label><br>
    <input type="password" id="mdpdVerif" name="mdpdVerif" placeholder="Confirmez le mot de passe" value="Testmdp22&"><br>

    <label for="email">Email</label><br>
    <input type="email" id="email" name="email" placeholder="Email" value="mail@test.com"><br>
    <br>

    <label for="image">Photo de Profil</label>
    <input type="file" name="image" id="image">
    <br>
    
    <button type="submit" name="submit">S'inscrire</button>
</form>