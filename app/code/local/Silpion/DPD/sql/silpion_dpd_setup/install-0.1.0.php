<?php

$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer->startSetup();
$connection = $installer->getConnection();
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

if (!$connection->tableColumnExists($installer->getTable('sales/order'), 'dpd_point')) {
    $connection->addColumn(
        $installer->getTable('sales/order'),
        'dpd_point',
        array(
        'type'=>Varien_Db_Ddl_Table::TYPE_TEXT,
        'length' => 16,
        'nullable'=> true,
        'comment'=> 'DPD Point'
    )
    );
}

$installer->endSetup();
