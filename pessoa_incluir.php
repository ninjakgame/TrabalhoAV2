<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastro</title>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>

        function salvarPessoa(){

            let vNome = document.getElementById("nome").value;
            let vCpf = document.getElementById("cpf").value;
            let vNascimento = document.getElementById("nascimento").value;
            let vTelefone = document.getElementById("telefone").value;

            if(
                vNome.trim() === "" ||
                vCpf.trim() === "" ||
                vNascimento.trim() === ""||
                vTelefone.trim() === ""
            ){
                alert("Preencha todos os campos!");
                return;
            }

            $.ajax({

                url: './acaoPessoa_incluir.php',

                type: 'POST',

                dataType: 'json',

                data: {
                    pNome: vNome,
                    pCpf: vCpf,
                    pNascimento: vNascimento,
                    pTelefone: vTelefone,
                },

                success: function(data){

                    if(data.status === "success"){

                        alert(data.message);

                        document.getElementById("formulario").reset();

                        window.location.href = "./pessoa_listar.php";

                    } else {

                        alert(data.message);

                    }

                },

                error: function(jqXHR, textStatus, errorThrown){

                    alert(
                        "Erro na requisição:\n\n" +
                        textStatus + "\n" +
                        errorThrown
                    );

                    console.log(jqXHR.responseText);

                }

            });

        }

        function voltarPagina(){

            window.location.href = "./pessoa_listar.php";

        }

    </script>

</head>

<body>

<div class="container">

    <div class="containerConteudo">

        <div class="conteudo">

            <form id="formulario" onsubmit="return false;">

                <p>CADASTRO PESSOAS</p>

                <input
                    type="text"
                    id="nome"
                    required
                    placeholder="Usuário"
                >

                <input
                    type="number"
                    id="cpf"
                    required
                    placeholder="Cpf"
                >

                <input
                    type="date"
                    id="nascimento"
                    required
                    placeholder="Nascimento"
                >

                <input 
                    type="number"
                    id="telefone"
                    required
                    placeholder="Telefone"    
                >

                <div class="bot">

                    <button
                        type="button"
                        onclick="salvarPessoa()"
                    >
                        Cadastrar
                    </button>

                    <button
                        type="button"
                        onclick="voltarPagina()"
                    >
                        Voltar
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>