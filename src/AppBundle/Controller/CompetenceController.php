<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Competence;
use AppBundle\Exception\ResourceValidationException;
use AppBundle\Representation\Competences;
use FOS\RestBundle\Controller\Annotations\Patch;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\Validator\ConstraintViolationList;

class CompetenceController extends FOSRestController
{
    /**
     * @Get(
     *     path = "/competences/{id}",
     *     name = "competence_show",
     *     requirements = {"id"="\d+"}
     * )
     * @View(
     *     statusCode = 201
     * )
     */
    public function showAction(Competence $competence)
    {
        return $competence;
    }

    /**
     * @Get(
     *     path = "/competences",
     *     name = "competence_list"
     * )
     *
     * @QueryParam(
     *     name="order",
     *     requirements="asc|desc",
     *     default="asc",
     *     description="Sort order (asc or desc)"
     * )
     *
     * @QueryParam(
     *     name="key",
     *     nullable=true,
     *     description="Sort order (asc or desc)"
     * )
     *
     * @QueryParam(
     *     name="page",
     *     requirements="\d+",
     *     default="1",
     *     description="The page"
     * )
     *
     * @View(
     *     statusCode = 200,
     * )
     */
    public function listAction($key, $order, $page)
    {
       $pager = $this->getDoctrine()
            ->getRepository('AppBundle:Competence')
            ->search(
                $key,
                $page,
                $order
            );

       $datas = array();


       foreach ($pager->getCurrentPageResults() as $result){
           $context = SerializationContext::create()->setGroups('GET_LIST');
           $datas[] = $this->get('jms_serializer')->toArray($result, $context);
       }

        return new Competences(
            $datas,
            $pager->getMaxPerPage(),
            count($datas),
            $pager->getNbResults(),
            $pager->getCurrentPage()
        );
    }

    /**
     * @Post(
     *     path = "/competences",
     *     name = "competence_create"
     * )
     * @View(
     *     statusCode = 201
     * )
     * @ParamConverter(
     *     "competence",
     *     converter="fos_rest.request_body",
     *     options={
     *         "validator"={ "groups"="Create" }
     *     }
     * )
     */
    public function createAction(Competence $competence, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'The JSON sent contains invalid data. Here are the errors you need to correct: ';

            foreach ($violations as $violation) {
                $message .= sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }


        $em = $this->getDoctrine()->getManager();

        $type = $em->getRepository('AppBundle:Typecomp')->find($competence->getType());
        $competence->setType($type);

        if($competence->getLangage()){
            $langage = $em->getRepository('AppBundle:Competence')->find($competence->getLangage());
            $competence->setLangage($langage);
        }

        $em->persist($competence);
        $em->flush();

        return $this->view(
            $competence,
            Response::HTTP_CREATED,
            [
                'Location' => $this->generateUrl(
                    'competence_show',
                    [
                        'id' => $competence->getIdComp()
                    ]
                )
            ]
        );
    }

    /**
     * @Delete(
     *     path = "/competences/{id}",
     *     name = "competence_delete",
     *     requirements = {"id"="\d+"}
     * )
     * @View(
     *     statusCode = 204
     * )
     */
    public function deleteAction(Competence $competence)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($competence);
        $em->flush();

        return $this->view(
            $competence,
            Response::HTTP_ACCEPTED
        );
    }

    /**
     * @Put(
     *     path = "/competences/{id}",
     *     name = "competence_update",
     *     requirements = {"id"="\d+"}
     * )
     * @View(
     *     statusCode = 204
     * )
     * @ParamConverter(
     *     "competenceNew",
     *     converter="fos_rest.request_body",
     *     options={
     *         "validator"={ "groups"="Create" }
     *     }
     * )
     *
     */
    public function updateAction(Request $request, Competence $competence, Competence $competenceNew, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'The JSON sent contains invalid data. Here are the errors you need to correct: ';

            foreach ($violations as $violation) {
                $message .= sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();

        $type = $em->getRepository('AppBundle:Typecomp')->find($competenceNew->getType());
        $niveau = null;
        $langage = null;

        if($competenceNew->getNiveau()){
            $niveau = $em->getRepository('AppBundle:Niveaucomp')->find($competenceNew->getNiveau());
        }

        if($competenceNew->getLangage()){
            $langage = $em->getRepository('AppBundle:Competence')->find($competenceNew->getLangage());
        }

        $competence->setNom($competenceNew->getNom());
        $competence->setType($type);
        $competence->setNiveau($niveau);
        $competence->setLangage($langage);

        $em->flush();

        return $this->view(
            $competence,
            Response::HTTP_ACCEPTED,
            [
                'Location' => $this->generateUrl(
                    'competence_show',
                    [
                        'id' => $competence->getIdComp()
                    ]
                )
            ]
        );
    }

    /**
     * @Patch(
     *     path = "/competences/{id}",
     *     name = "competence_patch_update",
     *     requirements = {"id"="\d+"}
     * )
     * @View(
     *     statusCode = 204
     * )
     * @ParamConverter(
     *     "competenceNew",
     *     converter="fos_rest.request_body",
     *     options={
     *         "validator"={ "groups"="Modify_patch" }
     *     }
     * )
     *
     */
    public function updatePatchAction(Competence $competence, Competence $competenceNew, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'The JSON sent contains invalid data. Here are the errors you need to correct: ';

            foreach ($violations as $violation) {
                $message .= sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $entityManager = $this->getDoctrine()->getManager();

        $competence->setNom($competenceNew->getNom());

        $entityManager->flush();

        return $this->view(
            $competence,
            Response::HTTP_ACCEPTED,
            [
                'Location' => $this->generateUrl(
                    'competence_show',
                    [
                        'id' => $competence->getIdComp()
                    ]
                )
            ]
        );
    }
}
