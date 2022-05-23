<?php

namespace Elsnertech\Homeslider\Controller\Index;
 
class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * $_pageFactory variable
     *
     * @var [type]
     */
     protected $_pageFactory;

    /**
     * Comment of __construct function
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $pageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    ) {
         $this->_pageFactory = $pageFactory;
         return parent::__construct($context);
    }

    /**
     * Comment of execute function
     *
     * @return void
     */
    public function execute()
    {
        //  echo "Module Created Successfully";
         return $this->_pageFactory->create();
    }
}
