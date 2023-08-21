<?php
// Inclua os arquivos necessários do PHPMailer
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

// Verifique se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupere os dados do formulário
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $atividades = $_POST["atividades"];
    $instagram = $_POST["instagram"];
    $comprovante_nome = $_FILES["comprovante"]["name"];
    $comprovante_temp = $_FILES["comprovante"]["tmp_name"];

    // Crie uma instância do PHPMailer
    $mail = new PHPMailer\PHPMailer\PHPMailer();

    // Configurações do servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    // senha desse email ae: BATATADOCE@123
    // a autenticação de dois fatores ta no celular do chris <3 
    // Atenção, provavelmente você não precisará mexer nesse e-mail aqui em baixo
    $mail->Username = 'contato.vivendociencia2@gmail.com';
    $mail->Password = 'fgddjaorfyniwbmn';
    $mail->Port = 587;

    // Configurações do email
    $mail->setFrom('contato.vivendociencia2@gmail.com', 'VivendoCiencia');
    $mail->addAddress('profvivendo.ciencia@gmail.com', 'VivendoCiencia');
    $mail->Subject = 'Novo pedido de compra';
    $mail->Body = "Nome: " . $nome . "\n";
    $mail->Body .= "E-mail: " . $email . "\n";
    $mail->Body .= "Perfil do Instagram ou número do WhatsApp: " . $instagram . "\n";
    $mail->Body .= "Atividades:\n" . $atividades . "\n\n";
    $mail->Body .= "Comprovante de Pagamento em anexo: \n";

    // Anexar o comprovante como anexo
    $mail->addAttachment($comprovante_temp, $comprovante_nome);

    // Verifique se o email foi enviado com sucesso
    if ($mail->send()) {
        // Redirecione para uma página de confirmação
        header("Location: confirmacao.html");
        exit;
    } else {
        // Exiba uma mensagem de erro, se houver algum problema no envio do email
        echo "Erro ao enviar o email: " . $mail->ErrorInfo;
    }
}