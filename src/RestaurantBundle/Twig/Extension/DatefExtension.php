<?php
namespace RestaurantBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use \Twig_Extension;

class DatefExtension extends Twig_Extension
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getName()
    {
        return 'RestaurantBundle:DatefExtension';
    }

    public function getFilters()
    {
        return array(
            'datef' => new \Twig_Filter_Method($this, 'datef'),
        );
    }

    public function datef(\Datetime $datetime, $lang = 'fr_FR', $pattern = 'd. MMMM Y')
    {
        $formatter = new \IntlDateFormatter($lang, \IntlDateFormatter::LONG, \IntlDateFormatter::LONG);
        $formatter->setPattern($pattern);
        return $formatter->format($datetime);
    }
}