<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Description of ContactController
 *
 * @author Jamil
 */
class ContactController extends AbstractController{
    
    /**
     * 
     * @param MailerInterface $mailer
     * @param Contact $contact
     */
    public function envoiMail(MailerInterface $mailer, Contact $contact)
    {
        $message = (new TemplatedEmail())
                ->from($contact->getEmail())
                ->to('contact@mesvoyages.fr')
                ->subject('Message du site de voyages')
                ->htmlTemplate('pages/_email.html.twig')
                ->context([
                    'contact' =>$contact,
                ])
                ;
        $mailer->send($message);
    }
     /**
     * @Route("/contact", name="contact")
     * @return Response
     */
    public function index(Request $request, MailerInterface $mailer): Response{
        $contact = new Contact();
        $formContact = $this->createForm(ContactType::class, $contact);
        $formContact->handleRequest($request);
        
        if($formContact->isSubmitted() && $formContact->isValid()){
           // envoi du mail
            $this->envoiMail($mailer, $contact);
            $this->addFlash('succes', 'message envoyé');
            return $this->redirectToRoute('contact');
        }    
        return $this->render("pages/contact.html.twig", [
           'contact' => $contact,
            'formcontact' =>$formContact->createView()
        ]);
       
    }
}
