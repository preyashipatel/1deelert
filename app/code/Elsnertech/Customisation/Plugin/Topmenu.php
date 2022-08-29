<?php
namespace Elsnertech\Customisation\Plugin;
use Magento\Backend\Model\Menu;
use Magento\Framework\Data\Tree\Node;
use Magento\Framework\Data\Tree\Node\Collection;
use Magento\Framework\Data\Tree\NodeFactory;
use Magento\Framework\Data\TreeFactory;
use Magento\Framework\DataObject;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\Product\Attribute\Source\Status;

class Topmenu extends \Magento\Theme\Block\Html\Topmenu
{
	/**
     * Cache identities
     *
     * @var array
     */
    protected $identities = [];

    /**
     * Top menu data tree
     *
     * @var Node
     */
    protected $_menu;

    /**
     * @var NodeFactory
     */
    private $nodeFactory;

    /**
     * @var TreeFactory
     */
    private $treeFactory;

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $_productCollectionFactory;
    protected $_collectionFactory;

    /**
     * @param Template\Context $context
     * @param NodeFactory $nodeFactory
     * @param TreeFactory $treeFactory
     * @param array $data
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory 
     * @param \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory 
     */
    public function __construct(
        Template\Context $context,
        NodeFactory $nodeFactory,
        TreeFactory $treeFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $collecionFactory,
        array $data = []
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_collectionFactory = $collecionFactory;
        parent::__construct($context,$nodeFactory,$treeFactory,$data);
    }
	
	 /**
     * Recursively generates top menu html from data that is specified in $menuTree
     *
     * @param Node $menuTree
     * @param string $childrenWrapClass
     * @param int $limit
     * @param array $colBrakes
     * @return string
     */
    protected function _getHtml(
        Node $menuTree,
        $childrenWrapClass,
        $limit,
        array $colBrakes = []
    ) {
        $html = '';

        $children = $menuTree->getChildren();
        $childLevel = $this->getChildLevel($menuTree->getLevel());
        $this->removeChildrenWithoutActiveParent($children, $childLevel);

        $counter = 1;
        $childrenCount = $children->count();

        $parentPositionClass = $menuTree->getPositionClass();
        $itemPositionClassPrefix = $parentPositionClass ? $parentPositionClass . '-' : 'nav-';

        /** @var Node $child */
        foreach ($children as $child) {
            //echo '<pre>';print_r($child->getData());exit;
            $child->setLevel($childLevel);
            $child->setIsFirst($counter === 1);
            $child->setIsLast($counter === $childrenCount);
            $child->setPositionClass($itemPositionClassPrefix . $counter);
            $collection = $this->_collectionFactory
                ->create()
                ->addAttributeToFilter('name',$child->getName())
                ->setPageSize(1);
            if ($collection->getSize()) {
                $categoryId = $collection->getFirstItem()->getId();
            }
            $outermostClassCode = '';
            $outermostClass = $menuTree->getOutermostClass();

            if ($childLevel === 0 && $outermostClass) {
                $outermostClassCode = ' class="' . $outermostClass . '" ';
                $this->setCurrentClass($child, $outermostClass);
            }

            if ($this->shouldAddNewColumn($colBrakes, $counter)) {
                $html .= '</ul></li><li class="column"><ul>';
            }

            $html .= '<li ' . $this->_getRenderedMenuItemAttributes($child) . '>';
            $html .= '<a href="' . $child->getUrl() . '" ' . $outermostClassCode . '><span>' . $this->escapeHtml(
                $child->getName()
            ) . '</span><span class="product-count">('.
                    $this->getProductCollectionByCategories($categoryId).')</span></a>' . $this->_addSubMenu(
                $child,
                $childLevel,
                $childrenWrapClass,
                $limit
            ) . '</li>';
            $counter++;
        }

        if (is_array($colBrakes) && !empty($colBrakes) && $limit) {
            $html = '<li class="column"><ul>' . $html . '</ul></li>';
        }

        return $html;
    }

    /**
     * Remove children from collection when the parent is not active
     *
     * @param Collection $children
     * @param int $childLevel
     * @return void
     */
    private function removeChildrenWithoutActiveParent(Collection $children, int $childLevel): void
    {
        /** @var Node $child */
        foreach ($children as $child) {
            if ($childLevel === 0 && $child->getData('is_parent_active') === false) {
                $children->delete($child);
            }
        }
    }

    /**
     * Retrieve child level based on parent level
     *
     * @param int $parentLevel
     *
     * @return int
     */
    private function getChildLevel($parentLevel): int
    {
        return $parentLevel === null ? 0 : $parentLevel + 1;
    }

    private function setCurrentClass(Node $child, string $outermostClass): void
    {
        $currentClass = $child->getClass();
        if (empty($currentClass)) {
            $child->setClass($outermostClass);
        } else {
            $child->setClass($currentClass . ' ' . $outermostClass);
        }
    }
    /**
     * Check if new column should be added.
     *
     * @param array $colBrakes
     * @param int $counter
     * @return bool
     */
    private function shouldAddNewColumn(array $colBrakes, int $counter): bool
    {
        return count($colBrakes) && $colBrakes[$counter]['colbrake'];
    }

    /**
     * Generates string with all attributes that should be present in menu item element
     *
     * @param Node $item
     * @return string
     */
    protected function _getRenderedMenuItemAttributes(Node $item)
    {
        $html = '';
        foreach ($this->_getMenuItemAttributes($item) as $attributeName => $attributeValue) {
            $html .= ' ' . $attributeName . '="' . str_replace('"', '\"', $attributeValue) . '"';
        }
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