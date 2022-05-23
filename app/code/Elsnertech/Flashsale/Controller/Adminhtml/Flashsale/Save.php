<?php

namespace Elsnertech\Flashsale\Controller\Adminhtml\Flashsale;

use Elsnertech\Flashsale\Controller\Adminhtml\Flashsale;
use Elsnertech\Flashsale\Api\FlashsaleRepositoryInterface;
use Elsnertech\Flashsale\Api\Data\FlashsaleInterfaceFactory;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\Model\AbstractModel;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Backend\Helper\Js;
use Exception;

class Save extends Flashsale
{
    /**
     * @var Js
     */
    protected $jsHelper;

    /**
     * Comment of __construct function
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param FlashsaleRepositoryInterface $flashsaleRepository
     * @param FlashsaleInterfaceFactory $flashsaleFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param Js $jsHelper
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        FlashsaleRepositoryInterface $flashsaleRepository,
        FlashsaleInterfaceFactory $flashsaleFactory,
        \Psr\Log\LoggerInterface $logger,
        Js $jsHelper
    ) {
        parent::__construct($context, $coreRegistry, $flashsaleRepository, $flashsaleFactory);
        $this->logger = $logger;
        $this->jsHelper = $jsHelper;
    }

    /**
     * Dispatch request
     *
     * @return ResultInterface|ResponseInterface
     * @throws NotFoundException
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $data = $this->getRequest()->getPostValue();
        $product_val = $data['product_val'];
        if ($data) {
            $id = $this->getRequest()->getParam('id');

            if ($id) {
                try {
                    $flashsale = $this->flashsaleRepository->getById($id);
                } catch (Exception $e) {
                    $this->messageManager->addError(__('This Flash Sale no longer exists.'));
                    /** @var Redirect $resultRedirect */
                    $resultRedirect = $this->resultRedirectFactory->create();
                    return $resultRedirect->setPath('*/*/');
                }
            } else {
                $flashsale = $this->flashsaleFactory->create();
            }
            $flashsale->setData($data);
            // if ($product_val != 0) {
            //     $flashsale = $this->decodeProductLinks($flashsale);
            // }
            try {
                $this->flashsaleRepository->save($flashsale);
                $this->messageManager->addSuccess(__('You saved the Flash Sale.'));
                $this->_session->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $flashsale->getId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->_session->setFormData($data);
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
    // public function decodeProductLinks(AbstractModel $object){
    //     if (false === $object->hasData('links')
    //         || false === array_key_exists('products', $object->getData('links'))
    //         || !$object->getData('links')['products']
    //     ) {
    //         return $object;
    //     }

    //     $postedProducts = $this->jsHelper->decodeGridSerializedInput($object->getData('links')['products']);
    //     //  array_walk($postedProducts, function (&$item) {
    //     //     $item = $item['position'];
    //     // });
    //     return $object->setData('posted_products', $postedProducts);
    // }
}
