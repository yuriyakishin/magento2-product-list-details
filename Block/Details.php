<?php

namespace Yu\ProductListDetails\Block;

use Magento\Catalog\Model\Product;
use Magento\Framework\Phrase;

class Details extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Magento\Catalog\Model\Product
     */
    private $product;

    /**
     * @param Product $product
     * @return $this
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return \Magento\Catalog\Model\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return \Magento\Eav\Model\Entity\Attribute\AbstractAttribute[] | null
     */
    public function getAttributes()
    {
        if ($this->product) {
            return $this->product->getAttributes($this->product->getAttributeSetId());
        }
        return null;
    }

    /**
     * @return array
     */
    public function getDetailsData()
    {
        $data = [];
        $product = $this->getProduct();
        $attributes = $product->getAttributes();
        foreach ($attributes as $attribute)
        {
            if ($attribute->getData('show_in_product_list') == 1) {
                $value = $attribute->getFrontend()->getValue($product);

                if (!empty($value)) {

                    if ($value instanceof Phrase) {
                        $value = (string) $value;
                    }

                    if (is_string($value) && strlen(trim($value))) {
                        $data[$attribute->getAttributeCode()] = [
                            'label' => $attribute->getStoreLabel(),
                            'value' => $value,
                            'code'  => $attribute->getAttributeCode(),
                        ];
                    }
                }
            }
        }
        return $data;
    }

    /**
     * Print product details
     * 
     * @param Product $product
     * @return string
     */
    public function getDetails(Product $product = null)
    {
        if ($product) {
            $this->setProduct($product);
        } else {
            return '';
        }

        return $this->toHtml();
    }

}
