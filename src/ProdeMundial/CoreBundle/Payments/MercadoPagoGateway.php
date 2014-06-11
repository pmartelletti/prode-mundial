<?php

namespace ProdeMundial\CoreBundle\Payments;


use Doctrine\ORM\EntityManager;
use ProdeMundial\CoreBundle\Entity\Payment;
use ProdeMundial\CoreBundle\Entity\PaymentRepository;
use ProdeMundial\CoreBundle\Entity\User;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\RouterInterface;

class MercadoPagoGateway
{
    private $gateweay;

    private $router;

    private $em;

    public function __construct($publicId, $secretID, RouterInterface $router, EntityManager $em)
    {
        $this->gateweay = new \MP($publicId, $secretID);
        $this->router = $router;
        $this->em = $em;
    }

    private function getPaymentItems($username, $email)
    {
        return $preference_data = array(
            "items" => array(
                array(
                    "title" => "Prode Mundial",
                    "quantity" => 1,
                    "currency_id" => "ARS",
                    "unit_price" => 50.00,
                    "description" => "Subscripcion a PRODE Mundial - http://prode-mundial.pmartelletti.com.ar. Usuario: $username"
                )
            ),
            "payer" => array(
                "email" => $email
            ),
            "back_urls" => array(
                "success" => $this->router->generate('fos_user_profile_show', array('paymentInfo' => 'success'), true),
                "failure" => $this->router->generate('fos_user_profile_show', array('paymentInfo' => 'failure'), true),
                "pending" => $this->router->generate('fos_user_profile_show', array('paymentInfo' => 'pending'), true)
            )
        );
    }

    public function getPaymentPreference(User $user)
    {
        $this->gateweay->sandbox_mode(TRUE);
        return $this->gateweay->create_preference(
            $this->getPaymentItems($user->getUsername(), $user->getEmail())
        );
    }

    public function processPayment($id) {
        $paymentInfo = $this->gateweay->get_payment_info($id);
        if ($paymentInfo['status'] == 200 ) {
            $paymentInfo = $paymentInfo['response'];
            $collection = $paymentInfo['collection'];
            $payer = $collection['payer'];
            /** @var User $user */
            $user = $this->em->getRepository('ProdeMundialCoreBundle:User')->findOneByEmail($payer['email']);
            /** @var Payment $payment */
            $payment = $this->em->getRepository('ProdeMundialCoreBundle:Payment')->findOneByExternalId($id);
            if (!$payment) {
                $payment = new Payment();
                $payment->setSource('mercadopago');
                $payment->setExternalId($id);
            }
            // we fill in the remaining fields
            $payment->setStatus($collection['status']);
            $payment->setStatusDetail($collection['status_detail']);
            $payment->setDateCreated(new \DateTime($collection['date_created']));
            $payment->setDateUpdated(new \DateTime($collection['last_modified']));

            if($user)
                $user->setPayment($payment);

            return $payment;
        }

        throw new BadRequestHttpException();

    }
} 