<?php
function require_login(string $msg = 'Faça login para acessar essa página.', string $url = '/auth.php') {
    global $login;
    if ($login) return;
    Alert::save($msg, AlertType::WARNING);
    Auth::redirect("$url?destiny=" . $_SERVER['REQUEST_URI']);
}
