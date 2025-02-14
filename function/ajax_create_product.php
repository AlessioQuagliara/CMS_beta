<?php
header('Content-Type: application/json');

require_once '../config.php';
require_once '../models/prodotti_pubblicitari.php';

// Recupera i dati in input (assumiamo vengano inviati in formato JSON)
$input = json_decode(file_get_contents('php://input'), true);

// Imposta dei valori default se non vengono passati
$data = [
    'nome'                => isset($input['nome']) ? $input['nome'] : 'Nuovo prodotto',
    'slug'                => isset($input['slug']) ? $input['slug'] : 'nuovo-prodotto-' . time(),
    'description'         => isset($input['description']) ? $input['description'] : '',
    'mezzo_pubblicitario' => isset($input['mezzo_pubblicitario']) ? $input['mezzo_pubblicitario'] : 'Digital',
    'dimensione'          => isset($input['dimensione']) ? $input['dimensione'] : 'Locale',
    'concessionaria'      => isset($input['concessionaria']) ? $input['concessionaria'] : 'Sipra',
    'genere'              => isset($input['genere']) ? $input['genere'] : 'Entrambi',
    'eta'                 => isset($input['eta']) ? $input['eta'] : 'Meno di 30 anni',
    'tipo_periodo'        => isset($input['tipo_periodo']) ? $input['tipo_periodo'] : 'giorno',
    'valore_periodo'      => isset($input['valore_periodo']) ? $input['valore_periodo'] : date('Y-m-d'),
    'slot'                => isset($input['slot']) ? $input['slot'] : null,
    'posizionamento'      => isset($input['posizionamento']) ? $input['posizionamento'] : null,
    'spot'                => isset($input['spot']) ? $input['spot'] : null,
];

$model = new ProdottiPubblicitariModel($pdo);

// Crea il prodotto nel database
$success = $model->createProduct($data);

if ($success) {
    echo json_encode(['success' => true, 'message' => 'Prodotto creato con successo.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Errore durante la creazione del prodotto.']);
}