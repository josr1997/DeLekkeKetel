<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function register(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createFormBuilder()
            ->add('firstname', TextType::class,[
                'label' => 'Voornaam'
            ])
            ->add('lastname', TextType::class,[
                'label' => 'Achternaam'
            ])
            ->add('username', TextType::class,[
                'label' => 'Gebruikersnaam'
            ])
            ->add('password', RepeatedType::class,[
                'type' => PasswordType::class,
                'required' => true,
                'first_options' => ['label' => 'Wachtwoord'],
                'second_options' => ['label' => 'Wachtwoord opnieuw invoeren']
            ])
            ->add('gender', ChoiceType::class,[
                'label' => 'Geslacht',
                'choices'  => [
                    'Man' => 'male',
                    'Vrouw' => 'female',
                    'Vaatwasser' => 'dishwasher',
                ]
            ])
            ->add('email', EmailType::class,[
                'label' => 'Emailadres'
            ])
            ->add('register', SubmitType::class,[
                'label' => 'Registreren'
            ])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted()){

            $data = $form->getData();

            if(empty($data['password'])){

                $this->addFlash('error', 'Wachtwoorden komen niet met elkaar overeen');
                return $this->redirect($this->generateUrl('register'));
            }

            //dump($data);

            $user = new User();
            $user->setUsername($data['username']);
            $user->setPassword(
                $passwordHasher->hashPassword($user, $data['password'])
            );
            $user->setFirstName($data['firstname']);
            $user->setLastName($data['lastname']);
            $user->setGender($data['gender']);
            $user->setEmail($data['email']);

            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('app_login'));
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
