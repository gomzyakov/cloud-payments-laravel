<?php

declare(strict_types = 1);

namespace AvtoDev\Tests\Unit\Requests\Payments\AltPay;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use AvtoDev\CloudPayments\References\AltPayType;
use AvtoDev\CloudPayments\References\Currency;
use AvtoDev\Tests\Unit\Requests\AbstractRequestBuilderTestCase;
use AvtoDev\CloudPayments\Requests\Payments\AltPay\AltPayRequestBuilder;

#[CoversClass(AltPayRequestBuilder::class)]
class AltPayRequestBuilderTest extends AbstractRequestBuilderTestCase
{
    public function testRequestPayload(): void
    {
        $request_builder = new AltPayRequestBuilder();
        $request_builder
            ->setPublicId('test_public_id')
            ->setAltPayType(AltPayType::DigitalRubLink)
            ->setScheme('charge')
            ->setAmount(150.50)
            ->setCurrency(Currency::RUB)
            ->setInvoiceId('ORD-4009')
            ->setDescription('Оплата по заказу #4009')
            ->setEmail('buyer@example.com')
            ->setSuccessRedirectUrl('https://avtocod.ru/success')
            ->setTtlMinutes(1440)
            ->setIsTest(true);

        $this->request_builder = $request_builder;

        $payload = \json_decode(
            $this->request_builder->buildRequest()->getBody()->getContents(),
            true,
            512,
            \JSON_THROW_ON_ERROR
        );

        $this->assertSame(150.50, $payload['Amount']);
        $this->assertSame(Currency::RUB, $payload['Currency']);
        $this->assertSame('ORD-4009', $payload['InvoiceId']);
        $this->assertSame('Оплата по заказу #4009', $payload['Description']);
        $this->assertSame('buyer@example.com', $payload['Email']);
        $this->assertSame(AltPayType::DigitalRubLink, $payload['AltPayType']);
        $this->assertSame('https://avtocod.ru/success', $payload['SuccessRedirectUrl']);
        $this->assertSame(1440, $payload['TtlMinutes']);
        $this->assertTrue($payload['IsTest']);
    }

    protected function getRequestBuilder(): AltPayRequestBuilder
    {
        return new AltPayRequestBuilder();
    }

    protected function getUri(): UriInterface
    {
        return new Uri('https://api.cloudpayments.ru/payments/altpay/pay');
    }
}
