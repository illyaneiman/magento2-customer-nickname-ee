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

namespace Ineiman\CustomerNickname\Controller\Nickname;

use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;

/**
 * Class for validation and check if CustomerNickname already exist
 */
class Validate implements HttpPostActionInterface
{
    /**
     * Construct
     *
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $collectionFactory
     * @param \Magento\Framework\App\RequestInterface $request
     */
    public function __construct(
        private readonly JsonFactory $jsonFactory,
        private readonly CollectionFactory $collectionFactory,
        private readonly RequestInterface $request
    ) {
    }

    /**
     * Validate Nickname attribute
     *
     * @return \Magento\Framework\Controller\Result\Json
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $params = $this->request->getParams();
        $attributeCode = $params['attributeCode'];
        $value = $params['attributeCodeValue'];
        $customerCollection = $this->collectionFactory->create();
        $customerCollection->addAttributeToSelect($attributeCode);
        $customerCollection->addAttributeToFilter($attributeCode, ['eq' => $value])->load();

        $result = $this->jsonFactory->create();
        $customerCollection->getSize() > 0 ? $data['success'] = false : $data['success'] = true;

        $result->setData($data);
        return $result;
    }
}
