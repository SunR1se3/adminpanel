<?php

class Routing {
    private $pages = array();

    function AddRoute($url, $path) {
        $this->pages[$url] = $path;
    }

    function Route($url) {
        $path = $this->pages[$url];
        $file_dir = "client/" . $path;
        if ($path == "") die("файл не найден!");

        if (file_exists($file_dir)) {
            require $file_dir;
        } else die("файл не найден!");
    }
}
