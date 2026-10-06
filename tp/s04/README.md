# TP S4 : la Galerie v1 (jalon 1)

## Ce que vous devez avoir à la fin

```
galerie/
|-- index.php              la page : charge tout et affiche
|-- fonctions.php          formaterTaille, categorie, e, render (types + strict_types)
|-- donnees.php            la liste de 6 modèles minimum : return [ ... ];
|-- style.css
`-- templates/
    |-- header.php         <head>, menu, titre
    |-- carte.php          la carte d'un modèle
    `-- footer.php
```

## Étapes (4 checkpoints)

1. **Découper** la page de la S3 en `index.php`, `fonctions.php`, `donnees.php`, `templates/`. Un seul déplacement à la fois ; rechargez ; la page doit rester identique.
2. **Fonctions** typées : `formaterTaille(float $mo): string`, `categorie(int $polygones): string`, `e(string $texte): string`. `declare(strict_types=1);` en première ligne de `index.php` et `fonctions.php`.
3. **Gabarits** : `render($gabarit, $variables)` et les trois fichiers de `templates/`. Utilisez `e()` pour chaque texte affiché.
4. **L'épreuve de Nadia** : changez un lien du menu (un seul fichier modifié), ajoutez un modèle (une seule ligne ajoutée).

## Vérifier

```bash
php outils/verifier.php galerie s4
```

Il doit afficher **« RÉSULTAT : tout est en ordre »**.

## Rendre (avant la séance 5)

Compressez le dossier `galerie` en `nom-prenom-galerie-v1.zip` (minuscules, tirets, sans accent), avec votre `memento.md` (pages 1 à 4).

Barème indicatif : structure 25 %, fonctions et types 25 %, gabarits et échappement 25 %, qualité (nommage, indentation) 15 %, mémento 10 %.
