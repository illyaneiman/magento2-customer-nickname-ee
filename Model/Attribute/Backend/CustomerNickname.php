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

namespace Ineiman\CustomerNickname\Model\Attribute\Backend;

use Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend;
use Magento\Framework\Exception\AlreadyExistsException;

/**
 * Backend model for Customer Nickname attribute
 */
class CustomerNickname extends AbstractBackend
{
    /**
     * Check if nickname unique
     *
     * @param \Magento\Framework\DataObject $object
     * @return void
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    protected function checkUniqueUsername($object)
    {
        $attribute = $this->getAttribute();
        $entity = $attribute->getEntity();
        if (!$entity->checkAttributeUniqueValue($attribute, $object)) {
            throw new AlreadyExistsException(__('Such Nickname is already exist.'));
        }
    }

    /**
     * Check if customer nickname unique before save
     *
     * @param \Magento\Framework\DataObject $object
     * @return $this
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function beforeSave($object)
    {
        $this->checkUniqueUsername($object);
        return parent::beforeSave($object);
    }
}
