<?php
/**
 * This file is part of virtualstyle/formstack-devtest.
 * https://github.com/virtualstyle/formstack-devtest.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */

 /**
  * Application entry point.
  */
 $path = __DIR__;
 define('APP_DEBUG', true);

 require_once __DIR__.'/config/bootstrap.php';

$cli = false;
 if (defined('STDIN')) {
     $cli = true;
 } elseif (empty($_SERVER['REMOTE_ADDR']) and !isset($_SERVER['HTTP_USER_AGENT']) and count($_SERVER['argv']) > 0) {
     $cli = true;
 }

 if ($cli) {
     $kernel = 'Aura\Cli_Kernel\CliKernel';
 } else {
     $kernel = 'Aura\Web_Kernel\WebKernel';
 }

 $kernel = (new \Aura\Project_Kernel\Factory())->newKernel(
     $path,
     $kernel
 );
 $status = $kernel();
 exit($status);
