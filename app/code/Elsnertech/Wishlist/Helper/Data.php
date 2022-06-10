<?php

namespace Elsnertech\Wishlist\Helper;
use \Magento\Framework\App\Helper\AbstractHelper;
use \Magento\Framework\App\Helper\Context;
use \Magento\Wishlist\Model\Wishlist;
use \Magento\Framework\App\Http\Context as HttpContext;
use \Magento\Framework\Registry;
use \Magento\Catalog\Model\CategoryFactory;

class Data extends AbstractHelper
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
        HttpContext $httpContext
        
    ) {
        $this->wishlist = $wishlist;
        $this->httpContext = $httpContext;
        parent::__construct($context);
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
    public function getProductCollectionFromCategory($productid)
    {
        $customerId = $this->getLoginUserId();
        
        if($this->isCustomerLoggedIn()) {

            $wishlistData = $this->wishlist->loadByCustomerId($customerId)->getItemCollection();

            $wishlistRecord = array();
            foreach($wishlistData as $wishlistCallection) {
                array_push($wishlistRecord, $wishlistCallection->getProduct()->getId());
            }
            if(in_array($productid,$wishlistRecord)){
                return 1;
            } else {
                return 0;
            }
        }
    }
}