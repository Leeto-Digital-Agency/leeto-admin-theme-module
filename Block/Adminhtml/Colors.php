<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Leeto\AdminTheme\Block\Adminhtml;

class Colors extends \Magento\Backend\Block\Template
{

    const XML_BASE_PATH = 'admin/colors/';
    
    const XML_PATH_THEME_ID = 'admin/theme/theme_id';

    const LETTO_THEME_CODE = 'Leeto/theme';
    
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Theme\Model\ThemeFactory
     */
    protected $themeFactory;
    
    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Template\Context  $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Theme\Model\ThemeFactory $themeFactory,
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->themeFactory = $themeFactory;
        parent::__construct($context, $data);
    }

    public function isThemeActive() {
        // load theme by code
        $theme = $this->themeFactory->create()->load(self::LETTO_THEME_CODE, 'code');
        // check if theme is active
        $selectedTheme = $this->scopeConfig->getValue(
            self::XML_PATH_THEME_ID,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
        );
        return $theme->getId() == $selectedTheme;
        
    }
    
    public function getColorByPath($path, $default) {
        $config = $this->scopeConfig->getValue(
            self::XML_BASE_PATH . $path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
        );
        if ($config) {
            return $config;
        }
        return $default;
    }

    public function darkenColor($hex){
        $color = str_replace('#', '', $hex);
        if (strlen($color) == 3) {
            $color = $color[0] . $color[0] . $color[1] . $color[1] . $color[2] . $color[2];
        }
        $darkness = 0.2;
        $darkness = min($darkness, 1);
        $darkness = max($darkness, 0);
        $red = hexdec(substr($color, 0, 2));
        $green = hexdec(substr($color, 2, 2));
        $blue = hexdec(substr($color, 4, 2));
        $red = round($red * (1 - $darkness));
        $green = round($green * (1 - $darkness));
        $blue = round($blue * (1 - $darkness));
        $darkenedColor = "#".sprintf("%02x", ($red)).sprintf("%02x", ($green)).sprintf("%02x", ($blue));
        return $darkenedColor;
    }

    public function lightenColor($hex) {
        $color = str_replace('#', '', $hex);
        if (strlen($color) == 3) {
            $color = $color[0] . $color[0] . $color[1] . $color[1] . $color[2] . $color[2];
        }
        $lightness = 0.2;
        $lightness = min($lightness, 1);
        $lightness = max($lightness, 0);
        $red = hexdec(substr($color, 0, 2));
        $green = hexdec(substr($color, 2, 2));
        $blue = hexdec(substr($color, 4, 2));
        $red = round($red * (1 + $lightness));
        $green = round($green * (1 + $lightness));
        $blue = round($blue * (1 + $lightness));
        $lightenedColor = "#".sprintf("%02x", ($red)).sprintf("%02x", ($green)).sprintf("%02x", ($blue));
        return $lightenedColor;
    }

}