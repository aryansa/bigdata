<?php
/**
 * Created by PhpStorm.
 * User: aryanpc
 * Date: 8/24/19
 * Time: 8:33 AM
 */

namespace App\Controllers;


use App\Misc\Response\TemplateResponse;
use App\Services;
use App\Views\CarLogView;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class StreamingController
{
    public function index()
    {
        Services::accountService()->checkAdminUser();

        return TemplateResponse::make(
            "stream.twig",
            []
        );
    }

    public function stream(Request $request)
    {

        Services::accountService()->checkAdminUser();
        $ids = Services::cassandraService()->query("SELECT DISTINCT company_id from vehicles_by_company", []);
        return TemplateResponse::make(
            "stream.twig",
            [
                'ids' => $ids,
            ]
        );
    }

    public function update(Request $request)
    {
        $id = $request->get("companyId");
        Services::accountService()->checkAdminUser();
        $results = (new CarLogView())->getLogs($id);
        $response = [];
        $i = 0;
        foreach ($results as $result) {
            $response[$i]['id'] = $result->getId();
            $response[$i]['lat'] = (float)$result->getLat();
            $response[$i]['lng'] = (float)$result->getLng();
            $i++;
        }


        return JsonResponse::create(json_encode($response)) ;
    }

}