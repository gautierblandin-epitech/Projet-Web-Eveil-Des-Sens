<?php

namespace App\Controller;

use App\Entity\Apply;
use App\Entity\Ads;
use App\Entity\User;
use App\Form\ApplyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class ApplyController extends AbstractController
{

    /**
     * @Route("/apply/{id}", name="applyForm")
     */
    public function apply(Request $request, $id)
    {

        $apply = new Apply();
        $ads = $this->getDoctrine()->getRepository(Ads::class);

        $authorized = false;
        $user = $this->getUser();

        if(!$user);
        else if($user){
            $authorized = true;
        }

        if(!$authorized) return $this->redirectToRoute('loginOrRegister');

        $apply->setFirstName($this->getUser()->getFirstName());
        $apply->setLastName($this->getUser()->getLastName());
        $apply->setEmail($this->getUser()->getEmail());
        $apply->setPhone($this->getUser()->getPhoneNumber());


        $form = $this->createForm(ApplyType::class, $apply);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $apply = $form->getData();
            $apply->setCreatedAt(new \DateTime('now'));
            $apply->setUpdatedAt(NULL);
            $ad = $ads->findOneById($id);
            $ad->addApplication($apply);


            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->findOneByEmail($this->getUser()->getUsername());
            $apply ->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($apply);
            $em->flush();
            return $this->redirectToRoute('ads_show');
        }


        return $this->render('apply.html.twig', [

            // this array defines the variables passed to the template,
            // where the key is the variable name and the value is the variable value
            // (Twig recommends using snake_case variable names: 'foo_bar' instead of 'fooBar')
            'form' => $form->createView(),
            'user' => $this->getUser(),
        ]);

    }

    /**
     * @Route("/createApply", name="createApply")
     */
    public function createApply(Request $request)
    {

        $apply = new Apply();

        $authorized = false;
        $user = $this->getUser();

        if(!$user);
        else if($user->getRole() == 'admin'){
            $authorized = true;
        }

        if(!$authorized) return $this->redirectToRoute('ads_show');

        $form = $this->createForm(ApplyType::class, $apply);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $apply = $form->getData();
            $apply->setCreatedAt(new \DateTime('now'));
            $apply->setUpdatedAt(NULL);

            $apply ->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($apply);
            $em->flush();
            return $this->redirectToRoute('ads_show');
        }


        return $this->render('apply.html.twig', [

            // this array defines the variables passed to the template,
            // where the key is the variable name and the value is the variable value
            // (Twig recommends using snake_case variable names: 'foo_bar' instead of 'fooBar')
            'form' => $form->createView(),
            'user' => $this->getUser(),
        ]);

    }

}