<?php
include 'php/db.php';


function listarLeitores($pdo) {
    $stmt = $pdo->query("SELECT * FROM leitores");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function criarLeitor($pdo, $nome, $email, $telefone) {
    $stmt = $pdo->prepare("INSERT INTO leitores (nome, email, telefone) VALUES (?, ?, ?)");
    return $stmt->execute([$nome, $email, $telefone]);
}


function atualizarLeitor($pdo, $id_leitor, $nome, $email, $telefone) {
    $stmt = $pdo->prepare("UPDATE leitores SET nome = ?, email = ?, telefone = ? WHERE id_leitor = ?");
    return $stmt->execute([$nome, $email, $telefone, $id_leitor]);
}


function excluirLeitor($pdo, $id_leitor) {
    $stmt = $pdo->prepare("DELETE FROM leitores WHERE id_leitor = ?");
    return $stmt->execute([$id_leitor]);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['criar'])) {
        criarLeitor($pdo, $_POST['nome'], $_POST['email'], $_POST['telefone']);
    } elseif (isset($_POST['atualizar'])) {
        atualizarLeitor($pdo, $_POST['id_leitor'], $_POST['nome'], $_POST['email'], $_POST['telefone']);
    } elseif (isset($_POST['excluir'])) {
        excluirLeitor($pdo, $_POST['id_leitor']);
    }
}


$leitores = listarLeitores($pdo);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Leitores</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Leitores</h1>
        <form method="POST">
            <input type="hidden" name="id_leitor" value="">
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="telefone" placeholder="Telefone" required>
            <button type="submit" name="criar">Adicionar Leitor</button>
        </form>

        <h2>Lista de Leitores</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($leitores as $leitor): ?>
            <tr>
                <td><?php echo $leitor['id_leitor']; ?></td>
                <td><?php echo $leitor['nome']; ?></td>
                <td><?php echo $leitor['email']; ?></td>
                <td><?php echo $leitor['telefone']; ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id_leitor" value="<?php echo $leitor['id_leitor']; ?>">
                        <button type="submit" name="excluir">Excluir</button>
                    </form>
                    <button onclick="editar(<?php echo $leitor['id_leitor']; ?>, '<?php echo $leitor['nome']; ?>', '<?php echo $leitor['email']; ?>', '<?php echo $leitor['telefone']; ?>')">Editar</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <script>
            function editar(id, nome, email, telefone) {
                document.querySelector('input[name="id_leitor"]').value = id;
                document.querySelector('input[name="nome"]').value = nome;
                document.querySelector('input[name="email"]').value = email;
                document.querySelector('input[name="telefone"]').value = telefone;
            }
        </script>
    </div>
</body>
</html>
