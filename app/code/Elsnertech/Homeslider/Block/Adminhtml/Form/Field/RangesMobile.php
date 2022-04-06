<?php
namespace Elsnertech\Homeslider\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Ranges
 */
class RangesMobile extends AbstractFieldArray
{
    /**
     * @var TaxColumn
     */
    private $taxRenderer;

    /**
     * Prepare rendering the new field by adding all the needed columns
     */
    protected function _prepareToRender()
    {
        $fileInputRenderer = $this->getImageColumnRenderer();
        $this->addColumn('category_name', ['label' => __('Category Name'), 'class' => 'required-entry']);
        $this->addColumn(
            'image',
            [
                'label' => __('Image'),
                'renderer' => $this->_geImageColumnRenderer()
            ]
        );
        $this->addColumn('url', ['label' => __('View All URL')]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    /**
     * Prepare existing row data object
     *
     * @param DataObject $row
     * @throws LocalizedException
     */

/**
 * Image Column Renderer
 *
 * @param string $columnName
 * @return string
 * @throws \Exception
 */
	protected function _geImageColumnRenderer() { 
	//if( !$this->_imageRenderer ) {
		$this->_imageRenderer = $this->getLayout()->createBlock('Elsnertech\Homeslider\Block\Adminhtml\Form\Field\MyFileRenderer','',['data' => ['is_render_to_js_template' => true,]]);

	//}
		return $this->_imageRenderer;
	}
}
