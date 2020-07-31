<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use App\Entity\Comment;
use App\Repository\CommentRepository;
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

    /**
     * @Route("/api/comment", name="api_comment_index", methods = {"GET"})
     * @param CommentRepository $commentRepository
     * @param NormalizerInterface $normalizer
     * @return Response
     * @throws ExceptionInterface
     */
    public function comment(CommentRepository $commentRepository, SerializerInterface $serialize)
    {
        
        return $this->json($commentRepository->findAll(), 200, []);
        
        //on peut ajouter en quatrième paramètre le filtre groupe
    }

    /**
     * @Route ("/api/comment", name="api_comment_insert",methods={"POST"})
     */
    public function insert_comment(Request $request, SerializerInterface $serializer,EntityManagerInterface $entityManager,ValidatorInterface $validator)
    {   
        try{
        $jsonRecu = $request->getContent();
        $comment = $serializer->deserialize($jsonRecu,Comment::class,'json');
        $comment->setDateComment(new \DateTime());

        $errors=$validator->validate($comment);

        if(count($errors) > 0){
            return $this->json($errors, 400);
        }

        $entityManager->persist($comment);
        $entityManager->flush();

        return $this->json($comment, 201, []);

        } catch (NotEncodableValueException $encodableValueException) {
            return $this->json([
                'status' => 400,
                'message'=> $encodableValueException->getMessage()
                ], 400);
        }
    }
}
