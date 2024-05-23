<?php

use App\Session;
$session=new Session();

$topic = $result["data"]["topic"];
$category = $result["data"]["category"];
$posts = $result["data"]["posts"];
$user=Session::getUser();
?>

<h1><?php echo htmlspecialchars($topic->getTitle());?></h1>
<p><?= $topic->getStatut() ?></p>
<p>Catégorie : <?php echo htmlspecialchars($topic->getCategory()->getName()); ?></p>

<div class='session_msg'><p><?php echo  $session->getFlash("message") ?></p></div>

<?php 
    if (empty($posts)) {
        echo "<p>Aucun message dans le topic</p>";
    } else {
        foreach ($posts as $post): ?>
            <p><?php echo $post->getText()." envoyé par ". $post->getUser()->getNickName()." le ".$post->getCreationDate(); ?></p>
        <?php endforeach; 
}?>

<?php if($user->getId()==$topic->getUser()->getId()){
    
    echo"<form action='index.php?ctrl=forum&action=lockTopic&id=".$topic->getId()."method='POST'>".
            "<select name='verrouillage' id='statut'>".
            "<option value='1' id='statut'>Verouiller</option>".
            "<option value='0' id='statut'>Deverouiller</option>".
            "</select>".
    
            "<button type='submit' name='submit'>Changer</button>".
        "</form>";

}?>
<?php if($topic->getStatut()=="1"){ echo "Le Topic est verouillé, vous ne pouvez pas envoyer de message";}else{
    
    echo "<form action='index.php?ctrl=forum&action=sendMessage&id=".htmlspecialchars($topic->getId()) ." method='POST'".
        "<label for='text'>Message:</label><br>".
        "<textarea id='text' name='text'></textarea><br>".
        "<button type='submit' name='submit'>Envoyer</button>".
    "</form>"."<br>";
}?>
<br>

<a href='index.php?ctrl=forum&action=backHomePage'>Revenir à la page d'accueil</a><br>
<a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= htmlspecialchars($category->getId()) ?>">Revenir en arrière</a>
