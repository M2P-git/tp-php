# TP S3 : la galerie, une carte par modèle

C'est ici que naît le projet fil rouge : le dossier `galerie/`.

## Ce que vous devez avoir à la fin

```
php-m3d/
`-- galerie/
    |-- index.php        un tableau de 6 modèles et une boucle foreach
    `-- style.css        la grille et les cartes (S1)
```

## Étapes (4 checkpoints)

1. **Tableau** : `$modeles`, une liste de 6 fiches (`titre`, `format`, `polygones`, `taille`).
2. **Boucle** : un `foreach` qui produit une carte HTML par fiche, dans un `<div class="galerie">`.
3. **Badge** (`match`), **titre échappé** (`htmlspecialchars`), **alerte** de format.
4. **Tri** par polygones (`usort`) et résumé : « 6 modèles, X Mo au total ».

## Le test de Nadia

Ajoutez un **septième** modèle en changeant *uniquement* le tableau. Une carte de plus doit apparaître.

## Vérifier

```bash
php outils/verifier.php galerie s3
```
