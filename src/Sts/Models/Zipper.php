<?php

namespace Sts\Models;

use ZipArchive;

class Zipper
{
    private array $files;
    private string $zipname;

    private function formatPath()
    {
        foreach ($this->files as $key => $value) {
            $this->files[$key] = explode('arc', $value)[1];
        }
    }

    public function zipFiles(array $files, string $zipname)
    {
        $this->files = $files;
        $this->formatPath();
        $this->zipname = $zipname;

        if (!file_exists(ARCHIVES_PATH . "/temp/")) {
            mkdir(ARCHIVES_PATH . "/temp", 0777, true);
        }

        $zipPath = ARCHIVES_PATH . "/temp/" . $this->zipname . ".zip";

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE)) {
            foreach ($this->files as $key => $value) {
                $i = 1;
                $filename = basename(ARCHIVES_PATH . $value);
                if (file_exists(ARCHIVES_PATH . $value)) {
                    $fileNameBroken = explode(".", $filename);
                    while ($zip->locateName($filename) !== false) {
                        $filename = $fileNameBroken[0] . "($i)." . $fileNameBroken[1];
                        $i++;
                    }
                    $zip->addFile(ARCHIVES_PATH . $value, $filename);
                } else {
                    $zip->close();
                    throw new \Exception("File not exists", 1);
                }
            }
            $zip->close();
        }

        return $zipPath;
    }


}
