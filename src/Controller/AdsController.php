<?php

namespace App\Controller;

// ...

use App\Entity\Ads;
use App\Entity\Apply;
use App\Form\ApplyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Form\JobAdType;
use App\Entity\User;
use App\Entity\Company;

class AdsController extends AbstractController
{

    /**
     * @Route("/ads", name="ads_show")
     */
    public function showAds(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $ads = $this->getDoctrine()->getRepository(ads::class)->findAll();


        if (!$ads) {
            throw $this->createNotFoundException(
                'No ads found');
        }
        else {
            return $this->render('ads.html.twig', [
                // this array defines the variables passed to the template,
                // where the key is the variable name and the value is the variable value
                // (Twig recommends using snake_case variable names: 'foo_bar' instead of 'fooBar')

                'ads' => $ads,
                'user' => $this->getUser(),

            ]);
        }
    }
}