<?php
namespace Elsnertech\Customisation\Controller;
use Magento\UrlRewrite\Model\UrlFinderInterface;
use Magento\UrlRewrite\Service\V1\Data\UrlRewrite;
use Magento\Framework\App\RouterInterface;
class RouterData
{
    protected $actionFactory;
    protected $storeManager;
    protected $urlFinder;
    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\RequestInterface $request,
        UrlFinderInterface $urlFinder
    ) {
        $this->actionFactory = $actionFactory;
        $this->storeManager = $storeManager;
        $this->request = $request;
        $this->urlFinder = $urlFinder;
    } 
    public function aroundMatch(\Magento\UrlRewrite\Controller\Router $subject, callable $proceed)
    {
        $array = explode('/',$this->request->getPathInfo());


        if (isset($array[2]) && isset($array[3])) {
            $customurl = "mproduct/".$array[2]."/".$array[3]."/";                   
        }else{
            $customurl = "";
        }
        $replaceUrl = str_replace($customurl, "", $this->request->getPathInfo());
        $rewrite = $this->getRewriteData($replaceUrl, $this->storeManager->getStore()->getId());    
        if ($rewrite == null)
        {
            return null;
        }
        $this->request->setAlias(\Magento\Framework\UrlInterface::REWRITE_REQUEST_PATH_ALIAS, $rewrite->getRequestPath());
        $this->request->setPathInfo('/' . $rewrite->getTargetPath());
        return $this->actionFactory->create('Magento\Framework\App\Action\Forward');
    }
    protected function getRewriteData($requestPath, $storeId)
   {
        return $this->urlFinder->findOneByData([
            UrlRewrite::REQUEST_PATH => trim($requestPath, '/'),
            UrlRewrite::STORE_ID => $storeId,
        ]);
   }
}