# TP S2 : la fiche d'un modèle 3D

Vous allez transformer une carte **écrite à la main** en une carte **calculée par PHP**, en quatre checkpoints (35 minutes en séance). Après chaque checkpoint, ouvrez sa solution (cliquez sur « Solution du checkpoint ») et comparez-la à votre code avant de passer au suivant.

## Ce que vous devez avoir à la fin

```
php-m3d/
`-- s02-variables/
    |-- fiche.php        la fiche d'un modèle, remplie par PHP
    `-- style.css        celui de la S1bis, plus .badge et .alerte
```

## Ce que contient ce dossier

| Chemin | Contenu |
| --- | --- |
| `depart/fiche.php` | le point de départ : la carte, avec des valeurs écrites à la main |
| `depart/style.css` | la feuille de style de la S1bis, plus `.badge` (checkpoint 3) et `.alerte` (checkpoint 4) |
| `solutions/fiche-checkpoint-01.php` à `fiche-checkpoint-04.php` | le fichier complet à la fin de chaque checkpoint |
| `solutions/style.css` | la même feuille de style, pour lancer les solutions |

Pour voir une solution dans le navigateur : `php -S localhost:8000` dans `solutions`, puis `http://localhost:8000/fiche-checkpoint-02.php` (par exemple).

## Point de départ (2 h 15)

1. Dans `php-m3d`, créez le dossier `s02-variables`.
2. Copiez-y `depart/fiche.php` et `depart/style.css`.
3. Dans `s02-variables`, lancez `php -S localhost:8000`, puis ouvrez `http://localhost:8000/fiche.php`.

Vous voyez une carte « La Casbah, 42000 polygones, 3.2 Mo, Par Nadia ». Chaque valeur est écrite à la main : votre mission est de les faire écrire par PHP.

## Checkpoint 1 : les variables (2 h 15 à 2 h 23)

**À faire**

1. À la place du commentaire `// Checkpoint 1 : vos cinq variables ici.`, déclarez cinq variables : `$titre` (`"La Casbah"`), `$format` (`"glb"`), `$polygones` (`42000`), `$taille` (`3.2`) et `$auteur` (`"Nadia"`).
2. Dans le HTML, remplacez chaque valeur écrite à la main par `<?= $titre ?>` et ses semblables, `<title>` compris.
3. `$format` n'est pas encore affiché : il servira au checkpoint 4.

**Ce que vous devez observer** : la page n'a pas changé, et Ctrl+U montre le même HTML qu'au départ.

**Si ça ne marche pas** : une page blanche ou une erreur ? Lisez le message (type, fichier, ligne). Il manque souvent un `;`, ou un nom de variable est mal écrit (`Warning: Undefined variable $tittre`). Des accents cassés ? Le fichier n'est pas en UTF-8, ou `<meta charset="utf-8">` manque.

<details>
<summary><b>Solution du checkpoint 1</b> (fichier complet : <code>solutions/fiche-checkpoint-01.php</code>)</summary>

```php
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
```

Ce que le navigateur reçoit (Ctrl+U), pour la carte :

```html
<article class="carte">
  <h2>La Casbah</h2>
  <p>42000 polygones, 3.2 Mo</p>
  <p>Par Nadia</p>
</article>
```

Le HTML reçu est identique au point de départ : c'est voulu, PHP remplit maintenant les trous. `42000` et `3.2` sont écrits comme l'ordinateur les range ; le checkpoint 2 les écrit à la française.

</details>

## Checkpoint 2 : formater les nombres (2 h 23 à 2 h 31)

**À faire**

1. Sous les variables, préparez deux **textes** : `$polygonesTexte` et `$tailleTexte`, avec `number_format`.
2. Dans la carte, affichez-les à la place de `$polygones` et `$taille`.
3. Essayez `$taille = 64.0;` : vous devez lire `64,0 Mo`, et non `64 Mo`.

**Aide** : `number_format($polygones, 0, ',', ' ')` donne `42 000` ; `number_format($taille, 1, ',', ' ')` donne `3,2`. Les arguments : la valeur, le nombre de décimales, le séparateur décimal, celui des milliers.

**Le réflexe** : on garde la valeur brute dans sa variable (un nombre), et on range le texte formaté dans une **autre** variable, qui ne sert qu'à l'affichage.

**Ce que vous devez observer** : `42 000 polygones, 3,2 Mo`.

<details>
<summary><b>Solution du checkpoint 2</b> (fichier complet : <code>solutions/fiche-checkpoint-02.php</code>)</summary>

Sous les variables :

```php
// Textes pour l'affichage : $polygones et $taille restent des nombres
$polygonesTexte = number_format($polygones, 0, ',', ' ');
$tailleTexte    = number_format($taille, 1, ',', ' ');
```

Dans la carte :

```php
<p><?= $polygonesTexte ?> polygones, <?= $tailleTexte ?> Mo</p>
```

| `$polygones` | `$taille` | La carte affiche |
| ---: | ---: | --- |
| `42000` | `3.2` | `42 000 polygones, 3,2 Mo` |
| `520000` | `64.0` | `520 000 polygones, 64,0 Mo` |
| `8000` | `0.9` | `8 000 polygones, 0,9 Mo` |

**Piège** : écrire `$polygones = number_format($polygones, 0, ',', ' ');` fait de `$polygones` le **texte** `"8 000"`. Au checkpoint 3, PHP comparerait alors des textes : 8 000 polygones deviendrait « lourd », et 150 000 « léger ».

</details>

## Checkpoint 3 : la catégorie (2 h 31 à 2 h 40)

**À faire**

1. Sous les textes, calculez `$categorie` : moins de 50 000 polygones, **léger** ; moins de 200 000, **moyen** ; au-delà, **lourd**.
2. Affichez-la dans un badge, après l'auteur : `<span class="badge">...</span>`.

**Questions** : quelle structure choisir, `if`, `match` ou `??` ? Justifiez en une phrase. Que se passe-t-il pour exactement `50000` ? Votre choix de `<` ou `<=` compte : décidez-le et notez-le.

**Ce que vous devez observer** : avec `8000`, `150000` et `520000`, le badge affiche léger, moyen, puis lourd.

<details>
<summary><b>Solution du checkpoint 3</b> (fichier complet : <code>solutions/fiche-checkpoint-03.php</code>)</summary>

Sous les textes :

```php
$categorie = match (true) {
    $polygones < 50000  => "léger",
    $polygones < 200000 => "moyen",
    default             => "lourd",
};
```

Dans la carte :

```php
<p>Par <?= $auteur ?> <span class="badge"><?= $categorie ?></span></p>
```

| `$polygones` | Catégorie |
| ---: | --- |
| `8000` | léger |
| `50000` | moyen (`50000 < 50000` est faux) |
| `150000` | moyen |
| `520000` | lourd |

- `match` **choisit une valeur** parmi plusieurs cas. `??` ne traite que `null` ; un `if` marcherait, mais répéterait `$categorie =` trois fois.
- L'**ordre** des cas compte : PHP garde le premier cas vrai. Avec `< 200000` en premier, 8 000 deviendrait « moyen ».
- Sans `default`, 520 000 ne correspond à aucun cas : erreur `UnhandledMatchError`.

</details>

## Checkpoint 4 : alerte de format et auteur absent (2 h 40 à 2 h 50)

**À faire**

1. Si le format n'est pas `glb`, affichez dans la carte l'alerte « Format OBJ : préférez le GLB pour le web. » (classe `alerte`).
2. Mettez `$auteur = null;` puis affichez « Auteur inconnu » à la place. Quel opérateur donne une valeur par défaut ?

**Aide** : pour afficher un bloc HTML seulement dans certains cas, utilisez `<?php if (...): ?> ... <?php endif; ?>`. `strtoupper("obj")` donne `OBJ`.

**Ce que vous devez observer** : en changeant `$format` en `"obj"`, puis en `"glb"`, l'alerte apparaît puis disparaît. Avec `$auteur = null;`, la carte affiche « Par Auteur inconnu ».

<details>
<summary><b>Solution du checkpoint 4</b> (fichier complet : <code>solutions/fiche-checkpoint-04.php</code>)</summary>

Les valeurs testées : `$format = "obj";` et `$auteur = null;`. Sous la catégorie :

```php
$auteurTexte = $auteur ?? "Auteur inconnu";
```

Dans la carte :

```php
<p>Par <?= $auteurTexte ?> <span class="badge"><?= $categorie ?></span></p>
<?php if ($format !== "glb"): ?>
  <p class="alerte">Format <?= strtoupper($format) ?> : préférez le GLB pour le web.</p>
<?php endif; ?>
```

Ce que le navigateur reçoit :

```html
<p>Par Auteur inconnu <span class="badge">léger</span></p>
<p class="alerte">Format OBJ : préférez le GLB pour le web.</p>
```

- Avec `"glb"`, la ligne d'alerte **disparaît** du HTML reçu : PHP ne l'envoie pas du tout.
- `??` ne réagit qu'à `null` : avec `$auteur = "";`, la fiche afficherait « Par », suivi de rien.

</details>

## Vérifier

Remplacez seulement les cinq valeurs du haut, rechargez, et comparez :

| `$titre` | `$format` | `$polygones` | `$taille` | `$auteur` | La carte affiche |
| --- | --- | ---: | ---: | --- | --- |
| `"La Casbah"` | `"glb"` | `42000` | `3.2` | `"Nadia"` | 42 000 polygones, 3,2 Mo ; Par Nadia ; **léger** |
| `"Astronaute"` | `"obj"` | `520000` | `64.0` | `"Nadia"` | 520 000 polygones, 64,0 Mo ; Par Nadia ; **lourd** ; alerte OBJ |
| `"La Lanterne"` | `"glb"` | `8000` | `0.9` | `null` | 8 000 polygones, 0,9 Mo ; Par Auteur inconnu ; **léger** |

Puis, depuis `php-m3d` :

```bash
php outils/verifier.php s02-variables s2
```

Le vérificateur doit afficher « RÉSULTAT : tout est en ordre ».

<details>
<summary><b>Solution complète du TP</b> (= <code>solutions/fiche-checkpoint-04.php</code>)</summary>

```php
<?php
// 1. Les données du modèle
$titre     = "La Casbah";
$format    = "obj";
$polygones = 42000;
$taille    = 3.2;
$auteur    = null;

// 2. Les calculs : $polygones et $taille restent des nombres
$polygonesTexte = number_format($polygones, 0, ',', ' ');
$tailleTexte    = number_format($taille, 1, ',', ' ');
$categorie = match (true) {
    $polygones < 50000  => "léger",
    $polygones < 200000 => "moyen",
    default             => "lourd",
};
$auteurTexte = $auteur ?? "Auteur inconnu";
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
      <p>Par <?= $auteurTexte ?> <span class="badge"><?= $categorie ?></span></p>
<?php if ($format !== "glb"): ?>
      <p class="alerte">Format <?= strtoupper($format) ?> : préférez le GLB pour le web.</p>
<?php endif; ?>
    </article>
  </div>
</body>
</html>
```

Le calcul est en haut, l'affichage en bas : on le systématisera à la séance 4 avec les gabarits. Gardez ce fichier : en S3, une boucle fabriquera 24 de ces cartes.

</details>

## Pour aller plus loin

1. Créez deux autres fiches, `fiche-lourd.php` (l'Astronaute) et `fiche-sans-auteur.php` (la Lanterne), en ne changeant que les valeurs des variables.
2. Donnez une couleur au badge selon la catégorie (vert pour léger, orange pour moyen, rouge pour lourd), comme sur le résultat attendu.

<details>
<summary><b>Solution de la question 2</b></summary>

Sous la catégorie, un second `match` choisit une classe CSS (sans accent) :

```php
$classeBadge = match ($categorie) {
    "léger" => "leger",
    "moyen" => "moyen",
    "lourd" => "lourd",
};
```

Dans la carte : `<span class="badge <?= $classeBadge ?>"><?= $categorie ?></span>`. Dans `style.css` :

```css
.badge.leger { background: #1a7f3c; }
.badge.moyen { background: #c26a00; }
.badge.lourd { background: #b3261e; }
```

Ici, pas de `default` : les trois catégories sont toutes prévues, et une catégorie inconnue doit provoquer une erreur plutôt qu'un badge sans couleur.

</details>
