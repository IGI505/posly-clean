<?php

namespace App\Services;

class CustomerDisplayService
{
    protected $serialPort;
    protected $port;

    public function __construct($port = '/dev/ttyS0')
    {
        $this->port = $port;
        $this->serialPort = fopen($port, 'w+');

        stream_set_blocking($this->serialPort, 0);

        exec("stty -F {$port} cs8 2400 -parenb -cstopb -crtscts");
    }

    public function setIndicatorLight($light)
    {
        $command = chr(27) . chr(115);

        switch (strtolower($light)) {
            case 'total':
                $command .= chr(50);
                break;
            case 'price':
                $command .= chr(51);
                break;
            case 'change':
                $command .= chr(52);
                break;
            default:
                throw new \InvalidArgumentException("ضوء مؤشر غير صحيح: $light");
        }

        $this->writeToDisplay($command);
    }

    public function sendText($text)
    {
        $text = str_pad(substr($text, 0, 8), 8, ' ', STR_PAD_LEFT);

        $command = chr(27) . chr(81) . chr(65) . $text . chr(13);

        $this->writeToDisplay($command);
    }

    protected function writeToDisplay($command)
    {
        fwrite($this->serialPort, $command);
    }

    public function __destruct()
    {
        fclose($this->serialPort);
    }
}
