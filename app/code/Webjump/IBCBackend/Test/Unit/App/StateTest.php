<?php
namespace Webjump\IBCBackend\Test\Unit\App;

use Exception;
use Webjump\IBCBackend\App\State;
use Magento\Framework\Config\ScopeInterface;
use PHPUnit\Framework\TestCase;

class StateTest extends TestCase
{
    private $configScopeMock;
    private $customState;

    protected function setUp(): void
    {
        $this->configScopeMock = $this->createMock(ScopeInterface::class);
        $this->customState = new State($this->configScopeMock);
    }

    public function testValidateAreaCode () {
        try {
            $this->customState->getAreaCode();
            $this->assertEquals(true, $this->customState->validateAreaCode());
        } catch (Exception $exception) {
            $this->assertEquals(false, $this->customState->validateAreaCode());
        }
    }
}
