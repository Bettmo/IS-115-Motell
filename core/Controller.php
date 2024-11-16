<?php

class Controller
{
    /**
     * Load a view and pass data to it.
     *
     * @param string $view The name of the view to load (relative to the `views` directory).
     * @param array $data Optional. Data to pass to the view.
     * @return void
     */
    public function view($view, $data = [])
    {
        // Convert array keys to variables accessible in the view
        extract($data);

        // Include the view file
        $viewPath = "../app/views/$view.php";
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("View [$view] does not exist.");
        }
    }

    /**
     * Redirect to another URL.
     *
     * @param string $url The URL to redirect to.
     * @return void
     */
    public function redirect($url)
    {
        header("Location: $url");
        exit;
    }

    /**
     * Check if a user is logged in.
     *
     * @return bool True if a user is logged in, false otherwise.
     */
    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Enforce that a user must be logged in to access a page.
     *
     * @return void
     */
    public function requireLogin()
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }
    }

    /**
     * Enforce that the user must be an admin to access a page.
     *
     * @return void
     */
    public function requireAdmin()
    {
        if (!($_SESSION['is_admin'] ?? false)) {
            $this->redirect('/');
        }
    }
}
