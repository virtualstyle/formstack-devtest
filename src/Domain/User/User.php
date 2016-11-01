<?php
/**
 * This file is part of virtualstyle/formstack-devtest.
 * https://github.com/virtualstyle/formstack-devtest.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace Virtualstyle\FormstackDevtest\Domain\User;

use Virtualstyle\FormstackDevtest\Domain\Repository as Repository;

/**
 * User object handles the application facing side of the data Domain.
 */
class User implements UserInterface
{
    /**
     * Id index generated by the repository.
     *
     * @var int Unique object Identifier
     */
    protected $id;

    /**
     * Username string.
     *
     * @var string Username 64 character string
     */
    protected $username;

    /**
     * Password string.
     *
     * @var string Password 128 character string
     */
    protected $password;

    /**
     * Email string (NOTE: I presumed to change the name of the first "Email"
     * on the assignment, and use the second,"Email Address" for the email).
     *
     * @var string Email address valid email address string
     */
    protected $email;

    /**
     * Firstname string.
     *
     * @var string Firstname 32 character string
     */
    protected $firstname;

    /**
     * Lastame string.
     *
     * @var string Lastname 32 character string
     */
    protected $lastname;

    /**
     * Repo UserRepository.
     *
     * @var UserRepository UserRepository interface
     */
    protected $repo;

    /**
     * Boolean updated flag.
     *
     * @var bool Flag to track unsaved changes
     */
    protected $updated = false;

    /**
     * These should probably be in a class, or at least a file, of their own,
     * but in the short term that caused a problem with PHPUnit's error handling
     * so I just moved them back here. Ostensibly, I COULD just put the strings
     * back in place of the class constants, but I find this more readable, and
     * a reminder of the proper direction to go with abstracting them.
     */
    const ERR_MSG_EMPTY_DATA =
        'All data fields are required (username, password, email, firstname, lastname).';
    const ERR_MSG_BAD_USERNAME =
        'The username cannot be blank and must be a string of less than 65 characters.';
    const ERR_MSG_BAD_PASSWORD =
        'The password cannot be blank and must be a string of less than 129 characters.';
    const ERR_MSG_BAD_EMAIL =
        'The email cannot be blank and must be a valid email string of less than 255 characters.';
    const ERR_MSG_BAD_FIRSTNAME =
        'The firstname cannot be blank and must be a string of less than 33 characters.';
    const ERR_MSG_BAD_LASTNAME =
        'The lastname cannot be blank. and must be a string of less than 33 characters.';

    /**
     * User constructor.
     *
     * @method __construct
     *
     * @param array $data An array of user data
     */
    public function __construct(array $data = array())
    {
        $validate_password = true;

        if (isset($data['validate_password'])) {
            $validate_password = $data['validate_password'];
        }

        if ($this->validateData($data, $validate_password) === true) {
            if (!isset($data['id'])) {
                $this->id = null;
            } else {
                $this->id = $data['id'];
            }
            $this->username = $data['username'];
            if ($validate_password) {
                $this->password = $data['password'];
            }
            $this->email = $data['email'];
            $this->firstname = $data['firstname'];
            $this->lastname = $data['lastname'];
            if (!isset($data['updated'])) {
                $this->updated = false;
            } else {
                $this->updated = $data['updated'];
            }
        }
    }

    /**
     * Inject a repository interface.
     *
     * @method setRepo
     *
     * @param UserRepository $repo UserRepository interface
     */
    public function setRepo(Repository\UserRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Expose the repository interface.
     *
     * @method getRepo
     *
     * @return UserRepository
     */
    public function getRepo()
    {
        return $this->repo;
    }

    /**
     * Set the id data member.
     *
     * @method setId
     *
     * @param mixed $id An id to set this object's id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Expose the id data member.
     *
     * @method getId
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the username data member.
     *
     * @method setUsername
     *
     * @param string $username A string to set username data member
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Expose the username data member.
     *
     * @method getUsername
     *
     * @return int
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the password data member.
     *
     * @method setUsername
     *
     * @param string $password A string to set password data member
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Set the email data member.
     *
     * @method setEmail
     *
     * @param string $email A string to set email data member
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Expose the email data member.
     *
     * @method getEmail
     *
     * @return int
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the firstname data member.
     *
     * @method setFirstname
     *
     * @param string $firstname A string to set firstname data member
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * Expose the firstname data member.
     *
     * @method getFirstname
     *
     * @return int
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the lastname data member.
     *
     * @method setLastname
     *
     * @param string $lastname A string to set lastname data member
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Expose the lastname data member.
     *
     * @method getLastname
     *
     * @return int
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Return object variables.
     *
     * @method getVars
     *
     * @param bool $return_password A flag to indicate to return password
     *
     * @return array
     */
    public function getVars(bool $return_password = true)
    {
        $vars = get_object_vars($this);
        unset($vars['repo']);
        unset($vars['updated']);
        if (is_null($vars['id'])) {
            unset($vars['id']);
        }
        if (!$return_password) {
            unset($vars['password']);
        }

        return $vars;
    }

    /**
     * Save this user in the data store.
     *
     * @method save
     */
    public function save()
    {
        if (is_null($this->id)) {
            if ($this->validateData($this->getVars()) === true) {
                $id = $this->repo->insert($this);
            }
        } else {
            if ($this->validateData($this->getVars(!is_null($this->password)), !is_null($this->password)) === true) {
                $this->repo->update($this, !is_null($this->password));
                $id = true;
            }
        }

        return $id;
    }

    /**
     * Validate User object data state.
     *
     * @method validateData
     *
     * @param array $data              An array of values indexed by field name
     * @param bool  $validate_password A flag indicating to validate password
     *
     * @return bool
     */
    public function validateData(array $data, bool $validate_password = true)
    {
        if (empty($data)) {
            throw new \InvalidArgumentException(self::ERR_MSG_EMPTY_DATA);
        }
        if (!isset($data['username'])
            || $data['username'] === ''
            || strlen($data['username']) > 64
        ) {
            throw new \InvalidArgumentException(self::ERR_MSG_BAD_USERNAME);
        }
        if ($validate_password && (!isset($data['password'])
            || $data['password'] === ''
            || strlen($data['password']) > 128
        )) {
            throw new \InvalidArgumentException(self::ERR_MSG_BAD_PASSWORD);
        }
        if (!isset($data['email'])
            || $data['email'] === ''
            || strlen($data['email']) > 254
            || filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false
        ) {
            throw new \InvalidArgumentException(self::ERR_MSG_BAD_EMAIL);
        }
        if (!isset($data['firstname'])
            || $data['firstname'] === ''
            || strlen($data['firstname']) > 32
        ) {
            throw new \InvalidArgumentException(self::ERR_MSG_BAD_FIRSTNAME);
        }
        if (!isset($data['lastname'])
            || $data['lastname'] === ''
            || strlen($data['lastname']) > 32
        ) {
            throw new \InvalidArgumentException(self::ERR_MSG_BAD_LASTNAME);
        }

        return true;
    }
}
