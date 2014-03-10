<?php

class LoginControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
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
    	$this->dispatch('/en/auth/login');
    	$this->assertModule('auth');
    	$this->assertController('login');
    	$this->assertAction('index');
    }
    
    /**
     * Test case: login page should contain login form
     *
     * @author          Siwei Mu
     * @param           void
     * @return          void
     *
     */
    public function testLoginPageShouldContainLoginForm()
    {
    	$this->dispatch('/en/auth/login');
    	$this->assertNotRedirect();
    	$this->assertQuery('form#loginForm');
    }

    /**
     * Test case: invalid credentials should result in rediplay of login Form
     *
     * @author          Siwei Mu
     * @param           void
     * @return          void
     *
     */
    public function testInvalidCredentialsShouldResultInRedisplayOfLoginForm()
    {
        $request = $this->getRequest();
        $request->setMethod('POST')
                ->setPost(array(
                    'email' => 'bogus',
                    'password' => 'reallyReallyBogus',
                ));
        $this->dispatch('/en/auth/login');
        $this->assertNotRedirect();
        $this->assertQuery('form');
    }
    
    /**
     * Test case: valid login should redirect to home page
     *
     * @author          Siwei Mu
     * @param           void
     * @return          void
     *
     */
    public function testValidLoginShouldRedirectToHomePage()
    {
    	$this->loginUser();
    }
}

