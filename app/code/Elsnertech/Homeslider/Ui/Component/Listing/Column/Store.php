<?php
 
namespace Elsnertech\Homeslider\Ui\Component\Listing\Column;
 
use Magento\Framework\Escaper;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Model\System\Store as SystemStore;
 
class Store extends \Magento\Store\Ui\Component\Listing\Column\Store
{
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        SystemStore $systemStore,
        Escaper $escaper,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $systemStore, $escaper, $components, $data, 'store_id'); // Add your column name
    }
 
    protected function prepareItem(array $item)
    {
        $origStores = '';
        $content = $origStores ;

        if (!is_null($item[$this->storeKey])) {
            $origStores = $item[$this->storeKey];
        }
 
        if (!is_array($origStores)) {
            $origStores = explode(',', $origStores);
        }
        if (in_array(0, $origStores) && count($origStores) == 1) {
            return __('All Store Views');
        }
 
        $data = $this->systemStore->getStoresStructure(false, $origStores);
 
        foreach ($data as $website) {
            $content .= $website['label'] . "<br/>";
            foreach ($website['children'] as $group) {
                $content .= str_repeat('&nbsp;', 3) . $this->escaper->escapeHtml($group['label']) . "<br/>";
                foreach ($group['children'] as $store) {
                    $content .= str_repeat('&nbsp;', 6) . $this->escaper->escapeHtml($store['label']) . "<br/>";
                }
            }
        }
 
        return $content;
    }
 
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')] = $this->prepareItem($item);
            }
        }
        return $dataSource;
    }
}