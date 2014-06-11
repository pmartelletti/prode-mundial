<?php
namespace ProdeMundial\CoreBundle\Twig;


use ProdeMundial\CoreBundle\Payments\MercadoPagoGateway;
use Symfony\Component\Security\Core\SecurityContextInterface;

class MercadoPagoExtension extends \Twig_Extension
{
    private $preferences;

    private $security;

    private $endpoint;

    public function __construct(SecurityContextInterface $security, MercadoPagoGateway $preferences, $endpoint)
    {
        $this->preferences = $preferences;
        $this->security = $security;
        $this->endpoint = $endpoint;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('mercadopago_payment', array($this, 'getMercadoPagoButton'), array('is_safe' => array('html')))
        );
    }

    public function getMercadoPagoButton()
    {
        $user = $this->security->getToken()->getUser();
        $preferences = $this->preferences->getPaymentPreference($user);

        return sprintf('<a href="%s" name="MP-Checkout" class="lightblue-M-Ov-ArOn">Pagar Prode</a>', $preferences['response'][$this->endpoint]);
    }

    public function getName()
    {
        return 'prodemundial_mercagopago';
    }
} 