<?php

namespace Elsnertech\Flashsale\Controller\Adminhtml;

use Elsnertech\Flashsale\Api\FlashsaleRepositoryInterface;
use Elsnertech\Flashsale\Api\Data\FlashsaleInterfaceFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Backend\Model\View\Result\Page;

abstract class Flashsale extends Action
{
    /**
     * @var FlashsaleInterfaceFactory
     */
    protected $flashsaleFactory;

    /**
     * @var FlashsaleRepositoryInterface
     */
    protected $flashsaleRepository;

    /**
     * @var Registry
     */
    protected $coreRegistry = null;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param FlashsaleRepositoryInterface $flashsaleRepository
     * @param FlashsaleInterfaceFactory $flashsaleFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        FlashsaleRepositoryInterface $flashsaleRepository,
        FlashsaleInterfaceFactory $flashsaleFactory
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->flashsaleRepository = $flashsaleRepository;
        $this->flashsaleFactory = $flashsaleFactory;
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param Page $resultPage
     * @return Page
     */
    protected function initPage(Page $resultPage)
    {
        $resultPage->setActiveMenu('Elsnertech_Flashsale::flashsale')
            ->addBreadcrumb(__('Flashsale'), __('Flashsale'))
            ->addBreadcrumb(__('Flashsale'), __('Flashsale'));
        return $resultPage;
    }

    /**
     * Check for is allowed
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return true;
    }
}
