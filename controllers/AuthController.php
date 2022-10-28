<?php

/**
 * AuthController.php
 * User: kzoltan
 * Date: 2022-05-17
 * Time: 07:30
 */

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Language;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\LoginForm;
use app\models\User;


/**
 * Class AuthController
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\controllers
 * @version 1.0
 */
class AuthController extends Controller
{
    /**
     * Konstruktor
     */
    public function __construct()
    {
        // Autentákíciós középréteg registrálása
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }
    
    /**
     * Belépés kezelése
     * GET kérés esetén a login oldal betöltése,
     * POST kérés esetén beléptetés
     * @param Request $request
     * @param Response $response
     * @return type
     */
    public function login(Request $request, Response $response)
    {
        $loginModel = new LoginForm();
        if($request->isPost())
        {
            $loginModel->loadData($request->getBody());
            
            if( $loginModel->validate() && $loginModel->login() )
            {
                //$loginModel->login_logging();
                $response->redirect('/');
                return;
            }
        }
        
        $this->setLayout('auth');
        $login_title = Language::trans('login');
        return $this->render('login', [
                     'title' => $login_title,
               'login_title' => $login_title,
            'register_title' => Language::trans('register'),
                     'model' => $loginModel,
        ]);
    }
   
    /**
     * Regisztráció kezelése
     * GET kérés esetén regisztrációs oldal betöltése
     * POST kérés esetén regisztráció
     * @param Request $request
     * @return string
     */
    public function register(Request $request)
    {
        $user = new User();
        
        if($request->isPost())
        {
            $user->loadData($request->getBody());
            
            if( $user->validate() && $user->save() )
            {
                Application::$app->session->setFlash('success', 'Thanks for registering');
                Application::$app->response->redirect('/');
            }
            
            return $this->render('register', [
                'model' => $user,
            ]);
        }
        
        $register_title = Language::trans('register');
        $this->setLayout('auth');
        return $this->render('register', [
            'model' => $user,
            'title' => $register_title,
            'register_title' => $register_title,
            'login_title' => Language::trans('login'),
        ]);
    }
    
    /**
     * Kilépés kezelése
     * @param Request $request
     * @param Response $response
     */
    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }
    
    /**
     * Profil oldal betöltése
     * @return type
     */
    public function profile()
    {
        
        return $this->render('profile');
    }
}
