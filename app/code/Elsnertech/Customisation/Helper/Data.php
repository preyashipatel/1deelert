<?php
namespace Elsnertech\Customisation\Helper;
 
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Registry;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Sales\Model\Order;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Authorization\Model\UserContextInterface;
use Psr\Log\LoggerInterface;
use Magento\Customer\Api\AddressRepositoryInterface;



class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * $_storeManager variable
     *
     * @var [type]
     */
    public $_storeManager;
    
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $_currency;
    protected $_context;
    protected $userContext;
    /**
     * Editor constructor.
     *
     * @param Context $context
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param Currency $currency
     * @param PriceCurrencyInterface $priceCurrency
     * @param Registry $registry
     * @param Order $order
     * @param AddressRepositoryInterface $addressRepositoryInterface
     * @param Http $request
     * @codeCoverageIgnore
     */
    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Directory\Model\Currency $currency,
        PriceCurrencyInterface $priceCurrency,
        Registry $registry,
        Order $order,
        AddressRepositoryInterface $addressRepositoryInterface,
        \Magento\Framework\App\Request\Http $request,
        LoggerInterface $logger,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        UserContextInterface $userContext,
        \Magento\Framework\App\Action\Context $_context
    ) {
        $this->_scopeConfig = $scopeConfig;
        $this->_storeManager=$storeManager;
        $this->_registry = $registry;
        $this->_currency = $currency;
        $this->priceCurrency = $priceCurrency;
        $this->_order = $order;
        $this->context = $_context;
        $this->addressRepositoryInterface = $addressRepositoryInterface;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->request = $request;
        $this->logger = $logger;
        $this->userContext = $userContext;
        parent::__construct($context);
    }
    
    /**
     * Description of getConfig here.
     *
     * @param string $config_path
     */
    public function getConfig($config_path)
    {
        return $this->_scopeConfig->getValue($config_path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    /**
     * Description of getBaseUrl here.
     *
     * @param
     */
    public function getBaseUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl();
    }
    /**
     * Description of getMediaUrl here.
     *
     * @param
     */
    public function getMediaUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }
    /**
     * Description of getCurrentProduct here.
     *
     * @param
     */
    public function getCurrentProduct()
    {
        return $this->_registry->registry('current_product')->getsku();
    }
    /**
     * Description of getCurrentCurrencySymbol here.
     *
     * @param
     */
    public function getCurrentCurrencySymbol()
    {
        //  $this->_currency->getCurrencySymbol();
        return $this->priceCurrency->getCurrencySymbol();
    }

    public function getCurrentCategory()
    {
        $category = $this->_registry->registry('current_category');//get current category
    }

    /**
     * Description of getLayout here.
     *
     * @param
     */
    public function getLayout()
    {
        $request = $this->context->getRequest();
        $pagename = $request->getFullActionName();
        return $pagename;
    }
    
    /**
     * Description of getPaymentmethodName here.
     *
     * @param string $orderId
     */
    public function getPaymentmethodName($orderId)
    {
        $order = $this->_order->loadByIncrementId($orderId);
        $payment = $order->getPayment();
        $method = $payment->getMethodInstance();
        return $method->getCode();
    }

    /**
     * Description of getCustomerId here.
     *
     */
    public function getLoginCustomerId()
    {
        $customerId = $this->userContext->getUserId();
        return $customerId;
    }

    /**
     * Retrieve customer address.
     *
     * @param int $addressId
     * @return AddressInterface
     * @throws LocalizedException
     */
    public function getCustomerAddress($attributeCode)
    {
        $addressId =  $this->request->getParam('id');
        try {
            $customerId = $this->getLoginCustomerId();
            $customer = $this->customerRepositoryInterface->getById($customerId);
            $customerAttributeData = $customer->__toArray();
            foreach ($customerAttributeData['addresses'] as $key => $customerAddress) {
                if($customerAddress['id'] == $addressId){
                    // echo '<pre>';print_r($customerAddress['custom_attributes'][$attributeCode]['value']);exit;
                    if(isset($customerAddress['custom_attributes'])){
                        return $customerAddress['custom_attributes'][$attributeCode]['value'];
                    }else{
                        return '';
                    }
                }

            }
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage());
        }

        return $addressRepository;
    }
}
