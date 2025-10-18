<?php
// formmail.php - simples handler para envio de contato
header('Content-Type: application/json; charset=utf-8');

// Apenas POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["ok" => false, "message" => "Método não permitido"]);
    exit;
}

// Ler campos
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');
$honeypot = trim($_POST['website'] ?? ''); // campo escondido para bots

// Anti-spam: honeypot deve estar vazio
if ($honeypot !== '') {
    // resposta silenciosa para bots
    http_response_code(200);
    echo json_encode(["ok" => true]);
    exit;
}

// Validações básicas
if ($name === '' || $email === '') {
    http_response_code(400);
    echo json_encode(["ok" => false, "message" => "Por favor, preencha nome e email."]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(["ok" => false, "message" => "Email inválido."]);
    exit;
}

// Monta email
$to = 'comercial@nitroag.com.br';
$subject = 'Novo contato - Site Nitro: ' . substr($name, 0, 100);
$body = "Você recebeu uma nova mensagem de contato do site:\n\n";
$body .= "Nome: $name\n";
$body .= "Email: $email\n";
$body .= "Mensagem:\n$message\n";

$headers = [];
$headers[] = 'From: noreply@nitroag.com.br';
$headers[] = "Reply-To: $email";
$headers[] = 'Content-Type: text/plain; charset=utf-8';

$sent = false;

// Tenta enviar usando mail(). Em muitos hosts isso funciona; em ambientes locais pode não enviar.
try {
    $sent = mail($to, $subject, $body, implode("\r\n", $headers));
} catch (Exception $e) {
    $sent = false;
}

if ($sent) {
    echo json_encode(["ok" => true, "message" => "Mensagem enviada com sucesso. Entraremos em contato o quanto antes."]);
    exit;
}

// Se falhou, retorna 500
http_response_code(500);
echo json_encode(["ok" => false, "message" => "Falha ao enviar a mensagem. Tente novamente mais tarde."]);
exit;

?>
