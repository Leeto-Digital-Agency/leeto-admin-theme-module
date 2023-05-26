<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Leeto\AdminTheme\Block\Adminhtml;

use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Control display of admin analytics and release notification modals
 */
class Logo implements ArgumentInterface
{
    const XML_PATH_LOGO = 'admin/theme/logo';
    
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;
    
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\UrlInterface $urlBuilder
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Get logo url
     *
     * @return string
     */
    public function getLogoUrl() {
        return $this->scopeConfig->getValue(
            self::XML_PATH_LOGO,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
        );
    }

    /**
     * Get logo url
     *
     * @return string
     */
    public function __toString() {
        $mediaUrl = $this->urlBuilder->getBaseUrl(['_type' => \Magento\Framework\UrlInterface::URL_TYPE_MEDIA]);
        $logoUrl = $this->getLogoUrl();
        if (!$logoUrl) {
            return 'images/magento-icon.svg';
        }
        return $mediaUrl . 'logo/' . $logoUrl;
    }
}