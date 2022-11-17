<?php

namespace App\Controller;

use App\Entity\CarCategory;
use App\Form\CarCategory1Type;
use App\Repository\CarCategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CarCategoryController extends AbstractController
{
    #[Route('/admin/car/category', name: 'app_car_category_index', methods: ['GET'])]
    public function index(Request $request,PaginatorInterface $paginator,CarCategoryRepository $carCategoryRepository): Response
    {
        $car_categories = $paginator->paginate(
            $carCategoryRepository->findAll(),
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('car_category/index.html.twig', [
            'car_categories' => $car_categories,
        ]);
    }

    #[Route('/admin/car/category/new', name: 'app_car_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CarCategoryRepository $carCategoryRepository): Response
    {
        $carCategory = new CarCategory();
        $form = $this->createForm(CarCategory1Type::class, $carCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carCategoryRepository->save($carCategory, true);

            return $this->redirectToRoute('app_car_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('car_category/new.html.twig', [
            'car_category' => $carCategory,
            'form' => $form,
        ]);
    }

    #[Route('/admin/car/category/{id}', name: 'app_car_category_show', methods: ['GET'])]
    public function show(CarCategory $carCategory): Response
    {
        return $this->render('car_category/show.html.twig', [
            'car_category' => $carCategory,
        ]);
    }

    #[Route('/admin/car/category/{id}/edit', name: 'app_car_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CarCategory $carCategory, CarCategoryRepository $carCategoryRepository): Response
    {
        $form = $this->createForm(CarCategory1Type::class, $carCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carCategoryRepository->save($carCategory, true);

            return $this->redirectToRoute('app_car_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('car_category/edit.html.twig', [
            'car_category' => $carCategory,
            'form' => $form,
        ]);
    }

    #[Route('/admin/car/category/{id}', name: 'app_car_category_delete', methods: ['POST'])]
    public function delete(Request $request, CarCategory $carCategory, CarCategoryRepository $carCategoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$carCategory->getId(), $request->request->get('_token'))) {
            $carCategoryRepository->remove($carCategory, true);
        }

        return $this->redirectToRoute('app_car_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
