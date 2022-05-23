<?php
namespace Elsnertech\Homeslider\Model\Config\Source;
 
use Magento\Framework\Option\ArrayInterface;
 
class Categorylist implements ArrayInterface
{
    /**
     * $_categoryHelper variable
     *
     * @var [type]
     */
    protected $_categoryHelper;

    /**
     * Comment of __construct function
     *
     * @param \Magento\Catalog\Helper\Category $catalogCategory
     */
    public function __construct(\Magento\Catalog\Helper\Category $catalogCategory)
    {
        $this->_categoryHelper = $catalogCategory;
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
     * Comment of toOptionArray function
     *
     * @return void
     */
    public function toOptionArray()
    {
 
        $arr = $this->toArray();
        $ret = [];
 
        foreach ($arr as $key => $value) {
 
            $ret[] = [
                'value' => $key,
                'label' => $value
            ];
        }
 
        return $ret;
    }

    /**
     * Comment of toArray function
     *
     * @return void
     */
    public function toArray()
    {
 
        $categories = $this->getStoreCategories(true, false, true);
 
        $catagoryList = [];
        foreach ($categories as $category) {
 
            $catagoryList[$category->getEntityId()] = __($category->getName());
        }
 
        return $catagoryList;
    }
}
