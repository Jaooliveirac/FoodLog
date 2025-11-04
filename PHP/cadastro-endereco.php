<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/cadastros.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>FoodLog Cadastro ONG's</title>


</head>

<body>

    <header>

        <div class="header-inner">
            <h1>FoodLog</h1>
            <nav>
                <ul>
                    <li><a href="home.html">Início</a></li>
                    <li><a href="sobre.html">Sobre</a></li>
                    <li><a href="estabelecimentos.html">Estabelecimentos</a></li>
                    <li><a href="ongs.html">ONGs</a></li>
                    <li><a href="login.html">Login</a></li>
                    <li><a href="escolha-cadastro.html">Cadastro</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <form action="../PHP/processa_endereco.php" method="POST">
            <input type="hidden" name="tipo" value="<?php echo htmlspecialchars($tipo); ?>">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <div class="container">
                <h2 style="color: orange">Cadastrar Endereço</h2>
                <p style="color: orange">Por favor, preencha as informações abaixo, baseadas no endereço da empresa:</p>
                <div class="input-box">
                    <input placeholder="CEP" type="text" name="cep" required>
                </div>
                <div class="input-box">
                    <input placeholder="Logradouro" type="text" name="logradouro" required>
                </div>
                <div class="input-box">
                    <input placeholder="Número" type="text" name="numero" required>
                </div>
                <div class="input-box">
                    <input placeholder="Bairro" type="text" name="bairro" required>
                </div>
                <div class="input-box">
                    <input placeholder="Cidade" type="text" name="cidade" required>
                </div>
                <div class="input-box">
                    <input placeholder="Estado" type="text" name="estado" required>
                </div>
                <button class="voltar" type="button" onclick="location.href='cadastro-ongs.html'">  Voltar </button>
                <button class="cadastro" type="submit"> Cadastrar </button>
            </div>

        </form>

    </main>

    <footer>
        <strong>&copy; FoodLog 2025. Todos os direitos reservados. </strong>
    </footer>

</body>



</html>