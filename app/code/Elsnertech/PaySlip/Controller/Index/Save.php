<?php

namespace Elsnertech\PaySlip\Controller\Index;

use Magento\Framework\App\Action\Context;
use Elsnertech\PaySlip\Model\PaySlipFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Zend_Mime;
use Elsnertech\PaySlip\Model\Mail\TransportBuilder;
use Magento\Framework\UrlFactory;

class Save extends \Magento\Framework\App\Action\Action
{
	/**
     * @var BlogImageGrid
     */
    protected $_payslip;
    protected $uploaderFactory;
    protected $adapterFactory;
    protected $filesystem;
    protected $inlineTranslation;
    protected $scopeConfig;
    protected $_transportBuilder;
    protected $_logLoggerInterface;
    protected $storeManager;

    public function __construct(
		Context $context,
        PaySlipFactory $payslip,
        UploaderFactory $uploaderFactory,
        AdapterFactory $adapterFactory,
        Filesystem $filesystem,
        StateInterface $inlineTranslation,
        ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Psr\Log\LoggerInterface $loggerInterface,
        StoreManagerInterface $storeManager,
        UrlFactory $urlFactory
    ) {
        $this->_payslip = $payslip;
        $this->uploaderFactory = $uploaderFactory;
        $this->adapterFactory = $adapterFactory;
        $this->filesystem = $filesystem;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
        $this->_transportBuilder = $transportBuilder;
        $this->_logLoggerInterface = $loggerInterface;
        $this->storeManager = $storeManager;
        $this->urlModel = $urlFactory->create();
        parent::__construct($context);
    }
	public function execute()
    {
        $data = $this->getRequest()->getParams();
        if(isset($_FILES['transfer_proof_image']['name']) && $_FILES['transfer_proof_image']['name'] != '') {
            try{
                $uploaderFactory = $this->uploaderFactory->create(['fileId' => 'transfer_proof_image']);
                $uploaderFactory->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png', 'pdf', 'docx', 'doc']);
                // $imageAdapter = $this->adapterFactory->create();
                // $uploaderFactory->addValidateCallback('custom_image_upload',$imageAdapter,'validateUploadFile');
                $uploaderFactory->setAllowRenameFiles(true);
                $uploaderFactory->setFilesDispersion(true);
                $mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
                $destinationPath = $mediaDirectory->getAbsolutePath('elsnertech/payslip');
                $result = $uploaderFactory->save($destinationPath);
                if (!$result) {
                    throw new LocalizedException(
                        __('File cannot be saved to path: $1', $destinationPath)
                    );
                }
                // echo"<pre>";print_r($result);die();
                $imagePath = $result['file'];
                $data['transfer_proof_image'] = $imagePath;
            } catch (\Exception $e) {
            }
        }
        // echo"<pre>";print_r($result['path'].$result['file']);die();
    	$payslip = $this->_payslip->create();
        $payslip->setData($data);
        if($payslip->save()){
            // Send Mail
            $filePath = $result['path'].$result['file'];
            $fileName = $result['name'];

            $this->inlineTranslation->suspend();           
            $sender = [
                'name' => $data['name'],
                'email' => $data['email']
            ];
             
            $sentToEmail = $this->scopeConfig ->getValue('payslip/general/email',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            // $sentToName = "Nidhi Parikh";
            $templateOptions = [
                'area' => 'frontend',
                'store' => $this->storeManager->getStore()->getId()
              ];
            $templateVars = [            
                'name'  => $data['name'],
                'email'  => $data['email'],
                'phone'  => $data['phone'],
                'address'  => $data['address'],
                'transfer_date'  => $data['transfer_date'],
                'purchase_order_number'  => $data['purchase_order_number'],
                'note'  => $data['note']
            ];
    
            if(isset($fileName)){
                $transport = $this->_transportBuilder->setTemplateIdentifier('customemail_email_template')
                    ->setTemplateOptions($templateOptions)
                    ->setTemplateVars($templateVars)
                    ->addAttachment(file_get_contents($filePath),$fileName,$result['type'])
                    ->setFromByScope($sender)
                    ->addTo($sentToEmail)
                    ->getTransport();
            }else{
                $transport = $this->_transportBuilder->setTemplateIdentifier('customemail_email_template')
                ->setTemplateOptions($templateOptions)
                ->setTemplateVars($templateVars)                
                ->setFromByScope($sender)
                ->addTo($sentToEmail)
                ->getTransport();
            }
            try {
                $transport->sendMessage();
                $this->inlineTranslation->resume();
                $this->messageManager->addSuccessMessage(__('Email sent Successfully.'));
            } catch (Exception $e) {
                $this->messageManager->addError(__('Email was not sent.'));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('payslip');
            }
        }else{
            $this->messageManager->addErrorMessage(__('Data was not saved.'));
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('payslip');
        return $resultRedirect;
    }
}
