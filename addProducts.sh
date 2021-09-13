#!/bin/bash
bin/magento ibc:csv:products
bin/magento catalog:images:resize
bin/magento indexer:reindex
bin/magento deploy:mode:set developer
bin/magento ok:urlrewrites:regenerate --entity-type=category
