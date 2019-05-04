<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Formation;
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

class FormationController extends FOSRestController
{
    /**
     * @Get(
     *     path = "/formations/{id}",
     *     name = "formation_show",
     *     requirements = {"id"="\d+"}
     * )
     * @View(
     *     statusCode = 201
     * )
     */
    public function showAction(Formation $formation)
    {
        return $formation;
    }

    /**
     * @Get(
     *     path = "/formations",
     *     name = "formation_list",
     * )
     * @View(
     *     statusCode = 201,
     *     serializerGroups={"GET_LIST"}
     * )
     */
    public function listAction()
    {
        $formations = $this->getDoctrine()
            ->getRepository('AppBundle:Formation')
            ->findAll();

        return $formations;
    }

    /**
     * @Post(
     *     path = "/formations",
     *     name = "formation_create",
     * )
     * @View(
     *     statusCode = 201
     * )
     * @ParamConverter(
     *     "formation",
     *     converter="fos_rest.request_body",
     *     options={
     *         "validator"={ "groups"="Create" }
     *     }
     * )
     */
    public function createAction(Formation $formation, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'The JSON sent contains invalid data. Here are the errors you need to correct: ';

            foreach ($violations as $violation) {
                $message .= sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();

        $em->persist($formation);
        $em->flush();

        return $this->view(
            $formation,
            Response::HTTP_CREATED,
            [
                'Location' => $this->generateUrl(
                    'formation_show',
                    [
                        'id' => $formation->getIdForm()
                    ]
                )
            ]
        );
    }

    /**
     * @Delete(
     *     path = "/formations/{id}",
     *     name = "formation_delete",
     *     requirements = {"id"="\d+"}
     * )
     * @View(
     *     statusCode = 204
     * )
     */
    public function deleteAction(Formation $formation)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($formation);
        $em->flush();

        return $this->view(
            $formation,
            Response::HTTP_ACCEPTED
        );
    }

    /**
     * @Put(
     *     path = "/formations/{id}",
     *     name = "formation_update",
     *     requirements = {"id"="\d+"}
     * )
     * @View(
     *     statusCode = 204
     * )
     *
     * @ParamConverter(
     *     "formationNew",
     *     converter="fos_rest.request_body"
     * )
     */
    public function updateAction(Formation $formation, Formation $formationNew, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'The JSON sent contains invalid data. Here are the errors you need to correct: ';

            foreach ($violations as $violation) {
                $message .= sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $formation->setNom($formationNew->getNom());
        $formation->setEtablissement($formationNew->getEtablissement());
        $formation->setVille($formationNew->getVille());
        $formation->setDebut($formationNew->getDebut());
        $formation->setFin($formationNew->getFin());
        $formation->setCommentaire($formationNew->getCommentaire());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->view(
            $formation,
            Response::HTTP_ACCEPTED
        );
    }
}
