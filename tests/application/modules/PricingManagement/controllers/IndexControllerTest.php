<?php

class IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }
    
    /**
     * Test case: call without action should pull from index action
     *
     * @author          Siwei Mu
     * @param           void
     * @return          void
     *
     */
    public function testCallShouldMatchRoute()
    {
    	$this->dispatch('/');
    	# match with route name which was defined in bootstrap
    	$this->assertRoute('default');
    }
    
    /**
     * Test case: call without action should pull from index action
     *
     * @author          Siwei Mu
     * @param           void
     * @return          void
     *
     */
    public function testCallWithoutActionShouldPullFromIndexAction()
    {
    	$this->dispatch('/');
    	$this->assertController('index');
    	$this->assertAction('index');
    }
    
    /**
     * Test case: call valid language code should pull from index action
     *
     * @author          Siwei Mu
     * @param           void
     * @return          void
     *
     */
    public function testCallValidLanguageCodeOnlyShouldPullFromIndexAction()
    {
    	$this->dispatch('/en');
    	$this->assertController('index');
    	$this->assertAction('index');
    }
    
    /**
     * Test case: call full route to index action should pull from index action
     *
     * @author          Siwei Mu
     * @param           void
     * @return          void
     *
     */
    public function testCallFullRouteToIndexActionShouldPullFromIndexAction()
    {
    	$this->dispatch('/en/Pricingmanagement/index/index');
    	$this->assertController('index');
    	$this->assertAction('index');
    }
    
    /**
     * Test case: call non-existing page should trigger error
     *
     * @author          Siwei Mu
     * @param           void
     * @return          void
     *
     */
    public function testCallNonExistingActionShouldTriggerError()
    {
    	$this->dispatch('/en/Pricingmanagement/index/anActionWhichDoesntExistAtAll7894515736941');
    	$this->assertController('error');
    	$this->assertAction('error');
    	$this->assertResponseCode(404, $message = '123');
    }
    


}

