<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Leeto\AdminTheme\Model\Config\Source;

class ThemeId implements \Magento\Framework\Data\OptionSourceInterface
{

    public function __construct(
        \Magento\Theme\Model\ResourceModel\Theme\CollectionFactory $themeCollectionFactory
    ) {
        $this->themeCollectionFactory = $themeCollectionFactory;
    }
    
    public function toOptionArray()
    {
        return $this->themeCollectionFactory->create()
            ->addAreaFilter(\Magento\Framework\App\Area::AREA_ADMINHTML)
            ->loadData()
            ->toOptionArray();
    }
}

