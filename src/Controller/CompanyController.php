<?php

namespace App\Controller;

// ...

use App\Entity\User;
use App\Entity\Ads;
use App\Entity\Company;
use App\Form\CompanyAdminCreationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class CompanyController extends AbstractController
{
    /**
     * @Route("/company/create", name="company")
     */
    public function createCompany()
    {

    $company = new Company();
    $company->setName('Comp');
    $company->setCity('New York');
  
    // tells Doctrine you want to (eventually) save the company (no queries yet)
    $em = $this->getDoctrine()->getManager();
    $em->persist($company);

    // actually executes the queries (i.e. the INSERT query)
    $em->flush();

    return new Response('Saved new company with id '.$company->getId()
                    );
}


    /**
     * @Route("/company/show/{companyId}", name="company_show")
     */
    public function showCompany($companyId)
    {
        $company = $this->getDoctrine()
            ->getRepository(Company::class)
            ->find($companyId);

        if (!$company) {
            throw $this->createNotFoundException(
                'No company found for id '.$companyId);
        }
        else {
            return new Response('Found company with id:' .$companyId);
        }
    }


    /**
     * @Route("/createCompany", name = "create_company")
     * @Route("/updateCompany/{id}", name="company_update")
     */
    public function updateCompany(Company $company = null, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $newCompany = false;

        if (!$company) {
            $company = new Company();
            $newCompany = true;
        }

        $form = $this->createForm(CompanyAdminCreationType::class, $company);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $company = $form->getData();

            // tells Doctrine you want to (eventually) save the company (no queries yet)
            $em = $this->getDoctrine()->getManager();
            $em->persist($company);

            $em->flush();

            return $this->redirectToRoute("admin_menu");
        }

        return $this->render('admin_cms/admin-user-creation.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser(),
        ]);
    }

    /**
     * @Route("/deleteCompany/{companyId}", name="company_delete")
     */
    public function deleteCompany($companyId)
    {
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository(Company::class)->find($companyId);

        if (!$company) {
            return $this->redirectToRoute('admin_menu');
//            throw $this->createNotFoundException(
//                'No company found for id '.$companyId
//            );
        }
        else{
            $em->remove($company);
            $em->flush();
            return $this->redirectToRoute('admin_menu');
        }
    }
}