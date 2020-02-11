<?php

namespace Yu\ProductListDetails\Observer\Block\Adminhtml\Product\Attribute\Edit\Tab;

use Magento\Framework\Event\ObserverInterface;
use Magento\Config\Model\Config\Source\Yesno;

class Front implements ObserverInterface
{
    /**
     * @var Yesno
     */
    protected $_yesNo;
    
    public function __construct(
        Yesno $yesNo
    ) {
        $this->_yesNo = $yesNo;
    }
    
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $observer->getData('form');
        
        /** @var Attribute $attributeObject */
        $attributeObject = $observer->getData('attribute');
        
        $yesnoSource = $this->_yesNo->toOptionArray();
        
        $form->getElement('front_fieldset')->addField(
            'show_in_product_list',
            'select',
            [
                'name' => 'show_in_product_list',
                'label' => __('Show in Product List'),
                'title' => __('Show in Product List'),
                'note' => __('Depends on design theme.'),
                'values' => $yesnoSource
            ]
        );
    }
}
