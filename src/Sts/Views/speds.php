<?php

// echo "<pre>";
// var_dump($data);
// echo "</pre>";

$data['date']['month'] = (isset($data['date']['month'])) ? $data['date']['month'] : "Todos";
$data['date']['year'] = (isset($data['date']['year'])) ? $data['date']['year'] : "Todos";
$data['selected'] = (isset($data['selected'])) ? $data['selected'] : "Todos";
$data['order'] = (isset($data['order']) && $data['order'] == "ASC") ? "DESC" : "ASC";

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SPED Fiscais</title>
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
        <a href="<?php echo DEFAULT_URL ?>Home/certificados"><i data-feather="file-text"></i>Certificados</a>
        <a href="<?php echo DEFAULT_URL ?>Home/sped"><i data-feather="file-text"></i>SPEDs Fiscais</a>
      </div>
      <a class="logout-btn" href="<?php echo DEFAULT_URL ?>Home/logout"><i data-feather="log-out"></i>Sair</a>
    </nav>

    <div class="content-wrapper">
      <header>
        <p class="page-name">
          SPEDs Fiscais -
          <?php echo strtoupper($data['user']) ?>
        </p>

        <form class="form" action="" method="get">
          <div class="custom-select monthpicker">
            <button type="button" class="select-btn">
              <input class="selected-value" id="selected-value" name="month"
                value="<?php echo $data['date']['month'] ?>" readonly />

              <span class="select-arrow"></span>
            </button>
            <ul class="select-dropdown">
              <li>
                <p class="option">Todos</p>
              </li>
              <li>
                <p class="option">Janeiro</p>
              </li>
              <li>
                <p class="option">Fevereiro</p>
              </li>
              <li>
                <p class="option">Março</p>
              </li>
              <li>
                <p class="option">Abril</p>
              </li>
              <li>
                <p class="option">Maio</p>
              </li>
              <li>
                <p class="option">Junho</p>
              </li>
              <li>
                <p class="option">Julho</p>
              </li>
              <li>
                <p class="option">Agosto</p>
              </li>
              <li>
                <p class="option">Setembro</p>
              </li>
              <li>
                <p class="option">Outubro</p>
              </li>
              <li>
                <p class="option">Novembro</p>
              </li>
              <li>
                <p class="option">Dezembro</p>
              </li>
            </ul>
          </div>
          <div class="custom-select yearpicker">
            <button type="button" class="select-btn">
              <input class="selected-value" id="selected-value" name="year" value="<?php echo $data['date']['year'] ?>"
                readonly />

              <span class="select-arrow"></span>
            </button>
            <ul class="select-dropdown">
              <li>
                <p class="option">Todos</p>
              </li>
              <?php

              if (!empty($data['years'])) {
                foreach ($data['years'] as $key => $value) {
                  echo "<li>";
                  echo "<p class=\"option\">{$value}</p>";
                  echo "</li>";
                }
              }

              ?>
            </ul>
          </div>
          <div class="custom-select namepicker">
            <button type="button" class="select-btn">
              <input class="selected-value" id="selected-value" name="name" value="<?php echo $data['selected'] ?>"
                readonly />

              <span class="select-arrow"></span>
            </button>
            <ul class="select-dropdown">
              <li>
                <p class="option">Todos</p>
              </li>
              <?php

              if (!empty($data['names'])) {
                foreach ($data['names'] as $key => $value) {
                  echo "<li>";
                  echo "<p class=\"option\">{$value['RAZAO']}</p>";
                  echo "</li>";
                }
              }

              ?>
            </ul>
          </div>
        </form>
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
              <label class="form-checkbox"><input type="checkbox" name="download" class="download all" /></label>
            </div>
            <a href="<?php echo DEFAULT_URL ?>/Home/sped?sort=filename&order=<?php echo $data['order'] ?>&month=<?php echo $data['date']['month'] ?>&year=<?php echo $data['date']['year'] ?>&name=<?php echo $data['selected'] ?>"
              class="name">
              Nome do arquivo
              <i data-feather="<?php echo ($data['order'] == "ASC") ? "chevron-down" : "chevron-up" ?>"></i>
            </a>
            <a href="<?php echo DEFAULT_URL ?>/Home/sped?sort=size&order=<?php echo $data['order'] ?>&month=<?php echo $data['date']['month'] ?>&year=<?php echo $data['date']['year'] ?>&name=<?php echo $data['selected'] ?>"
              class="size">
              Tamanho
              <i data-feather="<?php echo ($data['order'] == "ASC") ? "chevron-down" : "chevron-up" ?>"></i>
            </a>
            <a href="<?php echo DEFAULT_URL ?>/Home/sped?sort=Mtime&order=<?php echo $data['order'] ?>&month=<?php echo $data['date']['month'] ?>&year=<?php echo $data['date']['year'] ?>&name=<?php echo $data['selected'] ?>"
              class="Mtime">
              Ultima modificação
              <i data-feather="<?php echo ($data['order'] == "ASC") ? "chevron-down" : "chevron-up" ?>"></i>
            </a>
          </div>

          <div class="body">
            <?php

            if (!empty($data['files'])) {
              foreach ($data['files'] as $key => $value) {
                echo "<div class=\"row\">";
                echo " <div class=\"download-select\">";
                echo " <label class=\"form-checkbox\"><input type=\"checkbox\" name=\"download\" class=\"download\" /></label>";
                echo " </div>";
                echo " <div class=\"name\">";
                echo " <i data-feather=\"file\"></i>";
                echo " <a class=\"file-download\" download=\"{$value['filename']}\" href=\"" . ARCHIVES_URL . $value['path'] . "\">{$value['filename']}</a>";
                echo " </div>";
                echo " <p>" . number_format(($value['size'] / 1024), 1) . "KB</p>";
                echo " <p>{$value['Mtime']}</p>";
                echo "</div>";
              }
            } else {
              echo "<div class=\"empty\">";
              echo "<i class=\"empty-icon\" data-feather=\"x-octagon\"></i>";
              echo "<p>Nenhum arquivo correspondente a pesquisa ainda</p>";
              echo "</div>";
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
  <script src=" https://unpkg.com/feather-icons"></script>
  <script type="text/javascript">
    feather.replace();
  </script>
</body>

</html>