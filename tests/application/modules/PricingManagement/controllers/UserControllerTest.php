<?php
require_once '../../../../../application/modules/PricingManagement/controllers/UserController.php';

require_once 'Zend/Test/PHPUnit/ControllerTestCase.php';

/**
 * UserController test case.
 */
class UserControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    /**
     *
     * @var UserController
     */
    private $UserController;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp ()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
        
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown ()
    {
        // TODO Auto-generated UserControllerTest::tearDown()
        $this->UserController = null;
        
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct ()
    {
        // TODO Auto-generated constructor
    }

    public function testCallWithoutActionShouldPullFromIndexAction()
    {
    	$this->dispatch('/user');
    	$this->assertController('user');
    	$this->assertAction('index');
    }
}

