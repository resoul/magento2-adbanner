<?php
namespace MRYM\AdBanner\Controller\Adminhtml;

/**
 * Admin blog post edit controller
 */
class Banner extends Actions
{
    /**
     * Form session key
     * @var string
     */
    protected $_formSessionKey  = 'mrym_adbanner_form_data';

    /**
     * Allowed Key
     * @var string
     */
    protected $_allowedKey      = 'MRYM_AdBanner::banner';

    /**
     * Model class name
     * @var string
     */
    protected $_modelClass      = 'MRYM\AdBanner\Model\Banner';

    /**
     * Active menu key
     * @var string
     */
    protected $_activeMenu      = 'MRYM_AdBanner::banner';

    /**
     * Save request params key
     * @var string
     */
    protected $_paramsHolder 	= 'banner';
}
