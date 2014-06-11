<?php

namespace ProdeMundial\CoreBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PaymentsController extends Controller
{
    public function notificationsAction(Request $request)
    {
        // payment id
        $id = $request->get('id');
        if ($id)
            $payment = $this->get('prodemundial.core.mercadopago_preferences')->processPayment($id);
        else
            return new Response('Este URL debe ser utilizado por el IPN.', 403);

        $em = $this->getDoctrine()->getManager();
//        $em->persist($payment);
        $em->flush();

        return new Response('', 200);
    }
} 