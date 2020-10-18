<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Company;
use App\Entity\Ads;
use App\Entity\Apply;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminCMSController extends AbstractController
{
    /**
     * @Route("/adminMenu", name="admin_menu")
     */
    public function show_admin_menu(){
        $authorized = true;
        $user = $this->getUser();

        if(!$user){
            $authorized = false;
        }else if(!($user->getRole() == 'admin')){
            $authorized = false;
        }

        if(!$authorized) return $this->redirectToRoute('ads_show');


        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAll();
        $companies = $em->getRepository(Company::class)->findAll();
        $ads = $em->getRepository(Ads::class)->findAll();
        $applications = $em->getRepository(Apply::class)->findAll();

        return $this->render('admin_cms/admin-menu.html.twig', [
            // this array defines the variables passed to the template,
            // where the key is the variable name and the value is the variable value
            // (Twig recommends using snake_case variable names: 'foo_bar' instead of 'fooBar')

            'users' => $users,
            'companies' => $companies,
            'ads' => $ads,
            'applications' => $applications,
            'user' => $this->getUser(),
        ]);
    }
}
