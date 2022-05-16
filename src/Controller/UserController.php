<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;


class UserController extends AbstractController
{  
        private  UserPasswordEncoderInterface $passwordEncoder;
    
      
        public function __construct(UserPasswordEncoderInterface $passwordEncode)
        {
            $this->passwordEncoder = $passwordEncode;
        }
      /**
     * @Route("/register/{login}/{password}", name="register",requirements={"login"="[a-zA-Z0-9]{4,30}","password"="[a-zA-Z0-9]{8,30}"})
     */
        public  function register(Request $request,$login,$password)
        {
            $role[] = 'ROLE_USER';
        
            if($request->isMethod('get')){
            $user = new User;
            $user->setUsername($login);
            $user->setPassword($this->passwordEncoder->encodePassword($user,$password));
            //génération du token 
            $token = bin2hex(random_bytes(10));
            $user->setapiToken($token);
            $user->setRoles($role);
        //recuperation du repository grace au manager
        $em=$this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        //possibilité de récupération de l'id de l'utilisateur
        //$lastId=$user->getId();
        $resultat=["ok"];
            }
            else {
                $resultat=["Nok"];
            }
   
    $reponse=new JsonResponse($resultat);
    return $reponse;
        }
      /**
     * @Route("/login/{login}/{password}", name="login",requirements={"login"="[a-zA-Z0-9]{4,30}","password"="[a-zA-Z0-9]{8,30}"})
     */
        public function authentification(Request $request,$login,$password){
            $user = new User;
            $user->setUsername($login);
            $user->setPassword($this->passwordEncoder->encodePassword($user,$password));
              //récupération de l'entityManager pour insérer les données en bdd
              $em=$this->getDoctrine()->getManager();
              $userRepository=$em->getRepository(User::class);
               //requete de selection pour l'onbjet user
             $u=$userRepository->findOneBy(['username' => $login]);
             
             if($u){
                if (! $this->passwordEncoder->isPasswordValid($u, $password)) {
                    // invalid password
                    $resultat=["NOK pwd invalide"];
                }
                else{
                    $resultat=['id_user'=>$u->getId(),'token'=>$u->getApiToken()];
                }
         
             }
                else {
                    $resultat=["NOK login invalide"];
                }
       
        $reponse=new JsonResponse($resultat);
        return $reponse;
            

        }
}
