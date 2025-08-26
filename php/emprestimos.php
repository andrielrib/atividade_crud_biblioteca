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
    $stmt = $pdo->prepare("DELETE FROM emprestimos WHERE id autores)
    }
