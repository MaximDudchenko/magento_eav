<?php

namespace Dudchenko\ProductAdditionalAttributes\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Setup\CategorySetup;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Setup\CategorySetupFactory;

class AddProductHeightEnableAttribute implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var CategorySetupFactory
     */
    private $categorySetupFactory;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CategorySetupFactory $categorySetupFactory
     */
    public function __construct(
      ModuleDataSetupInterface $moduleDataSetup,
      CategorySetupFactory $categorySetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->categorySetupFactory = $categorySetupFactory;
    }

    public function apply()
    {
        /** @var CategorySetup $categorySetup */
        $categorySetup = $this->categorySetupFactory->create(['setup' => $this->moduleDataSetup]);

        $attributeCode = 'product_height_enable';
        $attributeLabel = 'Product Height Enable';
        $attributeGroup = 'General';

        $categorySetup->addAttribute(
            Product::ENTITY,
            $attributeCode,
            [
                'type' => 'int',
                'frontend' => '',
                'label' => $attributeLabel,
                'input' => 'boolean',
                'backend' => Product\Attribute\Backend\Boolean::class,
                'source' => Product\Attribute\Source\Boolean::class,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'is_visible' => true,
                'required' => false,
                'user_defined' => true,
                'default' => false,
                'visible_on_front' => true,
                'unique' => false,
                'filterable' => 1,
                'is_html_allowed_on_front' => true,
                'sort_order' => 49
            ]
        );

        $attributeSetIds = $categorySetup->getAllAttributeSetIds(Product::ENTITY);
        foreach ($attributeSetIds as $attributeSetId) {
            $attributeGroupId = $categorySetup->getAttributeGroupId(Product::ENTITY, $attributeSetId, $attributeGroup);
            $categorySetup->addAttributeToGroup(
                Product::ENTITY,
                $attributeSetId,
                $attributeGroupId,
                $attributeCode,
                99
            );
        }
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }


}
