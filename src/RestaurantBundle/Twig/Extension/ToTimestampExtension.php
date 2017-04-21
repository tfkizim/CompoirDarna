<?php
namespace RestaurantBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use \Twig_Extension;

class ToTimestampExtension extends Twig_Extension
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getName()
    {
        return 'RestaurantBundle:ToTimestampExtension';
    }

    public function getFilters()
    {
        return array(
            'totimestamp' => new \Twig_Filter_Method($this, 'toTimestamp'),
        );
    }

    public function toTimestamp($date)
    {
        return $date->getTimestamp();
    }
}