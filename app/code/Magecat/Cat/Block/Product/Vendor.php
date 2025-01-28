<?php

namespace Magecat\Cat\Block\Product;

use Magento\Catalog\Block\Product\AbstractProduct;
use Magento\Catalog\Block\Product\Context;

class Vendor extends AbstractProduct
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * Vendor constructor.
     *
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        array $data = []
    ) {
        $this->registry = $context->getRegistry();
        parent::__construct($context, $data);
    }

    /**
     * Get the current product.
     *
     * @return \Magento\Catalog\Model\Product|null
     */
    public function getProduct()
    {
        return $this->registry->registry('current_product');
    }

     /**
     * Convert vendor IDs to an array of labels.
     *
     * @param string $vendorIds
     * @return array
     */
    public function getVendorLabels($vendorIds)
    {
        // Get the current product
        $product = $this->getProduct();
        
        // Get the vendor attribute
        $attribute = $product->getResource()->getAttribute('vendor');
        if ($attribute && $attribute->usesSource()) {
            $vendorLabels = [];
            $vendorIdsArray = explode(',', $vendorIds); // Split IDs into an array
            foreach ($vendorIdsArray as $vendorId) {
                $label = $attribute->getSource()->getOptionText($vendorId);
                if ($label) {
                    $vendorLabels[] = $label;
                }
            }
            return $vendorLabels;
        }
        return [];
    }
}
