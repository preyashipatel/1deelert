<?php

namespace Elsnertech\TaxInvoice\Controller\Index;

use Magento\Framework\App\Action\Context;
use Elsnertech\TaxInvoice\Model\InvoiceFactory;

// use Magento\Store\Model\StoreManagerInterface;

class Save extends \Magento\Framework\App\Action\Action
{
    /**
     * $_invoice variable
     *
     * @var string
     */
    protected $_invoice;
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
    // protected $storeManager;

    /**
     * Undocumented function
     *
     * @param Context $context
     * @param InvoiceFactory $invoice
     * @param \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param string $loggerInterface
     */
    public function __construct(
        Context $context,
        InvoiceFactory $invoice,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Psr\Log\LoggerInterface $loggerInterface
        // StoreManagerInterface $storeManager
    ) {
        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_logLoggerInterface = $loggerInterface;
        $this->messageManager = $context->getMessageManager();
        // $this->storeManager = $storeManager;
        $this->_invoice = $invoice;
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
                $invoice = $this->_invoice->create();
                $invoice->setData($post)->save();
                $this->messageManager->addSuccessMessage(__("Data Saved Successfully."));
            // Send Mail
                $this->_inlineTranslation->suspend();

                $sender = [
                'name' => $post['name'],
                'email' => $post['email']
                ];

                $taxInvoiceData = [
                'name' => $post['name'],
                'email' => $post['email'],
                'c_sname' => $post['c_sname'],
                'taxidentificationNumber' => $post['taxidentificationNumber'],
                'address' => $post['address'],
                'receiptNumber' => $post['receiptNumber'],
                'note' => $post['note']
                ];
             
                $sentToEmail = $this->_scopeConfig ->getValue(
                    'texinvoice/general/email',
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                );

                $transport = $this->_transportBuilder
                ->setTemplateIdentifier('email_taxinvoice_template')
                ->setTemplateOptions(
                    [
                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars($taxInvoiceData)
                ->setFrom($sender)
                // ->setFromByScope($sender)
                ->addTo($sentToEmail)
                ->getTransport();
                 
                $transport->sendMessage();
                 
                $this->_inlineTranslation->resume();
                $this->messageManager->addSuccess('Email sent successfully');
                $this->_redirect('taxinvoice/*/*');
            }
                 
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e, __("We can\'t submit your request, Please try again."));
            // exit;
        }
    }
}
