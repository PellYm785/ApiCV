<?php
/**
 * Created by PhpStorm.
 * User: ngbamaw
 * Date: 04/01/19
 * Time: 20:25
 */

namespace AppBundle\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;

class NotFoundException extends BadRequestHttpException
{
    public function showAction(){
        return $exception = [
            "error" => [
                "code" => 404,
                "message" => "Ressource Not Found"
            ]
        ];
    }
}