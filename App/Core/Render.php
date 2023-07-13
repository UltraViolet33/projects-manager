<?php

namespace App\Core;

// use App\Core\Helpers\Session;

define('BASE_VIEW_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR . "\\views" . DIRECTORY_SEPARATOR);


class Render
{

    private string $viewPath;
    private ?array $args;


    public function __construct(string $viewPath, ?array $args = [])
    {
        $this->viewPath = $viewPath;
        $this->args = $args;
    }


    public function view(): string
    {
        // $errors = Session::get("error");
        ob_start();
        extract($this->args);
        require BASE_VIEW_PATH . 'layouts\header.php';
        require BASE_VIEW_PATH . $this->viewPath . '.php';
        require BASE_VIEW_PATH . 'layouts\footer.php';
        return ob_get_clean();
    }


    public static function make(string $viewPath, ?array $args = []): static
    {
        return new static($viewPath, $args);
    }


    public function __toString(): string
    {
        return $this->view();
    }
}
