<?php
require_once 'conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SALA+</title>

    <script>

        function editar(){

            const pessoa = document.querySelectorAll(
                'input[name="check_id"]:checked'
            );

            if(pessoa.length === 0){

                alert("Selecione um registro para editar");
                return;

            }

            if(pessoa.length > 1){

                alert("Selecione apenas um registro para editar");
                return;

            }

            const id = pessoa[0].value;

            window.location.href =
                "./pessoa_editar.php?pessoa_id=" + id;

        }

        async function excluir() {
            const pessoa = document.querySelectorAll('input[name="check_id"]:checked');
            
            if(pessoa.length === 0){
                alert("Selecione um registro para excluir.");
                return
            }

            if(pessoa.length > 1){
                alert("Selecione apenas um registro para excluir.");
                return;
            }

            const pessoa_id = usuarios[0].value;

            if(!confirm("Deseja realmente excluir este usuário?")){
                return;
            }

            try{
                const dados = new FormData();

                dados.append("pPessoa_id", pessoa_id);

                const resposta = await fetch("pessoa_excluir.php", {
                    method: "POST",

                    body: dados
                });

                const texto = await resposta.text();

                alert(texto);

                if(texto.includes("sucesso")){
                    location.reload();
                }
            }

            catch (erro){
                console.error(erro);

                alert("Erro ao excluir usuário!");
            }
        }
    </script>

</head>

<body>

<main id="principal">

    <div class="container">

        <h2>Pessoa - Listar</h2>

        <div>
          
          <button
              type="button"
              onclick="window.location.href='./paginaInicial.html'"
           >
            Voltar
          </button>

            <button
                type="button"
                onclick="window.location.href='./pessoa_incluir.php'"
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
                onclick="javascript:excluir();"
            >
                Excluir
            </button>

        </div>

        <br>

        <table class="tabela">

            <thead class="topo">

                <tr>

                    <th>
                        
                    </th>

                    <th>ID</th>

                    <th>Nome</th>

                    <th>Cpf</th>

                    <th>Nascimento</th>

                    <th>Telefone</th>

                </tr>

            </thead>

            <tbody class="corpo">

                <?php

                    $sql = "
                        SELECT
                            pessoa_id,
                            nome,
                            cpf,
                            nascimento,
                            telefone
                        FROM tbPessoas
                        ORDER BY nome
                    ";

                    $result = $conexao->query($sql);

                    if($result->num_rows > 0){

                        while($row = $result->fetch_assoc()){

                            $pessoa_id =
                                htmlspecialchars(
                                    $row['pessoa_id']
                                );

                            $nome =
                                htmlspecialchars(
                                    $row['nome']
                                );

                            $cpf =
                                htmlspecialchars(
                                    $row['cpf']
                                );

                            $nascimento =
                                htmlspecialchars(
                                    $row['nascimento']
                                );

                            $telefone =
                                htmlspecialchars(
                                    $row['telefone']
                                );

                            echo '<tr>';

                            echo '
                                <td>
                                    <input
                                        type="checkbox"
                                        name="check_id"
                                        value="'.$pessoa_id.'"
                                    >
                                </td>
                            ';

                            echo '<td>'.$pessoa_id.'</td>';

                            echo '<td>'.$nome.'</td>';

                            echo '<td>'.$cpf.'</td>';

                            echo '<td>'.$nascimento.'</td>';

                            echo '<td>'.$telefone.'</td>';

                            echo '</tr>';

                        }

                    } else {

                        echo '
                            <tr>
                                <td colspan="5">
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
