<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\NilUlid;
use Symfony\Component\Uid\Ulid;
use Twig\Environment;


#[Route('/ulid')]
class UlidController
{
    public function __construct(private Environment $twig)
    {
    }

    #[Route('',name: 'app_ulid')]
    public function ulid(Request $request): Response
    {
        $quantity = $request->get('quantity', 1);
        $values = self::generate($quantity);
        return new Response($this->twig->render('ulid/index.html.twig', [
            'values' => $values,
            'quantity'=>$quantity
        ]));
    }


    #[Route('/nil',name: 'app_ulid_nil')]
    public function nil(Request $request): Response{
        return new Response($this->twig->render('ulid/nil.html.twig', [
            'values' => [new NilUlid()],
        ]));
    }


    private static function generate(int $quantity): array
    {
        if ($quantity > 200) {
            $quantity = 1;
        }
        $result = [];
        for ($i = 0; $i < $quantity; $i++) {
            $result[] = Ulid::generate();
        }
        return $result;
    }

}
