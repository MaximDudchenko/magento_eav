<?php

namespace Dudchenko\ProductAdditionalAttributes\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Setup\CategorySetup;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Setup\CategorySetupFactory;

class AddProductHeightAttribute implements DataPatchInterface
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

        $attributeCode = 'product_height';
        $attributeLabel = 'Product Height';
        $attributeGroup = 'General';

        $categorySetup->addAttribute(
            Product::ENTITY,
            $attributeCode,
            [
                'type' => 'int',
                'frontend' => '',
                'label' => $attributeLabel,
                'input' => 'text',
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'is_visible' => true,
                'required' => false,
                'user_defined' => true,
                'visible_on_front' => true,
                'unique' => false,
                'sort_order' => 50
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
                100
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
