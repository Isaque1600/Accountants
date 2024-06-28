<?php
$data['order'] = (isset($data['order']) && $data['order'] == "ASC") ? "DESC" : "ASC";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Certificados</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <link rel="stylesheet" href="<?php echo CSS_URL ?>style.css" />
    <link rel="shortcut icon" href="<?php echo IMG_PATH ?>iconsite.ico" type="image/x-icon" />
</head>

<body>
    <div class="wrapper">
        <nav>
            <div class="logo">
                <img src="<?php echo IMG_URL ?>Logo.png" alt="Logo" />
            </div>
            <div class="list">
                <h1>Documentos</h1>
                <a href="<?php echo DEFAULT_URL ?>"><i data-feather="file-text"></i>Arquivos Fiscais</a>
                <a href=""><i data-feather="file-text"></i>Certificados</a>
                <a href="<?php echo DEFAULT_URL ?>Home/sped"><i data-feather="file-text"></i>SPEDs Fiscais</a>
            </div>
            <a class="logout-btn" href="<?php echo DEFAULT_URL ?>Home/logout"><i data-feather="log-out"></i>Sair</a>
        </nav>

        <div class="content-wrapper">
            <header>
                <p class="page-name">
                    Certificados -
                    <?php echo strtoupper($data['user']) ?>
                </p>
            </header>

            <main>
                <div class="top">
                    <div class="options">
                        <button class="download-btn zipped"><i data-feather="download"></i> Baixar</button>
                    </div>
                    <div class="info">
                        <p class="items-page">Itens na pagina: </p>
                    </div>
                </div>

                <div class="content">

                    <div class="head">
                        <div class="download-select">
                            <label class="form-checkbox"><input type="checkbox" name="download"
                                    class="download all" /></label>
                        </div>
                        <a href="<?php echo DEFAULT_URL ?>/Home/certificados?sort=filename&order=<?php echo $data['order'] ?>"
                            class="name">
                            Nome do arquivo
                            <i
                                data-feather="<?php echo ($data['order'] == "ASC") ? "chevron-down" : "chevron-up" ?>"></i>
                        </a>
                        <a href="<?php echo DEFAULT_URL ?>/Home/certificados?sort=size&order=<?php echo $data['order'] ?>"
                            class="size">
                            Tamanho
                            <i
                                data-feather="<?php echo ($data['order'] == "ASC") ? "chevron-down" : "chevron-up" ?>"></i>
                        </a>
                        <a href="<?php echo DEFAULT_URL ?>/Home/certificados?sort=Mtime&order=<?php echo $data['order'] ?>"
                            class="Mtime">
                            Ultima modificação
                            <i
                                data-feather="<?php echo ($data['order'] == "ASC") ? "chevron-down" : "chevron-up" ?>"></i>
                        </a>
                    </div>

                    <div class="body">
                        <?php

                        if (empty($data['names'])) {
                            echo "<div class=\"empty\">";
                            echo "<i class=\"empty-icon\" data-feather=\"x-octagon\"></i>";
                            echo "<p>O usuário " . ucfirst($data['user']) . " ainda não possui nenhum cliente registrado em nosso Banco de Dados</p>";
                            echo "</div>";
                        } elseif (empty($data['files'])) {
                            echo "<div class=\"empty\">";
                            echo "<i class=\"empty-icon\" data-feather=\"x-octagon\"></i>";
                            echo "<p>Nenhum arquivo correspondente a pesquisa ainda</p>";
                            echo "</div>";
                        } else {
                            foreach ((array) $data['files'] as $key => $value) {
                                echo "<div class=\"row\">";
                                echo " <div class=\"download-select\">";
                                echo " <label class=\"form-checkbox\"><input type=\"checkbox\" name=\"download\" class=\"download\" /></label>";
                                echo " </div>";
                                echo " <div class=\"name\">";
                                echo " <i data-feather=\"file\"></i>";
                                echo " <a class=\"file-download\" href=\"" . ARCHIVES_URL . $value['path'] . "\" download=\"{$value['filename']}\" \">{$value['filename']}</a>";
                                echo " </div>";
                                echo " <p>" . number_format(($value['size'] / 1024), 1) . "KB</p>";
                                echo " <p>{$value['Mtime']}</p>";
                                echo "</div>";
                            }
                        }

                        ?>
                    </div>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"
        integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?php echo JS_URL ?>main.js"></script>
    <script type="text/javascript" src="<?php echo JS_URL ?>DatePicker.js"></script>
    <script type="text/javascript" src="<?php echo JS_URL ?>Download.js"></script>
    <script type="text/javascript" src="<?php echo JS_URL ?>sendAjax.js"></script>
    <script src=" https://unpkg.com/feather-icons"></script>
    <script type="text/javascript">
        feather.replace();
    </script>
</body>

</html>