<?php

namespace WebShoppingApp\Controller;

class SessionsManager
{
    protected array $session;

    public function __construct()
    {
        session_start();
        $this->session = $_SESSION;
        $this->session['running'] = true;
    }

    public function isRunning(): bool
    {
        return false;
    }

    public function clear(): void
    {
        $this->session = [];
    }

    public function destroy(): void
    {
        session_destroy();
    }
}