<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 28/11/2018
 * Time: 17:37
 */

namespace Rabbit\Http\Response\Types;

use Rabbit\Http\Response\Response;

class HtmlResponse extends Response implements TypeInterface
{

    public function __construct(string $html, int $statusCode)
    {
        parent::__construct($html, $statusCode, ['Content-Type' => 'text/html']);
        $this->send();
    }

}