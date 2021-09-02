##### Hi, friend. How are u doing? I hope you r ok.
So...
This folder contains files that modify our site's database :)
We use the class DataPatchInterface, and it's necessary some steps to run this.

##Steps
First -> After pulling the branch, you need run:
     `composer update`
Second -> Then, you need run:
    `bin/magento setup:install`

You should already see the changes:)
 

## Script

In the directory root, you should see DataPatch.sh. 
Verify if all permissions are ok, use:
`sudo chown -R "$USER":www-data .`

This script will run all necessary commands, so run:
`sh DataPatch.sh`
 
## Attention, if the file's datapatch has already been run and you want to run it again:
In the database of your store, the table 'patch_list' will contain all datapatch executions.
Delete all lines referring "WEBJUMP_BACKEND" and execute the commands/script again.
BE CAREFUL!!!