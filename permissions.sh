#!/bin/bash
sudo find . -type d -exec chmod 775 {} \;
sudo find . -type f -exec chmod 664 {} \;
sudo gpasswd -a "$USER" www-data
sudo chown -R "$USER":www-data .
cd bin
sudo chmod u+x magento
