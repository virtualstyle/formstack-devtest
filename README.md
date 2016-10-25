# Formstack Software Engineer Assignment

## Initial Steps

- Followed directions from the [formstack server-playbooks-devtest](https://github.com/formstack/server-playbooks-devtest)

- Struggled a bit trying to get the VM running consistently on Ubuntu 16.04 (also Win 10, the two bootable disks I have available to me, and I'm *totally* on board with the single OS for all developers concept now, if I wasn't before, this took the *majority* of the time I spent on this project). The primary issues were updating multiple software versions, killing ssh-agent and net-ssh procs, and apparently nonstandard NFS ports, since enabling UDP NFS requests in UFW didn't work and I finally just disabled UFW altogether.

- Put together the directory and file structure for my initial commit, made the table in MySQL, and made the Phinx migration.



