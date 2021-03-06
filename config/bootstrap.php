<?php
/**
 * This file is part of virtualstyle/formstack-devtest.
 * https://github.com/virtualstyle/formstack-devtest.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */

error_reporting(E_ALL | E_STRICT);
//Composer's autoloader
require_once 'vendor/autoload.php';
//DB config (would prefer not to store this in the webroot)
require_once 'config/mysql_pdo_config.php';
