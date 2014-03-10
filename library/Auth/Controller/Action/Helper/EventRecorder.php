<?php
use Application\Entity\AccountEvent;
/**
 * Event action helper
 * Record account event such as logging in, logging out.
 *
 * @author Siwei Mu
 * @package Auth Module
 *
 */
class Auth_Controller_Action_Helper_EventRecorder extends Zend_Controller_Action_Helper_Abstract
{


    /**
     * Record event
     *
     * @author          Eddie Jaoude
     * @param           string $event name of the event to record
     * @param           int $user_id id of the user generating the event
     * @return           void
     *
     */
    public function record($event, $user_id)
    {
        $account_event = new AccountEvent();
        $account_event->setAccountId($user_id);
        $account_event->setEvent($event);
        
        $em = $this->getActionController()->getInvokeArg('bootstrap')->getResource('doctrine')->getEntityManager();
        $em->persist($account_event);
        $em->flush();
    }
}