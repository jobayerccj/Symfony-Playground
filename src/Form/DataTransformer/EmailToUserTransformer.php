<?php
namespace App\Form\DataTransformer;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class EmailToUserTransformer implements DataTransformerInterface {
    
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function transform($value){
        if(null == $value){
            return '';
        }

        if(!$value instanceof User){
            throw new \LogicException("It should be User Type");
        }

        return $value->getEmail();
    }

    public function reverseTransform($value){

        if(!$value){
            return;
        }

        $user = $this->userRepository->findOneBy(['email' => $value]);

        if(!$user){
            throw new TransformationFailedException("No User found with this email");
        }

        return $user;
    }
}