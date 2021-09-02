# Final project - Group 1

## To reinstall the project
- Delete the project folder
- Create again the folder
- Run "git init" to initialize git repository
- Run "git remote add origin git@github.com:nathfborges/pde-pf-grupo1.git" to add repo to remote
- Run "git fetch" to update repo files and branchs
- Run "git checkout develop" to go to develop branch
- Run "composer install" to install composer dependencies
- Run "setup:install" with yours arguments **and "--cleanup-database" argument** at the end.
* Maybe you got a "Connection "default" is not defined" error, if you got, run your "setup:install" command again, but **without "--cleanup-database" argument**.