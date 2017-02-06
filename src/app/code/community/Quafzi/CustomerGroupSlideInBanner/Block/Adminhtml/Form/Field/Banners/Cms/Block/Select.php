<?php
/**
 * This file is part of Quafzi_CustomerGroupSlideInBanner
 *
 * PHP version 7
 *
 * @package   Quafzi_CustomerGroupSlideInBanner
 * @author    Thomas Birke <magento@netextreme.de>
 * @copyright 2017 Thomas Birke
 * @license   OSL-3.0
 */

/**
 * CMS Block Select
 *
 * @package   Quafzi_CustomerGroupSlideInBanner
 * @author    Thomas Birke <magento@netextreme.de>
 */
class Quafzi_CustomerGroupSlideInBanner_Block_Adminhtml_Form_Field_Banners_Cms_Block_Select
    extends Mage_Core_Block_Html_Select
{
    protected function _construct()
    {
        $this
            ->setClass('select')
            ->setTitle(Mage::helper('quafzi_customergroupslideinbanner')->__('Select CMS Block'));
    }

    public function setInputName($value)
    {
        return $this->setName($value);
    }
}
