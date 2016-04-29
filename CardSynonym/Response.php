<?php

namespace vvovnenko\Yamoney\CardSynonym;


class Response
{
    const REASON_SUCCESS = 'success';
    const REASON_FAIL = 'cardinvalid';

    /** @var  string raw response data from yandex money */
    protected $rawData;

    /**
     * Result of data processing:
     * 'success' if successful
     * 'cardinvalid' if failed
     * @var  string
     */
    protected $reason;

    /** @var  string Bank card mask */
    protected $panmask;

    /** @var  string Bank card synonym */
    protected $synonym;

    /** @var  string Name of the card-issuing bank */
    protected $bankName;

    /** @var  string Digital code of the card-issuing country */
    protected $countryCode;

    /** @var  string Name of the card's payment system */
    protected $paymentSystem;

    /** @var  string Name of the card product */
    protected $productName;

    /** @var  string Code of the card product */
    protected $productCode;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        $this->rawData = $response;

        $data = json_decode($response);

        if (isset($data->storeCard)) {
            $this->reason = (string)$data->storeCard->reason;
            if ($this->reason == self::REASON_SUCCESS) {
                $this->panmask = (string)@$data->storeCard->skr_destinationCardPanmask;
                $this->synonym = (string)@$data->storeCard->skr_destinationCardSynonim;

                $this->bankName = (string)@$data->storeCard->skr_destinationCardBankName;
                $this->countryCode = (string)@$data->storeCard->skr_destinationCardCountryCode;
                $this->paymentSystem = (string)@$data->storeCard->skr_destinationCardPaymentSystem;
                $this->productName = (string)@$data->storeCard->skr_destinationCardProductName;
                $this->productCode = (string)@$data->storeCard->skr_destinationCardProductCode;
            }
        }

    }

    /**
     * @return string
     */
    public function getRawData()
    {
        return $this->rawData;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @return string
     */
    public function getPanmask()
    {
        return $this->panmask;
    }

    /**
     * @return string
     */
    public function getSynonym()
    {
        return $this->synonym;
    }

    /**
     * @return string
     */
    public function getBankName()
    {
        return $this->bankName;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @return string
     */
    public function getPaymentSystem()
    {
        return $this->paymentSystem;
    }

    /**
     * @return string
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * @return string
     */
    public function getProductCode()
    {
        return $this->productCode;
    }


}