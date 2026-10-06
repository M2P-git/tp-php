# Dépôt des TP : PHP et CakePHP (ISMAGI, Licence M3D)

Ce dossier contient les consignes de TP et un outil de vérification. **Votre travail ne se range pas ici** : il va dans *votre* dossier `php-m3d`, créé selon les règles ci-dessous.

## 0. Ce qu'il faut installer (et rien d'autre)

| Élément | Comment |
| --- | --- |
| **PHP 8.2 ou plus** (8.5 conseillée) | Windows : `winget install -e --id PHP.PHP.NTS.8.5` (puis rouvrir le terminal) · macOS : `brew install php` · Linux : `sudo apt install php-cli` |
| **Visual Studio Code** | éditeur gratuit ; extensions facultatives : *PHP Intelephense*, *Peacock* |
| **Un navigateur** | Firefox, Chrome ou Edge (outils de développement : `F12`) |

Vérification : `php -v` doit afficher `PHP 8.` suivi d'un numéro mineur de 2 ou plus.

**Pas de WAMP, de XAMPP ni de Docker au départ** : le serveur de développement de PHP (`php -S localhost:8000`) suffit pour les séances 1 à 5. Un pack ou Docker sera proposé à la séance 6 pour la base de données. Une extension de VS Code ne doit jamais être indispensable : `php fichier.php` doit toujours fonctionner.

## 1. Les règles de nommage (à respecter partout)

| Règle | Bon | Mauvais |
| --- | --- | --- |
| Uniquement des **minuscules** | `galerie-3d.php` | `Galerie3D.php` |
| **Aucun espace** (utilisez le tiret `-`) | `fiche-modele.php` | `fiche modele.php` |
| **Aucun accent** ni caractère spécial (`& ( ) ' ? #`) | `photo-ete.jpg` | `photo été (2).jpg` |
| Les chiffres de numérotation sur **deux chiffres** | `exercice-01.php`, `s01-premiers-pas` | `exercice1.php` |
| **Une seule extension**, visible | `index.php` | `index.php.txt`, `index.PHP` |
| Un nom **décrit le rôle**, pas la version | `fonctions.php` | `final.php`, `copie.php`, `test2.php`, `nouveau.php` |
| Le point d'entrée d'un site s'appelle toujours | `index.php` | `accueil-final.php` |

**Pourquoi ?** Un espace devient `%20` dans une adresse web ; Linux (là où tournent presque tous les serveurs) distingue `A` de `a` alors que Windows non ; les accents sont codés différemment d'un système à l'autre ; un fichier `index.php.txt` n'est pas exécuté par PHP. Un nom propre évite des heures de recherche d'un bug qui n'en est pas un.

**Où travailler ?** Dans `C:\dev\php-m3d` (Windows) ou `~/dev/php-m3d` (macOS, Linux). Jamais sur le Bureau, jamais dans Téléchargements, jamais dans un chemin qui contient un espace ou un accent (par exemple `C:\Users\Jean Dupont\...`).

**Sous Windows, affichez les extensions** : Explorateur de fichiers, onglet *Affichage*, *Afficher*, *Extensions de noms de fichiers*. Sans cela, `index.php.txt` s'affiche `index.php` et vous perdez du temps.

**Encodage** : tous vos fichiers sont enregistrés en **UTF-8** (affiché en bas à droite de VS Code), sans BOM.

## 2. L'arborescence du cours

```
php-m3d/
|-- s01-premiers-pas/      exercices de la séance 1
|   `-- index.php
|-- s01bis-revision-web/   exercices de la séance 1bis
|   |-- carte.html
|   |-- style.css
|   `-- filtre.html
|-- s02-variables/         exercices de la séance 2
|   `-- fiche.php
|-- s03-tableaux/          exercices de la séance 3
|-- galerie/               LE projet fil rouge (de S3 à S12)
|   |-- index.php
|   `-- style.css
|-- outils/
|   `-- verifier.php       copié depuis ce dépôt
`-- memento.md             votre mémento
```

À la séance 4, `galerie/` devient :

```
galerie/
|-- index.php              la page (contrôleur)
|-- fonctions.php          formaterTaille, categorie, e, render
|-- donnees.php            la liste des modèles : return [ ... ];
|-- style.css
`-- templates/             les gabarits (vues)
    |-- header.php
    |-- carte.php
    `-- footer.php
```

## 3. Créer un dossier et un fichier

**Avec VS Code** : *Fichier > Ouvrir un dossier* et choisissez `php-m3d`. Dans le panneau *Explorateur*, cliquez sur l'icône *Nouveau dossier* ou *Nouveau fichier*, tapez le nom **avec son extension** (`index.php`), validez avec Entrée.

**Avec le terminal** (dans le dossier `php-m3d`) :

| Action | Windows (PowerShell) | macOS, Linux |
| --- | --- | --- |
| Créer un dossier | `mkdir s01-premiers-pas` | `mkdir s01-premiers-pas` |
| Entrer dans un dossier | `cd s01-premiers-pas` | `cd s01-premiers-pas` |
| Créer un fichier vide | `New-Item index.php` | `touch index.php` |
| Lister le contenu | `ls` | `ls` |
| Remonter d'un niveau | `cd ..` | `cd ..` |

## 4. Le vérificateur

Il contrôle les noms, les fichiers attendus, l'encodage et la syntaxe PHP, et vous dit quoi corriger.

```bash
php outils/verifier.php s01-premiers-pas s1
php outils/verifier.php galerie s4
```

Un travail rendu doit afficher **« RÉSULTAT : tout est en ordre »**. Les profils disponibles : `noms` (noms seulement), `s1`, `s1bis`, `s2`, `s3`, `s4`.

## 5. Rendre un travail

Compressez *votre dossier* (jamais le dossier parent) en `nom-prenom-galerie-v1.zip` (même règle : minuscules, tirets, pas d'accent). Exemple : `mbilong-paul-galerie-v1.zip`.

## 6. Consignes par séance

- [S1](tp/s01/README.md) : premier script PHP, la date du jour
- [S1bis](tp/s01bis/README.md) : la carte HTML, sa grille CSS et un bouton de filtre JavaScript
- [S2](tp/s02/README.md) : la fiche d'un modèle 3D
- [S3](tp/s03/README.md) : la galerie, une carte par modèle
- [S4](tp/s04/README.md) : la Galerie v1 (jalon 1)
