# heartbeat.php

Heartbeat script with extra session sync feature

## Usage

```php
<?php

require 'src/Heartbeat.php';
// or when using Composer
// require 'vendor/autoload.php';

session_start();

$Heartbeat = new \Heartbeat\Responder(@$_GET['sentAt']);
$Heartbeat->respond((int) @$_GET['bytes']);

```

### Note on using Composer

```json
{
    "name": "yourproject",
    "repositories": [
        {
            "type": "vcs",
        	"url": "git@github.com:attitude/heartbeat.php.git"
    	}
    ],
    "require": {
        "attitude/heartbeat.php": "dev-master"
    }
}
```
