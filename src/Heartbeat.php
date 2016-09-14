<?php

namespace Heartbeat;

class Responder
{
    protected $sentAt;

    public function __construct($sentAt)
    {
        if (!is_numeric($sentAt)) {
            throw new \Exception("Send time must be an javascript Date.now() timestamp", 400);
        }

        $this->sentAt = $sentAt;

        if (isset($_POST) && !empty($_POST)) {
            if (isset($_SESSION['updatedAt']) && $_SESSION['updatedAt'] < $this->sentAt) {
                $_SESSION = static::arrayFilterDeep($_POST);
                $_SESSION['updatedAt'] = $this->sentAt;
            }
        }

        if (isset($_SESSION['updatedAt']) && $_SESSION['updatedAt'] > $this->sentAt) {
            header('HTTP/1.1 409 Conflict');
            header('Content-Type: application/json');
            echo json_encode($_SESSION);

            exit;
        }
    }

    public static function arrayFilterDeep(array $a) {
        foreach ($a as $k => &$v) {
            if (is_array($v)) {
                $a[$k] = static::arrayFilterDeep($v);
            } elseif ($v === 'true') {
                $v = true;
            } elseif ($v === 'false') {
                $v = false;
            }
        }

        return array_filter($a);
    }

    public function respond($bytes = 0)
    {
        if ($bytes > 10240) {
            $bytes = 10240;
        }

        header('Content-Type: image/gif');
        echo str_repeat('0', (int) $bytes);
    }

    public static function now()
    {
        $now = explode(' ', microtime());

        return $now[1].substr($now[0], 2, 3);
    }
}
