# TP S1 : premier script PHP

## Ce que vous devez avoir à la fin

```
php-m3d/
`-- s01-premiers-pas/
    `-- index.php        un script PHP : un titre et la date du jour
```

## Résultat attendu

Une page avec le titre « Bonjour depuis PHP » et, dessous, « Nous sommes le 03/10/2026. » (la date du jour). Rechargez le lendemain : la date change sans que vous ayez modifié le fichier.

## Étapes

1. **Créez** le dossier `php-m3d` à un endroit sans espace ni accent (`C:\dev\php-m3d`). Dedans, créez `s01-premiers-pas`.
2. **Ouvrez** `php-m3d` dans VS Code (*Fichier > Ouvrir un dossier*).
3. **Vérifiez PHP** dans le terminal : `php -v` doit afficher PHP 8.2 ou plus.
4. **Créez** `index.php` avec :
   ```php
   <?php
   echo "<h1>Bonjour depuis PHP</h1>";
   echo "<p>Nous sommes le " . date("d/m/Y") . ".</p>";
   ```
5. **Lancez** le serveur *depuis le dossier `s01-premiers-pas`* : `php -S localhost:8000`, puis ouvrez <http://localhost:8000>.
6. **Modifiez**, rechargez, puis faites Ctrl+U : vous voyez le HTML, pas le PHP.
7. **Copiez** le dossier `outils/` fourni dans `php-m3d`.

## Vérifier

```bash
php outils/verifier.php s01-premiers-pas s1
```

## Pièges fréquents

- `index.php.txt` : extensions masquées sous Windows (voir le README du dépôt).
- Serveur lancé dans le mauvais dossier : la page affiche *404*.
- Fichier enregistré en autre chose que UTF-8 : les accents sont cassés.
- `php` introuvable : fermez et rouvrez le terminal après l'installation.
