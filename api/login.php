<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

// 1. Recibir datos
$input = json_decode(file_get_contents("php://input"), true);
$usuarioRecibido = $input["username"] ?? "";
$passwordRecibido = $input["password"] ?? "";

// 2. Base de datos simulada
$usuarios = [
    ["username" => "admin", "password" => "1234"],
    ["username" => "user", "password" => "abcd"],
    ["username" => "laura", "password" => "design2024"],
    ["username" => "carlos", "password" => "devops99"],
    ["username" => "invitado", "password" => "guest"],
    ["username" => "ana", "password" => "frontend"], 
    ["username" => "roberto", "password" => "db_admin"],     
    ["username" => "sofia", "password" => "marketing"],  
    ["username" => "miguel", "password" => "seguridad"],   
    ["username" => "elena", "password" => "secret"]     
];

// 3. Validar credenciales
$usuarioEncontrado = null;
foreach ($usuarios as $user) {
    if ($user["username"] === $usuarioRecibido && $user["password"] === $passwordRecibido) {
        $usuarioEncontrado = $user;
        break;
    }
}

if (!$usuarioEncontrado) {
    http_response_code(401);
    echo json_encode(["error" => "Usuario o contraseña incorrectos"]);
    exit;
}

// 4. Generar Token JW
$header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
$headerB64 = rtrim(strtr(base64_encode($header), '+/', '-_'), '=');

$payload = json_encode([
    "sub" => $usuarioEncontrado["username"],
    "iat" => time(),
    "exp" => time() + 60 //1 minuto de validez
]);
$payloadB64 = rtrim(strtr(base64_encode($payload), '+/', '-_'), '=');

$secret = "MI_CLAVE_SECRETA_DEL_SERVIDOR";
$signature = hash_hmac('sha256', "$headerB64.$payloadB64", $secret, true);
$signatureB64 = rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');

$jwt = "$headerB64.$payloadB64.$signatureB64";

echo json_encode([
    "status" => "ok",
    "token" => $jwt
]);
?>