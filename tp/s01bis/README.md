# TP S1bis : la carte d'un modèle 3D (HTML, CSS, JavaScript)

## Ce que vous devez avoir à la fin

```
php-m3d/
`-- s01bis-revision-web/
    |-- carte.html       la carte HTML d'un modèle
    |-- style.css        grille de cartes et apparence
    `-- filtre.html      quatre cartes + un bouton qui cache les modèles lourds
```

## Résultats attendus

- `carte.html` **sans CSS** : une image, un titre « La Casbah », un texte « 42 000 polygones, format GLB » et un lien « Voir le modèle », l'un sous l'autre.
- Avec `style.css` : une **grille** de cartes (autant de colonnes de 220 px que possible), coins arrondis, titre en couleur d'accent (variable CSS), ombre au survol.
- `filtre.html` : au clic sur « Montrer les modèles légers », les cartes de 50 000 polygones ou plus disparaissent.

## Étapes

1. Dans `php-m3d`, créez `s01bis-revision-web`.
2. **HTML** : `carte.html`, un `article` de classe `carte` avec `img` (et `alt`), `h2`, `p`, `a href="modele.php?id=1"`.
3. **CSS** : `style.css`, `.galerie { display: grid; ... }`, variable `--accent`, `:hover`. Reliez-le avec `<link rel="stylesheet" href="style.css">`.
4. **JavaScript** : `filtre.html`, quatre cartes avec `data-polygones="..."`, un bouton `#filtre`, un script qui met `hidden` selon `Number(c.dataset.polygones) >= 50000`.
5. **Table de Rosetta** : commencez-la dans `memento.md` (variable, condition, boucle, fonction, afficher ; JavaScript et PHP).

## Vérifier

```bash
php outils/verifier.php s01bis-revision-web s1bis
```

## Pour tester `fetch` (facultatif)

`fetch` refuse d'ouvrir un fichier local : lancez `php -S localhost:8000` dans le dossier et ouvrez la page par `http://localhost:8000/...`.
