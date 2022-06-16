<?php

namespace Elsnertech\Productinquiry\Controller\Index;

use Magento\Framework\App\Action\Context;
use Elsnertech\Productinquiry\Model\InquiryFactory;

class Save extends \Magento\Framework\App\Action\Action
{
    /**
     * $inquiry variable
     *
     * @var string
     */
    protected $inquiry;
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $_inlineTranslation;
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $_transportBuilder;
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $_scopeConfig;
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $_logLoggerInterface;

    /**
     * Undocumented function
     *
     * @param Context $context
     * @param InquiryFactory $inquiry
     * @param \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param string $loggerInterface
     */
    public function __construct(
        Context $context,
        InquiryFactory $inquiry,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Psr\Log\LoggerInterface $loggerInterface
    ) {
        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_logLoggerInterface = $loggerInterface;
        $this->messageManager = $context->getMessageManager();
        $this->inquiry = $inquiry;
        parent::__construct($context);
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function execute()
    {
        $post = (array)$this->getRequest()->getPost();
        try {
            if ($post) {
                $inquiry = $this->inquiry->create();
                $inquiry->setData($post)->save();
                $this->messageManager->addSuccessMessage(__("Data Saved Successfully."));
            //Send Mail
                $this->_inlineTranslation->suspend();

                $sender = [
                'name' => $post['name'],
                'email' => $post['email']
                ];

                $productInquiryData = [
                'productname' => $post['productname'],
                'productsku' => $post['productsku'],
                'name' => $post['name'],
                'email' => $post['email'],
                'inquiry' => $post['inquiry']
                ];
                
             
                $sentToEmail = $this->_scopeConfig ->getValue(
                    'productinquiry/mainConfigProductinquiry/email',
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                );
                $transport = $this->_transportBuilder
                ->setTemplateIdentifier('email_productinquiry_template')
                ->setTemplateOptions(
                    [
                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars($productInquiryData)
                ->setFrom($sender)
                ->addTo($sentToEmail)
                ->getTransport();
                 
                try {
                $transport->sendMessage();
                 
                $this->_inlineTranslation->resume();
                $this->messageManager->addSuccess('Email sent successfully');
                $this->_redirect('*/*/*');
            } catch (Exception $e) {
                $this->messageManager->addError(__('Email was not sent.'));
                $this->_redirect('/*/*');
            }
            }
                 
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e, __("We can\'t submit your request, Please try again."));
        }
    }
}
