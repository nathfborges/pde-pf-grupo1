#!/bin/bash
bin/magento deploy:mode:set developer
bin/magento ibc:csv:products
bin/magento catalog:images:resize
bin/magento indexer:reindex
bin/magento ok:urlrewrites:regenerate --entity-type=category
sudo chown -R "$USER":www-data .