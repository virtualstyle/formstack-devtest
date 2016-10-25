# Formstack Software Engineer Assignment

## Development Process

- Followed directions from the [formstack server-playbooks-devtest](https://github.com/formstack/server-playbooks-devtest)

- Struggled a bit trying to get the VM running consistently on Ubuntu 16.04 (also Win 10, the two bootable disks I have available to me, and I'm *totally* on board with the single OS for all developers concept now, if I wasn't before, because this took the *majority* of the time I spent on this project). The primary issues were updating multiple software versions, killing ssh-agent and net-ssh procs, and apparently nonstandard NFS ports, since enabling UDP NFS requests in UFW didn't work and I finally just disabled UFW altogether.

- Put together the development tools config files, directory & file structure, and made the Phinx migration for my initial commit.

- Decided on a repository pattern for the model/domain/data abstraction layer, started test driven development with PHPUnit, got Docblocks in place, refined build tools, autoloading, and build process, checked progress with PHPDocumentor and PHPUnit-coverage. Kept code in style bounds with php-cs-fixer, made data seed for stable/wipable/restorable test data for the user table in Phinx.

## Instructions

- Clone the repo to your target machine
```
git clone https://github.com/virtualstyle/formstack-devtest.git
```
- Spin up vagrant VM
```
vagrant up
```
Note - you might need to reload and or vagrant up --provision a time or two, like I said, I had problems with the VM, I didn't change the vagrantfile, and I hope the issues were all due to my OS difference.

- Navigate to the repo clone folder (either locally or on the VM) and run composer install
```
composer install
```
Note - option --no-dev will eschew some of the composer dependency installs

- I've included a makefile for convenience. The following commands will get the help info like below:
```
make
#or
make help

tests                  Executes the Unit tests
docs                   Executes PHPDocumentor
migrate                Executes the Phinx migrate
rollback               Executes the Phinx rollback
coverage               Creates the Coverage reports
cs                     Executes the PHP CS Fixer
git                    Executes Git add/commit/push
```

These commands can be used to create and destroy the mysql table and test data, build the PHPDocs, execute the PHPUnit tests, and build the PHPUnit code coverage report, as well as fix any code styling mistakes and add, commit, & push the git repo. Unit tests should only be run after a fresh migrate to ensure test data integrity. Also, you'll need to set your git remote for git commands to work.
