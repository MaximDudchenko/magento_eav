<?php

namespace Dudchenko\ProductAdditionalAttributes\Block;

use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;
use \Magento\Framework\Registry;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Api\ProductRepositoryInterface;
use function PHPUnit\Framework\isNull;

class ProductView extends Template
{
    /**
     * @var Product
     */
    protected $product;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @param Context $context
     * @param ProductRepositoryInterface $productRepository
     * @param array $data
     */
    public function __construct(
        Context $context,
        ProductRepositoryInterface $productRepository,
        array $data = []
    ) {
        $this->productRepository = $productRepository;
        parent::__construct($context, $data);
    }

    /**
     * @return Product|null
     */
    private function getProduct(): Product|null
    {
        return is_null($this->product) ? $this->productRepository->getById($this->getRequest()->getParam('id')) : $this->product;
    }


    /**
     * @return int|null
     */
    public function getProductHeight(): int|null
    {
        return $this->getProduct()->getData('product_height');
    }

    /**
     * @return bool|null
     */
    public function getProductHeightEnable(): bool|null
    {
        return $this->getProduct()->getData('product_height_enable');
    }
}
