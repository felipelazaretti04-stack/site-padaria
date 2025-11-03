<?php
// Simulação de cálculo de frete (integrar com API real como Melhor Envio)
header('Content-Type: application/json');

$cep = $_POST['cep'] ?? '';
$peso = $_POST['peso'] ?? 1; // kg

// Simulação: frete fixo baseado no CEP
$frete = 15.00; // R$ 15,00
if (substr($cep, 0, 2) == '90') { // Porto Alegre
    $frete = 10.00;
}

echo json_encode(['frete' => $frete]);
?>
