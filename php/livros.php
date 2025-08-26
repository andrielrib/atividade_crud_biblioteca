<?php
include 'php/db.php';

function listarLivros($pdo) {
    $stmt = $pdo->query("SELECT * FROM livros");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function criarLivro($pdo, $titulo, $genero, $ano_publicacao, $id_autor) {
    $ano_atual = date("Y");
    
    if ($ano_publicacao <= 1500 || $ano_publicacao > $ano_atual) {
        return "O ano de publicação deve ser maior que 1500 e menor ou igual ao ano atual.";
    }

    $stmt = $pdo->prepare("INSERT INTO livros (titulo, genero, ano_publicacao, id_autor) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$titulo, $genero, $ano_publicacao, $id_autor]);
}


function atualizarLivro($pdo, $id_livro, $titulo, $genero, $ano_publicacao, $id_autor) {
    $ano_atual = date("Y");
    
    if ($ano_publicacao <= 1500 || $ano_publicacao > $ano_atual) {
        return "O ano de publicação deve ser maior que 1500 e menor ou igual ao ano atual.";
    }

    $stmt = $pdo->prepare("UPDATE livros SET titulo = ?, genero = ?, ano_publicacao = ?, id_autor = ? WHERE id_livro = ?");
    return $stmt->execute([$titulo, $genero, $ano_publicacao, $id_autor, $id_livro]);
}


function excluirLivro($pdo, $id_livro) {
    $stmt = $pdo->prepare("DELETE FROM livros WHERE id_livro = ?");
    return $stmt->execute([$id_livro]);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['criar'])) {
        criarLivro($pdo, $_POST['titulo'], $_POST['genero'], $_POST['ano_publicacao'], $_POST['id_autor']);
    } elseif (isset($_POST['atualizar'])) {
        atualizarLivro($pdo, $_POST['id_livro'], $_POST['titulo'], $_POST['genero'], $_POST['ano_publicacao'], $_POST['id_autor']);
    } elseif (isset($_POST['excluir'])) {
        excluirLivro($pdo, $_POST['id_livro']);
    }
}


$livros = listarLivros($pdo);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Livros</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Livros</h1>
        <form method="POST">
            <input type="hidden" name="id_livro" value="">
            <input type="text" name="titulo" placeholder="Título" required>
            <input type="text" name="genero" placeholder="Gênero" required>
            <input type="number" name="ano_publicacao" placeholder="Ano de Publicação" required>
            <input type="number" name="id_autor" placeholder="ID do Autor" required>
            <button type="submit" name="criar">Adicionar Livro</button>
        </form>

        <h2>Lista de Livros</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Gênero</th>
                <th>Ano de Publicação</th>
                <th>ID do Autor</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($livros as $livro): ?>
            <tr>
                <td><?php echo $livro['id_livro']; ?></td>
                <td><?php echo $livro['titulo']; ?></td>
                <td><?php echo $livro['genero']; ?></td>
                <td><?php echo $livro['ano_publicacao']; ?></td>
                <td><?php echo $livro['id_autor']; ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id_livro" value="<?php echo $livro['id_livro']; ?>">
                        <button type="submit" name="excluir">Excluir</button>
                    </form>
                    <button onclick="editar(<?php echo $livro['id_livro']; ?>, '<?php echo $livro['titulo']; ?>', '<?php echo $livro['genero']; ?>', <?php echo $livro['ano_publicacao']; ?>, <?php echo $livro['id_autor']; ?>)">Editar</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <script>
            function editar(id, titulo, genero, ano_publicacao, id_autor) {
                document.querySelector('input[name="id_livro"]').value = id;
                document.querySelector('input[name="titulo"]').value = titulo;
                document.querySelector('input[name="genero"]').value = genero;
                document.querySelector('input[name="ano_publicacao"]').value = ano_publicacao;
                document.querySelector('input[name="id_autor"]').value = id_autor;
            }
        </script>
    </div>
</body>
</html>
