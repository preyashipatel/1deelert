<?php

namespace Smartwave\Megamenu\Plugin;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class RemoveBlock implements ObserverInterface
{
    /**
     * $_scopeConfig variable
     *
     * @var [type]
     */
    protected $_scopeConfig;

    /**
     * Comment of __construct function
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->_scopeConfig = $scopeConfig;
    }

    /**
     * Comment of execute function
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var \Magento\Framework\View\Layout $layout */
        $layout = $observer->getLayout();
        $block = $layout->getBlock('catalog.topnav');  // here block reference name to remove

        if ($block) {
            $remove = $this->_scopeConfig->getValue('sw_megamenu/general/enable', ScopeInterface::SCOPE_STORE);
            if ($remove) {
                $layout->unsetElement('catalog.topnav');
            }
        }
    }
}
