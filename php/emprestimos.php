<?php
include 'db.php';


function listarEmprestimos($pdo) {
    $stmt = $pdo->query("SELECT e.*, l.titulo, r.nome AS leitor_nome FROM emprestimos e
                          JOIN livros l ON e.id_livro = l.id_livro
                          JOIN leitores r ON e.id_leitor = r.id_leitor");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function criarEmprestimo($pdo, $id_livro, $id_leitor, $data_emprestimo, $data_devolucao) {
    $stmt = $pdo->prepare("INSERT INTO emprestimos (id_livro, id_leitor, data_emprestimo, data_devolucao) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$id_livro, $id_leitor, $data_emprestimo, $data_devolucao]);
}

function atualizarEmprestimo($pdo, $id_emprestimo, $id_livro, $id_leitor, $data_emprestimo, $data_devolucao) {
    $stmt = $pdo->prepare("UPDATE emprestimos SET id_livro = ?, id_leitor = ?, data_emprestimo = ?, data_devolucao = ? WHERE id_emprestimo = ?");
    return $stmt->execute([$id_livro, $id_leitor, $data_emprestimo, $data_devolucao, $id_emprestimo]);
}


function excluirEmprestimo($pdo, $id_emprestimo) {
    $stmt = $pdo->prepare("DELETE FROM emprestimos WHERE id_emprestimo = ?");
    return $stmt->execute([$id_emprestimo]);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['criar'])) {
        criarEmprestimo($pdo, $_POST['id_livro'], $_POST['id_leitor'], $_POST['data_emprestimo'], $_POST['data_devolucao']);
    } elseif (isset($_POST['atualizar'])) {
        atualizarEmprestimo($pdo, $_POST['id_emprestimo'], $_POST['id_livro'], $_POST['id_leitor'], $_POST['data_emprestimo'], $_POST['data_devolucao']);
    } elseif (isset($_POST['excluir'])) {
        excluirEmprestimo($pdo, $_POST['id_emprestimo']);
    }
}


$emprestimos = listarEmprestimos($pdo);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Empréstimos</title>
</head>
<body>
    <h1>Empréstimos</h1>
    <form method="POST">
        <input type="hidden" name="id_emprestimo" value="">
        <input type="number" name="id_livro" placeholder="ID do Livro" required>
        <input type="number" name="id_leitor" placeholder="ID do Leitor" required>
        <input type="date" name="data_emprestimo" placeholder="Data de Empréstimo" required>
        <input type="date" name="data_devolucao" placeholder="Data de Devolução">
        <button type="submit" name="criar">Adicionar Empréstimo</button>
    </form>

    <h2>Lista de Empréstimos</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>ID do Livro</th>
           