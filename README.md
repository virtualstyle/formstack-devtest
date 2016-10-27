# Formstack Software Engineer Assignment

## Development Process

- Followed directions from the [formstack server-playbooks-devtest](https://github.com/formstack/server-playbooks-devtest)

- Struggled a bit trying to get the VM running consistently on Ubuntu 16.04 (also Win 10, the two bootable disks I have available to me, and I'm *totally* on board with the single OS for all developers concept now, if I wasn't before, because this took too large a chunk of the time I spent on this project). The primary issues were updating multiple software versions, killing ssh-agent and net-ssh procs, and apparently nonstandard NFS ports, since enabling UDP NFS requests in UFW didn't work and I finally just disabled UFW altogether (**not** an ideal solution but the time pressures are elsewhere right now).

- Put together the development tools config files, directory & file structure, and made the Phinx migration for my initial commit.

- Decided on a repository pattern for the model/domain/data abstraction layer, started test driven development with PHPUnit and fleshed out a draft, got Docblocks in place, refined build tools, autoloading, and build process, checked progress with PHPDocumentor and PHPUnit-coverage. Kept code in style bounds with php-cs-fixer, made data seed in Phinx for stable/wipable/restorable test data for the user table.

- Reworked file & directory structure, naming, and namespacing to something that seems more logical to me, though I suppose some might complain about the names of some of the files being the same. But with namespacing, I think it's pretty clear where everything stands in relation, and this is what feels the most logical.

## Instructions

- Clone the repo to your target machine

```
git clone https://github.com/virtualstyle/formstack-devtest.git
```
- Spin up vagrant VM

```
vagrant up
```
- Navigate to the repo clone folder (either locally or on the VM) and run composer install

```
composer install
```
- I've included a makefile for convenience. The following commands will get the help info:

```
make

#or

make help

#Resulting console output:

tests                  Executes the Unit tests
docs                   Executes PHPDocumentor
migrate                Executes the Phinx migrate
rollback               Executes the Phinx rollback
coverage               Creates the Coverage reports
cs                     Executes the PHP CS Fixer
gitadd                 Executes Git add
gitcommit              Executes Git commit
gitpush                Executes Git push
php-xml                Enables php-xml extension for PHPUnit
```

These commands can be passed to make to create and destroy the MySQL table and test data, build the PHPDocs, execute the PHPUnit tests, and build the PHPUnit code coverage report, as well as fix any code styling mistakes and add, commit, & push the Git repo. Docs and coverage reports are in the /build directory. Phinx migrations and seeds are in the tests directory.

***NOTE* - PHPUnit requires php-xml to install and run. Composer does not manage PHP extensions, so I added a make entry.**

***NOTE* - Unit tests should only be run after a fresh migrate to ensure test data integrity.**

***NOTE* - You'll need to set your git remote for git remote commands to work properly.**
