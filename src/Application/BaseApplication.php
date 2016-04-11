<?php

namespace Bludata\Application;

use Bludata\Entities\BaseEntity;
use Closure;
use Laravel\Lumen\Application;

abstract class BaseApplication extends Application
{
    /**
     * @var Bludata\Entities\BaseEntity
     */
    protected $currentUser;

    /**
     * @return Bludata\Entities\BaseEntity
     */
    public function getCurrentUser()
    {
        return $this->currentUser;
    }

    /**
     * @return Bludata\Application\BaseApplication
     */
    public function setCurrentUser(BaseEntity $currentUser)
    {
        $this->currentUser = $currentUser;

        return $this;
    }

    /**
     * @return Bludata\Application\BaseApplication
     */
	public function resource($descriptionGroup, $prefix, $controller, array $except = [], Closure $routes = null)
    {
        $exceptAll = false;

        if (isset($except[0]))
        {
            $exceptAll = $except[0] == '*';
        }

        if (!$exceptAll)
        {
            if (!in_array('index', $except))
            {
                $this->get($prefix, [
                	'as' => $prefix.'.index', 
                	'uses' => $controller.'@index', 
                	'description' => 'Buscar todos',
                	'descriptionGroup' => $descriptionGroup
                ]);
            }

            if (!in_array('store', $except))
            {
                $this->post($prefix, [
                	'as' => $prefix.'.store', 
                	'uses' => $controller.'@store', 
                	'description' => 'Cadastrar',
                	'descriptionGroup' => $descriptionGroup
                ]);
            }

            if (!in_array('update', $except))
            {
                $this->put($prefix.'/{id:[0-9]+}', [
                	'as' => $prefix.'.update', 
                	'uses' => $controller.'@update', 
                	'description' => 'Editar',
                	'descriptionGroup' => $descriptionGroup
                ]);
            }

            if (!in_array('destroy', $except))
            {
                $this->delete($prefix.'/{id:[0-9]+}', [
                	'as' => $prefix.'.destroy', 
                	'uses' => $controller.'@destroy', 
                	'description' => 'Excluir',
                	'descriptionGroup' => $descriptionGroup
                ]);
            }
        }

        if ($routes instanceof Closure)
        {
            $routes($descriptionGroup, $prefix, $controller);
        }

        return $this;
    }
}