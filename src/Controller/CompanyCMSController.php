<?php

namespace App\Controller;

use App\Entity\Apply;
use App\Form\JobAdType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Ads;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class CompanyCMSController extends AbstractController
{

    /**
     * @Route("/companyMenu", name="companyMenu")
     */

    public function index()
    {


        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();


        $authorized = false;

        if(!$user);
        else if($user->getRole() == 'admin') $authorized = true;
        else if($user->getRole() == 'contact') $authorized = true;

        if(!$authorized){
            return $this->redirectToRoute('ads_show');
        }

//        $user = $em->getRepository(User::class)->findOneByEmail($this->getUser()->getUsername());
        $company = $user -> getCompany();
        $ads = $company ->getJobads();

        return $this->render('company_cms/company-menu.html.twig', [
            'controller_name' => 'CompanyCMSController',
            'ads' => $ads,
            'user' => $this->getUser(),
        ]);
    }

    /**
     * @Route("/applicationCompanyMenu/{id}", name="application_company_menu")
     */

    public function show_application_for_ad(Ads $ad)
    {


        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();


        $authorized = false;

        if(!$user);
        else if($user->getRole() == 'admin') $authorized = true;
        else if($user->getRole() == 'contact'){
            if($ad->getCompany() == $user->getCompany()) $authorized = true;
        }

        if(!$authorized){
            return $this->redirectToRoute('ads_show');
        }

//        $applications = $em->getRepository(Apply::class)->findById($ad->getApplications());

        return $this->render('company_cms/ad_applications.html.twig', [
            'controller_name' => 'CompanyCMSController',
            'user' => $this->getUser(),
            'ad' => $ad,
//            'applications' => $applications,
        ]);
    }

    /**
     * @Route("/deleteAd/{id}", name="deleteAd")
     */
    public function deleteAd($id){

        $em = $this->getDoctrine()->getManager();
        $ad = $em->getRepository(Ads::class)->find($id);

        $authorized = false;

        $user = $this->getUser();

        if(!$user);
        else if($user->getRole() == 'admin') $authorized = true;
        else if($user->getRole() == 'contact'){
            if($user->getCompany() == $ad->getCompany()) $authorized = true;
        }

        if(!$authorized){
            return $this->redirectToRoute('ads_show');
        }

        if (!$ad) {
            throw $this->createNotFoundException('No Ad found');
        }

        foreach($ad->getApplications() as $application){
            $ad->removeApplication($application);
            $em->remove($application);
        }

        $em->remove($ad);
        $em->flush();

        if($user->getRole() == 'admin') return $this->redirect($this->generateUrl('admin_menu'));

        return $this->redirect($this->generateUrl('companyMenu'));
    }

    /**
     * @Route("/updateAd/{id}", name="updateAd")
     * @Route("/createAd", name = "create_ad")
     */

    public function updateAd(Ads $ad = null, Request $request){

        $em = $this->getDoctrine()->getManager();
//        $ad = $em->getRepository(Ads::class)->find($id);
        $newAd = false;
        $authorized = false;

        if (!$ad) {
            $ad = new Ads();
            $newAd = true;
        }

        $user = $this->getUser();

        if($newAd) {
            if (!$user);
            else if ($user->getRole() == 'admin') $authorized = true;
            else if ($user->getRole() == 'contact') $authorized = true;
        }

        if(!$newAd) {
            if (!$user);
            else if ($user->getRole() == 'admin') $authorized = true;
            else if ($user->getRole() == 'contact') {
                if ($user->getCompany() == $ad->getCompany()) $authorized = true;
            }
        }

        if(!$authorized){
            return $this->redirectToRoute('ads_show');
        }

        $form = $this->createForm(JobAdType::class, $ad);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $ad = $form->getData();

            if($newAd){
                $username = $this->getUser()->getUsername();
                $user = $em->getRepository(User::class)->findOneByEmail($username);
                $ad->setCompany($user->getCompany());
                $ad->setCreationDate(new \DateTime());
            }

            $em->persist($ad);
            $em->flush();



            return $this->redirectToRoute('companyMenu');
        }

        return $this->render('company_cms/update-form.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser(),
        ]);
    }


}
