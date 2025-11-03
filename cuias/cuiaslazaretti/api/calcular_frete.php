<?php
// Simulação de cálculo de frete (integrar com API real como Melhor Envio)
header('Content-Type: application/json');

$cep = $_GET['cep'] ?? '';

if (empty($cep)) {
    echo json_encode(['error' => 'CEP não informado']);
    exit;
}

// Simulação: frete fixo de R$ 15,00
$frete = 15.00;

echo json_encode(['frete' => $frete]);
?>
