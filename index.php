<?php

/**
 * Bango: The zero-tricks lightweight framework - just you, and PHP.
 *
 * @author  Gabriel Moreno <gamoreno@urbe.edu.ve>
 * @license MIT
 */

// In order for the app to work, the autoload function must be required
// at first, since all the class must be available in the entire app,
// that way, all include/require statements are no longer needed.
require_once __DIR__."/config/autoload.php";

use \Bango\App;

// All the initialization routines must be added into the start method
// in order for them to run before the website gets rendered.
$app = new App();

$app->start();