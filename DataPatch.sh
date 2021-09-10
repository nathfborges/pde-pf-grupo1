#!/bin/bash
echo "Script - DataPatch"
composer update
bin/magento setup:upgrade
sudo chown -R "$USER":www-data .
