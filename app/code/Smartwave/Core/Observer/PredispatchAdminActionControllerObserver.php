<?php
namespace Smartwave\Core\Observer;

use Magento\Framework\Event\ObserverInterface;

class PredispatchAdminActionControllerObserver implements ObserverInterface
{
    /**
     * $_feedFactory variable
     *
     * @var [type]
     */
    protected $_feedFactory;
    /**
     * $_backendAuthSession variable
     *
     * @var [type]
     */
    protected $_backendAuthSession;

    /**
     * Comment of __construct function
     *
     * @param \Smartwave\Core\Model\FeedFactory $feedFactory
     * @param \Magento\Backend\Model\Auth\Session $backendAuthSession
     */
    public function __construct(
        \Smartwave\Core\Model\FeedFactory $feedFactory,
        \Magento\Backend\Model\Auth\Session $backendAuthSession
    ) {
        $this->_feedFactory = $feedFactory;
        $this->_backendAuthSession = $backendAuthSession;
    }

    /**
     * Comment of execute function
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->_backendAuthSession->isLoggedIn()) {
            $feedModel = $this->_feedFactory->create();
            $feedModel->checkUpdate();
        }
    }
}
