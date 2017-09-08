<?php
/**
 * Created by PhpStorm.
 * User: sks89
 * Date: 08.09.2017
 * Time: 15:35
 */

namespace AppBundle\Services;


use AppBundle\Entity\Order;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;

class ContractCreator
{
    /**
     * @var ClientInterface
     */
    protected $http_client;

    /**
     * @var string
     */
    protected $ssn;

    /**
     * @var string
     */
    protected $doc_template_path;

    /**
     * @var string
     */
    protected $doc_service_url;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $template_placeholders;

    /**
     * @var Order
     */
    protected $order;

    /**
     * ContractCreator constructor.
     * @param ClientInterface $http_client
     * @param string $ssn
     * @param string $doc_template_path
     * @param string $doc_service_url
     */
    public function __construct(ClientInterface $http_client, $ssn, $doc_template_path, $doc_service_url)
    {
        $this->http_client = $http_client;
        $this->ssn = $ssn;
        $this->doc_template_path = $doc_template_path;
        $this->doc_service_url = $doc_service_url;
    }

    public function fillFromOrder(Order $order)
    {
        $this->order = $order;

        $props = [
            'client'   => $order->getUser()->getFullName(),
            'subject'  => $order->getServiceModification()->getService()->getTitle(),
            'amount'   => $order->getServiceModification()->getPrice(),
            'contacts' => $order->getUser()->getOtherContacts(),
            'email'    => $order->getUser()->getEmail(),
            'phone'    => $order->getUser()->getPhone(),
        ];

        $this->setTemplatePlaceholders($props);
    }

    public function setTemplatePlaceholders(array $options)
    {
        array_walk($options, function($val, $key) {
            $placeholder = '%' . strtoupper($key) . '%';
            $this->template_placeholders[$placeholder] = $val;
        });

        $this->template_placeholders['%DD%'] = date('d');
        $this->template_placeholders['%MON%'] = date('m');
    }

    public function downloadSignedContract($filename)
    {
        $result = false;

        $request = $this->_prepareRequest();
        $resp = $this->http_client->send($request);

        if ($resp->getStatusCode() == 200) {
            $content = $resp->getBody()->getContents();
            file_put_contents($filename, $content);
            $result = true;
        }

        return $result;
    }

    protected function _prepareRequest()
    {
        $this->request = $this->http_client->createRequest('POST', $this->doc_service_url, ['body' => [
            'ssn' => $this->ssn, 'path' => $this->doc_template_path,
            'template' => json_encode($this->template_placeholders)
        ]]);

        return $this->request;
    }
}