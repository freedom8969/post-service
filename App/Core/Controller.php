<?php

namespace Core;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\TwigFunction;

class Controller
{

    public function render($viewName, array $args = [])
    {
        static $twig = null;
        if ($twig === null) {
            $loader = new \Twig\Loader\FileSystemLoader(ROOTPATH . '/views');
            $params = array(
//                'cache' => '../cache',
                'auto_reload' => true,
                'debug' => true
            );
            $twig = new \Twig\Environment($loader, $params);
            $asset = new TwigFunction('asset', function ($path) {
                return '../public/' . $path;
            });
            $title = new TwigFunction('title', function ($title = null) {

                    return $title ;

            });

            $twig->addFunction($asset);
            $twig->addFunction($title);

        }
        try {
            echo $twig->render($viewName . '.twig', $args);
        } catch (LoaderError $e) {
            echo 'Twig LoaderError<br>' . $e;
        } catch (RuntimeError $e) {
            echo 'Twig RuntimeError<br>' . $e;
        } catch (SyntaxError $e) {
            echo 'Twig SyntaxError<br>' . $e;
        }

    }
}