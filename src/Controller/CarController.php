<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\CarSearch;
use App\Form\CarSearchType;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class CarController extends AbstractController
{

private $carRepository;

public function __construct(CarRepository $carRepo)
{
    $this->carRepository=$carRepo;
}

    #[Route('/car', name: 'car.index')]
    public function index(PaginatorInterface $paginator,Request $request): Response
    {



   
    $search = new CarSearch();
     
     $form = $this->createForm(CarSearchType::class, $search);
     $form->handleRequest($request);

     //pagination
     $cars = $paginator->paginate(
        $this->carRepository->findAllVisibleQuery($search),
        $request->query->getInt('page', 1),
        12
    );
        return $this->render('car/index.html.twig', [
            'controller_name' => 'CarController',
            'cars'=>$cars,
            'form' => $form->createView()
           
        ]);
    }

    
    /**
     * 
     * @param Car $car
     * @return Response
     */
    #[Route("/biens/{slug}-{id}", name:"car.show", requirements: ['slug'=> '[a-z0-9\-]*'])]
    public function show(int $id, string $slug, Request $request):Response
    {

       $car=$this->carRepository->findOneById($id);

       if($car->getSlug() !== $slug){

        return $this->redirectToRoute('car.show',[
            'id'=>$car->getId(),
            'slug'=>$car->getSlug()
        ],301);


    }

        return $this->render('car/show.html.twig',[
           'car'=>$car,
           'slug'=>$slug,
            'current_menu'=>'properties',
           
        ]);
    }


}
