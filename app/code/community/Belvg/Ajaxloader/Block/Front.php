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
 * @package    Belvg_Ajaxloader
 * @copyright  Copyright (c) 2010 - 2013 BelVG LLC. (http://www.belvg.com)
 * @license    http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
 */
class Belvg_Ajaxloader_Block_Front extends Mage_Adminhtml_Block_Template
{

    public function getCursorLoaderImage()
    {
        return Mage::helper('ajaxloader')->getCursorLoaderImage(); 
    }
    
    public function getOverlaySettings()
    {
        $helper = Mage::helper('ajaxloader');
        $color = $helper->getOverlayColor()?('#' . $helper->getOverlayColor()):NULL;
        $opacity = (float) $helper->getOverlayOpacity();
        if ($opacity > 1) {
            return 1;
        } elseif ($opacity < 0) {
            return 0;
        }
        
        $element = $helper->getOverlayElement();
        $loader = $helper->getMainLoaderImage();
        $loaderOpacity = $helper->getMainLoaderOpacity();
         
        return array(
            'color' => $color,
            'opacity' => $opacity,
            'element' => $element,
            'loader' => $loader,
            'loader_opacity' => $loaderOpacity
        );
    }
    
    public function isOnload()
    {
        return Mage::helper('ajaxloader')->isOnload();
    }
    
    public function getAnimationSpeed()
    {
        return Mage::helper('ajaxloader')->getAnimationSpeed();
    }
    
}