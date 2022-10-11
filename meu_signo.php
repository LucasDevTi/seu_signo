<?php

$succes_flag = false;

if (isset($_POST)) {

    if (isset($_POST['user_name']) && !empty($_POST['user_name'])) {
        $user_name = htmlspecialchars($_POST['user_name'], ENT_QUOTES);
    } else {
        $user_name = '';
    }

    if (isset($_POST['birth_date']) && !empty($_POST['birth_date'])) {
        $birth_date = htmlspecialchars($_POST['birth_date'], ENT_QUOTES);
        $horoscope_date = DateTime::createFromFormat('Y-m-d', $birth_date)->format('m/d');
        $succes_flag = true;
    } else {
        $birth_date = 0;
        $succes_flag = false;
    }

    if ($succes_flag) {
        // Lê arquivo xml
        require_once('meu_signo.php');
        $xml = simplexml_load_file('dados/signos.xml');
        $success = false;
        foreach ($xml->signo as $horoscope) {
            $initial_date = DateTime::createFromFormat('d/m', $horoscope->dataInicio)->format('m/d');
            $final_date = DateTime::createFromFormat('d/m', $horoscope->dataFim)->format('m/d');

            // se dataInicio for anterior a dataFim
            if (strtotime($initial_date) < strtotime($final_date)) {
                // Se data de nascimento, dia e mês, estiver dentro do limite dos dias inicias e finais
                if (strtotime($horoscope_date) >= strtotime($initial_date) && strtotime($horoscope_date) <= strtotime($final_date)) {
                    $success = true;
                    $data_inicio = $horoscope->dataInicio;
                    $data_fim = $horoscope->dataFim;
                    $descricao = $horoscope->descricao;
                    $signo_nome = $horoscope->signoNome;
                    break;
                }
            }
            // Se a dataFim for anterior a dataInicio (capricornio)
            else if (strtotime($initial_date) > strtotime($final_date)) {
                //Se data de aniversario for menor que dataInicio e menor que dataFim ou data de aniversario for maior que dataIncio e maior que dataFim
                if ((strtotime($horoscope_date) <= strtotime($initial_date) && strtotime($horoscope_date) <= strtotime($final_date)) || (strtotime($horoscope_date) >= strtotime($initial_date) && strtotime($horoscope_date) >= strtotime($final_date))) {
                    $success = true;
                    $data_inicio = $horoscope->dataInicio;
                    $data_fim = $horoscope->dataFim;
                    $descricao = $horoscope->descricao;
                    $signo_nome = $horoscope->signoNome;
                    break;
                }
            }
        }
        switch ($signo_nome) {
            case 'Áries':
                $src = 'resources/aries.png';
                break;
            case 'Touro':
                $src = 'resources/taurus.png';
                break;
            case 'Gêmeos':
                $src = 'resources/gemini.png';
                break;
            case 'Câncer':
                $src = 'resources/cancer.png';
                break;
            case 'Leão':
                $src = 'resources/leo.png';
                break;
            case 'Virgem':
                $src = 'resources/virgo.png';
                break;
            case 'Libra':
                $src = 'resources/libra.png';
                break;
            case 'Escorpião':
                $src = 'resources/scorpio.png';
                break;
            case 'Sagitário':
                $src = 'resources/sagittarius.png';
                break;
            case 'Capricórnio':
                $src = 'resources/capricorn.png';
                break;
            case 'Aquário':
                $src = 'resources/aquarius.png';
                break;
            case 'Peixes':
                $src = 'resources/pisces.png';
                break;
            default:
                break;
        }
        if ($success) { ?>

            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
            <link rel="stylesheet" href="css/style_index.css">
            <header>
                <nav class="navbar navbar-expand-lg bg-light">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#">Meu Signo</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="index.html">Home</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            <section class="container">
                <div class="row justify-content-center align-items-center vh-100">
                    <div class="col-10 rounded p-4" id="horoscopo">
                        <div id="signo_image" class="mb-4">
                            <img src="<?php echo $src ?>" alt="<?php echo $signo_nome ?>">
                        </div>
                        <div id="name_user_signo">
                            <p class="fs-1 fw-bolder"> Olá <?php echo (!empty($user_name) ? ", $user_name." : ""); ?></p>
                            <p class="fs-3 fw-semibold"> Você é do signo de <?php echo (!empty($signo_nome) ? "$signo_nome." : ""); ?></p>
                            <p class="fs-3 fw-lighter">Inicio em: <?php echo($data_inicio)?> até: <?php echo($data_fim)?></p>
                        </div>
                        <p class="fs-4 fw-normal" id="descricao">
                            <?php echo ($descricao) ?>
                        </p>
                    </div>
            </section>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
            <script>
                window.onload = (event) => {
                    document.body.style.backgroundColor ="rgb(36 6 116)";
                    document.body.style.backgroundImage = "linear-gradient(to right bottom, rgb(36 6 116), rgb(204, 97, 223))";
                }
            </script>
<?php }
    }
}
