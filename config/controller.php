<?php
use Phalcon\Mvc\Micro\Collection as MicroCollection;

/**
 * User Annotations to make MicroCollection
 * @param array $supportHandler
 * @param array $supportMethods
 * @param \Phalcon\Mvc\Micro $app
 * @return MicroCollection | false
 */
function createCollections(array $supportHandler,
        array $supportMethods,\Phalcon\Mvc\Micro $app)
{
    if (count($supportHandler) == 0 || count($supportMethods) == 0) {
        return false;
    }
    $url=  $app->url;
    $reader = new \Phalcon\Annotations\Adapter\Memory();
    foreach ($supportHandler as $Handler) {
        $RoutePrefix = '';
        $collection = new MicroCollection();
        $reader = new \Phalcon\Annotations\Adapter\Memory();

        $reflector = $reader->get($Handler);
        $collection->setHandler($Handler, true);

        //support RoutePrefix ex: @RoutePrefix("/api/products")
        $annotations = $reflector->getClassAnnotations();
        if (count($annotations) > 0) {
            foreach ($annotations as $annotation) {
                if ($annotation->getName() == 'RoutePrefix') {
                    $RoutePrefix = $annotation->getArgument(0);
                }
            }
        }

        $annotations = $reflector->getMethodsAnnotations();
        foreach ($annotations as $func => $annotation) {
            if (count($annotation) > 0) {
                foreach ($annotation as $key => $method) {
                    /**
                     * support any single ex: @Get("/")
                     */
                    if (in_array($method->getName(), $supportMethods)) {
                        $action = strtolower($method->getName());
                        $collection->$action($url->get($RoutePrefix . $method->getArgument(0)), $func);
                    }
                    /**
                     * support ex: @Route("/delete/{id:[0-9]+}",methods="DELETE"})
                     *            
                     */
                    if ($method->getName() == 'Route' && count($method->getArgument('methods')) > 0) {
                        foreach ($method->getArgument('methods') as $key => $action) {
                            $action = strtolower($action);
                            $collection->$action($url->get($RoutePrefix . $method->getArgument(0)), $func);
                        }
                    }
                }
            }
        }
        $app->mount($collection);
    }

    return true;
}

//Add yous Controller
$supportHandler = array("IndexController");
//Add you want supportMethods
$supportMethods = array('Get', 'Post', 'Put', 'Delete', 'Options');
$mapCollections = createCollections($supportHandler, $supportMethods, $app);
