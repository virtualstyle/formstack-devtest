<?php
/**
 * This file is part of virtualstyle/formstack-devtest.
 * https://github.com/virtualstyle/formstack-devtest.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace Aura\Cli_Project\_Config;

use Virtualstyle\FormstackDevtest\Controller\User\UserController;
use Virtualstyle\FormstackDevtest\Controller\HttpErrorResponse;
use Virtualstyle\FormstackDevtest\Domain\User\User;

use Aura\Di\Config;
use Aura\Di\Container;
use Aura\View\View;

/**
 * Configuration class to declare dependency injection for the dependency
 *  injection container, set services, initialize services, and a
 *  microframework pattern for the cli commands (and enough web routes/handlers)
 *  to present reasonable errors for HTTP request attempts.
 */
class Common extends Config
{
    /**
     * Set up all our dependencies and define services.
     * @method define
     * @param  Container $di An Aura dependency injection container
     */
    public function define(Container $di)
    {
        $di->setters['Virtualstyle\FormstackDevtest\Domain\Repository\Database\Pdo\PdoConnection']['setConfig']
            = array('dsn' => PDO_DSN, 'user' => PDO_USER, 'password' => PDO_PASS,
                'driverOptions' => array());

        $di->setters['Virtualstyle\FormstackDevtest\Domain\Repository\Database\Pdo\PdoConnection']['setConnection']
            = null;

        $di->setters['Virtualstyle\FormstackDevtest\Domain\Repository\Database\Pdo\PdoDatabase']['setConnection']
            = $di->lazyNew('Virtualstyle\FormstackDevtest\Domain\Repository\Database\Pdo\PdoConnection');

        $di->setters['Virtualstyle\FormstackDevtest\Domain\Repository\UserRepository']['setDatabase']
        = $di->lazyNew('Virtualstyle\FormstackDevtest\Domain\Repository\Database\Pdo\PdoDatabase');

        $di->setters['Virtualstyle\FormstackDevtest\Domain\User\User']['setRepo']
        = $di->lazyGet('user_repo');

        $di->set('aura/project-kernel:logger', $di->lazyNew('Monolog\Logger'));

        $di->set('user_repo', $di->lazyNew('Virtualstyle\FormstackDevtest\Domain\Repository\UserRepository'));

        $di->set('aura/view:view-factory', $di->lazyNew('Aura\View\ViewFactory'));

        $di->params['Aura\Web_Kernel\MissingRoute'] = array(
            'request' => $di->lazyGet('aura/web-kernel:request'),
            'responder' => $di->lazyNew('Virtualstyle\FormstackDevtest\Responder\MissingRouteResponder'),
        );

        $di->params['Aura\Web_Kernel\MissingAction'] = array(
            'request' => $di->lazyGet('aura/web-kernel:request'),
            'responder' => $di->lazyNew('Virtualstyle\FormstackDevtest\Responder\MissingActionResponder'),
        );

        $di->params['Aura\Web_Kernel\CaughtException'] = array(
            'request' => $di->lazyGet('aura/web-kernel:request'),
            'responder' => $di->lazyNew('Virtualstyle\FormstackDevtest\Responder\CaughtExceptionResponder'),
        );
    }

    /**
     * Modify the dependency container before it's locked.
     * @method modify
     * @param  Container $di An Aura dependency injection container
     */
    public function modify(Container $di)
    {
        $this->modifyLogger($di);
        $this->modifyUserRepository($di);
        $this->modifyCliDispatcher($di);
        $this->modifyWebRouter($di);
        $this->modifyWebDispatcher($di);
    }

    /**
     * Initialize and set the user repository service instance.
     * @method modifyUserRepository
     * @param  Container            $di An Aura dependency injection container
     */
    protected function modifyUserRepository(Container $di)
    {
        $user_repo = $di->get('user_repo');
    }

    /**
     * Initialize and set the monolog service instance.
     * @method modifyLogger
     * @param  Container            $di An Aura dependency injection container
     */
    protected function modifyLogger(Container $di)
    {
        $project = $di->get('project');
        $mode = $project->getMode();
        $file = $project->getPath("tmp/log/{$mode}.log");

        $logger = $di->get('aura/project-kernel:logger');
        $logger->pushHandler($di->newInstance(
            'Monolog\Handler\StreamHandler',
            array(
                'stream' => $file,
            )
        ));
    }

    /**
     * Initialize and set the clidispatcher service instance and set routes and
     * handlers.
     * @method modifyCliDispatcher
     * @param  Container $di An Aura dependency injection container
     */
    protected function modifyCliDispatcher(Container $di)
    {
        $context = $di->get('aura/cli-kernel:context');
        $stdio = $di->get('aura/cli-kernel:stdio');
        $logger = $di->get('aura/project-kernel:logger');
        $dispatcher = $di->get('aura/cli-kernel:dispatcher');
        $user_repo = $di->get('user_repo');

        $dispatcher->setObject(
            'users',
            function () use ($context, $stdio, $logger, $user_repo) {
                $collection = $user_repo->findAll(array(), false, 'id, username, email, firstname, lastname');

                foreach($collection as $key => $value) {
                    $collection[$key] = $value->getVars(false);
                }

                print_r($collection);

            }
        );

        $dispatcher->setObject(
            'user',
            function ($id) use ($context, $stdio, $logger, $user_repo) {
                $user = $user_repo->findById($id, 'id, username, email, firstname, lastname');
                print_r($user->getVars(false));

            }
        );

        $dispatcher->setObject(
            'user-create',
            function () use ($context, $stdio, $logger, $user_repo) {

                if (is_null($context->argv->get(2))) {

                    $data = array();

                    $stdio->outln('Enter the new username and press <Enter> (required]).');
                    $username = $stdio->in();
                    if ($username) {
                        $data['username'] = $username;
                    }
                    $stdio->outln('Enter the new password and press <Enter> (required]).');
                    $password = $stdio->in();
                    if ($password) {
                        $data['password'] = $password;
                    }
                    $stdio->outln('Enter the new email address and press <Enter> (required]).');
                    $email = $stdio->in();
                    if ($email) {
                        $data['email'] = $email;
                    }
                    $stdio->outln('Enter the new first name and press <Enter> (required]).');
                    $firstname = $stdio->in();
                    if ($firstname) {
                        $data['firstname'] = $firstname;
                    }
                    $stdio->outln('Enter the new last name and press <Enter> (required]).');
                    $lastname = $stdio->in();
                    if ($lastname) {
                        $data['lastname'] = $lastname;
                    }
                } else {

                    if ( !is_null($context->argv->get(3))) {
                        $data = array('username' => $context->argv->get(2),
                            'password' => $context->argv->get(3),
                            'email' => $context->argv->get(4),
                            'firstname' => $context->argv->get(5),
                            'lastname' => $context->argv->get(6));
                    } else {
                        $data = json_decode($context->argv->get(2), true);
                        if(!$data || is_null($data)) {
                            throw new \InvalidArgumentException('Invalid JSON in argv[2].');
                        }
                    }
                }
                $user = new User($data);
                $user->setRepo($user_repo);
                $user->save();
                $stdio->outln('User saved as follows:');
                print_r($user->getVars(false));
            }
        );

        $dispatcher->setObject(
            'user-update',
            function () use ($context, $stdio, $logger, $user_repo) {
                $data = array();

                if (is_null($context->argv->get(2))) {
                    $stdio->outln('Enter the user ID and press <Enter>');
                    $user_id = $stdio->in();
                    $user = $user_repo->findById($user_id, 'id, username, email, firstname, lastname');

                    $data = $user->getVars(false);

                    $stdio->outln('Enter the new username and press <Enter> (leave blank to leave as is['.$user->getUsername().']).');
                    $username = $stdio->in();
                    if ($username) {
                        $data['username'] = $username;
                    }
                    $stdio->outln('Enter the new password and press <Enter> (leave blank to leave as is.)');
                    $password = $stdio->in();
                    if ($password) {
                        $data['username'] = $password;
                    }
                    $stdio->outln('Enter the new email address and press <Enter> (leave blank to leave as is['.$user->getEmail().']).');
                    $email = $stdio->in();
                    if ($email) {
                        $data['username'] = $email;
                    }
                    $stdio->outln('Enter the new first name and press <Enter> (leave blank to leave as is['.$user->getFirstname().']).');
                    $firstname = $stdio->in();
                    if ($firstname) {
                        $data['username'] = $firstname;
                    }
                    $stdio->outln('Enter the new last name and press <Enter> (leave blank to leave as is['.$user->getLastname().']).');
                    $lastname = $stdio->in();
                    if ($lastname) {
                        $data['username'] = $lastname;
                    }
                } else {
                    if ( !is_null($context->argv->get(4))) {
                        $user_id = $context->argv->get(2);
                        $user = $user_repo->findById($user_id, 'id, username, email, firstname, lastname');
                        $data = array('username' => $context->argv->get(3),
                            'password' => $context->argv->get(4),
                            'email' => $context->argv->get(5),
                            'firstname' => $context->argv->get(6),
                            'lastname' => $context->argv->get(7));
                    } else {
                        $data = json_decode($context->argv->get(2), true);
                        $user_id = $data['id'];
                        $user = $user_repo->findById($user_id, 'id, username, email, firstname, lastname');
                        unset($data['id']);
                        if(!$data || is_null($data)) {
                            throw new \InvalidArgumentException('Invalid JSON in argv[2].');
                        }
                    }
                }

                $user->setUsername($data['username']);
                $user->setPassword($data['password']);
                $user->setEmail($data['email']);
                $user->setFirstname($data['firstname']);
                $user->setLastname($data['lastname']);

                $user->save();
                $user = $user_repo->findById($user_id, 'id, username, email, firstname, lastname');
                $stdio->outln('User updated as follows:');
                print_r($user->getVars(false));
            }
        );

        $dispatcher->setObject(
            'user-delete',
            function () use ($context, $stdio, $logger, $user_repo) {
                $stdio->outln('Enter the user ID and press <Enter>');
                $user_id = $stdio->in();
                $user = $user_repo->findById($user_id, 'id, username, email, firstname, lastname');
                if(!$user) {
                    $stdio->outln('User '.$user_id.' not found.');
                } else {
                    if($user_repo->delete($user->getId())) {
                        $stdio->outln('User '.$user_id.' was deleted.');
                    }
                }
            }
        );

        $this->modifyCliHelpService($di, 'user', 'Lists user data selected by unique id from repository.' .PHP_EOL . 'Argument (integer id)');
        $this->modifyCliHelpService($di, 'users', 'Lists all user data from the user repository. (No arguments)');
        $this->modifyCliHelpService($di, 'user-create', 'Create and store a user. Follow the prompts or:'.
            PHP_EOL.'Argument format: usernametest password email@emailtest.com firstnametest lastnametest'.
            PHP_EOL.'JSON format: \'{"username":"usernametest","password":"password","email":"email@emailtest.com","firstname":"firstnametest","lastname":"lastnametest"}\'');
        $this->modifyCliHelpService($di, 'user-update', 'Save data to an existing user. Follow the prompts or:'.
            PHP_EOL.'Argument format: id usernametest password email@emailtest.com firstnametest lastnametest'.
            PHP_EOL.'JSON format: \'{"id":5,"username":"usernametest","password":"password","email":"email@emailtest.com","firstname":"firstnametest","lastname":"lastnametest"}\'');
        $this->modifyCliHelpService($di, 'user-delete', 'Deletes user data selected by unique id from repository.' .PHP_EOL . 'Argument (integer id)');
    }

    /**
     * Function for setting entires in the Aura cli help menu.
     * @method modifyCliHelpService
     * @param  Container $di An Aura dependency injection container
     * @param  string $service The name/handle of the service we're adding
     * @param  string $summary A description to show in the help menu
     */
    protected function modifyCliHelpService(Container $di, $service, $summary)
    {
        $help_service = $di->get('aura/cli-kernel:help_service');

        $help = $di->newInstance('Aura\Cli\Help');
        $help_service->set($service, function () use ($help, $summary) {
            $help->setUsage(array('', '<noun>'));
            $help->setSummary($summary);
            return $help;
        });
    }

    /**
     * Initialize the Aura web router.
     * @method modifyWebRouter
     * @param  Container $di An Aura dependency injection container
     */
    public function modifyWebRouter(Container $di)
    {
        $router = $di->get('aura/web-kernel:router');

        $router->add('notimplemented', '/')
               ->setValues(array('action' => 'notimplemented'));
    }

    /**
     * Setting routes in the web dispatcher and initializing the service.
     * @method modifyWebDispatcher
     * @param  Container $di An Aura dependency injection container
     */
    public function modifyWebDispatcher($di)
    {
        $dispatcher = $di->get('aura/web-kernel:dispatcher');
        $user_repo = $di->get('user_repo');

        $dispatcher->setObject('notimplemented', function () use ($di) {
            $response = $di->get('aura/web-kernel:response');
            $response->status->set('404', 'Not Found');
            $response->content->set('HTTP Interface Not Implemented');
            $response->content->setType('text/plain');
        });

        // the url has no matching route
        $dispatcher->setObject('aura.web_kernel.missing_route', function () use ($di) {
            $response = $di->get('aura/web-kernel:response');
            $response->status->set('404', 'Not Found');
            $response->content->set('HTTP Interface Not Implemented');
            $response->content->setType('text/plain');
        });

        // the action was not found
        $dispatcher->setObject('aura.web_kernel.missing_action', function () use ($di) {
            $response = $di->get('aura/web-kernel:response');
            $response->status->set('404', 'Not Found');
            $response->content->set('HTTP Interface Not Implemented');
            $response->content->setType('text/plain');
        });

        // the kernel caught an exception
        $dispatcher->setObject('aura.web_kernel.caught_exception', function () use ($di) {
            $response = $di->get('aura/web-kernel:response');
            $response->status->set('404', 'Not Found');
            $response->content->set('HTTP Interface Not Implemented');
            $response->content->setType('text/plain');
        });
    }
}
