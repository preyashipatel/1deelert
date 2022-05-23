<?php

namespace Smartwave\Megamenu\Helper;

use Magento\Framework\View\Result\PageFactory;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $_objectManager;
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $_categoryHelper;
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $_categoryFactory;
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $_categoryFlatConfig;
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $_filterProvider;
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $resultPageFactory;

    /**
     * Comment of __construct function
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Catalog\Helper\Category $categoryHelper
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     * @param \Magento\Catalog\Model\Indexer\Category\Flat\State $categoryFlatState
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\Cms\Model\Template\FilterProvider $filterProvider
     * @param PageFactory $resultPageFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Catalog\Helper\Category $categoryHelper,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Catalog\Model\Indexer\Category\Flat\State $categoryFlatState,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        PageFactory $resultPageFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
        $this->_objectManager= $objectManager;
        $this->_categoryFactory = $categoryFactory;
        $this->_categoryFlatConfig = $categoryFlatState;
        $this->_categoryHelper = $categoryHelper;
        $this->resultPageFactory = $resultPageFactory;
        $this->_filterProvider = $filterProvider;

        parent::__construct($context);
    }
    /**
     * Comment of getBaseUrl function
     *
     * @param [type] $url_type
     * @return void
     */
    public function getBaseUrl($url_type = \Magento\Framework\UrlInterface::URL_TYPE_MEDIA)
    {
        return $this->_storeManager->getStore()->getBaseUrl();
    }
    /**
     * Comment of getConfig function
     *
     * @param [type] $config_path
     * @return void
     */
    public function getConfig($config_path)
    {
        return $this->scopeConfig->getValue(
            $config_path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    /**
     * Comment of getModel function
     *
     * @param [type] $model
     * @return void
     */
    public function getModel($model)
    {
        return $this->_objectManager->create($model);
    }
    /**
     * Comment of getCurrentStore function
     *
     * @return void
     */
    public function getCurrentStore()
    {
        return $this->_storeManager->getStore();
    }
    /**
     * Comment of getFirstLevelCategories function
     *
     * @param boolean $sorted
     * @param boolean $asCollection
     * @param boolean $toLoad
     * @return void
     */
    public function getFirstLevelCategories($sorted = false, $asCollection = false, $toLoad = true)
    {
        return $this->_categoryHelper->getStoreCategories($sorted, $asCollection, $toLoad);
    }
    /**
     * Comment of getCategoryModel function
     *
     * @param [type] $id
     * @return void
     */
    public function getCategoryModel($id)
    {
        $_category = $this->_categoryFactory->create();
        $_category->load($id);

        return $_category;
    }
    /**
     * Comment of getActiveChildCategories function
     *
     * @param [type] $category
     * @return void
     */
    public function getActiveChildCategories($category)
    {
        $children = [];
        $subcategories = $category->getChildrenCategories();
        foreach ($subcategories as $category) {
            if (!$category->getIsActive()) {
                continue;
            }
            $children[] = $category;
        }
        return $children;
    }
    /**
     * Comment of getBlockContent function
     *
     * @param string $content
     * @return void
     */
    public function getBlockContent($content = '')
    {
        if (!$this->_filterProvider)
            return $content;
        return $this->_filterProvider->getBlockFilter()->filter(trim($content));
    }
    /**
     * Comment of getResultPageFactory function
     *
     * @return void
     */
    public function getResultPageFactory()
    {
        return $this->resultPageFactory;
    }
    /**
     * Comment of getSubmenuItemsHtml function
     *
     * @param [type] $children
     * @param integer $level
     * @param integer $max_level
     * @return void
     */
    public function getSubmenuItemsHtml($children, $level = 0, $max_level = 2)
    {
        $html = '';
        if (count($children) && ($level < $max_level)) {
            $html .= '<ul';
            if ($level == 0)
                $html .=' class="columns5"';
            $html .= '>';
            foreach ($children as $child) {
                $html .= '<li class="menu-item level'.$level;
                $activeChildren = $this->getActiveChildCategories($child);

                if (count($activeChildren))
                    $html .= ' menu-parent-item';
                $html .= '">';

                $html .='<a href="'.$child->getUrl().'" data-id="'.$child->getId().'">
                <span>'.$child->getName().'</span></a>';
                if (count($activeChildren))
                    $html .= $this->getSubmenuItemsHtml($activeChildren, $level+1, $max_level);
                $html .= '</li>';
            }
            $html .= '</ul>';
        }
        return $html;
    }
}
