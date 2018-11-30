<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 14/11/2018
 * Time: 16:21
 */

namespace Rabbit\Http\Response\Types;

use Rabbit\Http\Response\Response;

class JsonResponse extends Response implements TypeInterface
{

    public function __construct(string $json, int $statusCode)
    {
        parent::__construct($json, $statusCode, ['Content-Type' => 'application/json']);
        $this->send();
    }

}