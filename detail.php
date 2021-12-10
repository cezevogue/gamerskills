<?php include 'inc/header.php';


$resultat = executeRequete("SELECT * FROM jeux WHERE id_jeux=:id", array(':id' => $_GET['id']));

$jeux = $resultat->fetch(PDO::FETCH_ASSOC);  // on "fetch" le produit sans boucle while car il y en a qu'un seul par identifiant. 
$requete = executeRequete("SELECT consoles.nom FROM jeux INNER JOIN console_jeux ON jeux.id_jeux = console_jeux.id_jeux INNER JOIN consoles ON consoles.id_console= console_jeux.id_console WHERE jeux.id_jeux=:id_jeux", array(':id_jeux' => $_GET['id']));
$consoles = $requete->fetchAll(PDO::FETCH_ASSOC);


$requ = executeRequete("SELECT * FROM notes WHERE id_jeux=:id_jeux", array(':id_jeux' => $_GET['id']));
$notes = $requ->fetchAll(PDO::FETCH_ASSOC);

//var_dump($consoles);

if (!empty($_POST)) :
  $req = executeRequete("INSERT INTO notes (note, commentaire, id_jeux) VALUES (:note, :commentaire, :id_jeux )", array(
    ':note' => $_POST['note'],
    ':commentaire' => $_POST['commentaire'],
    ':id_jeux' => $_POST['id_jeux']
  ));

  header("location:./detail.php?id=" . $_GET['id']);
  exit;
endif;

?>
<div>

  <a href="index.php"><button class="btn btn-primary">retour</button></a>

</div>

<div class="card mb-3 ml-40 mr-40 p-10">
  <h3 class="card-header text-[50px]"><?= $jeux['titre'] ?></h3>
  <div class="card-body">
  </div>

  <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
      <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="<?= $jeux['photo'] ?>" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block ">
          <h5></h5>
          <p></p>
        </div>
      </div>
      <div class="carousel-item ">
        <img src="<?= $jeux['photo1'] ?>" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h5></h5>
          <p></p>
        </div>
      </div>
      <div class="carousel-item ">
        <img src="<?= $jeux['photo2'] ?>" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h5></h5>
          <p></p>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-target="#carouselExampleCaptions" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-target="#carouselExampleCaptions" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </button>
  </div>
  </svg>
  <div class="card-body">
    <p class="card-text"><?= $jeux['description'] ?> </p>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item"> <?= $jeux['date'] ?> </li>
    <li class="list-group-item"> <?= $jeux['editeur'] ?> </li>
  </ul>
  <ul>
    <?php foreach ($consoles as $console) :  ?>
      <li><?= $console['nom'] ?></li>
    <?php endforeach; ?>
  </ul>
  <div class="card-body">
    <a href=<?= $jeux['lien_du_jeux'] ?> class="card-link">Lien du jeux</a>
  </div>






  <div>
    <form action="" method="POST">

      <div class="form-group">
        <label for="exampleFormControlSelect1">Note du jeux</label>
        <select name="note" class="form-control" id="exampleFormControlSelect1">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
        </select>
      </div>

      <div class="form-group">
        <label for="exampleFormControlTextarea1">Laisser un avis</label>
        <textarea name="commentaire" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
      </div>
      <input type="hidden" name="id_jeux" value="<?= $_GET['id'] ?>">
      <button class="btn text-white bg-secondary hover:bg-secondary" type="submit">Envoyer</button>
    </form>
  </div>

  <div class="row justify-content-around mt-10">
    <div class="col-md-6">
      <?php if (!empty($jeux['video'])) :  ?>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $jeux['video'] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      <?php endif;   ?>

    </div>
    <div class="col-md-5 p-5">
      <?php foreach ($notes as $note) :  ?>
        <div class="card pl-2">
          <p><?= $note['commentaire'] ?></p>
          <h4><?= $note['note'] ?> / 10</h4>
        </div>

      <?php endforeach; ?>

    </div>

  </div>
</div>

<?php include_once('inc/footer.php')    ?>