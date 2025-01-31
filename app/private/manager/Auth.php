<?php
class Auth {
    public static function redirect(string $url = '/'): void {
        header('Location:' . $url);
        exit;
    }

    public static function login(User $user, string $msg): void {
        self::setLogin($user);
        Alert::save($msg, AlertType::SUCCESS);
    }

    public static function loginRedirect(User $user, string $msg, string $url = '/'): void {
        self::login($user, $msg);
        self::redirect($url);
    }

    public static function logout(string $url = '/'): void {
        if (self::loginInSession()) {
            unset($_SESSION['login']);
            self::redirect($url);
        }
    }

    public static function isLogged(): false|array {
        global $userDAO;
        if ($login = self::loginInSession()) {
            $cd = $login['cd'];
            $token = $login['token'];

            if (($user = $userDAO->findById($cd, UserAtt::AUTH)) && $user->getToken() === $token) {
                self::setLogin($user);
                return $login;
            }
        }
        return false;
    }

    private static function setLogin(User $user): void {
        $_SESSION['login'] = [
            'cd' => $user->getCd() ?? throw new Exception('Código de usuário não pode ser nulo.'),
            'name' => $user->getUserName() ?? throw new Exception('Nome não pode ser nulo.'),
            'token' => $user->getToken() ?? throw new Exception('Token não pode ser nulo.'),
            'image' => $user->getImagePath(),
        ];
    }

    private static function loginInSession(): ?array {
        return $_SESSION['login'] ?? null;
    }
}
