# Formstack Software Engineer Assignment

## Development Tools:

- As given, PHPUnit (Image was complaining about php-dom, which installing php-xml fixed)
- As given, Vagrant and the bento/Ubuntu-16.04 image
- As suggested, Composer for dependency management and autoloading
- As suggested, Phinx for rapid setup and teardown of test data table and seed data
- Php-cs-fixer for automated PSR-2 compliance and other code maintenance benefits
- Phpunit- coverage for ensuring/inspecting code coverage of PHPUnit tests
- Phpdocumentor for checking Docblocks
- Make for shortening repetitive console commands
- Aura/cli-project a package to handle cli routing, dependency injection, and dispatching.


## Development Process

- Followed directions from the [formstack server-playbooks-devtest](https://github.com/formstack/server-playbooks-devtest)

- Troubleshooting the Vagrant image lost me a couple of days. The primary issues were:
    - Software versions (Vagrant/VirtualBox/GuestAdditions - the vagrant-guestadditions plugin saved this)
    - SSH authentication (pkilled ssh-agent and net-ssh on host machine)
    - NFS file synch failures (Enabling UDP NFS requests in UFW didn't work and I finally just disabled UFW altogether. **Not** an ideal solution but the time pressures were elsewhere).
    - There might have been other issues because it looks like the image was updated during this development, and thus could have resolved some issues.


- Decided on a repository pattern for the model/domain/data abstraction layer as a reasonably forward-looking persistence agnostic solution for decoupling storage implementation dependencies from the application objects. This will allow unlimited abstract storage systems to interact with the application. For the MySQL adapter, I chose PDO for the same reasons. PDO can be used on top of numerous databases, and so allows significant flexibility to the application.

- Went back and forth some with naming conventions and file organization. Finally decided to go with the PSR group's bylaws, which many argue against (one article writer even suggested using the "interface" suffix was enough to get one fired at his office), but since I'm following their standards, I figure their bylaws will do as well. Besides, I find the "Hungarian Notation" to be more readable when type hinting, even if it's semantically debatable.

- Tried to stick to setter injection for future flexibility.

- Tried to type hint as much as feasible, except where it would prevent implementation polymorphism.

- Delegated error handling, leaving it to PHP or a consumer application for handling, including letting PDO errors bubble through PHP. Also tried to adhere to HTTP errors where possible in the controllers.

- Spent a good bit of time trying to write my own implementation of the PSR-7 interfaces, realized time was short, and decided to use aura/cli-kernel, which provides routing, standard input and output, dependency injection, and dispatching for cli php apps. I left the application setup to branch to aura/web-kernel for HTTP requests, but that isn't implemented yet. ***The logic for the cli application is in ./Config/Common.php.***

## Build/Test Instructions

- Clone the repo to your target machine

```
git clone https://github.com/virtualstyle/formstack-devtest.git
```

- Navigate to the repo clone folder (either locally or spin up the vagrant VM) and run composer install

```
#To spin up and load a VM console:
vagrant up && vagrant ssh

composer install
```
- I've included a makefile for convenience - make or make help will get the help info:

```
make

#or

make help

#Resulting console output:

Please use 'make <target>' where <target> is one of
  test                   Rollback, Migrate, and Tests

  all                    As above, but also build PHPDocs and
                         PHPUnit Coverage report

  doc                    Build PHPDocs and PHPUnit coverage report

  cs                     Executes the PHP CS Fixer on src and tests

  tests                  Executes the Unit tests
  docs                   Executes PHPDocumentor
  migrate                Executes the Phinx migrate
  rollback               Executes the Phinx rollback
  coverage               Creates the Coverage reports
  cssrc                  Executes the PHP CS Fixer on src folder
  csstests               Executes the PHP CS Fixer on tests folder
  gitadd                 Executes Git add
  gitcommit              Executes Git commit
  gitpush                Executes Git push
  php-xml                Enables php-xml extension for PHPUnit
  log-init               Initializes default log directories



```

The primary commands are:
```
make cv #Destroy and build test db, run tests and make coverage report
make test #Destroy and build test db, run tests
make docs #Run PHPDocumentor
make cs #Fix coding style to adhere to PSR-2
```
These commands can be passed to make to create and destroy the MySQL table and test data, build the PHPDocs, execute the PHPUnit tests, and build the PHPUnit code coverage report, as well as fix any code styling mistakes, add, commit, & push the Git repo, and initialize and set the permissions of the log directories and files. Docs, coverage reports, and Phinx migrations and seeds are in the /build directory.

Coverage report: http://testbox.dev/build/coverage/
PHPDocs: http://testbox.dev/build/docs/

***NOTE - PHPUnit requires php-xml to install and run. Composer does not manage PHP extensions, so I added a make entry.***

***NOTE - Added the log-init make command to try and handle permission/ownership issues with logging.***

***NOTE - Unit tests should only be run after a fresh migrate to ensure test data integrity.***

***NOTE - You'll need to set your git remote for git remote commands to work properly.***

## Application Instructions

From the repo clone directory, execute:
```
php index.php

#OR

php index.php help
```
to see the following help menu:
```
help
    Gets the available commands, or the help for one command.
user
    Lists user data selected by unique id from repository.
Argument (integer id)
user-create
    Create and store a user. Follow the prompts or:
Argument format: usernametest password email@emailtest.com firstnametest lastnametest
JSON format: '{"username":"usernametest","password":"password","email":"email@emailtest.com","firstname":"firstnametest","lastname":"lastnametest"}'
user-delete
    Deletes user data selected by unique id from repository.
Argument (integer id)
user-update
    Save data to an existing user. Follow the prompts or:
Argument format: id usernametest password email@emailtest.com firstnametest lastnametest
JSON format: '{"id":5,"username":"usernametest","password":"password","email":"email@emailtest.com","firstname":"firstnametest","lastname":"lastnametest"}'
users
    Lists all user data from the user repository. (No arguments)
```

sample commands for cut and paste:
```
#List all user data
php index.php users

#View a user by id (Enter valid user ID at prompt)
php index.php user

#update a user(Enter valid user ID and data to be changed at prompt)
php index.php user-update
#Or
php index.php user-update id usernametest password email@emailtest.com firstnametest lastnametest
#Or
php index.php user-update '{"id":5,"username":"usernametest","password":"password","email":"email@emailtest.com","firstname":"firstnametest","lastname":"lastnametest"}'

#Create a user (Enter valid user data at prompt)
php index.php user-create
#Or
php index.php user-create usernametest password email@emailtest.com firstnametest lastnametest
#Or
php index.php user-create '{"username":"usernametest","password":"password","email":"email@emailtest.com","firstname":"firstnametest","lastname":"lastnametest"}'

#Delete a user (Enter valid user ID at prompt)
php index.php user-delete
```
