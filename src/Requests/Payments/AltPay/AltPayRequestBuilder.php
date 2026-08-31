<?php

declare(strict_types = 1);

namespace AvtoDev\CloudPayments\Requests\Payments\AltPay;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;
use AvtoDev\CloudPayments\Requests\Traits\HasReceipt;
use AvtoDev\CloudPayments\Requests\AbstractRequestBuilder;
use AvtoDev\CloudPayments\Requests\Traits\PaymentRequestTrait;

/**
 * Digital Ruble and other alternative payment methods via /payments/altpay/pay.
 *
 * @see AltPayType::DigitalRubImage QR code payment initiation
 * @see AltPayType::DigitalRubLink  Payment link initiation
 */
class AltPayRequestBuilder extends AbstractRequestBuilder
{
    use PaymentRequestTrait, HasReceipt;

    /**
     * Required.
     *
     * @see \AvtoDev\CloudPayments\References\AltPayType
     *
     * @var string|null
     */
    protected $alt_pay_type;

    /**
     * @var string|null
     */
    protected $public_id;

    /**
     * Payment scheme: charge (single-stage) or auth (dual-stage).
     *
     * @var string|null
     */
    protected $scheme;

    /**
     * @var string|null
     */
    protected $success_redirect_url;

    /**
     * @var string|null
     */
    protected $fail_redirect_url;

    /**
     * @var string|null
     */
    protected $os;

    /**
     * @var bool|null
     */
    protected $webview;

    /**
     * @var string|null
     */
    protected $device;

    /**
     * @var string|null
     */
    protected $browser;

    /**
     * @var int|null
     */
    protected $ttl_minutes;

    /**
     * @var bool|null
     */
    protected $is_test;

    /**
     * Required.
     *
     * @param string $alt_pay_type
     *
     * @return $this
     */
    public function setAltPayType(string $alt_pay_type): self
    {
        $this->alt_pay_type = $alt_pay_type;

        return $this;
    }

    /**
     * @param string $public_id
     *
     * @return $this
     */
    public function setPublicId(string $public_id): self
    {
        $this->public_id = $public_id;

        return $this;
    }

    /**
     * @param string $scheme
     *
     * @return $this
     */
    public function setScheme(string $scheme): self
    {
        $this->scheme = $scheme;

        return $this;
    }

    /**
     * @param string $success_redirect_url
     *
     * @return $this
     */
    public function setSuccessRedirectUrl(string $success_redirect_url): self
    {
        $this->success_redirect_url = $success_redirect_url;

        return $this;
    }

    /**
     * @param string $fail_redirect_url
     *
     * @return $this
     */
    public function setFailRedirectUrl(string $fail_redirect_url): self
    {
        $this->fail_redirect_url = $fail_redirect_url;

        return $this;
    }

    /**
     * @param string $os
     *
     * @return $this
     */
    public function setOs(string $os): self
    {
        $this->os = $os;

        return $this;
    }

    /**
     * @param bool $webview
     *
     * @return $this
     */
    public function setWebview(bool $webview): self
    {
        $this->webview = $webview;

        return $this;
    }

    /**
     * @param string $device
     *
     * @return $this
     */
    public function setDevice(string $device): self
    {
        $this->device = $device;

        return $this;
    }

    /**
     * @param string $browser
     *
     * @return $this
     */
    public function setBrowser(string $browser): self
    {
        $this->browser = $browser;

        return $this;
    }

    /**
     * @param int $ttl_minutes
     *
     * @return $this
     */
    public function setTtlMinutes(int $ttl_minutes): self
    {
        $this->ttl_minutes = $ttl_minutes;

        return $this;
    }

    /**
     * @param bool $is_test
     *
     * @return $this
     */
    public function setIsTest(bool $is_test): self
    {
        $this->is_test = $is_test;

        return $this;
    }

    /**
     * @inheritdoc
     */
    protected function getRequestPayload(): array
    {
        $this->setJsonData(\array_merge($this->json_data ?? [], $this->getReceiptData()));

        return \array_merge($this->getCommonPaymentParams(), [
            'PublicId'           => $this->public_id,
            'AltPayType'         => $this->alt_pay_type,
            'Scheme'             => $this->scheme,
            'SuccessRedirectUrl' => $this->success_redirect_url,
            'FailRedirectUrl'    => $this->fail_redirect_url,
            'Os'                 => $this->os,
            'Webview'            => $this->webview,
            'Device'             => $this->device,
            'Browser'            => $this->browser,
            'TtlMinutes'         => $this->ttl_minutes,
            'IsTest'             => $this->is_test,
        ]);
    }

    /**
     * @inheritdoc
     */
    protected function getUri(): UriInterface
    {
        return new Uri('/payments/altpay/pay');
    }
}
