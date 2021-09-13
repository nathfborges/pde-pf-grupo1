#!/bin/bash
bin/magento ibc:csv:backend
bin/magento catalog:images:resize
bin/magento indexer:reindex

