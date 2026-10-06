# TP S2 : la fiche d'un modèle 3D

## Ce que vous devez avoir à la fin

```
php-m3d/
`-- s02-variables/
    |-- fiche.php        la fiche d'un modèle, remplie par PHP
    `-- style.css        (recopié de la S1)
```

## Étapes (4 checkpoints)

1. **Variables** : `$titre`, `$format`, `$polygones`, `$taille`, `$auteur`, affichées dans la carte de la S1 avec `<?= $variable ?>`.
2. **Formats** : `42 000 polygones`, `3,2 Mo` avec `number_format`.
3. **Catégorie** avec `match (true)` : léger (moins de 50 000), moyen (moins de 200 000), lourd.
4. **Alerte** si le format n'est pas `glb`, et `Auteur inconnu` si `$auteur` vaut `null` (opérateur `??`).

## Vérifier

```bash
php outils/verifier.php s02-variables s2
```

## Pour aller plus loin

Créez deux autres fiches (`fiche-lourd.php`, `fiche-sans-auteur.php`) en ne changeant que les valeurs des variables.
