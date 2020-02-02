<?php
namespace MRYM\AdBanner\Block\Adminhtml\Banner\Edit;

use Magento\Backend\Block\Widget\Form\Generic;

/**
 * Adminhtml cms page edit form block
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Form extends Generic
{
    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post','enctype' => 'multipart/form-data']]
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
