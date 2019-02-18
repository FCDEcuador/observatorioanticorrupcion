<?php

namespace BlaudCMS\Http\Traits;

use Flashy;

trait BackendAuthorizable
{
    private $abilities = [
        'backend' => [
            'index' => 'view',
            'show' => 'view',
            'create' => 'add',
            'store' => 'add',
            'edit' => 'edit',
            'update' => 'edit',
            'changeStatus' => 'edit',
            'destroy' => 'delete',
        ],
    ];

    /**
     * Override of callAction to perform the authorization before
     *
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function callAction($method, $parameters)
    {
        if( $ability = $this->getAbility($method) ) {
            $this->authorize($ability);
        }

        return parent::callAction($method, $parameters);
    }

    public function getAbility($method)
    {
        $routeName = explode('.', \Request::route()->getName());
        $action = array_get($this->getAbilities(), $method);

        return $action ? $routeName[0] . '_' . $action . '_' . str_replace("-","",strtolower($routeName[count($routeName)-2])) : null;
    }

    private function getAbilities()
    {
        return $this->abilities;
    }

    public function setAbilities($abilities)
    {
        $this->abilities = $abilities;
    }
}