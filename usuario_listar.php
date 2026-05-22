<?php
require_once 'conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SALA+</title>
  
    <link rel="stylesheet" href="./css/usuarios.css">

    <link rel="stylesheet" href="./css/mobile5.css">

    <script>

        function editar(){

            const usuarios = document.querySelectorAll(
                'input[name="check_id"]:checked'
            );

            if(usuarios.length === 0){

                alert("Selecione um registro para editar");
                return;

            }

            if(usuarios.length > 1){

                alert("Selecione apenas um registro para editar");
                return;

            }

            const id = usuarios[0].value;

            window.location.href =
                "./usuario_editar.php?usuario_id=" + id;

        }

        function excluir(){

            const usuarios = document.querySelectorAll(
                'input[name="check_id"]:checked'
            );

            if(usuarios.length === 0){

                alert("Selecione um registro para excluir");
                return;

            }

            if(usuarios.length > 1){

                alert("Selecione apenas um registro para excluir");
                return;

            }

            const id = usuarios[0].value;

            let confirmar = confirm(
                "Deseja realmente excluir este usuário?"
            );

            if(confirmar){

                window.location.href =
                    "./usuario_excluir.php?usuario_id=" + id;

            }

        }

        function marcarTodos(){

            let checkTodos =
                document.getElementById("checkTodos");

            let checks =
                document.querySelectorAll(
                    'input[name="check_id"]'
                );

            checks.forEach(function(item){

                item.checked = checkTodos.checked;

            });

        }

    </script>

</head>

<body>

<main id="principal">

    <div class="container">

        <h2>Usuários - Listar</h2>

        <div>
          
          <button
              type="button"
              onclick="window.location.href='./paginaInicial.html'"
           >
            Voltar
          </button>

            <button
                type="button"
                onclick="window.location.href='./usuario_incluir.php'"
            >
                Incluir
            </button>

            <button
                type="button"
                onclick="editar()"
            >
                Editar
            </button>

            <button
                type="button"
                onclick="excluir()"
            >
                Excluir
            </button>

        </div>

        <br>

        <table class="tabela">

            <thead class="topo">

                <tr>

                    <th>

                        <input
                            type="checkbox"
                            id="checkTodos"
                            onclick="marcarTodos()"
                        >

                    </th>

                    <th>ID</th>

                    <th>Nome</th>

                    <th>Login</th>

                </tr>

            </thead>

            <tbody class="corpo">

                <?php

                    $sql = "
                        SELECT
                            usuario_id,
                            nome,
                            login
                        FROM tbUsuarios
                        ORDER BY nome
                    ";

                    $result = $conexao->query($sql);

                    if($result->num_rows > 0){

                        while($row = $result->fetch_assoc()){

                            $usuario_id =
                                htmlspecialchars(
                                    $row['usuario_id']
                                );

                            $nome =
                                htmlspecialchars(
                                    $row['nome']
                                );

                            $login =
                                htmlspecialchars(
                                    $row['login']
                                );

                            echo '<tr>';

                            echo '
                                <td>
                                    <input
                                        type="checkbox"
                                        name="check_id"
                                        value="'.$usuario_id.'"
                                    >
                                </td>
                            ';

                            echo '<td>'.$usuario_id.'</td>';

                            echo '<td>'.$nome.'</td>';

                            echo '
                                <td>
                                    <a href="
                                        ./usuario_editar.php?usuario_id='.$usuario_id.'
                                    ">
                                        '.$login.'
                                    </a>
                                </td>
                            ';

                            echo '</tr>';

                        }

                    } else {

                        echo '
                            <tr>
                                <td colspan="4">
                                    Nenhum registro encontrado
                                </td>
                            </tr>
                        ';

                    }

                ?>

            </tbody>

        </table>

    </div>

</main>

</body>
</html>