<?php
declare(strict_types=1);

/**
 * Vérificateur de projet du cours PHP (ISMAGI, Licence M3D).
 *
 * Usage :  php outils/verifier.php <dossier> [profil]
 *   profil : noms (par défaut), s1, s1bis, s2, s3, s4
 *
 * Exemples :
 *   php outils/verifier.php s01-premiers-pas s1
 *   php outils/verifier.php s01bis-revision-web s1bis
 *   php outils/verifier.php galerie s4
 *
 * Il contrôle : les noms de fichiers et de dossiers, les fichiers attendus,
 * l'encodage (UTF-8 sans BOM) et la syntaxe PHP (php -l).
 * Code de sortie : 0 si tout est correct, 1 sinon.
 */

const IGNORES = ['.git', '.vscode', '.idea', 'vendor', 'node_modules'];
const EXCEPTIONS_NOMS = ['README.md', 'LICENSE', '.gitignore', '.gitkeep', '.htaccess'];

/** Fichiers attendus, et contrôles supplémentaires, selon le profil. */
const PROFILS = [
    'noms' => ['fichiers' => [], 'controles' => []],
    's1' => ['fichiers' => ['index.php'], 'controles' => []],
    's1bis' => ['fichiers' => ['carte.html', 'style.css', 'filtre.html'], 'controles' => []],
    's2' => ['fichiers' => ['fiche.php'], 'controles' => []],
    's3' => ['fichiers' => ['index.php', 'style.css'], 'controles' => ['echappement']],
    's4' => [
        'fichiers' => [
            'index.php', 'fonctions.php', 'donnees.php', 'style.css',
            'templates/header.php', 'templates/carte.php', 'templates/footer.php',
        ],
        'controles' => ['strict_types', 'fonctions', 'echappement'],
    ],
];

$ok = 0;
$ko = 0;

function bilan(bool $reussi, string $message, string $conseil = ''): void
{
    global $ok, $ko;
    if ($reussi) {
        $ok++;
        echo "  [ OK ] $message\n";
        return;
    }
    $ko++;
    echo "  [ XX ] $message\n";
    if ($conseil !== '') {
        echo "         -> $conseil\n";
    }
}

/** Tous les chemins du dossier, relatifs, sans les dossiers ignorés. */
function lister(string $racine, string $relatif = ''): array
{
    $chemins = [];
    $dossier = $relatif === '' ? $racine : $racine . '/' . $relatif;
    foreach (scandir($dossier) ?: [] as $nom) {
        if ($nom === '.' || $nom === '..' || in_array($nom, IGNORES, true)) {
            continue;
        }
        $chemin = $relatif === '' ? $nom : $relatif . '/' . $nom;
        $chemins[] = $chemin;
        if (is_dir($racine . '/' . $chemin)) {
            $chemins = array_merge($chemins, lister($racine, $chemin));
        }
    }
    return $chemins;
}

/** Retourne la liste des problèmes d'un nom (vide si le nom est correct). */
function problemesDeNom(string $nom, bool $estDossier): array
{
    if (in_array($nom, EXCEPTIONS_NOMS, true)) {
        return [];
    }
    $problemes = [];
    if (str_contains($nom, ' ')) {
        $problemes[] = 'contient un espace';
    }
    if (preg_match('/[^\x20-\x7E]/', $nom)) {
        $problemes[] = 'contient un accent ou un caractère non ASCII';
    }
    if ($nom !== strtolower($nom)) {
        $problemes[] = 'contient des majuscules';
    }
    if (preg_match('/[^a-zA-Z0-9._ -]/', $nom) && !preg_match('/[^\x20-\x7E]/', $nom)) {
        $problemes[] = 'contient un caractère spécial';
    }
    if ($estDossier && str_contains($nom, '.')) {
        $problemes[] = 'un dossier ne doit pas contenir de point';
    }
    if (!$estDossier && substr_count($nom, '.') > 1) {
        $problemes[] = 'plusieurs points : double extension (ex. .php.txt) ?';
    }
    if (!$estDossier && !str_contains($nom, '.')) {
        $problemes[] = 'pas d\'extension';
    }
    if (preg_match('/(copie|copy|final|nouveau|new|test\d|\(\d+\))/i', $nom)) {
        $problemes[] = 'un nom décrit un rôle, pas une version (final, copie, nouveau...)';
    }
    return $problemes;
}

// ------------------------------------------------------------------ main
$dossier = $argv[1] ?? null;
$profil = $argv[2] ?? 'noms';

if ($dossier === null || !is_dir($dossier) || !isset(PROFILS[$profil])) {
    fwrite(STDERR, "Usage : php outils/verifier.php <dossier> [noms|s1|s1bis|s2|s3|s4]\n");
    exit(2);
}
$dossier = rtrim(str_replace('\\', '/', $dossier), '/');
$chemins = lister($dossier);

echo "\nVérification de « $dossier » (profil : $profil)\n\n";

// 1. Noms
echo "1. Noms des fichiers et des dossiers\n";
$nomsOk = true;
foreach ($chemins as $chemin) {
    $nom = basename($chemin);
    $problemes = problemesDeNom($nom, is_dir($dossier . '/' . $chemin));
    if ($problemes !== []) {
        $nomsOk = false;
        bilan(false, $chemin . ' : ' . implode(' ; ', $problemes), 'renommez-le en minuscules, sans espace ni accent, avec des tirets');
    }
}
if ($nomsOk) {
    bilan(true, count($chemins) . ' éléments, tous bien nommés');
}

// 2. Fichiers attendus
$attendus = PROFILS[$profil]['fichiers'];
if ($attendus !== []) {
    echo "\n2. Fichiers attendus\n";
    foreach ($attendus as $fichier) {
        bilan(is_file($dossier . '/' . $fichier), $fichier, 'ce fichier manque, ou il est mal nommé ou mal placé');
    }
}

// 3. Encodage et syntaxe des fichiers PHP
echo "\n3. Encodage et syntaxe PHP\n";
$fichiersPhp = array_values(array_filter($chemins, fn ($c) => is_file($dossier . '/' . $c) && str_ends_with(strtolower($c), '.php')));
if ($fichiersPhp === []) {
    if (in_array($profil, ['noms', 's1bis'], true)) {
        bilan(true, 'aucun fichier PHP à vérifier dans ce profil');
    } else {
        bilan(false, 'aucun fichier .php trouvé', 'vérifiez le dossier donné et les extensions');
    }
}
foreach ($fichiersPhp as $chemin) {
    $complet = $dossier . '/' . $chemin;
    $contenu = (string) file_get_contents($complet);
    if (str_starts_with($contenu, "\xEF\xBB\xBF")) {
        bilan(false, "$chemin : BOM présent", 'enregistrez en « UTF-8 » (sans BOM) dans VS Code');
        continue;
    }
    if (!mb_check_encoding($contenu, 'UTF-8')) {
        bilan(false, "$chemin : le fichier n'est pas en UTF-8", 'enregistrez-le en UTF-8');
        continue;
    }
    $sortie = [];
    $code = 0;
    exec(escapeshellarg(PHP_BINARY) . ' -l ' . escapeshellarg($complet) . ' 2>&1', $sortie, $code);
    $messages = array_values(array_filter(array_map('trim', $sortie), fn ($l) => $l !== ''));
    bilan($code === 0, $code === 0 ? "$chemin : syntaxe correcte" : "$chemin : " . ($messages[0] ?? 'erreur de syntaxe'), 'lisez le message : type, fichier, ligne');
}

// 4. Contrôles de qualité (profils avancés)
$controles = PROFILS[$profil]['controles'];
if ($controles !== []) {
    echo "\n4. Qualité du code\n";
    $lire = fn (string $f): string => is_file($dossier . '/' . $f) ? (string) file_get_contents($dossier . '/' . $f) : '';

    if (in_array('strict_types', $controles, true)) {
        $concernes = ['index.php', 'fonctions.php'];
        $sans = array_filter($concernes, fn ($c) => is_file($dossier . '/' . $c) && !str_contains($lire($c), 'declare(strict_types=1)'));
        bilan($sans === [], $sans === [] ? 'declare(strict_types=1) dans index.php et fonctions.php' : 'strict_types absent de : ' . implode(', ', $sans), 'ajoutez declare(strict_types=1); juste après <?php');
    }
    if (in_array('fonctions', $controles, true)) {
        $n = preg_match_all('/function\s+\w+\s*\([^)]*\)\s*:\s*[\w?]+/', $lire('fonctions.php'));
        bilan($n >= 3, "fonctions.php : $n fonction(s) avec type de retour (3 minimum)", 'écrivez function nom(type $p): type { ... }');
    }
    if (in_array('echappement', $controles, true)) {
        $tout = implode("\n", array_map($lire, $fichiersPhp));
        bilan(str_contains($tout, 'htmlspecialchars') || str_contains($tout, 'e('), 'les données affichées sont échappées (htmlspecialchars ou e())', 'échappez chaque donnée de texte à l\'affichage');
    }
}

// Bilan
echo "\n";
if ($ko === 0) {
    echo "RÉSULTAT : tout est en ordre ($ok contrôles réussis). Vous pouvez rendre le travail.\n\n";
    exit(0);
}
echo "RÉSULTAT : $ko point(s) à corriger, $ok contrôle(s) réussi(s). Corrigez, puis relancez la commande.\n\n";
exit(1);
