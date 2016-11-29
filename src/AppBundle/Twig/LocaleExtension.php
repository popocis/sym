<?php

namespace AppBundle\Twig;

use Twig_Extension;
use Twig_Filter_Method;

class LocaleExtension extends Twig_Extension
{
    public function getFilters()
    {
        return array(
            'localeflag' => new Twig_Filter_Method($this, 'localeFlagFilter')
        );
    }

    public function localeFlagFilter($arg1)
    {
        switch ($arg1) {
            case 'it':
                return 'flag-icon-it'; 

            case 'en':
            default:
                return 'flag-icon-us';
        }
    }

    public function getName()
    {
        return 'locale_extension';
    }
}