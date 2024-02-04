<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\EcoleType;
use App\Entity\Ecole;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class EcoleController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
     /**
     * @Route("/", name="index")
     */
    public function page_dacceuil():Response
    {
        return $this->render('index.html.twig');
    }
    /**
     * @Route("/ecole", name="app_ecole")
     */
    public function index(): Response
    {
        $data=$this->getDoctrine()->getRepository(Ecole::class)->findAll();
        return $this->render('ecole/index.html.twig', [
            'data' => $data,
        ]);
    }
     /**
    * @Route("/ecole/create",name="Ecole_new")
     */
    public function create(Request $request){
       $ecole= new Ecole();
       $form=$this->createForm(EcoleType::class,$ecole);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
        $em= $this->getDoctrine()->getManager();
        $em->persist($ecole);
        $em->flush();
        $this->addFlash('notice','ecole ajouté avec succes');
        return $this->redirectToRoute('app_ecole');  
    }
       return $this->render('ecole/create.html.twig', [
        'form' => $form->createView(),
    ]);
     }
     /**
    * @Route("ecole/update{id}",name="Ecole_update")
     */
    public function update(request $request,int $id){
       $ecole= $this->getDoctrine()->getRepository(Ecole::class)->find($id);
       $form=$this->createForm(EcoleType::class,$ecole);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
        $em= $this->getDoctrine()->getManager();
        $em->persist($ecole);
        $em->flush();
        // $this->addFlash('notice','modification effectuée avec succes');
        return $this->redirectToRoute('app_ecole');  
       }
       return $this->render('ecole/update.html.twig', [
        'form' => $form->createView(),
        'ecoleId'=> $id
    ]);

    }
     /**
    * @Route("ecole/delete{id}",name="Ecole_delete")
     */
    public function delete($id){
    // Récupérer l'école à supprimer
    $ecole= $this->getDoctrine()->getRepository(Ecole::class)->find($id);
    if (!$ecole) {
        throw $this->createNotFoundException('L\'école n\'existe pas');
    }
    $formations = $ecole->getFormations();
    foreach ($formations as $formation) {
        
        $this->entityManager->remove($formation);
    }
        $data = $this->getDoctrine()->getRepository(Ecole::class)->find($id);
        $em =$this->getDoctrine()->getManager(); 
        $em->remove($data);
        $em->flush();

        // $this->addFlash('notice','suppresion effectuée avec succes');
        return $this->redirectToRoute('app_ecole');
    }
    /**
     * @Route("/recherche_formation_par_ecole", name="recherche_formation_par_ecole")
     */
    public function rechercheFormationParEcole(Request $request): Response
    {
        // Récupérez le nom de l'école à partir de la requête (à ajuster selon votre logique)
        $nomEcole = $request->query->get('ecole_nom');
        $ecole="";
        $formations=null;
        if ($nomEcole !== null) {
         
        $ecoleRepository = $this->getDoctrine()->getRepository(Ecole::class);
        $ecole = $this->getDoctrine()->getRepository(Ecole::class)->findByNom($nomEcole);

        $formations = $ecole->getFormations();
        }
        return $this->render('ecole/ecole_form.html.twig', [
            'ecole' =>  $ecole ,
            'formations' => $formations,
        ]);
    
    }
    
}
