<?php


namespace App\Classes;

use Illuminate\Support\Facades\Http;

class Sms
{

    /**
     * SMS gönderilecek telefon numarası
     *
     * @var string
     */
    private string $phoneNumber;

    /**
     * Gönderilen SMS başlığı.
     *
     * @var string
     */
    private string $title;

    /**
     * @var string
     */
    private string $msg;

    public static function init(string $phoneNumber): Sms
    {
        return (new self())->setGsmNo($phoneNumber);
    }

    /**
     * @param string $phoneNumber
     * @return $this
     */
    public function setGsmNo(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title = 'M.KARATAS'): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string $code
     * @return $this
     */
    public function setMsgForRegister(string $code): static
    {
        $this->msg = "ManyPaw için üye kayıt kodunuz: $code";

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setMsgForApprove(string $name): static
    {
        $this->msg = "Sayın $name, ManyPaw'a hoşgeldiniz! İyi günler dileriz.";

        return $this;
    }

    /**
     *
     */
    public function send(): void
    {

        $url = config('sms.netgsm_url');

        $sms = Http::get($url, [
            'usercode' => config('sms.netgsm_username'),
            'password' => config('sms.netgsm_password'),
            'gsmno' => $this->phoneNumber,
            'message' => $this->msg,
            'msgheader' => $this->title,
            'dil' => 'TR'
        ]);

    }
}
