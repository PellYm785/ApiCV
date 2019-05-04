<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Niveaucomp;
use AppBundle\Exception\ResourceValidationException;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\Validator\ConstraintViolationList;

class NiveauCompController extends FOSRestController
{
    /**
     * @Get(
     *     path = "/niveaucomps/{id}",
     *     name = "niveaucomp_show",
     *     requirements = {"id"="\d+"}
     * )
     * @View(
     *     statusCode = 201
     * )
     */
    public function showAction(Niveaucomp $niveaucomp)
    {
        return $niveaucomp;
    }

    /**
     * @Get(
     *     path = "/niveaucomps",
     *     name = "niveaucomp_list",
     * )
     * @View(
     *     statusCode = 201
     * )
     */
    public function listAction()
    {
        $niveaucomps = $this->getDoctrine()
            ->getRepository('AppBundle:Niveaucomp')
            ->findAll();

        return $niveaucomps;
    }

    /**
     * @Post(
     *     path = "/niveaucomps",
     *     name = "niveaucomp_create",
     * )
     * @View(
     *     statusCode = 201
     * )
     * @ParamConverter(
     *     "niveaucomp",
     *     converter="fos_rest.request_body",
     *     options={
     *         "validator"={ "groups"="Create" }
     *     }
     * )
     */
    public function createAction(Niveaucomp $niveaucomp, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'The JSON sent contains invalid data. Here are the errors you need to correct: ';

            foreach ($violations as $violation) {
                $message .= sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();

        $em->persist($niveaucomp);
        $em->flush();

        return $this->view(
            $niveaucomp,
            Response::HTTP_CREATED,
            [
                'Location' => $this->generateUrl(
                    'niveaucomp_show',
                    [
                        'id' => $niveaucomp->getId()
                    ]
                )
            ]
        );
    }

    /**
     * @Delete(
     *     path = "/niveaucomps/{id}",
     *     name = "niveaucomp_delete",
     *     requirements = {"id"="\d+"}
     * )
     * @View(
     *     statusCode = 204
     * )
     */
    public function deleteAction(Niveaucomp $niveaucomp)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($niveaucomp);
        $em->flush();

        return new Response('',Response::HTTP_ACCEPTED);
    }

    /**
     * @Put(
     *     path = "/niveaucomps/{id}",
     *     name = "niveaucomp_update",
     *     requirements = {"id"="\d+"}
     * )
     * @View(
     *     statusCode = 204
     * )
     *
     * @ParamConverter(
     *     "niveaucompNew",
     *     converter="fos_rest.request_body"
     * )
     */
    public function updateAction(Niveaucomp $niveaucomp, Niveaucomp $niveaucompNew, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'The JSON sent contains invalid data. Here are the errors you need to correct: ';

            foreach ($violations as $violation) {
                $message .= sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $niveaucomp->setNiveau($niveaucompNew->getNiveau());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return new Response('',Response::HTTP_ACCEPTED);
    }
}
