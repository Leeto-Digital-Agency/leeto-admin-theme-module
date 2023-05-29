<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Leeto\AdminTheme\Plugin\Backend\Magento\Theme\Model\View;

use Magento\Store\Model\ScopeInterface;
class Design
{
    const XML_PATH_THEME_ID = 'admin/theme/theme_id';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;
    
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->_scopeConfig = $scopeConfig;
    }
    
    public function aroundGetConfigurationDesignTheme(
        \Magento\Theme\Model\View\Design $subject,
        \Closure $proceed,
        $area = null,
        $params = []
    ) {
        unset($subject);
        //Your plugin code
        if ($area == \Magento\Framework\App\Area::AREA_FRONTEND) {
            return $proceed($area, $params);
        }

        return (string) $this->_scopeConfig->getValue(
            self::XML_PATH_THEME_ID,
            ScopeInterface::SCOPE_STORE,
        );
    }
}

