<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/classes.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@1,700&family=Raleway&display=swap" rel="stylesheet">

    <title>Xavier Filmes</title>
</head>
<body>
    <nav>
        <span class="title">Xavier Filmes</span>
    </nav>
    <main class="container column p-1 gap" id="filmes-container">
        <?php
            //pega o IP local do server
            $local_ip = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            $url = "$local_ip/filmes.json";
            $curl = curl_init($url);

            if ($curl === false) {
                die('Erro ao inicializar a solicitação cURL: ' . curl_error($curl));
            }      
            
            //define que o resultado pode ser salvo numa variável
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
            
            if ($response === false) {
                die('Erro no response: ' . curl_error($curl));
            }

            if ($response) {
                $filmes = json_decode($response, true);
                
                if ($filmes && isset($filmes['filmes'])) {
                    foreach ($filmes['filmes'] as $filme) {
                        echo '<section class="filme">';
                        echo '<h2>' . $filme['nome'] . '</h2>';
                        echo '<p>Gênero: ' . $filme['gênero'] . '</p>';
                        echo '<p>Sinopse: ' . $filme['sinopse'] . '</p>';
                        echo '<p>Ano de Lançamento: ' . $filme['ano_lancamento'] . '</p>';
                        echo '<p>Línguas Disponíveis: ' . implode(', ', $filme['linguas_disponiveis']) . '</p>';
                        echo '</section>';
                    }
                }
            }
            
            curl_close($curl);
        ?>
    </main>
</body>
</html>
