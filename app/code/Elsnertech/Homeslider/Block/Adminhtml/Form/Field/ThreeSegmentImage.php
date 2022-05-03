<?php
namespace Elsnertech\Homeslider\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class ThreeSegmentImage extends AbstractFieldArray
{
protected $renderer = [];
 private $_imageRenderer;
protected function _geImageColumnRenderer() { 
if( !$this->_imageRenderer ) {
  $this->_imageRenderer = $this->getLayout()->createBlock('Elsnertech\Homeslider\Block\Adminhtml\Form\Field\MyFileRenderer','',['data' => ['is_render_to_js_template' => true,]]);
    }
    return $this->_imageRenderer;
}
protected function _prepareToRender()
{
    $this->addColumn('three_segmentimage',['label' => __('Segment Image'),'size' => '50px', 'class' => 'required-entry', 'renderer' => $this->_geImageColumnRenderer()]);
    $this->_addAfter = false;;
    $this->_addButtonLabel = __('Add New Segment');
}
}