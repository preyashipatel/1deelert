<?php
namespace Elsnertech\Customisation\Model;
use Magento\UrlRewrite\Model\UrlFinderInterface;
use Magento\UrlRewrite\Service\V1\Data\UrlRewrite;
use Magento\Framework\App\Config\ScopeConfigInterface;
class Url extends \Magento\Catalog\Model\Product\Url
{
    protected $urlFactory;
    protected $storeManager;
    private $scopeConfig;
 
    public function __construct(
        \Magento\Framework\UrlFactory $urlFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Filter\FilterManager $filter,
        \Magento\Framework\Session\SidResolverInterface $sidResolver,
        \Magento\Framework\App\Response\RedirectInterface $redirect,
        \Magento\Framework\Registry $registry,
        UrlFinderInterface $urlFinder,
        ScopeConfigInterface $scopeConfig = null
    ) {
        parent::__construct($urlFactory, $storeManager, $filter, $sidResolver, $urlFinder);
        $this->urlFactory = $urlFactory;
        $this->redirect = $redirect;
        $this->registry = $registry;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig ?:
            \Magento\Framework\App\ObjectManager::getInstance()->get(ScopeConfigInterface::class);
    }
    public function getUrl(\Magento\Catalog\Model\Product $product, $params = [])
    {
        $categorydata = $this->registry->registry('current_category');//get current category
        \Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info("Current Category : ".$product->getRequestPath());
        $requestPath = $product->getRequestPath();  
        $storeId = $product->getStoreId();
        $categoryId = $product->getCategoryId();
        if (!empty($requestPath))
        {
            $params['_direct'] = $requestPath;
        }else{
                $filterData = [
                    UrlRewrite::ENTITY_ID => $product->getId(),
                    UrlRewrite::ENTITY_TYPE => \Magento\CatalogUrlRewrite\Model\ProductUrlRewriteGenerator::ENTITY_TYPE,
                    UrlRewrite::STORE_ID => $storeId,
                ];
                $useCategories = $this->scopeConfig->getValue(
                    \Magento\Catalog\Helper\Product::XML_PATH_PRODUCT_URL_USE_CATEGORY,
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                );
                $filterData[UrlRewrite::METADATA]['category_id']
                    = $categoryId && $useCategories ? $categoryId : '';

                $rewrite = $this->urlFinder->findOneByData($filterData);

                if ($rewrite) {
                    $requestPath = $rewrite->getRequestPath();
                    $product->setRequestPath($requestPath);
                } else {
                    $product->setRequestPath(false);
                }
                $params['_direct'] = $product->getRequestPath();
        }
        $baseUrl = $this->storeManager->getStore()->getBaseUrl();
        $categorycheck = false;
        $categories = $product->getCategoryIds(); /*will return category ids array*/
        foreach($categories as $category1){
            if (isset($categorydata) && $category1 == $categorydata->getId()) {
                $categorycheck = true;
            }
        }        
        $productUrl = $this->getUrlInstance()->setScope($product->getStoreId())->getUrl(' ',$params);
                \Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info("From Url : ".$productUrl);
        $remainingUrl = str_replace($baseUrl, '', $productUrl);
        if (isset($categorydata) && $categorycheck == true){
            $productUrl = $baseUrl."mproduct/".$categorydata->getUrlKey()."/".$product->getUrlAttribute()."/". $remainingUrl;
        }
        return $productUrl;
    }
    private function getUrlInstance()
    {
        return $this->urlFactory->create();
    }
}