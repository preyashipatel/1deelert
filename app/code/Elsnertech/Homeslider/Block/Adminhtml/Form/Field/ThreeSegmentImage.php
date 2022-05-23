<?php
namespace Elsnertech\Homeslider\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class ThreeSegmentImage extends AbstractFieldArray
{
    /**
     * $renderer variable
     *
     * @var array
     */
    protected $renderer = [];
    /**
     * $_imageRenderer variable
     *
     * @var [type]
     */
    private $_imageRenderer;
    /**
     * Comment of _geImageColumnRenderer function
     *
     * @return void
     */
    protected function _geImageColumnRenderer()
    {
        if (!$this->_imageRenderer) {
            $this->_imageRenderer = $this->getLayout()
            ->createBlock(
                \Elsnertech\Homeslider\Block\Adminhtml\Form\Field\MyFileRenderer::class,
                [
                'data' => ['is_render_to_js_template' => true,]
                ]
            );
        }
        return $this->_imageRenderer;
    }
    /**
     * Comment of _prepareToRender function
     *
     * @return void
     */
    protected function _prepareToRender()
    {
        $this->addColumn(
            'three_segmentimage',
            ['label' => __('Segment Image'),'size' => '50px',
            'class' => 'required-entry', 'renderer' => $this->_geImageColumnRenderer()]
        );
        $this->_addAfter = false;
        ;
        $this->_addButtonLabel = __('Add New Segment');
    }
}
