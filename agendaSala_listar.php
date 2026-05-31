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

            const agendamento = document.querySelectorAll(
                'input[name="check_id"]:checked'
            );

            if(agendamento.length === 0){

                alert("Selecione um registro para editar");
                return;

            }

            if(agendamento.length > 1){

                alert("Selecione apenas um registro para editar");
                return;

            }

            const id = agendamento[0].value;

            window.location.href =
                "./agendamento_editar.php?usuario_id=" + id;

        }

        async function excluir() {
            const agendamento = document.querySelectorAll('input[name="check_id"]:checked');
            
            if(agendamento.length === 0){
                alert("Selecione um registro para excluir.");
                return
            }

            if(agendamento.length > 1){
                alert("Selecione apenas um registro para excluir.");
                return;
            }

            const agenda_sala_id = agendamento[0].value;

            if(!confirm("Deseja realmente excluir este agendamento?")){
                return;
            }

            try{
                const dados = new FormData();

                dados.append("pAgenda_sala_id", agenda_sala_id);

                const resposta = await fetch("agendamento_excluir.php", {
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

                alert("Erro ao excluir agendamento!");
            }
        }
    </script>

</head>

<body>

<main id="principal">

    <div class="container">

        <h2>Agendamento - Listar</h2>

        <div>
          
          <button
              type="button"
              onclick="window.location.href='./paginaInicial.html'"
           >
            Voltar
          </button>

            <button
                type="button"
                onclick="window.location.href='./agendamento_incluir.php'"
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

                    <th>ID</th>

                    <th>Data e Hora Inicio</th>

                    <th>Data e Hora Fim</th>

                    <th>Sala</th>

                    <th>Pessoa</th>

                    <th>Evento Tipo</th>

                    <th>Observação</th>


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
