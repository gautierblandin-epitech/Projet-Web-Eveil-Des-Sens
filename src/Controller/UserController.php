<?php

namespace App\Controller;

// ...
use App\Entity\User;
use App\Form\UserAdminCreationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Form\CompanyContactType;
use App\Entity\Company;

class UserController extends AbstractController
{

    /**
     * @Route("/register-menu", name = "registerMenu")
     */

    public function register_menu()
    {
        return $this->render('register-menu.html.twig', [
        ]);
    }

    /**
     * @Route("/login-or-register", name = "loginOrRegister")
     */
    public function login_or_register()
    {
        return $this->render('login-or-register.html.twig', [
        ]);
    }


    /**
     * @Route("/register-company", name = "registerCompany")
     */

    public function register_company(Request $request)
    {
        $user = new User();
        $company = new Company();
        $form = $this->createForm(CompanyContactType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $user = $form->getData();
            $user->setAdmin(false);
            $user->setRole('contact');
            $company = $user->getCompany();

            // tells Doctrine you want to (eventually) save the company (no queries yet)
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->persist($company);

            // actually executes the queries (i.e. the INSERT query)
            $em->flush();

            return $this->redirectToRoute("app_login");
        }

        return $this->render('register-company.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/register", name="registerPage")
     */

    public function new_user(Request $request)
    {
        // just setup a fresh $task object (remove the example data)
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $user = $form->getData();
            $user->setAdmin(false);
            $user->setRole('user');

            // tells Doctrine you want to (eventually) save the company (no queries yet)
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);

            // actually executes the queries (i.e. the INSERT query)
            $em->flush();

            return $this->redirectToRoute("app_login");
        }

        return $this->render('register-user.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/createUser", name = "create_user")
     * @Route("/updateUserAdmin/{id}", name = "update_user")
     */
    public function createUser(User $user = null, Request $request){
        // just setup a fresh $task object (remove the example data)


        $newUser = false;
        if(!$user){
            $user = new User();
            $newUser = true;
        }

        $form = $this->createForm(UserAdminCreationType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $user = $form->getData();

            // tells Doctrine you want to (eventually) save the company (no queries yet)
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);

            // actually executes the queries (i.e. the INSERT query)
            $em->flush();

            return $this->redirectToRoute("admin_menu");
        }

        return $this->render('admin_cms/admin-user-creation.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}