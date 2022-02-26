<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\NilUlid;
use Symfony\Component\Uid\NilUuid;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV1;
use Symfony\Component\Uid\UuidV6;
use Twig\Environment;

#[Route('/uuid')]
class UuidController
{
    public function __construct(private Environment $twig)
    {
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    #[Route('/v1', name: 'app_uuid_v1')]
    public function v1(Request $request): Response
    {
        $quantity = $request->get('quantity', 1);
        $values = self::generate(UuidV1::class, $quantity);
        return new Response($this->twig->render('uuid/v1.html.twig', [
            'values' => $values,
            'quantity'=>$quantity,
        ]));
    }

    /**
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\LoaderError
     */
    #[Route('/v3', name: 'app_uuid_v3')]
    public function v3(Request $request): Response
    {
        $value = null;
        if ($request->get('namespace') !== null && $request->get('name') !== null) {
            $namespace = match ($request->get('namespace')) {
                'NAMESPACE_DNS' => Uuid::fromString(Uuid::NAMESPACE_DNS),
                'NAMESPACE_URL' => Uuid::fromString(Uuid::NAMESPACE_URL),
                'NAMESPACE_OID' => Uuid::fromString(Uuid::NAMESPACE_OID),
                'NAMESPACE_X500' => Uuid::fromString(Uuid::NAMESPACE_X500),
                'CUSTOM' => Uuid::fromString($request->get('value')),
            };
            $value = Uuid::v3($namespace, $request->get('name'));
        }


        return new Response($this->twig->render('uuid/v3.html.twig', [
            'values' => [$value],
            'namespace' => $request->get('namespace'),
            'name' => $request->get('name'),
        ]));
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    #[Route('/v4', name: 'app_uuid_v4')]
    public function v4(Request $request): Response
    {
        $quantity = $request->get('quantity', 1);
        $values = self::generate(UuidV1::class, $quantity);
        return new Response($this->twig->render('uuid/v4.html.twig', [
            'values' => $values,
            'quantity'=>$quantity,
        ]));
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    #[Route('/v5', name: 'app_uuid_v5')]
    public function v5(Request $request): Response
    {
        $value = null;
        if ($request->get('namespace') !== null && $request->get('name') !== null) {
            $namespace = match ($request->get('namespace')) {
                'NAMESPACE_DNS' => Uuid::fromString(Uuid::NAMESPACE_DNS),
                'NAMESPACE_URL' => Uuid::fromString(Uuid::NAMESPACE_URL),
                'NAMESPACE_OID' => Uuid::fromString(Uuid::NAMESPACE_OID),
                'NAMESPACE_X500' => Uuid::fromString(Uuid::NAMESPACE_X500),
                'CUSTOM' => Uuid::fromString($request->get('value')),
            };
            $value = Uuid::v5($namespace, $request->get('name'));
        }
        return new Response($this->twig->render('uuid/v5.html.twig', [
            'values' => [$value],
            'namespace' => $request->get('namespace'),
            'name' => $request->get('name'),
        ]));
    }

    /**
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\LoaderError
     */
    #[Route('/v6', name: 'app_uuid_v6')]
    public function v6(Request $request): Response
    {
        $quantity = $request->get('quantity', 1);
        $values = self::generate(UuidV6::class, $quantity);
        return new Response($this->twig->render('uuid/v6.html.twig', [
            'values' => $values,
            'quantity'=>$quantity,
        ]));
    }

    #[Route('/nil',name: 'app_uuid_nil')]
    public function nil(Request $request): Response{
        return new Response($this->twig->render('uuid/nil.html.twig', [
            'values' => [new NilUuid()],
        ]));
    }

    private static function generate(string $class, int $quantity): array
    {
        if ($quantity > 200) {
            $quantity = 1;
        }
        $result = [];
        for ($i = 0; $i < $quantity; $i++) {
            $result[] = $class::generate();
        }
        return $result;
    }
}
