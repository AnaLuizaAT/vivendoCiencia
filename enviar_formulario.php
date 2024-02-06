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

    // Crie uma instância do PHPMailer para enviar o e-mail de confirmação
    $confirmationMail = new PHPMailer\PHPMailer\PHPMailer();

    // Configurações do servidor SMTP para o e-mail de confirmação
    $confirmationMail->isSMTP();
    $confirmationMail->Host = 'smtp.gmail.com';
    $confirmationMail->SMTPAuth = true;
    // senha desse email ae: BATATADOCE@123
    // a autenticação de dois fatores ta no celular do chris <3 
    // Atenção, provavelmente você não precisará mexer nesse e-mail aqui em baixo
    $confirmationMail->Username = 'contato.vivendociencia2@gmail.com'; // Coloque o seu e-mail aqui
    $confirmationMail->Password = 'fgddjaorfyniwbmn'; // Coloque a sua senha aqui
    $confirmationMail->Port = 587;

    // Configurações do e-mail de confirmação
    $confirmationMail->setFrom('contato.vivendociencia2@gmail.com', 'VivendoCiencia');
    $confirmationMail->addAddress($email, $nome); // Envia a confirmação para o e-mail fornecido no formulário
    $confirmationMail->Subject = 'Confirmação de Recebimento de Compra';
    $confirmationMail->Body = "Olá " . $nome . ",\n\n";
    $confirmationMail->Body .= "Recebemos seu pedido de compra com sucesso!\n";
    $confirmationMail->Body .= "Detalhes do pedido:\n";
    $confirmationMail->Body .= "Atividades: " . $atividades . "\n";
    // Adicione mais informações conforme necessário

    // Verifique se o e-mail de confirmação foi enviado com sucesso
    if (!$confirmationMail->send()) {
        // Exiba uma mensagem de erro, se houver algum problema no envio do e-mail de confirmação
        echo "Erro ao enviar o e-mail de confirmação: " . $confirmationMail->ErrorInfo;
    }

    // Crie uma instância do PHPMailer para enviar o e-mail de pedido
    $orderMail = new PHPMailer\PHPMailer\PHPMailer();

    // Configurações do servidor SMTP para o e-mail de pedido
    $orderMail->isSMTP();
    $orderMail->Host = 'smtp.gmail.com';
    $orderMail->SMTPAuth = true;
    $orderMail->Username = 'contato.vivendociencia2@gmail.com';
    $orderMail->Password = 'fgddjaorfyniwbmn';
    $orderMail->Port = 587;

    // Configurações do e-mail de pedido
    $orderMail->setFrom('contato.vivendociencia2@gmail.com', 'VivendoCiencia');
    $orderMail->addAddress('profvivendo.ciencia@gmail.com', 'VivendoCiencia');
    $orderMail->Subject = 'Novo pedido de compra';
    $orderMail->Body = "Nome: " . $nome . "\n";
    $orderMail->Body .= "E-mail: " . $email . "\n";
    $orderMail->Body .= "Perfil do Instagram ou número do WhatsApp: " . $instagram . "\n";
    $orderMail->Body .= "Atividades:\n" . $atividades . "\n\n";
    $orderMail->Body .= "Comprovante de Pagamento em anexo: \n";

    // Anexar o comprovante como anexo
    $orderMail->addAttachment($comprovante_temp, $comprovante_nome);

    // Verifique se o e-mail de pedido foi enviado com sucesso
    if ($orderMail->send()) {
        // Redirecione para uma página de confirmação
        header("Location: confirmacao.html");
        exit;
    } else {
        // Exiba uma mensagem de erro, se houver algum problema no envio do e-mail de pedido
        echo "Erro ao enviar o email de pedido: " . $orderMail->ErrorInfo;
    }
}