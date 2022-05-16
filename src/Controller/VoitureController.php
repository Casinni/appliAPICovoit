<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Voiture;
use App\Entity\Marque;


class VoitureController extends AbstractController
{
     /**
     * @Route("/insertVoiture/{modele}/{place}/{marqueId}", name="insertVoiture",requirements={"modele"="[a-z0-9]{3,30}","place"="[0-9]{1,2}","marqueId"="[0-9]{1,2}"})
     */
    public function insert(Request $request,$modele,$place,$marqueId)
    {

           $voit=new Voiture();
           $voit->setModele($modele);          
           $voit->setNbPlace($place);

        if($request->isMethod('get')){
            //récupération de l'entityManager pour insérer les données en bdd
            $em=$this->getDoctrine()->getManager();
            $marqueRepository=$em->getRepository(Marque::class);
            //requete de selection pour l'onbjet marque
             $marq=$marqueRepository->find($marqueId);
             //affectaiton à l'objet voiture
             $voit->setMarque($marq);
             //
            $em->persist($voit);
            //insertion en bdd
            $em->flush();
            $resultat=["ok"];
        }
        else {
            $resultat=["nok"];
        } 
          
        $reponse=new JsonResponse($resultat);
        return $reponse;
      
    }
     /**
    * @Route("/deleteVoiture/{id}", name="deleteVoiture",requirements={"id"="[0-9]{1,5}"})
    */
    public function delete(Request $request,$id)
    {
         //récupération du Manager  et du repository pour accéder à la bdd
        $em=$this->getDoctrine()->getManager();
        $voitureRepository=$em->getRepository(Voiture::class);
          //requete de selection
        $voit=$voitureRepository->find($id);
        //suppression de l'entity
        $em->remove($voit);
        $em->flush();
        $resultat=["ok"];
        $reponse=new JsonResponse($resultat);
        return $reponse;

    }
       /**
     * @Route("/listeVoiture", name="listeVoiture")
     */
    public function liste(Request $request)
    {//recuperation du repository grace au manager
        $em=$this->getDoctrine()->getManager();
        $voitureRepository=$em->getRepository(Voiture::class);
    //VoitureRepository herite de servciceEntityRepository ayant les methodes pour recuperer les données de la bdd
        $listeVoitures=$voitureRepository->findAll();
        $resultat=[];
		foreach($listeVoitures as $voit){
			array_push($resultat,$voit->__toString());
		}
		$reponse=new JsonResponse($resultat);
		
		
        return $reponse;
    }
}
