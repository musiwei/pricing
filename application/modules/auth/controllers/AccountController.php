<?php

/**
 * Account Controller
 * 
 * @author Siwei Mu (musiwei.work@gmail.com)
 * @copyright Newton's Nerds
 * @since 24 Feb 2014
 * @version 1.0
 * @package Auth Module
 */
class Auth_AccountController extends Zend_Controller_Action
{

    /**
     * Initialisation method
     *
     * @author Siwei Mu
     * @param void
     * @return void
     *
     */
    public function init()
    {
        parent::init();
    }

    /**
     * initiates before any action is dispatched
     *
     * @param Siwei Mu
     * @return void
     */
    public function preDispatch()
    {
        # if the user is not logged in, they can not access secure pages
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            # redirect login page
            $this->_helper->redirector('denied', 'index', 'auth');
        }
    }

    /**
     * post dispatch method
     *
     * @author          Eddie Jaoude
     * @param void
     * @return void
     *
     */
    public function  postDispatch()
    {
        parent::postDispatch();
    }

    /**
     * default method
     *
     * @author Siwei Mu
     * @param void
     * @return void
     *
     */
    public function indexAction()
    {

    }

    /**
     * history method
     *
     * @author Siwei Mu
     * @param void
     * @return void
     *
     */
    public function eventAction()
    {
        

        $account = $this->_helper->DoctrineInit->getRepository('\Application\Entity\Account')->findOneBy(array('id' => Zend_Auth::getInstance()->getIdentity()->getId()));
        $events = $this->_helper->DoctrineInit->getRepository('\Application\Entity\Accountevent')->findBy(array('accountId' => Zend_Auth::getInstance()->getIdentity()->getId()));
        
        # send to view
        $this->view->events = $events;
        $this->view->account = $account;
    }

    /**
     * Fetch event to popolate into datatable method
     *
     * @author Siwei Mu
     * @param void
     * @return void
     *
     */
    public function fetcheventAction ()
    {
        # get account events
        $events = $this->_helper->DoctrineInit->getRepository('\Application\Entity\Accountevent')->findBy(array('accountId' => Zend_Auth::getInstance()->getIdentity()->getId()));
    	
        $aColumns = array( 'event', 'happened_at' );
        
        if ( isset( $_GET['iSortCol_0'] ) )
        {
        	$sOrder = "ORDER BY  ";
        	for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
        	{
        		if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
        		{
        			$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
				 	".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
        		}
        	}
        
        	$sOrder = substr_replace( $sOrder, "", -2 );
        	if ( $sOrder == "ORDER BY" )
        	{
        		$sOrder = "";
        	}
        }
        
        # array that datatable accepts
        $output = array(
        		"sEcho" => intval($_GET['sEcho']),
        		"iTotalRecords" => $iTotal,
        		"iTotalDisplayRecords" => $iFilteredTotal,
        		"aaData" => array()
        );
        
        $form = new Auth_Form_Login();
    	$form->isValid($this->_getAllParams());
    	$this->_helper->json($form->getMessages());
    }


}