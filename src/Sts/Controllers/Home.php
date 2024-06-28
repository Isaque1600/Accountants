<?php

namespace Sts\Controllers;

use Sts\Models\Zipper;
use Core\ConfigView;
use Sts\Models\FileSystem;
use Sts\Models\Helpers\Select;
use Sts\Models\Date;

class Home
{
    private ?array $data = [];

    public function index(?array $urlParameters = null)
    {
        $select = new Select();
        $date = new Date;

        $this->data['page'] = "Arquivos Fiscais";
        $this->data['user'] = $_SESSION["newsession"];

        try {
            $this->data['names'] = $select->selectAllByName($_SESSION["newsession"]);
            $years = new FileSystem();
            $this->data['years'] = $years->years();
        } catch (\PDOException $err) {
            $this->data['err'] = $err;
        }

        $dataForm = filter_input_array(INPUT_GET, FILTER_DEFAULT);
        unset($dataForm['url']);

        if (isset($dataForm)) {
            $this->data['date'] = array('month' => $dataForm['month'], 'year' => $dataForm['year']);
            $this->data['selected'] = $dataForm['name'];

            if (isset($dataForm['sort']) && isset($dataForm['order'])) {
                $this->data['sort'] = $dataForm['sort'];
                $this->data['order'] = $dataForm['order'];
            } else {
                $this->data['sort'] = 'filename';
                $this->data['order'] = 'ASC';
            }

        } else {
            $this->data['date'] = $date->getDate();
            $this->data['selected'] = "Todos";
            $this->data['sort'] = 'filename';
            $this->data['order'] = 'ASC';
        }

        foreach ($this->data['names'] as $key => $value) {
            $names[] = $value['RAZAO'];
        }

        $dir = new FileSystem((isset($this->data['selected'])) ? $this->data['selected'] : "Todos", trim($this->data['date']['month']), trim($this->data['date']['year']), isset($names) ? $names : []);
        $this->data['files'] = $dir->getFiles();

        switch ($this->data['sort']) {
            case 'filename':
                if ($this->data['order'] == 'ASC') {
                    array_multisort(array_column($this->data['files'], 'filename'), SORT_FLAG_CASE, $this->data['files']);
                } else {
                    array_multisort(array_column($this->data['files'], 'filename'), SORT_FLAG_CASE, $this->data['files']);
                    $this->data['files'] = array_reverse($this->data['files']);
                }
                break;

            case 'size':
                if ($this->data['order'] == 'ASC') {
                    array_multisort(array_column($this->data['files'], 'size'), SORT_ASC, $this->data['files']);
                } else {
                    array_multisort(array_column($this->data['files'], 'size'), SORT_DESC, $this->data['files']);
                }
                break;

            case 'Mtime':
                if ($this->data['order'] == 'ASC') {
                    array_multisort(array_column($this->data['files'], 'Mtime'), SORT_ASC, $this->data['files']);
                } else {
                    array_multisort(array_column($this->data['files'], 'Mtime'), SORT_DESC, $this->data['files']);
                }
                break;
        }

        $loadView = new ConfigView('Sts/Views/archive', $this->data);
        $loadView->renderView();
    }

    public function sped(?array $urlParameters = null)
    {
        $select = new Select();
        $date = new Date;

        $this->data['page'] = "SPEDs Fiscais";
        $this->data['user'] = $_SESSION["newsession"];

        try {
            $this->data['names'] = $select->selectAllByName($_SESSION["newsession"]);
            $years = new FileSystem();
            $this->data['years'] = $years->years();
        } catch (\PDOException $err) {
            $this->data['err'] = $err;
        }

        $dataForm = filter_input_array(INPUT_GET, FILTER_DEFAULT);
        unset($dataForm['url']);

        if (isset($dataForm) && !empty($dataForm)) {
            $this->data['date'] = array('month' => $dataForm['month'], 'year' => $dataForm['year']);
            $this->data['selected'] = $dataForm['name'];

            if (isset($dataForm['sort']) && isset($dataForm['order'])) {
                $this->data['sort'] = $dataForm['sort'];
                $this->data['order'] = $dataForm['order'];
            } else {
                $this->data['sort'] = 'filename';
                $this->data['order'] = 'ASC';
            }

        } else {
            $this->data['date'] = $date->getDate();
            $this->data['sort'] = 'filename';
            $this->data['order'] = 'ASC';
        }

        foreach ($this->data['names'] as $key => $value) {
            $names[] = $value['RAZAO'];
        }

        $dir = new FileSystem((isset($this->data['selected'])) ? $this->data['selected'] : "Todos", trim($this->data['date']['month']), trim($this->data['date']['year']), isset($names) ? $names : [], 'SPED');
        $this->data['files'] = $dir->getFiles();

        switch ($this->data['sort']) {
            case 'filename':
                if ($this->data['order'] == 'ASC') {
                    array_multisort(array_column($this->data['files'], 'filename'), SORT_FLAG_CASE, $this->data['files']);
                } else {
                    array_multisort(array_column($this->data['files'], 'filename'), SORT_FLAG_CASE, $this->data['files']);
                    $this->data['files'] = array_reverse($this->data['files']);
                }
                break;

            case 'size':
                if ($this->data['order'] == 'ASC') {
                    array_multisort(array_column($this->data['files'], 'size'), SORT_ASC, $this->data['files']);
                } else {
                    array_multisort(array_column($this->data['files'], 'size'), SORT_DESC, $this->data['files']);
                }
                break;

            case 'Mtime':
                if ($this->data['order'] == 'ASC') {
                    array_multisort(array_column($this->data['files'], 'Mtime'), SORT_ASC, $this->data['files']);
                } else {
                    array_multisort(array_column($this->data['files'], 'Mtime'), SORT_DESC, $this->data['files']);
                }
                break;
        }

        $loadView = new ConfigView('Sts/Views/speds', $this->data);
        $loadView->renderView();
    }

    public function certificados(?array $urlParameters = null)
    {
        $select = new Select();

        $this->data['page'] = "Certificados";
        $this->data['user'] = $_SESSION["newsession"];

        try {
            $this->data['names'] = $select->selectAllByName($_SESSION["newsession"]);
        } catch (\PDOException $err) {
            $this->data['err'] = $err;
        }

        if ($this->data['names'] != null) {
            foreach ($this->data['names'] as $key => $value) {
                $names[] = $value['RAZAO'];
            }
        }

        $dataForm = filter_input_array(INPUT_GET, FILTER_DEFAULT);
        unset($dataForm['url']);

        if (isset($dataForm) && !empty($dataForm)) {
            $this->data['sort'] = $dataForm['sort'];
            $this->data['order'] = $dataForm['order'];
        } else {
            $this->data['sort'] = 'filename';
            $this->data['order'] = 'ASC';
        }

        $dir = new FileSystem("", "", "", isset($names) ? $names : []);

        if (isset($names)) {
            $this->data['files'] = $dir->certificates();
        }

        switch ($this->data['sort']) {
            case 'filename':
                if ($this->data['order'] == 'ASC') {
                    array_multisort(array_column($this->data['files'], 'filename'), SORT_FLAG_CASE, $this->data['files']);
                } else {
                    array_multisort(array_column($this->data['files'], 'filename'), SORT_FLAG_CASE, $this->data['files']);
                    $this->data['files'] = array_reverse($this->data['files']);
                }
                break;

            case 'size':
                if ($this->data['order'] == 'ASC') {
                    array_multisort(array_column($this->data['files'], 'size'), SORT_ASC, $this->data['files']);
                } else {
                    array_multisort(array_column($this->data['files'], 'size'), SORT_DESC, $this->data['files']);
                }
                break;

            case 'Mtime':
                if ($this->data['order'] == 'ASC') {
                    array_multisort(array_column($this->data['files'], 'Mtime'), SORT_ASC, $this->data['files']);
                } else {
                    array_multisort(array_column($this->data['files'], 'Mtime'), SORT_DESC, $this->data['files']);
                }
                break;
        }

        $loadView = new ConfigView('Sts/Views/certificates', $this->data);
        $loadView->renderView();
    }

    public function logout()
    {
        header("location: ../../zyro/ajax/logout.php");
    }

    public function zipFiles()
    {

        $zipname = isset($_POST['filename']) ? $_POST['filename'] : "SPEDSFiscias";

        if ($_POST['download'] == 'true') {
            $zip = new Zipper();
            $zipPath = $zip->zipFiles($_POST['files'], $zipname);

            if (file_exists($zipPath)) {
                echo (ARCHIVES_URL . "/temp/" . $zipname . ".zip");
            }
            exit;
        }

        if (file_exists(ARCHIVES_PATH . "/temp/" . "$zipname.zip")) {
            unlink(ARCHIVES_PATH . "/temp/" . "$zipname.zip");
            echo true;
        }

    }

}
