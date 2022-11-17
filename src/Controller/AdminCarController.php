<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\CarSearch;
use App\Form\CarType;
use App\Repository\CarRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class AdminCarController extends AbstractController
{
    

    private $carRepository;
/**
 *
 * @var EntityManager
 */
    private $em;

public function __construct(CarRepository $carRepo,EntityManagerInterface $em)
{
    $this->carRepository=$carRepo;
    $this->em=$em;
}


    #[Route('/admin-car', name: 'car.admin')]
    public function index(PaginatorInterface $paginator,Request $request): Response
    {

    $car = new CarSearch();

     $cars = $paginator->paginate(
        $this->carRepository->findAllVisibleQuery($car),
        $request->query->getInt('page', 1),
        20
    );
        return $this->render('admin_car/index.html.twig', [
            'cars'=>$cars,
           
        ]);
    }



    
    /**
     * 
     * @param Car $car
     * @return Response
     */
    #[Route("/admin-car-{id}", name:"car.edit")]
    public function edit(int $id,Request $request): Response
    {

    $car = $this->carRepository->findOneById($id);
$car->setUpdate_at(new DateTime());
    $form=$this->createForm(CarType::class,$car);
 
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            
            $this->em->flush();
            $this->addFlash('success','car edit successfully');
            return $this->redirectToRoute('car.admin',[
                
                'cars'=>$car,
            ],301);
        }


        return $this->render('admin_car/edit.html.twig', [
            
            'cars'=>$car,
            'form' => $form->createView()
           
        ]);
    }



    /**
     * 
     * @param Car $car
     * @return Response
     */
    #[Route("/admin-car/delete-{id}", name:"car.delete")]
    public function delete(int $id,Request $request): Response
    {

        $car = $this->carRepository->findOneById($id);

if($this->isCsrfTokenValid('delete'. $car->getId(),$request->get('_token'))){


    $this->carRepository->remove($this->carRepository->findOneById($id));
    $this->em->flush();
    $this->addFlash('success','car delete successfully');
        return $this->redirectToRoute('car.admin');

}
return $this->redirectToRoute('car.admin');
     
    }

    
    /**
     * 
     * @param Car $car
     * @return Response
     */
    #[Route("/admin-car/create", name: "car.create")]
    public function create(Request $request): Response
    {

$car = new Car();

        $form=$this->createForm(CarType::class,$car);

 
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            
            $this->em->persist($car);

            $this->em->flush();

            return $this->redirectToRoute('car.admin');
        }
        
    return $this->render('admin_car/create.html.twig', [
      
        'form' => $form->createView()
    ]);
    }
}
