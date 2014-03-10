<?php

class IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }
    
    /**
     * User log in action, default parameters are valid credentials
     *
     * @author          Siwei Mu
     * @param           string $user
     * @param           string $password
     * @return          void
     *
     */
    public function loginUser ($user = 'msw0629@gmail.com', $password ='123')
    {
    	$this->request->setMethod('POST')->setPost(
    			array(
    					'email' => $user,
    					'password' => $password
    			));
    	$this->dispatch('/en/auth/login');
    	$this->assertRedirectTo('/en/auth');
    
    	$this->resetRequest()->resetResponse();
    
    	$this->request->setPost(array());
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
    	$this->dispatch('/en/auth/index');
    	$this->assertModule('auth');
    	$this->assertController('index');
    	$this->assertAction('index');
    }
    
    /**
     * Test case: page should redirect to home page
     *
     * @author          Siwei Mu
     * @param           void
     * @return          void
     *
     */
    public function testPageShouldRedirectToHomePage()
    {
    	$this->dispatch('/en/auth/index');
    	$this->assertRedirectTo('/en/');
    }

}

