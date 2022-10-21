<?php

/**
 * HumanController.php
 * User: kzoltan
 * Date: 2022-06-29
 * Time: 13:45
 */

namespace app\controllers;

use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\Human;

/**
 * Description of HumanController
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\controllers
 * @version 1.0
 */
class HumanController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['humans']));
    }
    
    public function humans()
    {
        $humans = Human::getAll();
        
        $this->setLayout('main');
        return $this->render('humans/humans', [
            'humans' => $humans,
        ]);
    }
    
    public function getHuman(Request $request, Response $response): string
    {
        $human = new Human();
        if( isset($request->getRouteParams()['id']) )
        {
            $id = (int)$request->getRouteParams()['id'];
            $human = Human::findOne(['id' => $id]);
        }
        
        return json_encode($human);
    }
    
    public function human_new(Request $request, Response $response){}
    
    public function human_edit(Request $request, Response $response){}
    
    public function human_delete(Request $request, Response $response){}
    
}
