<?php

namespace Elsner\Pwa\Block\Index;


class Index extends \Magento\Framework\View\Element\Template 
{
	protected $_helper;

	protected $_manifest;

    public function __construct(
    	\Magento\Catalog\Block\Product\Context $context,
    	\Elsner\Pwa\Helper\Data $helper,
    	\Elsner\Pwa\Model\Manifest $manifest,
    	array $data = []) 
    {
    	$this->_helper = $helper;
    	$this->_manifest = $manifest;
        parent::__construct($context, $data);

    }

    public function isAllow()
    {
    	return $this->_helper->isEnabled();
    }

    public function getManifestFile()
    {
    	$this->_manifest->createFile();
    }

    public function getCurrentStoreUrl()
    {
    	return $this->_helper->getBaseUrl();
    }

    public function getThemeColor()
    {
    	return $this->_helper->getThemeColor();
    }

    public function getIconUrl()
    {
    	return $this->_helper->getIconUrl();
    }

}