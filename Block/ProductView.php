<?php

namespace Dudchenko\ProductAdditionalAttributes\Block;

use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;
use \Magento\Framework\Registry;
use Magento\Catalog\Model\Product;

class ProductView extends Template
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var Product
     */
    protected $product;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->registry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * @return Product|null
     */
    private function getProduct(): Product|null
    {
        return is_null($this->product) ? $this->registry->registry('product') : $this->product;
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
