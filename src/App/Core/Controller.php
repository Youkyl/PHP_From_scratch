<?php

namespace App\core;

class Controller
{
    protected function renderHtml(string $templateName, array $data = [])
    {
        $path = PATH_ROOT . '/templates/' . $templateName;
        if (!file_exists($path)) {
            http_response_code(404);
            die("Page introuvable");
        }
          extract($data);
          ob_start();
           require_once $path;
           $contentForView = ob_get_clean();
           
           require_once PATH_ROOT . '/templates/base.layout.html.php';
    }

    protected function redirect(string $url)
    {
        header("Location: $url");
        exit;
    }
}