<?php
namespace Smartwave\Megamenu\Block;

use Magento\Catalog\Model\Product\Attribute\Source\Status;

class Topmenu extends \Magento\Framework\View\Element\Template
{

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
    protected $_categoryFlatConfig;
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $_topMenu;
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
    protected $_helper;
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
    protected $_blockFactory;
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $_megamenuConfig;
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $_storeManager;
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $_productCollectionFactory;

    /**
     * Comment of __construct function
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Catalog\Helper\Category $categoryHelper
     * @param \Smartwave\Megamenu\Helper\Data $helper
     * @param \Magento\Catalog\Model\Indexer\Category\Flat\State $categoryFlatState
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     * @param \Magento\Theme\Block\Html\Topmenu $topMenu
     * @param \Magento\Cms\Model\Template\FilterProvider $filterProvider
     * @param \Magento\Cms\Model\BlockFactory $blockFactory
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Helper\Category $categoryHelper,
        \Smartwave\Megamenu\Helper\Data $helper,
        \Magento\Catalog\Model\Indexer\Category\Flat\State $categoryFlatState,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Theme\Block\Html\Topmenu $topMenu,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        \Magento\Cms\Model\BlockFactory $blockFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
    ) {

        $this->_categoryHelper = $categoryHelper;
        $this->_categoryFlatConfig = $categoryFlatState;
        $this->_categoryFactory = $categoryFactory;
        $this->_topMenu = $topMenu;
        $this->_helper = $helper;
        $this->_filterProvider = $filterProvider;
        $this->_blockFactory = $blockFactory;
        $this->_storeManager = $context->getStoreManager();
        $this->_productCollectionFactory = $productCollectionFactory;
        parent::__construct($context);
    }

    /**
     * Comment of getCategoryHelper function
     *
     * @return void
     */
    public function getCategoryHelper()
    {
        return $this->_categoryHelper;
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
     * Comment of getHtml function
     *
     * @param string $outermostClass
     * @param string $childrenWrapClass
     * @param integer $limit
     * @return void
     */
    public function getHtml($outermostClass = '', $childrenWrapClass = '', $limit = 0)
    {
        return $this->_topMenu->getHtml($outermostClass, $childrenWrapClass, $limit);
    }

    /**
     * Comment of getStoreCategories function
     *
     * @param boolean $sorted
     * @param boolean $asCollection
     * @param boolean $toLoad
     * @return void
     */
    public function getStoreCategories($sorted = false, $asCollection = false, $toLoad = true)
    {
        return $this->_categoryHelper->getStoreCategories($sorted, $asCollection, $toLoad);
    }

    /**
     * Comment of getChildCategories function
     *
     * @param [type] $category
     * @return void
     */
    public function getChildCategories($category)
    {
        if ($this->_categoryFlatConfig->isFlatEnabled() && $category->getUseFlatResource()) {
            $subcategories = (array)$category->getChildrenNodes();
        } else {
            $subcategories = $category->getChildren();
        }

        return $subcategories;
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
        if ($this->_categoryFlatConfig->isFlatEnabled() && $category->getUseFlatResource()) {
            $subcategories = (array)$category->getChildrenNodes();
        } else {
            $subcategories = $category->getChildren();
        }
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
     * Comment of getCustomBlockHtml function
     *
     * @param string $type
     * @return void
     */
    public function getCustomBlockHtml($type = 'after')
    {
        $html = '';

        $block_ids = $this->_megamenuConfig['custom_links']['staticblock_'.$type];

        if (!$block_ids) return '';

        $block_ids = preg_replace('/\s/', '', $block_ids);
        $ids = explode(',', $block_ids);
        $store_id = $this->_storeManager->getStore()->getId();

        foreach ($ids as $block_id) {
            $block = $this->_blockFactory->create();
            $block->setStoreId($store_id)->load($block_id);

            if (!$block) continue;

            $block_content = $block->getContent();

            if (!$block_content) continue;

            $content = $this->_filterProvider->getBlockFilter()->setStoreId($store_id)->filter($block_content);
            if (substr($content, 0, 4) == '<ul>')
                $content = substr($content, 4);
            if (substr($content, strlen($content) - 5) == '</ul>')
                $content = substr($content, 0, -5);

            $html .= $content;
        }

        return $html;
    }
    /**
     * Comment of getSubmenuItemsHtml function
     *
     * @param [type] $children
     * @param integer $level
     * @param integer $max_level
     * @param integer $column_width
     * @param string $menu_type
     * @param [type] $columns
     * @return void
     */
    public function getSubmenuItemsHtml(
        $children,
        $level = 1,
        $max_level = 0,
        $column_width = 12,
        $menu_type = 'fullwidth',
        $columns = null
    ) {
        $html = '';

        if (!$max_level || ($max_level && $max_level == 0) ||
        ($max_level && $max_level > 0 && $max_level-1 >= $level)) {
            $column_class = "";
            if ($level == 1 && $columns && ($menu_type == 'fullwidth' || $menu_type == 'staticwidth')) {
                $column_class = "col-md-".$column_width." ";
                $column_class .= "mega-columns columns".$columns;
            }
            $html = '<ul class="subchildmenu '.$column_class.'">';
            foreach ($children as $child) {
                $cat_model = $this->getCategoryModel($child->getId());

                $sw_menu_hide_item = $cat_model->getData('sw_menu_hide_item');

                if (!$sw_menu_hide_item) {
                    $sub_children = $this->getActiveChildCategories($child);

                    $sw_menu_cat_label = $cat_model->getData('sw_menu_cat_label');
                    $sw_menu_icon_img = $cat_model->getData('sw_menu_icon_img');
                    $sw_menu_font_icon = $cat_model->getData('sw_menu_font_icon');

                    $item_class = 'level'.$level.' ';
                    if (count($sub_children) > 0)
                        $item_class .= 'parent ';
                    $html .= '<li class="ui-menu-item '.$item_class.'">';
                    if (count($sub_children) > 0) {
                        $html .= '<div class="open-children-toggle"></div>';
                    }
                    if ($level == 1 && $sw_menu_icon_img) {
                        $html .= '<div class="menu-thumb-img">
                        <a class="menu-thumb-link" href="'.
                        $this->_categoryHelper->getCategoryUrl($child).'">
                        <img src="' . $this->_helper->getBaseUrl().'' . $sw_menu_icon_img . '"
                        alt="'.$child->getName().'"/></a></div>';
                    }
                    $html .= '<a href="'.$this->_categoryHelper->getCategoryUrl($child).'"
                    title="'.$child->getName().'">';
                    if ($level > 1 && $sw_menu_icon_img)
                        $html .= '<img class="menu-thumb-icon" src="' .
                        $this->_helper->getBaseUrl().'' . $sw_menu_icon_img . '"
                        alt="'.$child->getName().'"/>';
                    elseif ($sw_menu_font_icon)
                        $html .= '<em class="menu-thumb-icon '.$sw_menu_font_icon.'"></em>';
                    $html .= '<span>'.$child->getName();
                    if ($sw_menu_cat_label)
                        $html .= '<span class="cat-label cat-label-'.$sw_menu_cat_label.'">'.
                        $this->_megamenuConfig['cat_labels'][$sw_menu_cat_label].'</span>';
                    $html .= '</span></a>';
                    if (count($sub_children) > 0) {
                        $html .= $this->getSubmenuItemsHtml(
                            $sub_children,
                            $level+1,
                            $max_level,
                            $column_width,
                            $menu_type
                        );
                    }
                    $html .= '</li>';
                }
            }
            $html .= '</ul>';
        }

        return $html;
    }

    /**
     * Comment of getMegamenuHtml function
     *
     * @return void
     */
    public function getMegamenuHtml()
    {
        $html = '';

        $categories = $this->getStoreCategories(true, false, true);

        $this->_megamenuConfig = $this->_helper->getConfig('sw_megamenu');

        $max_level = $this->_megamenuConfig['general']['max_level'];
        $html .= $this->getCustomBlockHtml('before');
        foreach ($categories as $category) {
            if (!$category->getIsActive()) {
                continue;
            }

            $cat_model = $this->getCategoryModel($category->getId());

            $sw_menu_hide_item = $cat_model->getData('sw_menu_hide_item');

            if (!$sw_menu_hide_item) {
                $children = $this->getActiveChildCategories($category);
                $sw_menu_cat_label = $cat_model->getData('sw_menu_cat_label');
                $sw_menu_icon_img = $cat_model->getData('sw_menu_icon_img');
                $sw_menu_font_icon = $cat_model->getData('sw_menu_font_icon');
                $sw_menu_cat_columns = $cat_model->getData('sw_menu_cat_columns');
                $sw_menu_float_type = $cat_model->getData('sw_menu_float_type');

                if (!$sw_menu_cat_columns) {
                    $sw_menu_cat_columns = 4;
                }

                $menu_type = $cat_model->getData('sw_menu_type');
                if (!$menu_type)
                    $menu_type = $this->_megamenuConfig['general']['menu_type'];

                $custom_style = '';
                if ($menu_type=="staticwidth")
                    $custom_style = ' style="width: 500px;"';

                $sw_menu_static_width = $cat_model->getData('sw_menu_static_width');
                if ($menu_type=="staticwidth" && $sw_menu_static_width)
                    $custom_style = ' style="width: '.$sw_menu_static_width.';"';

                $item_class = 'level0 ';
                $item_class .= $menu_type.' ';

                $menu_top_content = $cat_model->getData('sw_menu_block_top_content');
                $menu_left_content = $cat_model->getData('sw_menu_block_left_content');
                $menu_left_width = $cat_model->getData('sw_menu_block_left_width');
                if (!$menu_left_content || !$menu_left_width)
                    $menu_left_width = 0;
                $menu_right_content = $cat_model->getData('sw_menu_block_right_content');
                $menu_right_width = $cat_model->getData('sw_menu_block_right_width');
                if (!$menu_right_content || !$menu_right_width)
                    $menu_right_width = 0;
                $menu_bottom_content = $cat_model->getData('sw_menu_block_bottom_content');
                if ($sw_menu_float_type)
                    $sw_menu_float_type = 'fl-'.$sw_menu_float_type.' ';
                if (count($children) > 0 || (($menu_type=="fullwidth" || $menu_type=="staticwidth") &&
                ($menu_top_content || $menu_left_content || $menu_right_content || $menu_bottom_content)))
                    $item_class .= 'parent ';
                $html .= '<li class="ui-menu-item '.($category->getName()=="บ้าน" ? 'home-catagory ' : '').
                $item_class.$sw_menu_float_type.'">';
                if (count($children) > 0) {
                    $html .= '<div class="open-children-toggle"></div>';
                }
                $html .= '<a href="'.$this->_categoryHelper->getCategoryUrl($category).'" 
                class="level-top" title="'.$category->getName().'">';
                if ($sw_menu_icon_img)
                    $html .= '<img class="menu-thumb-icon" src="' .
                    $this->_helper->getBaseUrl().'' . $sw_menu_icon_img . '"
                    alt="'.$category->getName().'"/>';
                elseif ($sw_menu_font_icon)
                    $html .= '<em class="menu-thumb-icon '.$sw_menu_font_icon.'"></em>';
                $html .= '<span>'.$category->getName().'</span>';
                if ($sw_menu_cat_label)
                    $html .= '<span class="cat-label cat-label-'.$sw_menu_cat_label.'">'.
                    $this->_megamenuConfig['cat_labels'][$sw_menu_cat_label].'</span>';
                    $html .='<span class="product-count">('.
                    $this->getProductCollectionByCategories($category->getId()).')</span>';
                $html .= '</a>';
                if (count($children) > 0 || (($menu_type=="fullwidth" || $menu_type=="staticwidth") &&
                ($menu_top_content || $menu_left_content || $menu_right_content || $menu_bottom_content))) {
                    $html .= '<div class="level0 submenu"'.$custom_style.'>';
                    if (($menu_type=="fullwidth" || $menu_type=="staticwidth")) {
                        $html .= '<div class="container">';
                    }
                    if (($menu_type=="fullwidth" || $menu_type=="staticwidth") && $menu_top_content) {
                        $html .= '<div class="menu-top-block">'.$this->getBlockContent($menu_top_content).'</div>';
                    }
                    if (count($children) > 0 || (($menu_type=="fullwidth" || $menu_type=="staticwidth") &&
                    ($menu_left_content || $menu_right_content))) {
                        $html .= '<div class="row">';
                        if (($menu_type=="fullwidth" || $menu_type=="staticwidth") &&
                        $menu_left_content && $menu_left_width > 0) {
                            $html .= '<div class="menu-left-block col-md-'.
                            $menu_left_width.'">'.$this->getBlockContent($menu_left_content).'</div>';
                        }
                        $html .= $this->getSubmenuItemsHtml(
                            $children,
                            1,
                            $max_level,
                            12-$menu_left_width-$menu_right_width,
                            $menu_type,
                            $sw_menu_cat_columns
                        );
                        if (($menu_type=="fullwidth" || $menu_type=="staticwidth") && $menu_right_content && $menu_right_width > 0) {
                            $html .= '<div class="menu-right-block col-md-'.
                            $menu_right_width.'">'.$this->getBlockContent($menu_right_content).'</div>';
                        }
                        $html .= '</div>';
                    }
                    if (($menu_type=="fullwidth" || $menu_type=="staticwidth") && $menu_bottom_content) {
                        $html .='<div class="menu-bottom-block">'.$this->getBlockContent($menu_bottom_content).'</div>';
                    }
                    if (($menu_type=="fullwidth" || $menu_type=="staticwidth")) {
                        $html .= '</div>';
                    }
                    $html .= '</div>';
                }
                $html .= '</li>';
            }
        }
        $html .= $this->getCustomBlockHtml('after');

        return $html;
    }

    /**
     * Comment of getProductCollectionByCategories function
     *
     * @param [type] $ids
     * @return void
     */
    public function getProductCollectionByCategories($ids)
    {
        if ($ids != '' && !empty($ids)) {
            $collection = $this->_productCollectionFactory->create();
            $collection->addAttributeToSelect('*');
            $collection->addFieldToFilter('visibility', 4);
            $collection->addAttributeToFilter('status', Status::STATUS_ENABLED);
            $collection->addCategoriesFilter(['in' => $ids]);
            
            return count($collection);
        } else {
            return 0;
        }
    }
}
