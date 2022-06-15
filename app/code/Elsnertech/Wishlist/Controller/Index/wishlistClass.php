<?php

namespace Elsnertech\Wishlist\Controller\Index;
use \Magento\Framework\App\Helper\AbstractHelper;
use \Magento\Framework\App\Action\Context;
use \Magento\Wishlist\Model\Wishlist;
use \Magento\Framework\App\Http\Context as HttpContext;
use \Magento\Framework\Registry;
use \Magento\Catalog\Model\CategoryFactory;
use Magento\Framework\App\Action\Action;


class wishlistClass extends Action
{

    public $categoryFactory;
    public $wishlistItem;
    public $wishlistRecord;
    /**
     * Undocumented function
     *
     * @param Context $context
     * @param Wishlist $wishlist
     * @param HttpContext $httpContext
     * @param array $data
     */
    public function __construct(
        Context $context,
        Wishlist $wishlist,
        HttpContext $httpContext,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
        
    ) {
        $this->wishlist = $wishlist;
        $this->httpContext = $httpContext;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }
    public function execute() {
        $result = $this->resultJsonFactory->create();
        $wishlistData = $this->wishlistCollation();
        if ($this->getRequest()->isAjax()) 
        {
            return $result->setData($wishlistData);
        }
    }
    /**
     * @return bool
     */
    public function isCustomerLoggedIn()
    {
        return (bool)$this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
    }
    
    /**
     * Undocumented function
     *
     * @return void
     */
    public function getLoginUserId()
    {
       return $id = $this->httpContext->getValue('id');
    }

    public function wishlistCollation(){
        $customerId = $this->getLoginUserId();
        $wishlistRecord = array();
        if($this->isCustomerLoggedIn()) {

            $wishlistData = $this->wishlist->loadByCustomerId($customerId)->getItemCollection();

            
            foreach($wishlistData as $wishlistCallection) {
                array_push($wishlistRecord, $wishlistCallection->getProduct()->getId());
            }
        }
        return $wishlistRecord;
    }
}