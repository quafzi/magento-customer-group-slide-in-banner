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
 * Quafzi_CustomerGroupSlideInBanner_Block_Banner
 *
 * @package   Quafzi_CustomerGroupSlideInBanner
 * @author    Thomas Birke <magento@netextreme.de>
 */
class Quafzi_CustomerGroupSlideInBanner_Block_Banner
    extends Mage_Core_Block_Template
{
    public function getBannerConfig()
    {
        $customerGroupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
        $groupToBlockMapping = @unserialize(Mage::getStoreConfig('promo/banners/banners'));
        if (!$groupToBlockMapping) {
            $groupToBlockMapping = [];
        }
        foreach ($groupToBlockMapping as $mapping) {
            if ($mapping['customer_group_id'] == $customerGroupId) {
                return $mapping;
            }
        }
    }
}
