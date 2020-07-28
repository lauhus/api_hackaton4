<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiController extends AbstractController
{
        /**
     * @Route("/api/post", name="api_post_index", methods = {"GET"})
     * @param PostRepository $postRepository
     * @param NormalizerInterface $normalizer
     * @return Response
     * @throws ExceptionInterface
     */
    public function index(PostRepository $postRepository, SerializerInterface $serialize)
    {
        
        return $this->json($postRepository->findAll(), 200, [],["groups" => "post:read"]);
        
        //on peut ajouter en quatrième paramètre le filtre groupe
    }


    /**
     * @Route ("/api/post", name="api_post_insert",methods={"POST"})
     */
    public function insert(Request $request, SerializerInterface $serializer,EntityManagerInterface $entityManager,ValidatorInterface $validator)
    {   
        try{
        $jsonRecu = $request->getContent();
        $post = $serializer->deserialize($jsonRecu,Post::class,'json');
        $post->setCreatedAt(new \DateTime());

        $errors=$validator->validate($post);

        if(count($errors) > 0){
            return $this->json($errors, 400);
        }

        $entityManager->persist($post);
        $entityManager->flush();

        return $this->json($post, 201, [],["groups" => "post:read"]);

        } catch (NotEncodableValueException $encodableValueException) {
            return $this->json([
                'status' => 400,
                'message'=> $encodableValueException->getMessage()
                ], 400);
        }
    }
}
