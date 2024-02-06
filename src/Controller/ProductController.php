<?php

// src/Controller/ProductController.php

namespace App\Controller;

use App\Entity\Producto;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class ProductController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    #[Route('/', name: 'pagina_principal')]
    public function paginaPrincipal(ManagerRegistry $doctrine): Response
    {
        $productos = $doctrine->getRepository(Producto::class)->findAll();
        return $this->render('product/lista.html.twig', [
            'productos' => $productos
        ]);
    }
    

    #[Route('/agregar/{id}', name: 'agregar_al_carrito')]
    public function agregarAlCarrito(Producto $producto): RedirectResponse
    {
        // Obtener el carrito de la sesión o inicializarlo si aún no existe
        $carrito = $this->session->get('carrito', []);

        // Agregar el producto al carrito
        $carrito[] = [
            'id' => $producto->getId(),
            'nombre' => $producto->getNombre(),
            'precio' => $producto->getPrecio(),
        ];

        // Guardar el carrito en la sesión
        $this->session->set('carrito', $carrito);

        // Redirigir de vuelta a la página principal después de agregar el producto
        return $this->redirectToRoute('pagina_principal');
    }

    #[Route('/producto/{id}', name: 'detalle_producto')]
    public function detalleProducto(Producto $producto): Response
    {
        return $this->render('product/detalle.html.twig', [
            'producto' => $producto,
        ]);
    }

    #[Route('/carrito', name: 'carrito_compras')]
    #[Route('/carrito', name: 'carrito_compras')]
    public function carritoCompras(): Response
    {
        // Obtener el carrito de la sesión
        $carrito = $this->session->get('carrito', []);

        // Renderizar la plantilla del carrito de compras
        return $this->render('product/carrito.html.twig', [
            'productosEnCarrito' => $carrito,
        ]);
    }
}

