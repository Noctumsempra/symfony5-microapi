<?php

namespace App\Controller;

use Exception;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/create_user", name="POST_create_user", methods={"POST"})
     * @param EntityManagerInterface $entityManager
     * @param UserRepository $userRepository
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function postCreateUser(EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $request = Request::createFromGlobals();

        $json_data = json_decode($request->getContent());

        // Sanitizo datos
        $json_data->name = isset($json_data->name) ? trim($json_data->name) : '';
        $json_data->phone = isset($json_data->phone) ? trim($json_data->phone) : '';
        $json_data->email = isset($json_data->email) ? trim($json_data->email) : '';

        // Error si no especifican nombre
        if (!$json_data->name) {
            return $this->json(['success' => false, 'message' => 'Name cannot be empty.']);
        }

        // Error si no especifican email
        if (!$json_data->email) {
            return $this->json(['success' => false, 'message' => 'E-mail cannot be empty.']);
        }

        // Error si el usuario con ese email ya existe
        $user = $userRepository->findBy(['email' => $json_data->email]);
        if ($user) {
            return $this->json(['success' => false, 'message' => 'E-mail already exists.']);
        }

        $newUser = new User();
        $newUser->setName($json_data->name);
        $newUser->setEmail($json_data->email);
        $newUser->setPhone($json_data->phone);
        $newUser->setCreatedAt(new \DateTime('now', new \DateTimeZone('America/Buenos_Aires')));

        $entityManager->persist($newUser);
        $entityManager->flush();

        return $this->json([
            'success' => true,
            'message' => [
                'id' => $newUser->getId(),
                'createdAt' => $newUser->getCreatedAt()->format('d-m-Y H:i:s')
            ]
        ]);
    }

    /**
     * @Route("/delete_user/{id}", name="DELETE_user", methods={"DELETE"})
     * @param EntityManagerInterface $entityManager
     * @param UserRepository $userRepository
     * @param string $id
     *
     * @return JsonResponse
     */
    public function deleteUser(EntityManagerInterface $entityManager, UserRepository $userRepository, string $id)
    {
        $user = $userRepository->find($id);
        if (!$user) {
            return $this->json([
                'success' => false,
                'message' => sprintf("User ID %s does not exist.", $id)
            ]);
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->json([
            'success' => true,
            'message' => sprintf("User ID %s has been deleted successfully.", $id)
        ]);
    }
}
