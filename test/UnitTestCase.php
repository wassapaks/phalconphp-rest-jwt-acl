<?php
use PhalconRestJWT\App\Di;
use Phalcon\Config;
use Phalcon\Test\UnitTestCase as PhalconTestCase;

abstract class UnitTestCase extends PhalconTestCase
{
    /**
     * @var bool
     */
    private $_loaded = false;



    public function setUp()
    {
        parent::setUp();

        // Load any additional services that might be required during testing
        $configPath = CONFIG_DIR . '/config.' . APP_ENV . '.php';

        // Create Config
        $config = new Config(include $configPath);
        // Generate DI 
        $di = new Di($config);
        // Get any DI components here. If you have a config, be sure to pass it to the parent
        $this->setDi($di);

        $this->_loaded = true;
    }

    /**
     * Check if the test case is setup properly
     *
     * @throws \PHPUnit_Framework_IncompleteTestError;
     */
    public function __destruct()
    {
        if (!$this->_loaded) {
            throw new \PHPUnit_Framework_IncompleteTestError(
                "Please run parent::setUp()."
            );
        }
    }
}