<?php

/**
 * CompanyController.php
 * User: kzoltan
 * Date: 2022-06-29
 * Time: 13:30
 */

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\Company;

/**
 * Description of CompanyController
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\controllers
 * @version 1.0
 */
class CompanyController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['companies']));
    }
    
    /**
     * Cégek index oldalának betöltése
     * @param Request $request
     * @param Response $response
     * @return type
     */
    public function companies(Request $request, Response $response)
    {
        $companies = Company::getAll();
        
        $this->setLayout('main');
        return $this->render('companies/companies', ['companies' => $companies]);
    }
    
    public function getCompany(Request $request, Response $response)
    {
        $company = new Company();
        if( isset($request->getRouteParams()['id']) )
        {
            $id = (int)$request->getRouteParams()['id'];
            $company = Company::findOne(['id' => $id]);
        }
        
        return json_encode($company);
    }
    
    public function company_new(Request $request, Response $response)
    {
        $company = new Company();
        if( $request->isPost() )
        {
            $company->loadData($request->getBody());
            
            if( $company->validate() && $company->save() )
            {
                Application::$app->session->setFlash('success', 'Thanks for add new company');
                Application::$app->response->redirect('/companies');
            }
        }
        
        $this->setLayout('main');
        return $this->render('companies/company_new', [
            'model' => $company
        ]);
    }
    
    public function company_edit(Request $request, Response $response)
    {
        $companyModel = new Company();
        
        if( isset($request->getRouteParams()['id']) )
        {
            $id = (int)$request->getRouteParams()['id'];
            $company = Company::findOne(['id' => $id]);
        }
        
        if( $request->isPost() )
        {
            $companyModel->loadData($request->getBody());

            if( $companyModel->validate() && $companyModel->save() )
            {
                Application::$app->session->setFlash('success', 'Thanks for edit company');
                Application::$app->response->redirect('/companies');
            }
        }
        
        $this->setLayout('main');
        return $this->render('companies/company_edit', [
            'model' => $company,
        ]);
    }
    
    public function company_delete(Request $request, Response $response)
    {
        $companyModel = new Company();
        
        $id = (int)$request->getRouteParams()['id'];
        $company = Company::findOne(['id' => $id]);
        
        if( $request->isPost() )
        {
            //
        }
        
        $this->setLayout('main');
        return $this->render('companies/company_delete', [
            'model' => $company
        ]);
    }
    
    /**
     * Cég adatainak megjelenítése
     * @param Request $request
     * @param Response $response
     */
    public function show(Request $request, Response $response)
    {
        //
    }
    
    /**
     * Új cég adatainak felvitele
     * @param Request $request
     * @param Response $response
     */
    public function create(Request $request, Response $response)
    {
        //
    }
    
    /**
     * Új cég adatinak mentése
     * @param Request $request
     * @param Response $response
     */
    public function store(Request $request, Response $response)
    {
        //
    }
    
    /**
     * Cég adatainak megjelenítése szerkesztésre
     * @param Request $request
     * @param Response $response
     */
    public function edit(Request $request, Response $response)
    {
        //
    }
    
    /**
     * Cég szerkesztett adatainak mentése
     * @param Request $request
     * @param Response $response
     */
    public function update(Request $request, Response $response)
    {
        //
    }
    
    /**
     * Cég adatainak törlése
     * Soft Delete esetén: 
     *  status = 0; 
     *  deleted_at = UTC_TIMESTAMP();
     * @param Request $request
     * @param Response $response
     */
    public function delete(Request $request, Response $response)
    {
        //
    }
}
