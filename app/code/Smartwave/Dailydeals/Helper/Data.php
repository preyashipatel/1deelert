<?php
namespace Smartwave\Dailydeals\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * $dailydealFactory variable
     *
     * @var [type]
     */
    protected $dailydealFactory;
    /**
     * $scopeConfig variable
     *
     * @var [type]
     */
    protected $scopeConfig;
    /**
     * $productFactory variable
     *
     * @var [type]
     */
    protected $productFactory;
    /**
     * $loadedTimer variable
     *
     * @var [type]
     */
    protected $loadedTimer;
    
    /**
     * Comment of __construct function
     *
     * @param \Smartwave\Dailydeals\Model\DailydealFactory $dailydealFactory
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     */
    public function __construct(
        \Smartwave\Dailydeals\Model\DailydealFactory $dailydealFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Catalog\Model\ProductFactory $productFactory
    ) {
    
        $this->dailydealFactory = $dailydealFactory;
        $this->scopeConfig=$scopeConfig;
        $this->productFactory= $productFactory;
        $this->loadedTimer = 0;
    }

    /**
     * Comment of chkEnableDailydeals function
     *
     * @return void
     */
    public function chkEnableDailydeals()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
       
        $configPath = "sw_dailydeal/general/dailydeal_enabled";
       
        $chkEnableDailydeals = $this->scopeConfig->getValue($configPath, $storeScope);
        
        return $chkEnableDailydeals;
    }

    // Get ObjectManager Instance

    /**
     * Comment of getObjectManagerInstance function
     *
     * @return void
     */
    public function getObjectManagerInstance()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        return $objectManager;
    }
    
    //Check Dailydeal Product

    /**
     * Comment of isDealProduct function
     *
     * @param [type] $productId
     * @return boolean
     */
    public function isDealProduct($productId)
    {
        if (!$this->chkEnableDailydeals()) {
            return false;
        }
        $productcollection=$this->productFactory->create()->getCollection();
        $productcollection->addAttributeToSelect('*');
        $productcollection->addAttributeToFilter('entity_id', ['eq'=>$productId]);
        $sku=$productcollection->getFirstItem()->getSku();
        
        $dailydealcollection=$this->getDailydealcollection();
        $dailydealcollection->addFieldToSelect('*');
        $dailydealcollection->addFieldToFilter('sw_product_sku', ['eq'=>$sku]);
        
        if ($dailydealcollection->getSize() ==1) {
            $objDate = $this->getObjectManagerInstance()->create(\Magento\Framework\Stdlib\DateTime\DateTime::class);
        
            $curdate=strtotime($this->getcurrentDate());
            $Todate=strtotime($this->getDailydealToDate($sku));
            $fromdate=strtotime($this->getDailydealFromDate($sku));
            
            if (( $curdate <= $Todate ) && ($curdate >= $fromdate)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // Get Product Price

    /**
     * Comment of getProductPrice function
     *
     * @param [type] $sku
     * @return void
     */
    public function getProductPrice($sku)
    {
        $productcollection=$this->productFactory->create()->getCollection();
        $productcollection->addAttributeToSelect('*');
        $productcollection->addAttributeToFilter('sku', ['eq'=>$sku]);
        $productcollection->addAttributeToFilter('type_id', ['neq'=>'bundle']);
        if ($productcollection->getSize() ==1 && $productcollection->getFirstItem()->getTypeId() !="grouped") {
            return $productcollection->getFirstItem()->getFinalPrice();
        } else {
            return 1;
        }
    }
    // Get Bundle Discount Value

    /**
     * Comment of getbundleProductDiscount function
     *
     * @param [type] $sku
     * @return void
     */
    public function getbundleProductDiscount($sku)
    {
        $dailydealcollection=$this->getDailydealcollection();
        $dailydealcollection->addFieldToSelect('*');
        $dailydealcollection->addFieldToFilter('sw_product_sku', ['eq'=>$sku]);

        if ($dailydealcollection->getFirstItem()->getSwDiscountType() ==1) {
            return '<div style=" margin-top:20px; ">
            <strong>Save:'.$this->getcurrencySymbol().''.
            number_format($dailydealcollection->getFirstItem()->getSwDiscountAmount(), 2).
            '</strong></div>';
        } elseif ($dailydealcollection->getFirstItem()->getSwDiscountType() ==2) {
            return '<div style="margin-top:20px;">
            <strong>OFF:'.number_format($dailydealcollection->getFirstItem()->getSwDiscountAmount(), 2).
            '%</strong></div>';
        }
    }
    //Get "Product price" by ProductId

    /**
     * Comment of getDealproductbyId function
     *
     * @param [type] $productId
     * @return void
     */
    public function getDealproductbyId($productId)
    {
        $productcollection=$this->productFactory->create()->getCollection();
        $productcollection->addAttributeToSelect('*');
        $productcollection->addAttributeToFilter('entity_id', ['eq'=>$productId]);
        $sku=$productcollection->getFirstItem()->getSku();
        
        return $this->getDealProductPrice($sku);
    }
    
    // Get Current Currency Symbol

    /**
     * Comment of getcurrencySymbol function
     *
     * @return void
     */
    public function getcurrencySymbol()
    {
        $currencySymbol=$this->getObjectManagerInstance()->create(\Magento\Store\Model\StoreManagerInterface::Class);
        return $currencySymbol->getStore()->getCurrentCurrency()->getCurrencySymbol();
    }

    // Get Current Date

    /**
     * Comment of getcurrentDate function
     *
     * @return void
     */
    public function getcurrentDate()
    {
         $objDate = $this->getObjectManagerInstance()->create(\Magento\Framework\Stdlib\DateTime\DateTime::class);
         return $objDate->gmtDate("Y-m-d H:i:s");
    }

    // Get Collection of dailydeal

    /**
     * Comment of getDailydealcollection function
     *
     * @return void
     */
    public function getDailydealcollection()
    {
        $dailydealcollection=$this->dailydealFactory->create()->getCollection();
        return $dailydealcollection;
    }
    
    // Get Discount Value  of Dailydeal Product

    /**
     * Comment of getDealProductDiscountValue function
     *
     * @param [type] $dealproductsku
     * @return void
     */
    public function getDealProductDiscountValue($dealproductsku)
    {
        $dailydealcollection=$this->getDailydealcollection();
        $dailydealcollection->addFieldToSelect('*');
        $dailydealcollection->addFieldToFilter('sw_product_sku', ['eq'=>$dealproductsku]);
        
        return $dailydealcollection->getFirstItem()->getSwDiscountAmount();
    }
    
    // Get Dailydeal Product with Discount Price

    /**
     * Comment of getDealProductPrice function
     *
     * @param [type] $dealproductsku
     * @return void
     */
    public function getDealProductPrice($dealproductsku)
    {
        $dailydealcollection=$this->getDailydealcollection();
        $dailydealcollection->addFieldToSelect('*');
        $dailydealcollection->addFieldToFilter('sw_product_sku', ['eq'=>$dealproductsku]);
        
        return $dailydealcollection->getFirstItem()->getSwProductPrice();
    }
    
    // Get Dailydeal Product TO date

    /**
     * Comment of getDailydealToDate function
     *
     * @param [type] $dealproductsku
     * @return void
     */
    public function getDailydealToDate($dealproductsku)
    {
        $dailydealcollection=$this->getDailydealcollection();
        $dailydealcollection->addFieldToSelect('*');
        $dailydealcollection->addFieldToFilter('sw_product_sku', ['eq'=>$dealproductsku]);
        
        return $dailydealcollection->getFirstItem()->getSwDateTo();
    }
    // Get Dailydeal Product FROM Date

    /**
     * Comment of getDailydealFromDate function
     *
     * @param [type] $dealproductsku
     * @return void
     */
    public function getDailydealFromDate($dealproductsku)
    {
        $dailydealcollection=$this->getDailydealcollection();
        $dailydealcollection->addFieldToSelect('*');
        $dailydealcollection->addFieldToFilter('sw_product_sku', ['eq'=>$dealproductsku]);
        
        return $dailydealcollection->getFirstItem()->getSwDateFrom();
    }
            
    // Get "OFF value" (in percentage) of Dailydeal Product

    /**
     * Comment of getDealOffValue function
     *
     * @param [type] $dealproductsku
     * @return void
     */
    public function getDealOffValue($dealproductsku)
    {
        $dailydealcollection=$this->getDailydealcollection();
        $dailydealcollection->addFieldToSelect('*');
        $dailydealcollection->addFieldToFilter('sw_product_sku', ['eq'=>$dealproductsku]);
        
        $discountType=$dailydealcollection->getFirstItem()->getSwDiscountType();
        if ($discountType ==1) {
            $off=(($this->getProductPrice($dealproductsku)-$this->getDealProductPrice($dealproductsku))* 100)/
            $this->getProductPrice($dealproductsku) ;
            return $off;
        } elseif ($discountType ==2) {
            return $dailydealcollection->getFirstItem()->getSwDiscountAmount();
        }
    }
    
    // Get "Save value" (In price) of dailydeal Product

    /**
     * Comment of getDealSaveValue function
     *
     * @param [type] $dealproductsku
     * @return void
     */
    public function getDealSaveValue($dealproductsku)
    {
        $dailydealcollection=$this->getDailydealcollection();
        $dailydealcollection->addFieldToSelect('*');
        $dailydealcollection->addFieldToFilter('sw_product_sku', ['eq'=>$dealproductsku]);
        
        $discountType=$dailydealcollection->getFirstItem()->getSwDiscountType();
        if ($discountType ==1) {
            return $dailydealcollection->getFirstItem()->getSwDiscountAmount();
        } elseif ($discountType ==2) {
            $save=$this->getProductPrice($dealproductsku) - $this->getDealProductPrice($dealproductsku);
            return $save;
        }
    }

    /**
     * Comment of isLoadedTimer function
     *
     * @return boolean
     */
    public function isLoadedTimer()
    {
        return $this->loadedTimer;
    }

    /**
     * Comment of setLoadedTimer function
     *
     * @return void
     */
    public function setLoadedTimer()
    {
        $this->loadedTimer = 1;
    }
}
