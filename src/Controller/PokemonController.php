<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PokemonRepository;
use App\Entity\Pokemon;
use App\Form\PokemonType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;



class PokemonController extends AbstractController
{
    //* Show pokemons
    #[Route('/pokedex', name: 'show_pokemons', method : ['GET'])]
    public function index(PokemonRepository $pokemonRepository): Response
    {
        return $this->render('pokemon/index.html.twig', [
            'pokemons' => $pokemonRepository->findAll(),
        ]);
    }


    /**
     * La fontion génére le formulaire et insère en base de données
     * Créer le formType depuis la console
     * persist est un commit
     * flush est un push 
     * persister avant de flush
     */
    //! rajouter les méthods
    #[Route('/pokedex/create', name: 'pokemon_create', method : ['POST'])]
    public function create(Request $request, PokemonRepository $pokemonRepository): Response
    {
        //Créer l'objet pokemon : 
        $new_pokemon = new Pokemon();

        //Créer le formulaire
        $form = $this->createForm(PokemonType::class, $new_pokemon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pokemonRepository->save($new_pokemon, true);

            return $this->redirectToRoute('show_pokemon', ['id' => $new_pokemon->getId()]);
        }

        return $this->render('pokemon/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/pokedex/{id}/', name: 'show_pokemon', requirements: ['id' => '\d'], method : ['GET'])]
    public function show(Pokemon $pokemon): Response
    {
        return $this->render('pokemon/show.html.twig', [
            'pokemon' => $pokemon,
        ]);
    }


     //! PokemonRepository contient persist et flush et pour eviter de persist, on utilise ManagerRegistry 
     #[Route('/pokedex/{id}/update/', name: 'update_pokemon', requirements: ['id' => '\d'], method : ['POST','GET'])]
     public function update(Pokemon $pokemon, Request $request, ManagerRegistry $ManagerRegistry): Response
     {
         $form = $this->createForm(PokemonType::class, $pokemon);
         $form->handleRequest($request);
 
         if ($form->isSubmitted() && $form->isValid()) {
             $ManagerRegistry->getManager()->flush();
             return $this->redirectToRoute('show_pokemon', ['id' => $pokemon->getId()]);
         }
         return $this->render('pokemon/update.html.twig', [
             'form' => $form->createView(),
         ]);
     }


    #[Route('/pokedex/{id}/delete/{token}', name: 'delete_pokemon', requirements: ['id' => '\d'], method : ['POST'])]
    public function delete(String $token, Pokemon $pokemon, PokemonRepository $pokemonRepository)
    {

        if (!$this->isCsrfTokenValid('delete' . $pokemon->getId(), $token)) {
            throw new AccessDeniedException;
        }

        $pokemonRepository->remove($pokemon, true);
        return $this->redirectToRoute('show_pokemons');
    }
   
}
