<?php
/**
* @author Elsner Team
* @copyright Copyright (c) 2021 Elsner Technologies Pvt. Ltd
(https://www.elsner.com/)
* @package Elsnertech_Custom
*/
namespace Elsnertech\Wishlist\Plugin;

class CustomerSessionContext
{
      /**
       * Customer authorization cache context
     */
    const CONTEXT_CUSTOMER_ID = 'logged_in_customer_id';
    /**
 	* @var \Magento\Customer\Model\Session
 	*/
    protected $customerSession;

    /**
 	* @var \Magento\Framework\App\Http\Context
 	*/
    protected $httpContext;

    /**
 	* @param \Magento\Customer\Model\Session $customerSession
 	* @param \Magento\Framework\App\Http\Context $httpContext
 	*/
    public function __construct(
    	\Magento\Customer\Model\Session $customerSession,
    	\Magento\Framework\App\Http\Context $httpContext
    ) {
    	$this->customerSession = $customerSession;
    	$this->httpContext = $httpContext;
    }

    /**
 	* @param \Magento\Framework\App\ActionInterface $subject
 	* @param callable $proceed
 	* @param \Magento\Framework\App\RequestInterface $request
 	* @return mixed
 	*/
    public function aroundDispatch(
    	\Magento\Framework\App\ActionInterface $subject,
    	\Closure $proceed,
    	\Magento\Framework\App\RequestInterface $request
    ) {
    	$this->httpContext->setValue(
        	'id',
        	$this->customerSession->getCustomerId(),
        	false
    	);

    	$this->httpContext->setValue(
        	'customer_name',
        	$this->customerSession->getCustomer()->getName(),
        	false
    	);

    	$this->httpContext->setValue(
        	'customer_email',
        	$this->customerSession->getCustomer()->getEmail(),
        	false
    	);

    	return $proceed($request);
    }
}