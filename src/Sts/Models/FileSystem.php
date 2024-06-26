<?php

namespace Sts\Models;

use FilesystemIterator;

class FileSystem
{
    private string $basePath = ARCHIVES_PATH;
    private array $users;
    private ?string $name;
    private ?string $month;
    private ?string $year;
    private ?string $type;
    private array $files = [];


    public function __construct(string $name = "", string $month = "", string $year = "", array $users = [], string $type = "ARQUIVOS FISCAIS")
    {
        $this->users = $users;
        $this->name = $name;
        $this->month = $month;
        $this->year = $year;
        $this->type = $type;

        $this->dataFormatter();
    }

    private function dataFormatter()
    {
        if ($this->name == "Todos") {
            $this->name = ".";
        }

        switch ($this->month) {
            case 'Janeiro':
                $this->month = '01';
                break;
            case 'Fevereiro':
                $this->month = '02';
                break;
            case 'Março':
                $this->month = '03';
                break;
            case 'Abril':
                $this->month = '04';
                break;
            case 'Maio':
                $this->month = '05';
                break;
            case 'Junho':
                $this->month = '06';
                break;
            case 'Julho':
                $this->month = '07';
                break;
            case 'Agosto':
                $this->month = '08';
                break;
            case 'Setembro':
                $this->month = '09';
                break;
            case 'Outubro':
                $this->month = '10';
                break;
            case 'Novembro':
                $this->month = '11';
                break;
            case 'Dezembro':
                $this->month = '12';
                break;
            default:
                break;
        }

        $this->month .= ($this->month != "Todos") ? "-{$this->year}" : "";
    }

    private function folderIterator()
    {
        // baseDir -> yearDir -> monthDir -> nameFile
        // arc     /  2021    /  04       / example

        $baseDir = new FilesystemIterator($this->basePath, FilesystemIterator::SKIP_DOTS | FilesystemIterator::NEW_CURRENT_AND_KEY);
        while ($baseDir->valid()) {
            if (($this->year != "Todos" && $baseDir->key() != $this->year) || $baseDir->key() == "Certificados" || $baseDir->key() == "temp" || $baseDir->getType() != "dir") {
                $baseDir->next();
                continue;
            }

            $yearDir = new FilesystemIterator($this->basePath . "/{$baseDir->key()}", FilesystemIterator::SKIP_DOTS | FilesystemIterator::NEW_CURRENT_AND_KEY);
            while ($yearDir->valid()) {
                if ($this->month != "Todos" && $yearDir->key() != $this->month) {
                    $yearDir->next();
                    continue;
                }

                $monthDir = new FilesystemIterator($this->basePath . "/{$baseDir->key()}/{$yearDir->key()}", FilesystemIterator::SKIP_DOTS | FilesystemIterator::NEW_CURRENT_AND_KEY);
                while ($monthDir->valid()) {
                    if (stristr($monthDir->key(), $this->name) === false || !$this->verifyUsers($monthDir->key()) || stristr($monthDir->key(), $this->type) === false) {
                        $monthDir->next();
                        continue;
                    }

                    $this->files[] = array("filename" => $monthDir->getFilename(), "path" => "/{$baseDir->key()}/{$yearDir->key()}/{$monthDir->key()}", "size" => $monthDir->getSize(), "Mtime" => date('d/m/y', $monthDir->getMTime()));
                    $monthDir->next();
                }
                $yearDir->next();
            }
            $baseDir->next();
        }

        return $this->files;
    }

    public function certificates()
    {
        $dir = new FilesystemIterator($this->basePath . "/Certificados", FilesystemIterator::SKIP_DOTS | FilesystemIterator::NEW_CURRENT_AND_KEY);
        while ($dir->valid()) {
            if ($this->verifyUsers($dir->key()) && $dir->getExtension() == "pfx") {
                $this->files[] = array('filename' => $dir->getFilename(), "path" => "/Certificados/{$dir->getFilename()}", "size" => $dir->getSize(), "Mtime" => date('d/m/y', $dir->getMTime()));
            }

            $dir->next();
        }
        return $this->files;
    }

    public function years()
    {
        $years = array_values(array_intersect(scandir($this->basePath . "/"), ['2018', '2019', '2020', '2021', '2022', '2023', '2024', '2025', '2026', '2027', '2028', '2029', '2030', '2031', '2032', '2033', '2034', '2035', '2036', '2037', '2038', '2039', '2040']));
        return $years;
    }

    private function verifyUsers($string)
    {
        foreach ($this->users as $key => $value) {
            if (stristr($string, $value)) {
                return true;
            }
        }
        return false;
    }

    public function getFiles()
    {
        return $this->folderIterator();
    }

}
