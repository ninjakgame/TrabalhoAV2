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

            const sala = document.querySelectorAll(
                'input[name="check_id"]:checked'
            );

            if(sala.length === 0){

                alert("Selecione um registro para editar");
                return;

            }

            if(sala.length > 1){

                alert("Selecione apenas um registro para editar");
                return;

            }

            const id = sala[0].value;

            window.location.href =
                "./sala_editar.php?sala_id=" + id;

        }

        async function excluir() {
            const sala = document.querySelectorAll('input[name="check_id"]:checked');
            
            if(sala.length === 0){
                alert("Selecione um registro para excluir.");
                return
            }

            if(sala.length > 1){
                alert("Selecione apenas um registro para excluir.");
                return;
            }

            const sala_id = sala[0].value;

            if(!confirm("Deseja realmente excluir esta sala?")){
                return;
            }

            try{
                const dados = new FormData();

                dados.append("pSala_id", sala_id);

                const resposta = await fetch("sala_excluir.php", {
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

                alert("Erro ao excluir a sala!");
            }
        }
    </script>

</head>

<body>

<main id="principal">

    <div class="container">

        <h2>Sala - Listar</h2>

        <div>
          
          <button
              type="button"
              onclick="window.location.href='./paginaInicial.html'"
           >
            Voltar
          </button>

            <button
                type="button"
                onclick="window.location.href='./sala_incluir.php'"
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

                    <th>Numero</th>

                </tr>

            </thead>

            <tbody class="corpo">

                <?php

                    $sql = "
                        SELECT
                            sala_id,
                            numero
                        FROM tbSalas
                        ORDER BY numero
                    ";

                    $result = $conexao->query($sql);

                    if($result->num_rows > 0){

                        while($row = $result->fetch_assoc()){

                            $pessoa_id =
                                htmlspecialchars(
                                    $row['pessoa_id']
                                );

                            $numero =
                                htmlspecialchars(
                                    $row['numero']
                                );

                            echo '<tr>';

                            echo '
                                <td>
                                    <input
                                        type="checkbox"
                                        name="check_id"
                                        value="'.$sala_id.'"
                                    >
                                </td>
                            ';

                            echo '<td>'.$sala_id.'</td>';

                            echo '<td>'.$numero.'</td>';

                            echo '</tr>';

                        }

                    } else {

                        echo '
                            <tr>
                                <td colspan="2">
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
