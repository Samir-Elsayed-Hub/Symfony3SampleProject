<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    private $limit = 5;

    /**
     * @Route("/{page}", name="homepage", requirements={"page": "\d+"})
     */
    public function indexAction(Request $request, $page = 1)
    {
        return $this->render('default/index.html.twig', [
            'books'     => $this->getBooks($page),
            'page'      => $page
        ]);
    }

    /**
     * @Route("/book/{name}", name="showBook")
     */
    public function showBookAction(Request $request, $name)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Book');
        $book       = $repository->findOneByName($name);

        if(!$book->getUserReadable()) {
            if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                return new Response('Access denied');
            }
        }

        return $this->render('default/showBook.html.twig', [
            'book'     => $book
        ]);
    }

    /**
     * @Route("/genre/{name}", name="showGenreBooks")
     */
    public function showGenreBooksAction(Request $request, $name)
    {
        return $this->render('default/showGenreBooks.html.twig', [
            'books'     => $this->getBooksByGenre($name),
            'genre'     => $name
        ]);
    }

    /**
     * @param string $currentPage
     *
     * @return Paginator
     */
    public function getBooks($currentPage)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery('SELECT b FROM AppBundle:Book b')
                                ->setFirstResult(($currentPage - 1) * $this->limit)
                                ->setMaxResults($this->limit);

        $paginator = new Paginator($query);

        return $paginator;
    }

    /**
     * @param string $genre
     *
     * @return mixed
     */
    public function getBooksByGenre($genre)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery('SELECT b FROM AppBundle:Book b WHERE b.genres = :genre')
                               ->setParameter('genre', $genre);

        $books = $query->getResult();

        return $books;
    }
}
