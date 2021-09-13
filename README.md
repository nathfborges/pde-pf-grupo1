# Final project - Group 1

## To install the project from zero
- Create again the folder
- Run "git init" to initialize git repository
- Run "git remote add origin git@github.com:nathfborges/pde-pf-grupo1.git" to add repo to remote
- Run "git fetch" to update repo files and branchs
- Run "git checkout develop" to go to develop branch
- Run "composer install" to install composer dependencies
- Run "sh permissions.sh" to run permissions comand before instalation
- Run "setup:install" with yours arguments **and "--cleanup-database" argument** at the end.
* Maybe you got a "Connection "default" is not defined" error, if you got, run your "setup:install" command again, but **without "--cleanup-database" argument**.
- Run "addProducts.sh" to finish the instalation, maybe this command takes more time to run.

## To reinstall the project, if are already installed
- Delete "env.php" file inside "app/etc/"
- Run "setup:install" with yours arguments **and "--cleanup-database" argument** at the end.
* Maybe you got a "Connection "default" is not defined" error, if you got, run your "setup:install" command again, but **without "--cleanup-database" argument**.