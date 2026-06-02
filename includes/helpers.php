<?php

/**
 * Normalizează textul pentru potrivire cuvinte cheie (fără diacritice, lowercase).
 */
function normalize_text(string $text): string
{
    $text = mb_strtolower(trim($text), 'UTF-8');
    $diacritice = [
        'ă' => 'a', 'â' => 'a', 'î' => 'i', 'ș' => 's', 'ş' => 's',
        'ț' => 't', 'ţ' => 't', 'é' => 'e', 'è' => 'e',
    ];
    return strtr($text, $diacritice);
}

/**
 * Cuvinte cheie → categorie iconiță.
 * @return array<string, list<string>>
 */
function categorii_cuvinte_cheie(): array
{
    return [
        'electronice' => [
            'telefon', 'smartphone', 'laptop', 'notebook', 'calculator', 'pc',
            'tableta', 'tablet', 'casti', 'casca', 'monitor', 'televizor', 'tv',
            'consola', 'playstation', 'xbox', 'camera', 'aparat foto', 'usb',
            'incarcator', 'baterie', 'mouse', 'tastatura', 'router', 'wifi',
            'electronic', 'gadget', 'smartwatch', 'ceas inteligent',
        ],
        'alimente' => [
            'paine', 'lapte', 'iaurt', 'branza', 'cascaval', 'ou', 'oua',
            'carne', 'pui', 'porc', 'peste', 'sunca', 'salam', 'carnati',
            'fruct', 'mar', 'para', 'banana', 'portocala', 'leguma', 'rosie',
            'cartof', 'ceapa', 'salata', 'cafea', 'ceai', 'miere', 'gem',
            'zahar', 'faina', 'orez', 'paste', 'macaroane', 'suc', 'apa minerala',
            'bere', 'vin', 'whisky', 'vodka', 'ciocolata', 'biscuit', 'prajitura',
            'cereale', 'napolitana', 'chips', 'snack', 'aliment', 'mancare',
            'patiserie', 'croissant', 'inghetata',
        ],
        'imbracaminte' => [
            'tricou', 'bluza', 'camasa', 'pantaloni', 'jeans', 'rochie', 'fusta',
            'geaca', 'palton', 'hanorac', 'pulover', 'maieu', 'sosete', 'ciorapi',
            'pantofi', 'adidasi', 'ghete', 'sandale', 'papuci', 'caciula', 'sapca',
            'esarpa', 'manusi', 'centura', 'costum', 'sacou', 'imbracaminte',
            'haine', 'lenjerie', 'pijama',
        ],
        'casa' => [
            'scaun', 'masa', 'pat', 'saltea', 'perna', 'pilota', 'patura',
            'dulap', 'raft', 'birou', 'canapea', 'fotoliu', 'lampa', 'candelabru',
            'covor', 'perdea', 'fereastra', 'oglinda', 'vaza', 'ceas perete',
            'mobilier', 'bucatarie', 'aragaz', 'cuptor', 'frigider', 'masina spalat',
            'aspirator', 'fierbator', 'blender', 'tigaie', 'cratita', 'farfurie',
            'pahar', 'tacam', 'prosop',
        ],
        'sport' => [
            'sport', 'minge', 'fotbal', 'baschet', 'tenis', 'volei', 'racheta',
            'bicicleta', 'trotineta', 'role', 'skateboard', 'fitness', 'sala',
            'gantera', 'haltera', 'alergare', 'echipament sport', 'costum inot',
            'piscina', 'casca ski', 'schi', 'snowboard', 'yoga', 'covoras yoga',
        ],
        'carte' => [
            'carte', 'roman', 'poveste', 'manual', 'enciclopedie', 'dictionar',
            'revista', 'ziar', 'caiet', 'notebook', 'pix', 'stilou', 'creion',
            'radiere', 'markere', 'acuarela', 'pensula', 'rechizite', 'birou scoala',
            'ghiozdan', 'penar',
        ],
        'frumusete' => [
            'sampon', 'balsam', 'sapun', 'gel dus', 'crema', 'lotiune', 'serum',
            'parfum', 'deodorant', 'machiaj', 'ruj', 'fond de ten', 'rimel',
            'demachiant', 'aftershave', 'apa de parfum', 'cosmetice', 'ingrijire',
            'penseta', 'oglinda machiaj', 'perie par', 'uscator par',
        ],
        'auto' => [
            'auto', 'masina', 'anvelopa', 'roata', 'ulei motor', 'baterie auto',
            'parbriz', 'stergator', 'bec auto', 'antifurt', 'navigatie', 'gps auto',
            'scaun auto', 'motocicleta', 'scuter',
        ],
        'jucarii' => [
            'jucarie', 'papusa', 'masinuta', 'lego', 'puzzle', 'joc', 'board game',
            'plush', 'ursulet', 'minge plus', 'tricicleta copii', 'trotineta copii',
            'set constructii', 'figurina',
        ],
        'sanatate' => [
            'vitamina', 'supliment', 'medicament', 'sirop', 'plasture', 'bandaj',
            'termometru', 'tensiometru', 'masca', 'dezinfectant', 'paracetamol',
            'aspirina', 'prospect',
        ],
        'gradina' => [
            'gradina', 'planta', 'floare', 'ghiveci', 'pamant', 'ingrasamant',
            'seminte', 'coasa', 'lopata', 'furtun', 'stropitoare',
            'gard', 'iarba', 'gazon',
        ],
        'animale' => [
            'caine', 'pisica', 'hamster', 'pasare', 'peste acvariu', 'hrana caine',
            'hrana pisica', 'lesa', 'zgarda', 'cusca', 'litiera', 'jucarie animale',
            'veterinar',
        ],
    ];
}

/**
 * Detectează categoria produsului după nume.
 */
function categorie_produs(string $nume, int $id = 0): string
{
    $text = normalize_text($nume);

    foreach (categorii_cuvinte_cheie() as $categorie => $cuvinte) {
        foreach ($cuvinte as $cuvant) {
            $cuvant = normalize_text($cuvant);
            if ($cuvant !== '' && strpos($text, $cuvant) !== false) {
                return $categorie;
            }
        }
    }

    $variante = ['generic', 'generic-2', 'generic-3'];
    $index = abs(crc32($text !== '' ? $text : (string) $id)) % count($variante);

    return $variante[$index];
}

/**
 * Returnează iconița SVG sugestivă pe baza numelui produsului.
 */
function imagine_produs(string $nume, int $id = 0): string
{
    $categorie = categorie_produs($nume, $id);
    return "assets/images/cat-{$categorie}.svg";
}
