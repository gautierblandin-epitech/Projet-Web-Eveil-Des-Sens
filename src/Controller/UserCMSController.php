<?php

namespace App\Controller;

use App\Form\ApplyType;
use App\Form\UserAdminCreationType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Apply;
use App\Entity\Company;
use App\Entity\Ads;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class UserCMSController extends AbstractController
{

    /**
     * @Route("/userMenu", name="userMenu")
     */

    public function index()
    {
        $authorized = false;
        $user = $this->getUser();

        if(!$user);
        else if(($user->getRole() == 'admin')){
            $authorized = true;
        }else if(($user->getRole() == 'user')){
            $authorized = true;
        }

        if(!$authorized) return $this->redirectToRoute('ads_show');

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneByEmail($this->getUser()->getUsername());
        $applications = $user->getApplies();

        /*foreach ($applications as $application) {
        $applys = $em->getRepository(applys::class)->find($applications.getapply());
        }*/
        return $this->render('user_cms/user-menu.html.twig', [
            'controller_name' => 'UserCMSController',
            'user' => $this->getUser(),
            'applications' => $applications,

        ]);
    }

    /**
     * @Route("/deleteApplication/{id}", name="deleteApplication")
     */
    public function deleteApply($id){

        $em = $this->getDoctrine()->getManager();
        $apply = $em->getRepository(Apply::class)->find($id);

        $authorized = false;

        $user = $this->getUser();

        if(!$user);
        else if($user->getRole() == 'admin') $authorized = true;
        else if($user->getRole() == 'user'){
            if($apply->getUser() == $user) $authorized = true;
        }

        if(!$authorized){
            return $this->redirectToRoute('userMenu');
        }

        if (!$apply) {
            throw $this->createNotFoundException('No apply found');
        }

        $apply->getAd()->removeApplication($apply);

        $em->remove($apply);
        $em->flush();

        if($user->getRole() == 'admin') return $this->redirect($this->generateUrl('admin_menu'));

        return $this->redirect($this->generateUrl('userMenu'));
    }

    /**
     * @Route("/showApplication/{id}", name="showApplication")
     */
    public function showApply($id){

        $em = $this->getDoctrine()->getManager();
        $apply = $em->getRepository(Apply::class)->find($id);

        $authorized = false;

        $user = $this->getUser();

        if(!$user);
        else if($user->getRole() == 'admin') $authorized = true;
        else if($user->getRole() == 'user'){
            if($apply->getUser() == $user) $authorized = true;
        }

        if(!$authorized){
            return $this->redirectToRoute('userMenu');
        }

        if (!$apply) {
            throw $this->createNotFoundException('No application found');
        }


        return $this->redirect($this->generateUrl('userMenu'));
    }


    /**
     * @Route("/updateApplication/{id}", name="updateApply")
     */
    public function updateApply(Apply $apply, Request $request, $id){

        $em = $this->getDoctrine()->getManager();
        $apply = $em->getRepository(Apply::class)->find($id);

        $authorized = false;

        $user = $this->getUser();

        if(!$user);
        else if($user->getRole() == 'admin') $authorized = true;
        else if($user->getRole() == 'user'){
            if($apply->getUser() == $user) $authorized = true;
        }

        if(!$authorized){
            return $this->redirectToRoute('userMenu');
        }

        $newApply = false;

        $form = $this->createForm(ApplyType::class, $apply);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $apply = $form->getData();
            $apply->setUpdatedAt(new \DateTime('now'));

            $em->persist($apply);
            $em->flush();

            return $this->redirectToRoute('userMenu');
        }

        return $this->render('user_cms/update-form.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser(),
        ]);
    }


    /**
     * @Route("/deleteAccount/{id}", name="deleteUser")
     */
    public function deleteUser($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);

        $authorized = false;

        $user = $this->getUser();

        if(!$user);
        else if($user->getRole() == 'admin') $authorized = true;
        else if($user->getRole() == 'user'){
            if($user->getId() == $id) $authorized = true;
        }

        if(!$authorized){
            return $this->redirectToRoute('ads_show');
        }

        $applications = $user->getApplies();

        foreach($applications as $application){
            $application->getAd()->removeApplication($application);
            $user->removeApply($application);
            $em->remove($application);
        }

        $em->remove($user);
        $em->flush();

        return $this->redirect($this->generateUrl('ads_show'));
    }


    /**
     * @Route("/updateUser/{id}", name="updateUser")
     */
    public function updateUser(Request $request, $id){

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);

        $authorized = false;
        $loggedUser = $this->getUser();

        if(!$loggedUser);
        else if($loggedUser->getRole() == 'admin') $authorized = true;
        else if($loggedUser->getRole() == 'user'){
            if($loggedUser->getId() == $user->getId()) $authorized = true;
        }

        if(!$authorized){
            return $this->redirectToRoute('ads_show');
        }

        $newUser = false;

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user = $form->getData();

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('userMenu');
        }

        return $this->render('user_cms/update-user.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser(),
        ]);
    }

    /**
     * @Route("/showUser/{id}", name="showUser")
     */
    public function showUser(Request $request, $id){

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);

        $authorized = false;
        $loggedUser = $this->getUser();

        if(!$loggedUser);
        else if($loggedUser->getRole() == 'admin') $authorized = true;
        else if($loggedUser->getRole() == 'contact') $authorized = true;
        else if($loggedUser->getRole() == 'user'){
            if($loggedUser->getId() == $user->getId()) $authorized = true;
        }

        if(!$authorized){
            return $this->redirectToRoute('ads_show');
        }


        return $this->render('user_information.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/updateUserAdmin/{id}", name="updateUserAdmin")
     */
    public function updateUserAdmin(Request $request, $id){

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);

        $authorized = false;
        $loggedUser = $this->getUser();

        if(!$loggedUser);
        else if($loggedUser->getRole() == 'admin') $authorized = true;

        if(!$authorized){
            return $this->redirectToRoute('ads_show');
        }

        $form = $this->createForm(UserAdminCreationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user = $form->getData();

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('userMenu');
        }

        return $this->render('admin_cms/admin-user-creation.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser(),
        ]);
    }
}