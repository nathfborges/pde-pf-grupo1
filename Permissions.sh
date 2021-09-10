#!/bin/bash
sudo chown -R "$USER":www-data .
sudo gpasswd -a "$USER" www-data
sudo find . -type d -exec chmod 775 {} \;
sudo find . -type f -exec chmod 664 {} \;
cd bin
sudo chmod u+x magento
sudo gpasswd -a "$USER" www-data
