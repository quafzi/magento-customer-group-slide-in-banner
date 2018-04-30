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
 * Customer Group Slide-In Banner Form Field
 *
 * @package   Quafzi_CustomerGroupSlideInBanner
 * @author    Thomas Birke <magento@netextreme.de>
 */
class Quafzi_CustomerGroupSlideInBanner_Block_Adminhtml_Form_Field_Banners
    extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    /**
     * @var Mage_Core_Block_Html_Select
     */
    protected $_templateRenderer;

    protected $_customerGroupsOptions;

    protected function getStoreIds()
    {
        if ($code = Mage::getSingleton('adminhtml/config_data')->getStore()) { // store level 
            return [ Mage::getModel('core/store')->load($code)->getId() ];
        } elseif (strlen($code = Mage::getSingleton('adminhtml/config_data')->getWebsite())) { // website level
            return Mage::getModel('core/website')->load($code)->getStores()->getAllIds();
        } else { // default level
            return Mage::getModel('core/store')->getCollection()->getAllIds();
        }
    }

    protected function getCmsBlockOptions()
    {
        if (!$this->_cmsBlockOptions) {
            $this->_cmsBlockOptions = Mage::getResourceModel('cms/block_collection')
                ->loadData()->addStoreFilter($this->getStoreIds(), false)->toOptionArray();
            array_unshift($this->_cmsBlockOptions, [
                'value'=> '',
                'label'=> Mage::helper('adminhtml')->__('-- Please Select --')
            ]);
        }
        return $this->_cmsBlockOptions;
    }

    protected function getCustomerGroupsOptions()
    {
        if (!$this->_customerGroupsOptions) {
            $this->_customerGroupsOptions = Mage::getResourceModel('customer/group_collection')
                ->loadData()->toOptionArray();
            array_unshift($this->_customerGroupsOptions, [
                'value'=> '',
                'label'=> Mage::helper('adminhtml')->__('-- Please Select --')
            ]);
        }
        return $this->_customerGroupsOptions;
    }

    /**
     * Create renderer used for displaying the country select element
     *
     * @return Mage_Core_Block_Html_Select
     */
    protected function _getCustomerGroupSelectRenderer()
    {
        if (!$this->_customerGroupSelectRenderer) {
            $this->_customerGroupSelectRenderer = $this->getLayout()->createBlock(
                'quafzi_customergroupslideinbanner/adminhtml_form_field_banners_customer_group_select',
                '',
                [ 'is_render_to_js_template' => true ]
            );

            /* @var $sourceModel Mage_Adminhtml_Model_System_Config_Source_Customer_Group */
            $this->_customerGroupSelectRenderer->setOptions($this->getCustomerGroupsOptions());
        }

        return $this->_customerGroupSelectRenderer;
    }

    /**
     * Create renderer used for displaying the cms block select element
     *
     * @return Mage_Core_Block_Html_Select
     */
    protected function _getCmsBlockSelectRenderer()
    {
        if (!$this->_cmsBlockSelectRenderer) {
            $this->_cmsBlockSelectRenderer = $this->getLayout()->createBlock(
                'quafzi_customergroupslideinbanner/adminhtml_form_field_banners_cms_block_select',
                '',
                [ 'is_render_to_js_template' => true ]
            );

            /* @var $sourceModel Mage_Adminhtml_Model_System_Config_Source_Customer_Group */
            $this->_cmsBlockSelectRenderer->setOptions($this->getCmsBlockOptions());
        }

        return $this->_cmsBlockSelectRenderer;
    }

    /**
     * (non-PHPdoc)
     * @see Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract::_prepareArrayRow()
     */
    protected function _prepareArrayRow(Varien_Object $row)
    {
        $row->setData(
            'option_extra_attr_' . $this->_getCustomerGroupSelectRenderer()->calcOptionHash($row->getData('customer_group_id')),
            'selected="selected"'
        );
        $row->setData(
            'option_extra_attr_' . $this->_getCmsBlockSelectRenderer()->calcOptionHash($row->getData('block_id')),
            'selected="selected"'
        );

        return parent::_prepareArrayRow($row);
    }

    /**
     * (non-PHPdoc)
     * @see Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract::_prepareToRender()
     */
    protected function _prepareToRender()
    {
        $helper = Mage::helper('quafzi_customergroupslideinbanner');
        $this->addColumn('customer_group_id', [
            'label'    => $helper->__('Customer Group'),
            'renderer' => $this->_getCustomerGroupSelectRenderer()
        ]);
        $this->addColumn('title', [
            'label' => $helper->__('Title'),
            'style' => 'width:100px',
        ]);
        $this->addColumn('block_id', [
            'label'    => $helper->__('Static Block'),
            'renderer' => $this->_getCmsBlockSelectRenderer()
        ]);
        // hide "Add after" button
        $this->_addAfter = false;

        return parent::_prepareToRender();
    }
}
