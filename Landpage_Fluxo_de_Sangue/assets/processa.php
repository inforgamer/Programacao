<?php
function limpar($campo) {
    return htmlspecialchars(trim($campo));
}

function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validarData($data) {
    $hoje = new DateTime();
    $nascimento = DateTime::createFromFormat('Y-m-d', $data);
    return $nascimento && $nascimento <= $hoje;
}

function formatarData($data) {
    $nascimento = DateTime::createFromFormat('Y-m-d', $data);
    return $nascimento ? $nascimento->format('d/m/Y') : $data;
}

$campos = ['nome', 'endereco', 'data_nascimento', 'email', 'telefone', 'mensagem'];
$dados = [];
$erros = [];

foreach ($campos as $campo) {
    $dados[$campo] = isset($_POST[$campo]) ? limpar($_POST[$campo]) : '';
    
    // Verificar campos obrigatórios
    if (in_array($campo, ['nome', 'endereco', 'data_nascimento', 'email', 'telefone']) && $dados[$campo] === '') {
        $erros[] = "O campo '" . ucfirst(str_replace('_', ' ', $campo)) . "' é obrigatório.";
    }
}

// Validações específicas
if (!empty($dados['email']) && !validarEmail($dados['email'])) {
    $erros[] = "Por favor, insira um e-mail válido.";
}

if (!empty($dados['data_nascimento']) && !validarData($dados['data_nascimento'])) {
    $erros[] = "Por favor, insira uma data de nascimento válida.";
}

if (!empty($dados['nome']) && strlen($dados['nome']) < 2) {
    $erros[] = "O nome deve ter pelo menos 2 caracteres.";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Processamento - Fluxo de Sangue</title>
    <link rel="stylesheet" href="assets/css/estilo.css">
    <style>
        .dados { margin: 24px 0; }
        .erro { color: #ffb3b3; font-weight: bold; margin-bottom: 16px; }
        .sucesso { color: #b3ffb3; font-weight: bold; margin-bottom: 16px; }
        a { color: #fff; text-decoration: underline; }
        .container { max-width: 700px; }
    </style>
</head>
<body>
<div class="container">
    <img src="assets/img/capa%202.png" alt="Capa do livro Fluxo de Sangue" class="capa" style="max-width:180px;margin-bottom:18px;">
    <h2>Processamento do Formulário</h2>
    <?php if ($_SERVER['REQUEST_METHOD'] !== 'POST'): ?>
        <div class="erro">Acesso inválido. Por favor, envie o formulário pela página principal.<br><a href="index.html">Voltar</a></div>
    <?php elseif (count($erros) > 0): ?>
        <div class="erro">
            <?php foreach ($erros as $erro) echo $erro . '<br>'; ?>
            <a href="index.html">Voltar e corrigir</a>
        </div>
    <?php else: ?>
        <div class="sucesso">Dados recebidos e salvos no banco de dados (simulado).</div>
        <div class="dados">
            <strong>Nome:</strong> <?php echo $dados['nome']; ?><br>
            <strong>Endereço:</strong> <?php echo $dados['endereco']; ?><br>
            <strong>Data de Nascimento:</strong> <?php echo formatarData($dados['data_nascimento']); ?><br>
            <strong>E-mail:</strong> <?php echo $dados['email']; ?><br>
            <strong>Telefone:</strong> <?php echo $dados['telefone']; ?><br>
            <strong>Motivo do interesse:</strong> <?php echo $dados['mensagem'] ? $dados['mensagem'] : 'Não informado.'; ?><br>
        </div>
        <a href="index.html">Voltar para a página inicial</a>
    <?php endif; ?>
</div>
</body>
</html>
