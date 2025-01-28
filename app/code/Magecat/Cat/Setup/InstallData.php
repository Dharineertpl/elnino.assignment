<?php
namespace Magecat\Cat\Setup;

use Magento\Catalog\Model\Product;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    protected $eavSetupFactory;

    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        // Add the attribute
        $eavSetup->addAttribute(
            Product::ENTITY,
            'vendor',
            [
                'type' => 'varchar',
                'label' => 'Vendor',
                'input' => 'multiselect',
                'backend' => \Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend::class,
                'required' => false,
                'user_defined' => true,
                'visible' => true,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'option' => [
                    'values' => [
                        'Vendor A',
                        'Vendor B',
                        'Vendor C',
                        'Vendor D'
                    ]
                ]
            ]
        );

        // Assign the attribute to the default attribute set
        $attributeSetId = $eavSetup->getDefaultAttributeSetId(Product::ENTITY);
        $attributeGroupId = $eavSetup->getDefaultAttributeGroupId(Product::ENTITY, $attributeSetId);

        $eavSetup->addAttributeToGroup(
            Product::ENTITY,
            $attributeSetId,
            $attributeGroupId,
            'vendor',
            null // Sort order
        );

        $setup->endSetup();
    }
}
