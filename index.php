<?php   include_once('inc/header.php');  

$resultat = executeRequete("SELECT * FROM jeux");

$jeux = $resultat->fetchAll(PDO::FETCH_ASSOC);  // on "fetch" le produit sans boucle while car il y en a qu'un seul par identifiant. 



?>
  

  <div class="text-center  mt-4  " style="background-color: #1B2838">
    <h1 class="text-[75px] text-sky-600">Mon premier titre</h1>
    <div class="row justify-content-center">
<?php   foreach($jeux as $jeu):   ?>

<div class="card bg-neutral-600 text-white col-3 m-3" style="width: 18rem;">
    <img style="max-height: 250px;min-height: 250px" src="<?= $jeu['photo'] ?>" class="mt-2" alt="...">
    <div class="card-body">
      <h5 class="card-title"><?= $jeu['titre'] ?></h5>
      

      <p class="card-text"><?= $jeu["description"]  ?> </p>
      <a href="detail.php?id=<?= $jeu['id_jeux'] ?>" class="btn btn-primary">plus d'information
      </a>
      <a href="formulaire.php?id=<?= $jeu['id_jeux'] ?>" class="btn btn-primary">modifier
      </a>
    </div>
    
  </div>
  
<?php   endforeach;   ?>
  </div>


<?php   include_once('inc/footer.php');     ?>  
