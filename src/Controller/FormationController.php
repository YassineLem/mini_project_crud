<?php

namespace App\Controller;
use App\Entity\Formation;
use App\Form\FormationType;
use App\Entity\Ecole;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FormationController extends AbstractController
{
    /**
     * @Route("/formation", name="app_formation")
     */
    public function index(): Response
    {
        $data=$this->getDoctrine()
            ->getRepository(Formation::class)
            ->createQueryBuilder('f')
            ->leftJoin('f.ecole', 'e') // Jointure avec l'entité Ecole
            ->addSelect('e') 
            ->getQuery()
            ->getResult();
        return $this->render('formation/index.html.twig', [
            'data' => $data,
        ]);
    }
    /**
     * @Route("/formation/new", name="formation_new")
     */
    public function new(Request $request): Response
    {
        $formation = new Formation();
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $ecole = $formation->getEcole();
            if ($ecole) {
        
                $formation->setEcole($ecole);

                $entityManager->persist($formation);
                $entityManager->flush();

                // $this->addFlash('success', 'Nouvelle formation ajoutée avec succès');

                return $this->redirectToRoute('app_formation'); // Rediriger vers la liste des formations, ajustez cela en fonction de votre structure de routes
            } else {

                $this->addFlash('error', 'Veuillez sélectionner une école.');
            }
        }

        return $this->render('formation/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/formation/update{id}", name="formation_update")
     */
    public function update(Request $request,int $id): Response
    {
        $formation = $this->getDoctrine()->getRepository(Formation::class)->find($id);
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $ecole = $formation->getEcole();

            if ($ecole) {
                $formation->setEcole($ecole);
                $entityManager->persist($formation);
                $entityManager->flush();

                $this->addFlash('success', 'Nouvelle formation ajoutée avec succès');

                return $this->redirectToRoute('app_formation'); 
            } else {
        
                $this->addFlash('error', 'Veuillez sélectionner une école.');
            }
        }
        return $this->render('formation/update.html.twig', [
            'form' => $form->createView(),
            'FormationId'=> $id,
        ]);
    }
     /**
    * @Route("formation/delete{id}",name="formation_delete")
     */
    public function delete(Request $request,int $id): Response{

        $formation= $this->getDoctrine()->getRepository(Formation::class)->find($id);
            $em =$this->getDoctrine()->getManager(); 
            $em->remove($formation);
            $em->flush();
    
            return $this->redirectToRoute('app_formation');
        }
}
