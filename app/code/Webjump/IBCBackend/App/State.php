<?php
namespace Webjump\IBCBackend\App;

use Magento\Framework\App\State as AppState;

class State extends AppState
{

    public function validateAreaCode()
    {
        if (!isset($this->_areaCode)) {
            return false;
        }
        return true;
    }
}
