<?php include('inc/header.php');



//var_dump($_POST);
//var_dump($_FILES);

if (!empty($_POST)) {   // si le formulaire a été envoyé

  // ici il faudrait mettre tous les contrôles sur le formulaire...

  $photo_bdd = ''; // par défaut la photo en BDD est vide     

  $photo_bdd1 = '';
  $photo_bdd2 = '';

  // 9 suite : modification de la photo :



  // 5 suite : traitement de la photo :
  // debug($_FILES);  // $_FILES est une superglobale qui représente l'input type "file" d'un formulaire. L'indice "photo" correspond à l'attribut "name" de l'input. Les autres indices du sous-tableau sont prédéfinis : "name" pour le nom du fichier, "type" pour le type du fichier (image), "tmp_name" pour l'adresse du fichier temporaire en cours d'upload, "error" pour le code erreur de téléchargement, "size" pour la taille du fichier uploadé.

  if (!empty($_FILES['photo']['name'])) {  // si un fichier est en cours d'upload

    $fichier_photo = $_FILES['photo']['name']; // nom de la photo

    $photo_bdd = 'photo/' . $fichier_photo;  // chemin relatif de la photo qui est enregistré en BDD et qui nous servira pour l'attribut "src" des balises images (les photos sont copiées dans le dossier "photo" ligne suivante).

    copy($_FILES['photo']['tmp_name'],  $photo_bdd); // cette fonction prédéfinie enregistre le fichier qui est temporairement à l'adresse "tmp_name" vers l'adresse dont le chemin est "../photo/fichier_photo.jpg".

  }
  
  if(empty($_FILES['photo']['name']) && isset($_POST['photo_actuelle'])):

    $photo_bdd=$_POST['photo_actuelle'];
  endif;

  if (!empty($_FILES['photo1']['name'])) {  // si un fichier est en cours d'upload

    $fichier_photo = $_FILES['photo1']['name']; // nom de la photo

    $photo_bdd1 = 'photo/' . $fichier_photo;  // chemin relatif de la photo qui est enregistré en BDD et qui nous servira pour l'attribut "src" des balises images (les photos sont copiées dans le dossier "photo" ligne suivante).

    copy($_FILES['photo1']['tmp_name'],  $photo_bdd1); // cette fonction prédéfinie enregistre le fichier qui est temporairement à l'adresse "tmp_name" vers l'adresse dont le chemin est "../photo/fichier_photo.jpg".
  }

  if(empty($_FILES['photo1']['name']) && isset($_POST['photo_actuelle1'])):

    $photo_bdd1=$_POST['photo_actuelle1'];
  endif;

  if (!empty($_FILES['photo2']['name'])) {  // si un fichier est en cours d'upload

    $fichier_photo = $_FILES['photo2']['name']; // nom de la photo

    $photo_bdd2 = 'photo/' . $fichier_photo;  // chemin relatif de la photo qui est enregistré en BDD et qui nous servira pour l'attribut "src" des balises images (les photos sont copiées dans le dossier "photo" ligne suivante).

    copy($_FILES['photo2']['tmp_name'],  $photo_bdd2); // cette fonction prédéfinie enregistre le fichier qui est temporairement à l'adresse "tmp_name" vers l'adresse dont le chemin est "../photo/fichier_photo.jpg".


  }
  
  if(empty($_FILES['photo2']['name']) && isset($_POST['photo_actuelle2'])):

    $photo_bdd2=$_POST['photo_actuelle2'];
  endif;

  // Insertion en BDD :
  $requete = executeRequete("REPLACE INTO jeux VALUES (:id_jeux, :titre, :description, :photo,:photo1, :photo2, :editeur, :date, :lien_du_jeux, :video)", array(
    ':id_jeux'  => $_POST['id_jeux'],
    ':titre'       => $_POST['titre'],
    ':description' => $_POST['description'],
    ':photo' => $photo_bdd,
    ':photo1' => $photo_bdd1,
    ':photo2' => $photo_bdd2,
    ':editeur'   => $_POST['editeur'],
    ':date' => $_POST['date'],
    ':lien_du_jeux' => $_POST['lien_du_jeux'],
    ':video' => $_POST['video']

  ));  // REPLACE INTO fait un INSERT quand l'ID donné n'existe pas (0). Il se comporte comme un UPDATE quand l'ID donné existe. 

  $resultat = executeRequete("SELECT * FROM jeux ORDER BY id_jeux DESC");

  $je = $resultat->fetch(PDO::FETCH_ASSOC);
  //die($je['id_jeux']);

  // die($requete->lastInsertId());
  foreach ($_POST['plateforme'] as $plateforme) :

    $requete = executeRequete("INSERT INTO console_jeux (id_jeux, id_console) VALUES (:id_jeux, :id_console )", array(
      ':id_jeux' => $je['id_jeux'],
      ':id_console' => $plateforme
    ));

  endforeach;

  header('location:./index.php');
  exit;
}

$resultat = executeRequete("SELECT * FROM consoles");

$consoles = $resultat->fetchAll(PDO::FETCH_ASSOC);


if (isset($_GET['id'])) {  // si "id_produit" est dans l'URL, c'est que nous avons demandé la modification du produit : on sélectionne les infos du produit en BDD pour l'afficher dans le formulaire
  $resultat = executeRequete("SELECT * FROM jeux WHERE id_jeux = :id_jeux", array(':id_jeux' => $_GET['id']));

  $jeux = $resultat->fetch(PDO::FETCH_ASSOC);  // on "fetch" le produit sans boucle while car il y en a qu'un seul par identifiant. 

  // debug($produit);

}




















?>

<link rel="stylesheet" href="inc/css/select2.css">

<form action="" method="post" enctype="multipart/form-data" class="bg-white ml-20 mr-20 p-10">
  <div class="text-center">
<h1 class="text-cyan-400 text-[40px] mb-20">Ajouter un jeu</h1>
</div>
  <input type="hidden" value="<?= $jeux['id_jeux'] ??  0  ?>" name="id_jeux">
  <div class="row g-3 align-items-center">
   <div class="col-auto mb-10">
      <label for="inputPassword6" class="col-form-label">nom du jeux</label>
    
 
      <input type="text" name='titre' id="inputPassword6" class="form-control" value="<?= $jeux['titre'] ??  ''  ?>" aria-describedby="passwordHelpInline">
    </div>


  </div>
  <div class="form-group">
    <fieldset>
      <label class="form-label" for="disabledInput">editeur</label>
      <input class="form-control" type="text" name='editeur' value="<?= $jeux['editeur'] ??  ''  ?>" placeholder="nom de l'editeur">
    </fieldset>
  </div>

  <div class="form-group">
    <label for="exampleTextarea" class="form-label mt-4">descriptif</label>
    <textarea class="form-control" name='description' id="exampleTextarea" rows="3"> <?= $jeux['description'] ??  ''  ?></textarea>
  </div>



  <div class="form-group">
    <label class="col-form-label mt-4" for="inputDefault">date de sortie</label>
    <input type="date" name="date" class="form-control" value="<?= $jeux['date'] ??  ''  ?>" placeholder="saisir date de sortie" id="inputDefault">
  </div>





  <fieldset class="form-group">
    <div class="form-check">







      <div class=row>

        <div class="col-4">
          <div class="form-group">
            <label for="formFile" class="form-label mt-4">image du jeux</label>
            <input name='photo' onChange="loadFile(event)" class="form-control" type="file" id="formFile">
          </div>
        </div>
        <div class="col-4">

          <div class="form-group">
            <label for="formFile" class="form-label mt-4">2eme image du jeux</label>
            <input name='photo1' onChange="loadFile1(event)" class="form-control" type="file" id="formFile">
          </div>
        </div>

        <div class="col-4">
          <div class="form-group">
            <label for="formFile" class="form-label mt-4">3eme image du jeux</label>
            <input name='photo2' onChange="loadFile2(event)" class="form-control" type="file" id="formFile">
          </div>
        </div>

      </div>

      <div class=row>

        <div class="col-4">
          <?php
          if (isset($jeux['photo'])) {  // si nous sommes en train de modifier le produit, nous affichons la photo actuellement en BDD :
            echo '<div class="text-center"><p>Photo</p>';
            echo '<img src="' . $jeux['photo'] . '" style="width:300px">';
            echo '<input type="hidden" name="photo_actuelle"  value="' . $jeux['photo'] . '"></div>';
          }
          ?>
          <div class="text-center mt-2">
            <img id="image" style="width: 300px">
          </div>
        </div>
        <div class="col-4">

          <?php
          if (isset($jeux['photo1'])) {  // si nous sommes en train de modifier le produit, nous affichons la photo actuellement en BDD :
            echo '<div class="text-center"><p>photo1</p>';
            echo '<img src="' . $jeux['photo1'] . '" style="width:300px">';
            echo '<input type="hidden" name="photo_actuelle1"  value="' . $jeux['photo1'] . '"></div>';
          }
          ?>
          <div class="text-center">
            <img id="image1" style="width: 300px">

          </div>

        </div>

        <div class="col-4">

          <?php
          if (isset($jeux['photo2'])) {  // si nous sommes en train de modifier le produit, nous affichons la photo actuellement en BDD :
            echo '<div class="text-center"><p>Photo2</p>';
            echo '<img src="' . $jeux['photo2'] . '" style="width:300px">';
            echo '<input type="hidden" name="photo_actuelle2"  value="' . $jeux['photo2'] . '"></div>';
          }
          ?>
          <div class="text-center">
            <img id="image2" style="width: 300px">

          </div>
        </div>

      </div>





      <div class="form-group">
        <label for="exampleFormControlSelect2">plateforme</label>
        <select name="plateforme[]" multiple="multiple" class="form-control select2" id="exampleFormControlSelect2">
          <?php foreach ($consoles as $console) :  ?>
            <option value="<?= $console['id_console'] ?>" <?php  ?> class="select2"><?= $console['nom']  ?></option>
          <?php endforeach;   ?>
        </select>
      </div>


      <div class="form-group">
        <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">lien du jeux</label>
        <input class="form-control form-control-sm" value="<?= $jeux['lien_du_jeux'] ?? "" ?>" type="text" name="lien_du_jeux" placeholder="mettre le liens steam ou autre si possible" id="inputSmall">
      </div>


      <div class="form-group">
        <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">lien de video</label>
        <input class="form-control form-control-sm" type="text" value="<?= $jeux['video'] ?? "" ?>" name="video" placeholder="mettre le liens d'une video du jeux si possible" id="inputSmall">
      </div>
    </div>
    <button type="submit" class="btn btn-secondary bg-secondary hover:bg-secondary">envoyer</button>
</form>



</form>



<script>
  var loadFile = function(event) {

    var image = document.getElementById('image');

    image.src = URL.createObjectURL(event.target.files[0]);

  };
  var loadFile1 = function(event) {

    var image1 = document.getElementById('image1');

    image1.src = URL.createObjectURL(event.target.files[0]);

  };

  var loadFile2 = function(event) {

    var image2 = document.getElementById('image2');

    image2.src = URL.createObjectURL(event.target.files[0]);

  };
</script>

<?php include_once "inc/footer.php" ?>