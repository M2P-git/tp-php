<?php
$titre     = "La Casbah";
$format    = "glb";
$polygones = 42000;
$taille    = 3.2;
$auteur    = "Nadia";
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title><?= $titre ?></title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Fiche d'un modèle 3D</h1>
  <div class="galerie">
    <article class="carte">
      <h2><?= $titre ?></h2>
      <p><?= $polygones ?> polygones, <?= $taille ?> Mo</p>
      <p>Par <?= $auteur ?></p>
    </article>
  </div>
</body>
</html>
