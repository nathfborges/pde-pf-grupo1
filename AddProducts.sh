#!/bin/bash
bin/magento ibc:csv:products
bin/magento catalog:images:resize
bin/magento indexer:reindex

