<?php

namespace Elsnertech\Productinquiry\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;
use \Magento\Framework\App\Helper\Context;
use \Magento\Framework\App\Http\Context as HttpContext;

class Data extends AbstractHelper
{
    /**
     * Undocumented function
     *
     * @param Context $context
     * @param HttpContext $httpContext
     * @param array $data
     */
    public function __construct(
        Context $context,
        HttpContext $httpContext
    ) {
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

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getLoginUserName()
    {
       return $id = $this->httpContext->getValue('customer_name');
    }
    
    /**
     * Undocumented function
     *
     * @return void
     */
    public function getLoginUserEmail()
    {
       return $id = $this->httpContext->getValue('customer_email');
    }
    
}