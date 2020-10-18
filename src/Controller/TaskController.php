<?php

// src/Controller/TaskController.php
namespace App\Controller;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\BrowserKit\Request;

// src/Controller/TaskController.php

class TaskController extends AbstractController
{

    /**
     * @Route("/testForm", name="testingForm")
     */

    public function new(Request $request)
    {
        // just setup a fresh $task object (remove the example data)
        $task = new Task();

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();

            // tells Doctrine you want to (eventually) save the company (no queries yet)
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);

            // actually executes the queries (i.e. the INSERT query)
            $em->flush();

            return $this->redirectToRoute("testingForm");
        }

        return $this->render('task/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}