<?php

namespace App\Classes;

use Fcm\Exception\FcmClientException;
use Fcm\FcmClient;
use JetBrains\PhpStorm\Pure;

class Notification
{

    /**
     * @var FcmClient
     */
    protected FcmClient $client;

    /**
     * @var \Fcm\Push\Notification
     */
    protected \Fcm\Push\Notification $notification;

    /**
     * @var array
     */
    protected array $users;

    /**
     * @var string
     */
    protected string $title;

    /**
     * @var string
     */
    protected string $body;

    public function __construct(FcmClient $client, \Fcm\Push\Notification $notification)
    {
        $this->client = $client;
        $this->notification = $notification;
    }

    /**
     * @param FcmClient $client
     * @param \Fcm\Push\Notification $notification
     * @return static
     */
    #[Pure]
    public static function init(FcmClient $client, \Fcm\Push\Notification $notification): static
    {
        return new static($client, $notification);
    }

    /**
     * @param array $users
     * @return $this
     */
    public function setDeviceIds(array $users): Notification
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): Notification
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string $body
     * @return $this
     */
    public function setBody(string $body): Notification
    {
        $this->body = $body;

        return $this;
    }

    public function send()
    {

        $notification = $this->notification
            ->addRecipient($this->users)
            ->setTitle($this->title)
            ->setBody($this->body)
            ->setSound('default');

        try {
            return $this->client->send($notification);
        } catch (FcmClientException $exception) {
            return $exception;
        }

    }

}
