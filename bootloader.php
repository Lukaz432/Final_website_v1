<?php

declare(strict_types = 1);

require 'config.php';

// Load Core Classes
require_once ROOT . '/vendor/autoload.php';

// Load Core Functions
require ROOT . '/core/functions/form/Core.php';
require ROOT . '/core/functions/html/builder.php';

// Load App Functions
require ROOT . '/app/functions/validators.php';

// Load ONE DB For All Purposes (instead of $this->db separately for each function)
$app = new \App\App();
