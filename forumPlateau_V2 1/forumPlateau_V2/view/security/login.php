<?php

use App\Session;

$session=new Session();
?>

<div class='session_msg'><p><?php echo  $session->getFlash("message") ?></p></div>

<h1>Connectez Vous</h1>

<form action="index.php?ctrl=security&action=loginUser" method="POST">

    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="mail@test.com" placeholder="Email">

    <label for="mdp">Mot de passe</label>
    <input type="password" id="mdp" name="mdp" value="Testmdp22&">

    <button type="submit" name="submit">Se connecter</button>
</form>