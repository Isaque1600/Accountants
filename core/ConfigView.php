<?php

namespace Core;

class ConfigView
{

    private string $name;
    private array $data;

    public function __construct($name, $data)
    {
        $this->name = $name;
        $this->data = $data;
    }

    public function renderView()
    {

        $data = $this->data;

        if (file_exists("src/" . $this->name . ".php")) {
            include("src/" . $this->name . ".php");
        } else {
            die("An error has occurred, contact the Support");
        }

    }

}
