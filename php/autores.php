<?php
include 'db.php';


function listarAutores($pdo) {
    $stmt = $pdo->query("SELECT * FROM autores");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function criarAutor($pdo, $nome, $nacionalidade, $ano_nascimento) {
    $stmt = $pdo->prepare("INSERT INTO autores (nome, nacionalidade, ano_nascimento) VALUES (?, ?, ?)");
    return $stmt->execute([$nome, $nacionalidade, $ano_nascimento]);
}

function atualizarAutor($pdo, $id_autor, $nome, $nacionalidade, $ano_nascimento) {
    $stmt = $pdo->prepare("UPDATE autores SET nome = ?, nacionalidade = ?, ano_nascimento = ? WHERE id_autor = ?");
    return $stmt->execute([$nome, $nacionalidade, $ano_nascimento, $id_autor]);
}


function excluirAutor($pdo, $id_autor) {
    $stmt = $pdo->prepare("DELETE FROM autores WHERE id_autor = ?");
    return $stmt->execute([$id_autor]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['criar'])) {
        criarAutor($pdo, $_POST['nome'], $_POST['nacionalidade'], $_POST['ano_nascimento']);
    } elseif (isset($_POST['atualizar'])) {
        atualizarAutor($pdo, $_POST['id_autor'], $_POST['nome'], $_POST['nacionalidade'], $_POST['ano_nascimento']);
    } elseif (isset($_POST['excluir'])) {
        excluirAutor($pdo, $_POST['id_autor']);
    }
}


$autores = listarAutores($pdo);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Autores</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Autores</h1>
        <form method="POST">
            <input type="hidden" name="id_autor" value="">
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="text" name="nacionalidade" placeholder="Nacionalidade" required>
            <input type="number" name="ano_nascimento" placeholder="Ano de Nascimento" required>
            <button type="submit" name="criar">Adicionar Autor</button>
        </form>

        <h2>Lista de Autores</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Nacionalidade</th>
                <th>Ano de Nascimento</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($autores as $autor): ?>
            <tr>
                <td><?php echo $autor['id_autor']; ?></td>
                <td><?php echo $autor['nome']; ?></td>
                <td><?php echo $autor['nacionalidade']; ?></td>
                <td><?php echo $autor['ano_nascimento']; ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id_autor" value="<?php echo $autor['id_autor']; ?>">
                        <button type="submit" name="excluir">Excluir</button>
                    </form>
                    <button onclick="editar(<?php echo $autor['id_autor']; ?>, '<?php echo $autor['nome']; ?>', '<?php echo $autor['nacionalidade']; ?>', <?php echo $autor['ano_nascimento']; ?>)">Editar</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <script>
            function editar(id, nome, nacionalidade, ano_nascimento) {
                document.querySelector('input[name="id_autor"]').value = id;
                document.querySelector('input[name="nome"]').value = nome;
                document.querySelector('input[name="nacionalidade"]').value = nacionalidade;
                document.querySelector('input[name="ano_nascimento"]').value = ano_nascimento;
            }
        </script>
    </div>
</body>
</html>
