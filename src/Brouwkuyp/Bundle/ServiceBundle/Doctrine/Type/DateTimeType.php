<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Doctrine\Type;

use Brouwkuyp\Bundle\ServiceBundle\Doctrine\DateTime;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeType as BaseDateTimeType;

/**
 * DateTimeType
 */
class DateTimeType extends BaseDateTimeType
{
    /**
     * @param  mixed                                    $value
     * @param  AbstractPlatform                         $platform
     * @return \DateTime|DateTime
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (!$dateTime = parent::convertToPHPValue($value, $platform)) {
            return $value;
        }

        return new DateTime('@' . $dateTime->format('U'));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'brouwkuyp_datetime';
    }
}
