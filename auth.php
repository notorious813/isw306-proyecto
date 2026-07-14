<?php
declare(strict_types=1);

session_start();

function isLoggedIn(): bool
{
    return !empty($_SESSION['user']);
}

function currentUser(): ?string
{
    return $_SESSION['user'] ?? null;
}

function requireLogin(): void
{
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

function setFlash(string $message): void
{
    $_SESSION['flash'] = $message;
}

function getFlash(): ?string
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

function loginUser(string $username, string $password): bool
{
    $users = [
        'admin' => password_hash('Proyecto2026!', PASSWORD_DEFAULT),
    ];

    if (!isset($users[$username])) {
        return false;
    }

    if (!password_verify($password, $users[$username])) {
        return false;
    }

    $_SESSION['user'] = $username;
    return true;
}

function logoutUser(): void
{
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    session_destroy();
}

function sanitizeValue(?string $value): string
{
    return trim($value ?? '');
}
