<?php

namespace Elsnertech\Flashsale\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * Comment of install function
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
    
        $installer = $setup;

        $installer->startSetup();

            /**
             * Create table 'flashsale'
            */
            $table = $installer->getConnection()->newTable(
                $installer->getTable('flashsale')
            )->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true],
                'Id'
            )->addColumn(
                'name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Name'
            )->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['nullable' => false, 'default' => '1'],
                'Status'
            )->addColumn(
                'start_date',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATE,
                null,
                ['nullable'=> false],
                'Start Date'
            )->addColumn(
                'end_date',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATE,
                null,
                ['nullable'=> false],
                'End Date'
            )->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                'Created At'
            )->addColumn(
                'updated_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                'Updated At'
            )->setComment(
                'Flashsale Table'
            );
        $installer->getConnection()->createTable($table);
        /**
         * Create table 'flashsale_product'
        */
          $table = $installer->getConnection()->newTable(
              $installer->getTable('flashsale_product')
          )->addColumn(
              'id',
              \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
              null,
              ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true],
              'Id'
          )->addColumn(
              'flashsale_id',
              \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
              null,
              ['nullable' => false],
              'Flashsale ID'
          )->addColumn(
              'product_id',
              \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
              null,
              ['nullable' => false],
              'product ID'
          )->setComment(
              'Flashsale To Product Linkage Table'
          );
          $installer->getConnection()->createTable($table);
        $installer->endSetup();
    }
}
