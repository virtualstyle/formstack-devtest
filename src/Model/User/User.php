<?php
/**
 * User object business logic.
 */
namespace Virtualstyle\FormstackDevtest\Model\User;

use Virtualstyle\FormstackDevtest\Model\Repository as Repository;

/**
 * User object handles the application facing side of the data model.
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
     * Password hash string.
     *
     * @var string Hashed password string
     */
    protected $password_hash;

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
        if ($this->validateData($data) === true) {
            if (!isset($data['id'])) {
                $this->id = null;
            } else {
                $this->id = $data['id'];
            }
            $this->username = $data['username'];
            $this->password = $data['password'];
            $this->password_hash = null;
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
     * Return object variables.
     *
     * @method getVars
     *
     * @return array
     */
    public function getVars()
    {
        $vars = get_object_vars($this);
        unset($vars['password_hash']);
        unset($vars['repo']);
        unset($vars['updated']);
        if (is_null($vars['id'])) {
            unset($vars['id']);
        }

        return $vars;
    }

    /**
     * Validate User object data state.
     *
     * @method validateData
     *
     * @param array $data An array of values indexed by field name
     *
     * @return bool
     */
    protected function validateData(array $data)
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
        if (!isset($data['password'])
            || $data['password'] === ''
            || strlen($data['password']) > 128
        ) {
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
