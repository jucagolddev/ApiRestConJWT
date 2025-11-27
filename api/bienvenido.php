<?php
header('Content-Type: application/json');

// Obtener cabeceras
$headers = getallheaders();
$authHeader = $headers["Authorization"] ?? $_SERVER["HTTP_AUTHORIZATION"] ?? null;

if (!$authHeader) {
    http_response_code(403);
    echo json_encode(["error" => "Token no proporcionado"]);
    exit;
}

// Limpiar token
$jwt = str_replace("Bearer ", "", $authHeader);
$partes = explode(".", $jwt);

if (count($partes) !== 3) {
    http_response_code(403);
    echo json_encode(["error" => "Token inválido"]);
    exit;
}

list($headerB64, $payloadB64, $signatureB64) = $partes;

// Validar Firma
$secret = "MI_CLAVE_SECRETA_DEL_SERVIDOR";
$firmaServidor = rtrim(strtr(base64_encode(
    hash_hmac('sha256', "$headerB64.$payloadB64", $secret, true)
), '+/', '-_'), '=');

if (!hash_equals($firmaServidor, $signatureB64)) {
    http_response_code(403);
    echo json_encode(["error" => "Acceso denegado: Firma falsa"]);
    exit;
}

// Validar Caducidad
$payload = json_decode(base64_decode(strtr($payloadB64, '-_', '+/')), true);
if ($payload["exp"] < time()) {
    http_response_code(403);
    echo json_encode(["error" => "Sesión expirada"]);
    exit;
}

// Respuesta OK
echo json_encode([
    "mensaje" => "Acceso autorizado correctamente",
    "usuario" => $payload["sub"],
    "hora" => date("H:i:s d/m/Y")
]);
?>