<?php

/**
 * Simipwa Helper
 */

namespace Elsner\Pwa\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\ObjectManagerInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    public $objectManager;
    public $filesystem;
    protected $_storeManager;

    public function __construct(
        Context $context,
        ObjectManagerInterface $manager,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
       
        $this->objectManager = $manager;
        $this->_storeManager = $storeManager;
        $this->filesystem = $this->objectManager->create('\Magento\Framework\Filesystem');
        parent::__construct($context);
    }


    public function getBaseDir()
    {
        $path = $this->filesystem->getDirectoryRead(
            DirectoryList::MEDIA
        )->getAbsolutePath('Simipwa');
        return $path;
    }

    public function isEnabled()
    {
       return $this->scopeConfig->getValue('elsner/homescreen/homescreen_enable',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getAppname()
    {
        return $this->scopeConfig->getValue('elsner/homescreen/app_name',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getAppSortName()
    {
        return $this->scopeConfig->getValue('elsner/homescreen/app_short_name',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getIconUrl()
    {
        return  $this->scopeConfig->getValue('elsner/homescreen/home_screen_icon',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getThemeColor()
    {
        return $this->scopeConfig->getValue('elsner/homescreen/theme_color',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getBackgroundColor()
    {
        return $this->scopeConfig->getValue('elsner/homescreen/background_color',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getBaseUrl()
    {
       $baseurl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB, true);
       return $baseurl;
    }

}
