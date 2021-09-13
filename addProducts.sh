#!/bin/bash
sudo chown -R "$USER":www-data .
bin/magento deploy:mode:set developer
bin/magento ibc:csv:products
bin/magento catalog:images:resize
bin/magento indexer:reindex
bin/magento ok:urlrewrites:regenerate --entity-type=category