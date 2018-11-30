<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 29/11/2018
 * Time: 19:58
 */

namespace Rabbit\Http\Response\Types;

interface TypeInterface
{

    public function __construct(string $content, int $statusCode);

}