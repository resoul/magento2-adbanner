<?php
namespace MRYM\AdBanner\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Installs DB schema for a module
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
         * Create table 'mrym_ad_banners'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('mrym_ad_banners')
        )->addColumn(
            'banner_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Banner ID'
        )->addColumn(
            'title',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Title'
        )->addColumn(
            'image',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Image'
        )->addColumn(
            'alt',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Alt Image'
        )->addColumn(
            'identifier',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true, 'default' => null],
            'Identifier'
        )->addColumn(
            'url',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Url'
        )->addColumn(
            'clicks',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'default' => 0],
            'Clicks'
        )->addColumn(
            'clicks_unique',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'default' => 0],
            'Unique Clicks'
        )->addIndex(
            $setup->getIdxName(
                $installer->getTable('mrym_ad_banners'),
                ['title', 'identifier'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            ['title', 'identifier'],
            ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
        )->setComment(
            'Ad Banners'
        );
        $installer->getConnection()->createTable($table);

        /**
         * Create table 'mrym_ad_banners_store'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('mrym_ad_banners_store')
        )->addColumn(
            'banner_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'primary' => true],
            'Banner ID'
        )->addColumn(
            'store_id',
            Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Store ID'
        )->addIndex(
            $installer->getIdxName('mrym_ad_banners_store', ['store_id']),
            ['store_id']
        )->addForeignKey(
            $installer->getFkName('mrym_ad_banners_store', 'banner_id', 'mrym_ad_banners', 'banner_id'),
            'banner_id',
            $installer->getTable('mrym_ad_banners'),
            'banner_id',
            Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName('mrym_ad_banners_store', 'store_id', 'store', 'store_id'),
            'store_id',
            $installer->getTable('store'),
            'store_id',
            Table::ACTION_CASCADE
        )->setComment(
            'Banner To Store Linkage Table'
        );
        $installer->getConnection()->createTable($table);

        /**
         * Create table 'mrym_ad_conversion'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('mrym_ad_conversion')
        )->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'ID'
        )->addColumn(
            'store_id',
            Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Store ID'
        )->addColumn(
            'session_id',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Session ID'
        )->addColumn(
            'key',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Key Id'
        )->addColumn(
            'creation_time',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Creation Time'
        )->setComment(
            'Banner Conversion Table'
        );
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}