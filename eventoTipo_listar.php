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

            const evento = document.querySelectorAll(
                'input[name="check_id"]:checked'
            );

            if(evento.length === 0){

                alert("Selecione um registro para editar");
                return;

            }

            if(evento.length > 1){

                alert("Selecione apenas um registro para editar");
                return;

            }

            const id = evento[0].value;

            window.location.href =
                "./eventoTipo_editar.php?evento_tipo_id=" + id;

        }

        async function excluir() {
            const evento = document.querySelectorAll('input[name="check_id"]:checked');
            
            if(evento.length === 0){
                alert("Selecione um registro para excluir.");
                return
            }

            if(evento.length > 1){
                alert("Selecione apenas um registro para excluir.");
                return;
            }

            const evento_tipo_id = evento[0].value;

            if(!confirm("Deseja realmente excluir este evento?")){
                return;
            }

            try{
                const dados = new FormData();

                dados.append("pEvento_tipo_id", evento_tipo_id);

                const resposta = await fetch("evento_excluir.php", {
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

                alert("Erro ao excluir evento!");
            }
        }
    </script>

</head>

<body>

<main id="principal">

    <div class="container">

        <h2>Evento - Listar</h2>

        <div>
          
          <button
              type="button"
              onclick="window.location.href='./paginaInicial.html'"
           >
            Voltar
          </button>

            <button
                type="button"
                onclick="window.location.href='./eventoTipo_incluir.php'"
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

                </tr>

            </thead>

            <tbody class="corpo">

                <?php

                    $sql = "
                        SELECT
                            evento_tipo_id,
                            nome
                        FROM tbEventoTipo
                        ORDER BY nome
                    ";

                    $result = $conexao->query($sql);

                    if($result->num_rows > 0){

                        while($row = $result->fetch_assoc()){

                            $evento_tipo_id =
                                htmlspecialchars(
                                    $row['evento_tipo_id']
                                );

                            $nome =
                                htmlspecialchars(
                                    $row['nome']
                                );

                            echo '<tr>';

                            echo '
                                <td>
                                    <input
                                        type="checkbox"
                                        name="check_id"
                                        value="'.$evento_tipo_id.'"
                                    >
                                </td>
                            ';

                            echo '<td>'.$evento_tipo_id.'</td>';

                            echo '<td>'.$nome.'</td>';

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
