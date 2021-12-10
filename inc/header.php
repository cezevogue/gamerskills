<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.6.1/sketchy/bootstrap.min.css" integrity="sha512-ekVfi4ctYpVeTlxoAjQHeTnaqoJsZ5xLHhNJHYCYC63vFquzBQQVQzM5JCpqoCKKxIAkC6xGtZvcjKSN55Kq9w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Intro HTML</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-teal-700">
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="intro.php">Mon premier site</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link active" href="intro.php">Accueil

            </a>
          </li>
         
          <li class="nav-item">
            <a class="nav-link" href="formulaire.php">ajouter un jeux</a>
          </li>


        </ul>

      </div>
    </div>
  </nav>
  <div class="container">
    <?php include 'inc/init.php';  ?>