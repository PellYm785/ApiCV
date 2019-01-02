<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Competence;
use AppBundle\Representation\Competences;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\YamlFileLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CompetenceController extends Controller
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
     *     statusCode = 200
     * )
     */
    public function listAction($key, $order, $page)
    {
       $pager = $this->getDoctrine()
            ->getRepository('AppBundle:Competence')
            ->search(
                $key,
                $order,
                $page
            );

        $serializer = $this->get('serializer');

        $data = $serializer->normalize($pager, null, array('groups' => array('GET_LIST')));

        $compRep = $serializer->normalize(new Competences(
            $data,
            $pager->getItemNumberPerPage(),
            $pager->count(),
            $pager->getTotalItemCount(),
            $pager->getCurrentPageNumber()
        ));

        return $compRep;
    }
}
