<?php

ob_start(); // Inicia o buffer de saída

// Only process POST requests.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form fields and remove whitespace.
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r","\n"),array(" "," "),$name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = trim($_POST["phone"]);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // Check that data was sent to the mailer.
    if ( empty($name) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Set a 400 (bad request) response code and exit.
        http_response_code(400);
        echo "Preencha o formulário corretamente e tente novamente.";
        exit;
    }

    // Verificar se o telefone não está vazio ou contém apenas espaços em branco.
    if (empty($phone)) {
        http_response_code(400);
        echo "O campo de telefone é obrigatório.";
        exit;
    }

    // Set the recipient email address.
    // FIXME: Update this to your desired email address.
    $recipient = "contato@henrichsconsultoria.com.br";

    // Set the email subject.
    $subject = "Nova solicitação de Consultoria: $name";

    // Build the email content.
    $email_content = "Nome: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Telefone: $phone\n";
    $email_content .= "Assunto: $subject\n\n";
    $email_content .= "Mensagem:\n$message\n";

    // Build the email headers.
    $email_headers = "Enviado por: $name <$email>";

    // Send the email.
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // Set a 200 (okay) response code.
        http_response_code(200);
        echo "Obrigado! Sua mensagem foi enviada.";
    } else {
        // Set a 500 (internal server error) response code.
        http_response_code(500);
        echo "Ops! Algo deu errado e não foi possível enviar sua mensagem.";
    }

} else {
    // Not a POST request, set a 403 (forbidden) response code.
    http_response_code(403);
    echo "Houve um problema com seu envio. Tente novamente.";
}

ob_end_flush(); // Envia o buffer de saída e limpa o buffer

?>
