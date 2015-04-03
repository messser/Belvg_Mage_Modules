<?php
/*
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
 * @copyright  Copyright (c) 2010 - 2015 BelVG LLC. (http://www.belvg.com)
 * @license    http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
 */
class Belvg_Ajaxloader_Helper_Data extends Mage_Core_Helper_Abstract
{
    
    const MEDIA_FOLDER = 'ajaxloader';
    
    public function isEnabled()
    {
        return Mage::getStoreConfigFlag('ajaxloader/settings/enabled');
    }
    
    public function isOnload()
    {
        return Mage::getStoreConfigFlag('ajaxloader/settings/onload');
    }
    
    public function isCursorLoaderEnabled()
    {
        return Mage::getStoreConfigFlag('ajaxloader/settings/cursor_loader_enabled');
    }
    
    public function getCursorLoaderImage()
    {
        if (!$this->isCursorLoaderEnabled()) {
            return FALSE;
        }
        
        return Mage::getBaseUrl('media') . self::MEDIA_FOLDER . DS . Mage::getStoreConfig('ajaxloader/settings/cursor_loader_image');
    }
    
    public function getOverlayColor()
    {
        $color = Mage::getStoreConfig('ajaxloader/settings/overlay_color');
        
        return ($this->isEnabled() && Mage::getStoreConfig('ajaxloader/settings/overlay_enabled')) ? $color : NULL;
    }
    
    public function getOverlayOpacity()
    {
        return Mage::getStoreConfig('ajaxloader/settings/overlay_opacity');
    }
    
    public function getOverlayElement()
    {
        return Mage::getStoreConfig('ajaxloader/settings/overlay_element');
    }
    
    public function isMainLoaderEnabled()
    {
        return Mage::getStoreConfigFlag('ajaxloader/settings/main_loader_enabled');
    }
    
    public function getMainLoaderImage()
    {
        if (!$this->isMainLoaderEnabled()) {
            return FALSE;
        }
        
        return Mage::getBaseUrl('media') . self::MEDIA_FOLDER . DS . Mage::getStoreConfig('ajaxloader/settings/main_loader_image');
    }
    
    public function getMainLoaderOpacity()
    {
        return Mage::getStoreConfig('ajaxloader/settings/main_loader_opacity');
    }
    
    public function getAnimationSpeed()
    {
        return (int) Mage::getStoreConfig('ajaxloader/settings/animation_speed');
    }
    
}