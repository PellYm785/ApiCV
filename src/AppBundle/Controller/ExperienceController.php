<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Experience;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\View;

class ExperienceController extends Controller
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
}
