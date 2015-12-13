<?php

namespace Bolt\Extension\OnlineSid\UIBootstrapCarousel;

use Bolt\BaseExtension;

/**
 * Class Extension
 *
 * @package Bolt\Extension\OnlineSid\UIBootstrapCarousel
 */
class Extension extends BaseExtension
{
    /**
     * Extension name
     *
     * @return string
     */
    public function getName()
    {
        return "UI Bootstrap Carousel";
    }

    /**
     * Initialise
     *
     * @return void
     */
    public function initialize()
    {
        /*
         * Frontend
         */
        if ($this->app['config']->getWhichEnd() == 'frontend') {
            // Initialize the Twig function
            $this->addTwigFunction('uib_carousel', 'twigUIBootstrapCarousel');
        }
    }
    /**
     * Twig callback function
     *
     * @param string $name
     *
     * @return \Twig_Markup
     */
    public function twigUIBootstrapCarousel($name = '')
    {
        // If the passed record name doesn't match one in config, just return
        if (empty($name)) {
            return new \Twig_Markup('<b>No carousel name passed in.</b>', 'UTF-8');
        }
        // Check for a valid config carousel
        if (!isset($this->config[$name])) {
            return new \Twig_Markup('<b>Invalid carousel name specified.</b>', 'UTF-8');
        }
        // Content is required
        if (empty($this->config[$name]['content'])) {
            return new \Twig_Markup('<b>Carousel configuration is missing a content key.</b>', 'UTF-8');
        }
        // Get the config specific to this carousel
        $carousel = $this->config[$name];
        // Default to using the 'images' field
        if (empty($carousel['field'])) {
            $field = 'images';
        } else {
            $field = $carousel['field'];
        }
        // Get the specified content type and the images field
        $params = array();
        $content = $this->app['storage']->getContent($carousel['content'], $params);
        $images = $content->values[$field];
        $dataoptions = '';
        if (isset($carousel['options'])) {
            foreach ($carousel['options'] as $option => $val) {
                $dataoptions .= "data-{$option}={$val} ";
            }
        }
        if (is_array($images)) {
            // Randomise the array if configured
            if (!empty($carousel['random']) && $carousel['random']) {
                shuffle($images);
            }
            // Limit the number of pictures if configured
            if (!empty($carousel['count']) && is_numeric($carousel['count'])) {
                $images = array_slice($images, 0, $carousel['count']);
            }
            $this->app['twig.loader.filesystem']->addPath(__DIR__ . '/assets/');
            $html = $this->app['render']->render($carousel['template'], array(
                'name'        => $name,
                'class'       => isset($carousel['class']) ? : '',
                'next'        => isset($carousel['text']['next']) ? : 'Next',
                'prev'        => isset($carousel['text']['next']) ? : 'Previous',
                'dataoptions' => trim($dataoptions),
                'images'      => $images,
                'interval'    => @$carousel['options']['interval'] ? : 5000,
                'no_wrap'     => @$carousel['options']['no_wrap'] ? : 'false',
            ));
            return new \Twig_Markup($html, 'UTF-8');
        }
    }

    /**
     * Set up config defaults
     *
     * @return array
     */
    protected function getDefaultConfig()
    {
        return array();
    }
}
