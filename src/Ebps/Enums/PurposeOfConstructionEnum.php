<?php

namespace Src\Ebps\Enums;

enum PurposeOfConstructionEnum: string
{
    case RESIDENTIAL = 'residential';
    case COMMERCIAL = 'commercial';
    case EDUCATION = 'education';
    case HEALTH = 'health';
    case GOVERNMENT = 'government';
    case SEMI_GOVERNMENT = 'semi_government';
    case ASSEMBLY_BUILDING = 'assembly_building';
    case INDUSTRY = 'industry';
    case BUSINESS_BUILDING = 'business_building';
    case HOTEL = 'hotel';
    case SERVICE_DISTRIBUTION = 'service_distribution';
    case APARTMENT = 'apartment';
    case INSTITUTION = 'institution';
    case HAZARDOUS_BUILDING = 'hazardous_building';
    case PSYCHIATRIC_BUILDING = 'psychiatric_building';

    case INDUSTRIAL = 'industrial'; 
    case COMMERCIAL_BUILDING = 'commercial_building';
    case ORGANIZATION = 'organization';

    case DANGEROUS_GOODS = 'dangerous_goods';
    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::RESIDENTIAL => __('आवासीय'),
            self::ORGANIZATION => __('संस्था'),
            self::PSYCHIATRIC_BUILDING => __('मानसिकरोग भेटा हुने भवन'),
            self::COMMERCIAL => __('व्यवसायिक'),
            self::EDUCATION => __('शिक्षा'),
            self::HEALTH => __('स्वास्थ्'),
            self::GOVERNMENT => __('सरकारी'),
            self::SEMI_GOVERNMENT => __('अर्ध सरकारी'),
            self::ASSEMBLY_BUILDING => __('मानिसहरू भेला हुने भवन'),
            self::INDUSTRY => __('उद्योग'),
            self::BUSINESS_BUILDING => __('व्यावसायिक भवन'),
            self::HOTEL => __('होटल'),
            self::SERVICE_DISTRIBUTION => __('सेवा प्रवाह तथा वितरण सुविधा'),
            self::APARTMENT => __('अपार्टमेन्ट'),
            self::INSTITUTION => __('संस्था'),
            self::HAZARDOUS_BUILDING => __('जोखिमयुक्त पदार्थ रोकथाम भवन'),
            self::INDUSTRIAL => __('उद्योग'),
            self::COMMERCIAL_BUILDING => __('व्यावसायिक भवन'),
            self::DANGEROUS_GOODS => __('जोखिमयुक्त पदार्थ रोकथाम भवन'),
        };
    }

    public static function getValuesWithLabels(): array
    {
        return array_map(fn($value) => [
            'value' => $value->value,
            'label' => $value->label(),
        ], self::cases());
    }
}
