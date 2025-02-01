<?php
enum AlertType: string {
    case ERROR = 'error';
    case SUCCESS = 'success';
    case WARNING = 'warning';
}

class Alert {
    public static function save(string $msg, AlertType $type = AlertType::WARNING): void {
        $_SESSION['alert'] = ['type' => $type->value, 'msg' => $msg];
    }

    public static function load(): string {
        if ($alert = $_SESSION['alert'] ?? false) {
            $r = self::gen($alert['msg'], AlertType::from($alert['type']));
            unset($_SESSION['alert']);
        }
        return $r ?? '';
    }

    public static function loadIf(bool $ic): string { return $ic ? self::load() : ''; }

    public static function gen(string $msg, AlertType $type = AlertType::WARNING): string { return "<div id='alert' class='alert-$type->value limiter-lg'>$msg</div>"; }
}
