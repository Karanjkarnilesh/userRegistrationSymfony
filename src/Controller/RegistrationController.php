<?php

namespace App\Controller;

use App\Entity\Registration;
use App\Form\LoginForm;
use App\Form\RegistrationForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class RegistrationController extends AbstractController
{
    private $em;
    private $slugger;
    public function __construct(EntityManagerInterface $em, SluggerInterface $slugger)
    {
        $this->em = $em;
        $this->slugger = $slugger;
    }

    #[Route('/registration', name: 'app_registration')]
    public function index(Request $request): Response
    {
        $register = new Registration();

        $form = $this->createForm(RegistrationForm::class, $register);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            dd($data);
            $file = $form->getData()->getimage();
            if ($file) {
                $filename = $form->getData()->getImage()->getClientOriginalName();
                $uploadPath = $file->move($this->getParameter('upload_profile'), $filename);
            }
            $register->setUsername($data->getUsername());
            $register->setEmail($data->getEmail());
            $register->setPhone($data->getPhone());
            $register->setGender($data->getGender());
            $register->setBirthdate($data->getBirthdate());
            $register->setAddress($data->getAddress());
            $register->setZipcode($data->getZipcode());
            $register->setImage($uploadPath);
            $this->em->persist($register);
            $this->em->flush();
            return  $this->redirectToRoute('user_login');
        }
        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/login', name: 'user_login')]
    public function login(Request $request): Response
    {
        $form = $this->createForm(LoginForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        $data = $form->getData();
       $user=array($this->em->getRepository(Registration::class)->findBy(['email'=>$data['email'],'password'=>$data['password']])[0]);
    if(count($user)>0)
    {
        $request->getSession()->set('user', $user);
        return new Response("login successfull");
    }
    }


        return $this->render('registration/login.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/list', name: 'user_list')]
    public function list(Request $request): Response
    {
        $users = $this->em->getRepository(Registration::class)->findAll();

        return $this->render('registration/list.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/edit/{id}', name: 'user_edit')]
    public function edit($id, Request $request): Response
    {
        $user =$this->em->getRepository(Registration::class)->findBy(['id' => $id])[0];
        if($request->isMethod('post'))
        {
            $data=$request->request->all();
            $user->setUsername($data['username']);
            // $user->setEmail($data['email']);
            $user->setPhone($data['phone']);
            $user->setGender($data['gender']);
            // $user->setBirthdate($data['birthdate']);
            $user->setAddress($data['address']);
            $user->setZipcode($data['zipcode']);
            $this->em->persist($user);
            $this->em->flush();
            return $this->redirectToRoute('user_list');
        }
        return $this->render('registration/edit.html.twig', [
            'user' => $user,
        ]);
    }
    #[Route('/delete/{id}', name: 'user_delete')]
    public function delete($id, Request $request)
    {
        $user = $this->em->getRepository(Registration::class)->findBy(['id' => $id]);
        $this->em->remove($user);
        $this->em->flush();
        $this->addFlash("success", "user Deleted Successfully");
        return $this->redirectToRoute('user_list');
    }
    #[Route('/search', name: 'user_search')]
    public function search(Request $request)
    {
        $search=$_GET['slug'];
        $users = $this->em->getRepository(Registration::class)->search($search);
        dd($users);
        // return $this->redirectToRoute('user_list');
    }
}
