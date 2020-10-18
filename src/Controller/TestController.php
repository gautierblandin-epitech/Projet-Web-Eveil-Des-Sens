<?php

// src/Controller/UserController.php
namespace App\Controller;

use App\Entity\JobAd;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class TestController extends AbstractController
{

    /**
     * @Route("/testing/{id}", name="testingpageid")
     */
    public function notifications($id)
    {

        // the template path is the relative file path from `templates/`
        return $this->render('ads.html.twig', [
            // this array defines the variables passed to the template,
            // where the key is the variable name and the value is the variable value
            // (Twig recommends using snake_case variable names: 'foo_bar' instead of 'fooBar')
            'name' => "TEST",
        ]);
    }

    /**
     * @Route("/testing", name="testing_page")
     */

    public function notifications2()
    {


        // the template path is the relative file path from `templates/`
        return $this->render('ads.html.twig', [
            // this array defines the variables passed to the template,
            // where the key is the variable name and the value is the variable value
            // (Twig recommends using snake_case variable names: 'foo_bar' instead of 'fooBar')
            'name' => "TEST",
        ]);
    }

}
