<?php
/**
 * Illia Neiman
 *
 * NOTICE OF LICENSE
 *
 * According to LICENCE file you are not allowed to copy, use or recreate this file in any ways.
 * Specially for eCommerce usage.
 *
 * @category Ineiman
 * @package CustomerNickname
 * @copyright Copyright (c) 2021-current Ineiman (https://github.com/illyaneiman)
 * @email kg.illya.ney@gmail.com
 */

namespace Ineiman\CustomerNickname\Setup\Patch\Data;

use Ineiman\CustomerNickname\Model\Attribute\Backend\CustomerNickname;
use Magento\Customer\Model\Customer;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

/**
 * Add attribute customer_nickname
 */
class AddCustomerNicknameAttribute implements DataPatchInterface, PatchRevertableInterface
{
    /**
     * Attribute code
     */
    public const CODE = 'customer_nickname';

    /**
     * Constructor
     *
     * @param \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        private readonly EavSetupFactory $eavSetupFactory,
        private readonly ModuleDataSetupInterface $moduleDataSetup
    ) {
    }

    /**
     * @inheritdoc
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavSetup->removeAttribute(
            Customer::ENTITY,
            self::CODE
        );

        $eavSetup->addAttribute(
            Customer::ENTITY,
            self::CODE,
            [
                'type' => 'varchar',
                'label' => 'Customer Nickname',
                'input' => 'text',
                'required' => 0,
                'user_defined' => 1,
                'sort_order' => 190,
                'position' => 190,
                'visible' => 1,
                'group' => 'Default',
                'attribute_set_id' => 1,
                'attribute_group_id' => 1,
                'visible_on_front' => 0,
                'is_visible_on_front' => 0,
                'system' => 0,
                'backend' => CustomerNickname::class,
                'validate_rules' => '{"input_validation":"alphanumeric","max_text_length":20,"min_text_length":4}'
            ]
        );

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @inheritdoc
     */
    public function revert()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->removeAttribute(Customer::ENTITY, self::CODE);
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }
}
