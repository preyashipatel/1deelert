<?php
namespace Elsnertech\Flashsale\Model\ResourceModel;

use Elsnertech\Flashsale\Api\Data\FlashsaleInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Flashsale extends AbstractDb
{
    const TABLE_NAME = 'flashsale';
    protected $flashsaleProductTable = null;
    protected $eventManager = null;
    protected $logger;

    public function __construct(
        Context $context,
        ManagerInterface $eventManager,
        \Psr\Log\LoggerInterface $logger,
        \Elsnertech\Flashsale\Model\FlashsaleProduct $flashsaleProductFactory,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
        $this->logger = $logger;
        $this->flashsaleProductFactory = $flashsaleProductFactory;

        $this->eventManager = $eventManager;
    }


    protected function _construct()
    {
        $this->_init(static::TABLE_NAME, FlashsaleInterface::ID);
    }

    /**
     * Perform actions after object save
     *
     * @param AbstractModel $object
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function _afterSave(AbstractModel $object)
    {
        $this->saveProducts($object);
        return parent::_afterSave($object);
    }

    protected function saveProducts(AbstractModel $flashsale)
    {


        $id = $flashsale->getId();
        $product_val = $flashsale->getProductVal();
        // print_r($flashsale->getProductSelectedValue());exit;
        if ($product_val != 0) {
            /**
             * new flashsale-product relationships
             */
            $products = json_decode($flashsale->getProductSelectedValue());
           /**
             * Example re-save flashsale
             */
            if ($products === null) {
                $flashsaleProductModel = $this->flashsaleProductFactory;
                $flashsaleProductCollection = $flashsaleProductModel->getCollection()
                            ->addFieldToFilter('flashsale_id', ['eq' => $id]);
                $flashsaleProductCollection->walk('delete');
                return $this;
            }



            $flashsaleProductModel = $this->flashsaleProductFactory;
            $flashsaleProductCollection = $flashsaleProductModel->getCollection()
                        ->addFieldToFilter('flashsale_id', ['eq' => $id]);
            $flashsaleProductCollection->walk('delete');


            foreach ($products as $key => $data) {
                $flashsaleProductModel->setData(
                    [
                        'product_id' => $data,
                        'flashsale_id' => $id,
                    ]
                );
                $flashsaleProductModel->save();
            }
        }

        return $this;
    }
}
