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

use Magento\Customer\Model\Customer;
use Magento\Customer\Model\ResourceModel\Attribute as AttributeResource;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * Class updates CustomerNickname attribute to be editable in admin panel
 */
class UpdateCustomerNicknameAttribute implements DataPatchInterface
{
    /**
     * Constructor
     *
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
     * @param \Magento\Customer\Setup\CustomerSetupFactory $customerSetupFactory
     * @param \Magento\Customer\Model\ResourceModel\Attribute $attributeResource
     */
    public function __construct(
        private readonly ModuleDataSetupInterface $moduleDataSetup,
        private readonly CustomerSetupFactory $customerSetupFactory,
        private readonly AttributeResource $attributeResource,
    ) {
    }

    /**
     * @inheritdoc
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $attribute = $customerSetup->getEavConfig()
            ->getAttribute(
                Customer::ENTITY,
                AddCustomerNicknameAttribute::CODE
            );
        $attribute->setData('used_in_forms', ['adminhtml_customer', 'customer_account_create']);
        $this->attributeResource->save($attribute);

        $this->moduleDataSetup->getConnection()->endSetup();

        return $this;
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [AddCustomerNicknameAttribute::class];
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }
}
