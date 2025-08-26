<?php
include 'db.php';

function listarLivros($pdo) {
    $stmt = $pdo->query("SELECT * FROM livros");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function criarLivro($pdo, $titulo, $genero, $ano_publicacao, $id_autor) {
    $stmt = $pdo->prepare("INSERT INTO livros (titulo, genero, ano_publicacao, id_autor) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$titulo, $genero, $ano_publicacao, $id_autor]);
}


function atualizarLivro($pdo, $id_livro, $titulo, $genero, $ano_publicacao, $id_autor) {
    $stmt = $pdo->prepare("UPDATE livros SET titulo = ?, genero = ?, ano_publicacao = ?, id_autor = ? WHERE id_livro = ?");
    return $stmt->execute([$titulo, $genero, $ano_publicacao, $id_autor, $id_livro]);
}


function excluirLivro($pdo, $id_livro) {
    $stmt = $pdo->prepare("DELETE FROM livros WHERE id_livro = ?");
    return $stmt->execute([$id_livro]);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
}
?>
