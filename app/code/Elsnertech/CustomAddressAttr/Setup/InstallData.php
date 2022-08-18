<?php
/**
 * Copyright © 2017 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

namespace Elsnertech\CustomAddressAttr\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Quote\Setup\QuoteSetup;
use Magento\Quote\Setup\QuoteSetupFactory;
use Magento\Sales\Setup\SalesSetup;
use Magento\Sales\Setup\SalesSetupFactory;

/**
 * Class InstallData
 * @package Elsnertech\CustomAddressAttr\Setup
 */
class InstallData implements InstallDataInterface
{
    /**
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;

    /**
     * @var SalesSetupFactory
     */
    private $salesSetupFactory;

    /**
     * @var QuoteSetupFactory
     */
    private $quoteSetupFactory;

    /**
     * InstallData constructor.
     * @param CustomerSetupFactory $customerSetupFactory
     * @param SalesSetupFactory $salesSetupFactory
     * @param QuoteSetupFactory $quoteSetupFactory
     */
    public function __construct(
        CustomerSetupFactory $customerSetupFactory,
        SalesSetupFactory $salesSetupFactory,
        QuoteSetupFactory $quoteSetupFactory
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->salesSetupFactory = $salesSetupFactory;
        $this->quoteSetupFactory = $quoteSetupFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        $customerSetup->addAttribute('customer_address', 'distric', [
            'label' => 'Distric',
            'input' => 'text',
            'type' => 'varchar',
            'source' => '',
            'required' => false,
            'position' => 100,
            'visible' => true,
            'system' => false,
            'is_used_in_grid' => true,
            'is_visible_in_grid' => true,
            'is_filterable_in_grid' => true,
            'is_searchable_in_grid' => true,
            'backend' => ''
        ]);

        $customerSetup->addAttribute('customer_address', 'sub_distric', [
            'label' => 'Sub distric',
            'input' => 'text',
            'type' => 'varchar',
            'source' => '',
            'required' => false,
            'position' => 101,
            'visible' => true,
            'system' => false,
            'is_used_in_grid' => true,
            'is_visible_in_grid' => true,
            'is_filterable_in_grid' => true,
            'is_searchable_in_grid' => true,
            'backend' => ''
        ]);


        $attribute = $customerSetup->getEavConfig()->getAttribute('customer_address', 'distric')
            ->addData(['used_in_forms' => [
                'adminhtml_customer_address',
                'customer_address_edit',
                'customer_register_address'
            ]]);

        $attribute->save();

        $attribute = $customerSetup->getEavConfig()->getAttribute('customer_address', 'sub_distric')
            ->addData(['used_in_forms' => [
                'adminhtml_customer_address',
                'customer_address_edit',
                'customer_register_address'
            ]]);

        $attribute->save();
        $installer = $setup;

        $installer->getConnection()->addColumn(
            $installer->getTable('quote_address'),
            'distric',
            [
                'comment' => 'Distric',
                'type' => Table::TYPE_TEXT,
                'length' => 255
            ]
        );

        $installer->getConnection()->addColumn(
            $installer->getTable('quote_address'),
            'sub_distric',
            [
                'comment' => 'Sub distric',
                'type' =>  Table::TYPE_TEXT,
                'length' => 255
            ]
        );
        

        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order_address'),
            'distric',
            [
                'comment' => 'distric',
                'type' =>  Table::TYPE_TEXT,
                'length' => 255
            ]
        );
        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order_address'),
            'sub_distric',
            [
                'comment' => 'Sub distric',
                'type' =>  Table::TYPE_TEXT,
                'length' => 255
            ]
        );
        
    }
}
