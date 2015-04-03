<?php
/**
 * BelVG LLC.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
 *
 *******************************************************************
 * @category   Belvg
 * @package    Belvg_Zendeskint
 * @version    1.0.0
 * @copyright  Copyright (c) 2010 - 2012 BelVG LLC. (http://www.belvg.com)
 * @license    http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
 */
class Belvg_Zendeskint_AccountController extends Mage_Core_Controller_Front_Action
{
    
    public function indexAction()
    {
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $this->loadLayout();
            $this->renderLayout();
        } else {
            $this->_redirect('customer/account/login');
        }
    }
    
    public function createZendeskUser($customer)
    {
        $username = Mage::getStoreConfig('zendeskint/settings/agent');
        $token = Mage::getStoreConfig('zendeskint/settings/token');
        $url = Mage::getStoreConfig('zendeskint/settings/domain') . '/api/v2/users.json';
        $headers = array( "Content-Type: application/json" );
        $data = array( "user" => array( "name" => $customer->getFirstname() . ' ' . $customer->getLastname(),
                                        "email" => $customer->getEmail() ));
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $username . '/token:' . $token);
             
        $result = curl_exec($ch);
        $ch_error = curl_error($ch);
        curl_close($ch);

        $result = (array)json_decode($result);
        Mage::getSingleton('core/session')->setZendeskUser($result);
    }
    
    public function ssoAction()
    {
        if ($user = Mage::getSingleton('core/session')->getZendeskUser()) {
            $token = Mage::getStoreConfig('zendeskint/settings/auth_token');

            $now = time();
            $jti = md5($now . rand());
            $params = array(
                "iat" => $now,
                "jti" => $jti,
                "name" => $user['name'],
                "email" => $user['email']
            );
            
            $jwt = Zendesk_JWT::encode($params, $token);
            $url = Mage::getStoreConfig('zendeskint/settings/domain') . "/access/jwt?jwt=" . $jwt;
            $this->_redirectUrl($url);
        } else {
            $this->_redirect('customer/account/login');
        }
    }
    
}