<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiBaseController;
use Illuminate\Http\Request;
use App;
use App\Category;
use App\Setting;
use App\Lawyer;

/**
 * Handle category operations
 * @author Ahmad Gamal <eng.asgamal@gmail.com>
 */
class CategoryController extends ApiBaseController {

    /**
     * @SWG\Get(
     *     path="/api/auth/category/list",
     *     summary="List request categories",
     *     tags={"Category"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          in="header", name="X-Api-Language", description="['ar','en'] default is 'ar'", type="string",
     *      ),
     *     @SWG\Parameter(
     *          in="header", name="Authorization", description="Logged in User access token", required=true, type="string",
     *      ),
     *     @SWG\Response(response="405",description="Invalid input"),
     *     @SWG\SecurityScheme(
     *         securityDefinition="X-Api-Token",
     *         type="apiKey",
     *         in="header",
     *         name="X-Api-Token"
     *    ),
     * )
     */
    public function listCategories(Request $request) {
        $parentCategories = Category::whereParent(null)->get();
        $responses = new \stdClass();
        $fees = Setting::where('setting', 'DELIVER_REQUEST_TO_HOME')->first();
        $responses->deliverToHomeFees = $fees ? $fees->value: 0;
        $responses->categories = $this->prepareCategoriesWithSubs($parentCategories);
        return $this->getSuccessJsonResponse($responses);
    }
    
    private function prepareCategoriesWithSubs($parentCategories) {
        $categories = [];
        foreach ($parentCategories as $category) {
            $categories[] = [
                'id' => $category->id,
                'name' => $category->getNameLocal(),
                'discription' => $category->getDiscriptionLocal(),
                'cost' => $category->cost,
                'hasSubs' => $category->leave ? 0 : 1,
                'subs' => $category->leave ? null : $this->prepareCategoriesWithSubs($category->subCategories()),
            ];
        }
        return $categories;
    }

    /**
     * @SWG\Get(
     *     path="/api/auth/laywer/prices",
     *     summary="List request categories",
     *     tags={"Category"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          in="header", name="X-Api-Language", description="['ar','en'] default is 'ar'", type="string",
     *      ),
     *     @SWG\Parameter(
     *          in="header", name="Authorization", description="Logged in User access token", required=true, type="string",
     *      ),
     *     @SWG\Response(response="405",description="Invalid input"),
     *     @SWG\SecurityScheme(
     *         securityDefinition="X-Api-Token",
     *         type="apiKey",
     *         in="header",
     *         name="X-Api-Token"
     *    ),
     * )
     */
    public function listLawyerPrices(Request $request) {
        $parentCategories = Category::whereLeave(true)->get();
        $responses = new \stdClass();
        $fees = Setting::where('setting', 'DELIVER_REQUEST_TO_HOME')->first();
        $responses->deliverToHomeFees = $fees ? $fees->value: 0;

        $categories = [];
        foreach ($parentCategories as $category) {
            if(!in_array($user->lawyerType, $this->getCategoryType($category)))
                continue;
            
            $categories[] = [
                'name' => $category->parentCategory ? $category->parentCategory->getNameLocal().'-'.$category->getNameLocal() : $category->getNameLocal(),
                'discription' => $category->getDiscriptionLocal(),
                'cost' => $category->cost,
            ];
        }


        $responses->categories = $categories;
        $fees = Setting::where('setting', 'DELIVER_REQUEST_TO_HOME')->first();
        $responses->deliverToHomeFees = $fees ? $fees->value: 0;
        return $this->getSuccessJsonResponse($responses);
    }

    public function getCategoryType($category) {
        $type = $category->id == 13 ? Lawyer::$LAWYER_CLERK_SUBTYPE : Lawyer::$LAWYER_AUTHORIZED_SUBTYPE;
        return [$type, Lawyer::$LAWYER_BOTH_SUBTYPE];
    }
}
