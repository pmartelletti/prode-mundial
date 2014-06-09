<?php
namespace ProdeMundial\WebBundle\Twig;


use Symfony\Bundle\TwigBundle\Extension\AssetsExtension;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Templating\Helper\CoreAssetsHelper;

class FlagExtension extends  \Twig_Extension
{
    /** @var \Symfony\Component\Templating\Helper\CoreAssetsHelper  */
    private $assetsHelper;

    public function __construct(ContainerInterface $container)
    {
        $this->assetsHelper = $container->get('templating.helper.assets');
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('flag', array($this, 'renderFlag'))
        );
    }

    public function renderFlag($flag)
    {
        $asset = sprintf('bundles/prodemundialweb/img/flags/%s.png', strtolower($flag));

        return $this->assetsHelper->getUrl($asset);
    }

    public function getName()
    {
        return 'prodemundial_flag_extension';
    }
} 