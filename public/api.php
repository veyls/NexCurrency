<?php
require_once __DIR__ . '/../vendor/autoload.php';
header('Content-Type: application/json');

use Nex\Converter;

$amount = $_GET['amount'] ?? 1;
$from = $_GET['from'] ?? 'USD';
$to = $_GET['to'] ?? 'TRY';

$result = Converter::convert($amount, $from, $to);
echo json_encode($result);