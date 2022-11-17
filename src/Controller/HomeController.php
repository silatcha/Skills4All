<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends  AbstractController
{


public function __construct()
{
   
}


    
 /**
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @Route ("/", name="home")
     */
    public function index(): Response
    {
        
        $number = random_int(0, 100);

      

        return $this->render('pages/home.html.twig');

    }


}