<?php

// src/Controller/ProductController.php

namespace App\Controller;

use App\Entity\Producto;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/', name: 'pagina_principal')]
    public function paginaPrincipal(ManagerRegistry $doctrine): Response
    {
        $productos = $doctrine->getRepository(Producto::class)->findAll();
        return $this->render('product/lista.html.twig', [
            'productos' => $productos
        ]);
    }

    #[Route('/producto/{id}', name: 'detalle_producto')]
    public function detalleProducto(Producto $producto): Response
    {
        return $this->render('product/detalle.html.twig', [
            'producto' => $producto,
        ]);
    }
}

