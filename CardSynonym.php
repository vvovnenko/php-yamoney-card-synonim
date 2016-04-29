<?php

namespace vvovnenko\Yamoney;


use vvovnenko\Yamoney\CardSynonym\Exception\RequestException;
use vvovnenko\Yamoney\CardSynonym\Response;

class CardSynonym
{
    /**
     * @var Response
     */
    protected $lastResponse;

    /**
     * @param $cardNumber
     * @return Response
     * @throws RequestException
     */
    public function request($cardNumber)
    {
        $handler = curl_init('https://paymentcard.yamoney.ru/gates/card/storeCard');

        curl_setopt($handler, CURLOPT_POST, true);

        $postFields = http_build_query(array(
            'skr_destinationCardNumber' => $cardNumber,
            'skr_responseFormat' => 'json',
        ));
        curl_setopt($handler, CURLOPT_POSTFIELDS, $postFields);

        ob_start();
        if (!curl_exec($handler)) {
            throw new RequestException('Error while performing request (' . curl_error($handler) . ')');
        }
        $content = ob_get_contents();
        ob_end_clean();
        curl_close($handler);

        if (trim($content) == '') {
            throw new RequestException('No response was received from the server');
        }

        $this->lastResponse = new Response($content);

        return $this->lastResponse;
    }

    /**
     * @return Response
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }


}