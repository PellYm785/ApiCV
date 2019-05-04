<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Typecomp;
use AppBundle\Exception\ResourceValidationException;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
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
            $message = 'The JSON sent contains invalid data. Here are the errors you need to correct: ';

            foreach ($violations as $violation) {
                $message .= sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
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

        return $this->view(
            $typecomp,
            Response::HTTP_ACCEPTED
        );
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
     *
     * @ParamConverter(
     *     "typecompNew",
     *     converter="fos_rest.request_body"
     * )
     */
    public function updateAction(Typecomp $typecomp, Typecomp $typecompNew)
    {
        $typecomp->setType($typecompNew->getType());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->view(
            $typecomp,
            Response::HTTP_ACCEPTED
        );
    }


}
