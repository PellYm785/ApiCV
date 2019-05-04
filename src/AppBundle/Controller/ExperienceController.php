<?php

namespace AppBundle\Controller;

use AppBundle\Exception\ResourceValidationException;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Experience;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;

class ExperienceController extends FOSRestController
{
    /**
     * @Get(
     *     path = "/experiences/{id}",
     *     name = "experience_show",
     *     requirements = {"id"="\d+"}
     * )
     * @View(
     *     statusCode = 201
     * )
     * @param Experience $experience
     * @return Experience
     */
    public function showAction(Experience $experience)
    {
        return $experience;
    }

    /**
     * @Get(
     *     path = "/experiences",
     *     name = "experience_list",
     * )
     *
     * @View(
     *     statusCode = 201,
     *     serializerGroups={"GET_LIST"}
     * )
     */
    public function listAction()
    {
        $experiences = $this->getDoctrine()
            ->getRepository('AppBundle:Experience')
            ->findAll();

        return $experiences;
    }

    /**
     * @Post(
     *     path = "/experiences",
     *     name = "experience_create",
     * )
     * @View(
     *     statusCode = 201
     * )
     * @ParamConverter(
     *     "experience",
     *     converter="fos_rest.request_body",
     *     options={
     *         "validator"={ "groups"="Create" }
     *     }
     * )
     * @param Experience $experience
     * @param ConstraintViolationList $violations
     * @return \FOS\RestBundle\View\View
     * @throws ResourceValidationException
     */
    public function createAction(Experience $experience, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'The JSON sent contains invalid data. Here are the errors you need to correct: ';

            foreach ($violations as $violation) {
                $message .= sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();

        $em->persist($experience);
        $em->flush();

        return $this->view(
            $experience,
            Response::HTTP_CREATED,
            [
                'Location' => $this->generateUrl(
                    'experience_show',
                    [
                        'id' => $experience->getId()
                    ]
                )
            ]
        );
    }

    /**
     * @Delete(
     *     path = "/experiences/{id}",
     *     name = "experience_delete",
     *     requirements = {"id"="\d+"}
     * )
     * @View(
     *     statusCode = 204
     * )
     * @param Experience $experience
     * @return \FOS\RestBundle\View\View
     */
    public function deleteAction(Experience $experience)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($experience);
        $em->flush();

        return $this->view(
            $experience,
            Response::HTTP_ACCEPTED
        );
    }

    /**
     * @Put(
     *     path = "/experiences/{id}",
     *     name = "experience_update",
     *     requirements = {"id"="\d+"}
     * )
     * @View(
     *     statusCode = 204
     * )
     *
     * @ParamConverter(
     *     "experienceNew",
     *     converter="fos_rest.request_body"
     * )
     * @param Experience $experience
     * @param Experience $experienceNew
     * @param ConstraintViolationList $violations
     * @return \FOS\RestBundle\View\View
     * @throws ResourceValidationException
     */
    public function updateAction(Experience $experience, Experience $experienceNew, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'The JSON sent contains invalid data. Here are the errors you need to correct: ';

            foreach ($violations as $violation) {
                $message .= sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $experience->setPoste($experienceNew->getPoste());
        $experience->setOrganisation($experienceNew->getOrganisation());
        $experience->setType($experienceNew->getType());
        $experience->setDebut($experienceNew->getDebut());
        $experience->setFin($experienceNew->getFin());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->view(
            $experience,
            Response::HTTP_ACCEPTED
        );
    }
}
