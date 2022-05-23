<?php
namespace Elsnertech\Flashsale\Model\ResourceModel;

use Elsnertech\Flashsale\Api\Data\FlashsaleInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Flashsale extends AbstractDb
{
    public const TABLE_NAME = 'flashsale';
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $flashsaleProductTable = null;
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $eventManager = null;
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $logger;

    /**
     * Comment of __construct function
     *
     * @param Context $context
     * @param ManagerInterface $eventManager
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Elsnertech\Flashsale\Model\FlashsaleProduct $flashsaleProductFactory
     * @param [type] $connectionName
     */
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
    /**
     * Comment of _construct function
     *
     * @return void
     */
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

    /**
     * Comment of saveProducts function
     *
     * @param AbstractModel $flashsale
     * @return void
     */
    protected function saveProducts(AbstractModel $flashsale)
    {
        $id = $flashsale->getId();
        $product_val = $flashsale->getProductVal();
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
