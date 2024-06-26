<?php

namespace Core;

use Error;

class ConfigController extends Config
{
    private array $url;
    private string $urlController;
    private string $urlMethod;
    private ?array $urlParameters = null;

    public function __construct()
    {

        Config::__construct();

        if (!empty(filter_input(INPUT_GET, "url", FILTER_SANITIZE_URL))) {
            $this->url = explode("/", filter_input(INPUT_GET, "url", FILTER_SANITIZE_URL));

            if (isset($this->url[0]) && isset($this->url[1])) {
                $this->urlController = $this->url[0];
                $this->urlMethod = (!empty($this->url[1])) ? $this->url[1] : "index";
                $this->urlParameters = filter_input_array(INPUT_GET, FILTER_SANITIZE_URL);
                // var_dump($this->url);
            } else {
                $this->urlController = "Error";
                $this->urlMethod = "index";
            }
        } else {
            $this->urlController = "Home";
            $this->urlMethod = "index";
        }

        // var_dump($this->urlParameters);
        // var_dump($this->urlController);
        // var_dump($this->urlMethod);
        // var_dump($this->url);

    }

    public function loadPage()
    {

        $classLoad = "\\Sts\Controllers\\" . $this->urlController;
        try {
            $classPage = new $classLoad();
            $classPage->{$this->urlMethod}($this->urlParameters);
        } catch (Error $err) {
            var_dump($err->getMessage());
            $classLoad = "\\Sts\Controllers\\" . "NotFound";
            $classPage = new $classLoad();
            $classPage->index();
        }

    }

}
