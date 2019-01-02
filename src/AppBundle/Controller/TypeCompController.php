<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Typecomp;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\ConstraintViolationList;

class TypeCompController extends FOSRestController
{
    /**
     * @Get(
     *     path = "/typecomps/{id}",
     *     name = "typecomp_show",
     *     requirements = {"id"="\d+"}
     * )
     * @View(
     *     statusCode = 201
     * )
     */
    public function showAction(Typecomp $typecomp)
    {
        return $typecomp;
    }

    /**
     * @Get(
     *     path = "/typecomps",
     *     name = "typecomp_list",
     * )
     * @View(
     *     statusCode = 201
     * )
     */
    public function listAction()
    {
        $typecomps = $this->getDoctrine()
            ->getRepository('AppBundle:Typecomp')
            ->findAll();

        return $typecomps;
    }


    /**
     * @Post(
     *     path = "/typecomps",
     *     name = "typecomp_create",
     * )
     * @View(
     *     statusCode = 201
     * )
     * @ParamConverter(
     *     "typecomp",
     *     converter="fos_rest.request_body",
     *     options={
     *         "validator"={ "groups"="Create" }
     *     }
     * )
     */
    public function createAction(Typecomp $typecomp, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $viols = array();

            $serializer = $this->get('serializer');

            foreach ($violations as $violation){
                $obj = array();
                $obj["propriety"] = $violation->getPropertyPath();
                $obj["message"] = $violation->getMessage();
                $viols[] = $obj;
            }

            return $this->view($viols, Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();

        $em->persist($typecomp);
        $em->flush();

        return $this->view(
            $typecomp,
            Response::HTTP_CREATED,
            [
                'Location' => $this->generateUrl(
                    'typecomp_show',
                    [
                        'id' => $typecomp->getId()
                    ]
                )
            ]
        );
    }

    /**
     * @Delete(
     *     path = "/typecomps/{id}",
     *     name = "typecomp_delete",
     *     requirements = {"id"="\d+"}
     * )
     * @View(
     *     statusCode = 204
     * )
     */
    public function deleteAction(Typecomp $typecomp)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($typecomp);
        $em->flush();

        return new Response('',Response::HTTP_ACCEPTED);
    }

    /**
     * @Put(
     *     path = "/typecomps/{id}",
     *     name = "typecomp_update",
     *     requirements = {"id"="\d+"}
     * )
     * @View(
     *     statusCode = 204
     * )
     */
    public function updateAction(Typecomp $typecomp)
    {
        $em = $this->getDoctrine()->getManager();

        $em->persist($typecomp);
        $em->flush();

        return new Response('',Response::HTTP_ACCEPTED);
    }


}
