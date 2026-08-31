<?php

declare(strict_types = 1);

namespace AvtoDev\CloudPayments\References;

/**
 * Alternative payment types.
 */
interface AltPayType
{
    /**
     * Alternative payment type: Digital ruble via QR-code
     */
    public const string DigitalRubImage = 'DigitalRubImage';

    /**
     * Alternative payment type: Digital ruble via payment link
     */
    public const string DigitalRubLink  = 'DigitalRubLink';
}
