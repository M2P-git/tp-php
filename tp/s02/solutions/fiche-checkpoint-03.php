<?php
$titre     = "La Casbah";
$format    = "glb";
$polygones = 42000;
$taille    = 3.2;
$auteur    = "Nadia";

// Textes pour l'affichage : $polygones et $taille restent des nombres
$polygonesTexte = number_format($polygones, 0, ',', ' ');
$tailleTexte    = number_format($taille, 1, ',', ' ');

$categorie = match (true) {
    $polygones < 50000  => "léger",
    $polygones < 200000 => "moyen",
    default             => "lourd",
};
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
      <p><?= $polygonesTexte ?> polygones, <?= $tailleTexte ?> Mo</p>
      <p>Par <?= $auteur ?> <span class="badge"><?= $categorie ?></span></p>
    </article>
  </div>
</body>
</html>
