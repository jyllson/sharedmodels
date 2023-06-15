<?php

namespace Lundash\SharedModels\Controllers;

use App\Http\Requests\StoreBrandRequest;
use Lundash\SharedModels\Models\Brand;
use Illuminate\Http\Request;
use App\Models\Log;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class BrandController extends App\Http\Controllers\Controller
{
    public function __construct()
    {
        $this->authorizeResource(Brand::class, 'brand');
    }
    /**
     * Display a listing of the resource.
     * @group Brands
     * @urlParam perPage integer optional Number of brands to show per page.
     */
    public function index()
    {
        $per_page = request('perPage', 25);
        // $brands = Auth()->user()->brands()->paginate($per_page);
        $brands = Brand::paginate($per_page);
        return $brands;
    }

    /**
     * Store a newly created resource in storage.
     * @group Brands
     * @bodyParam name string required The name of the brand. Example: Casinozer
     * @bodyParam slug string required The slug of the brand. Example: cazinozer
     * @bodyParam type string required The type of the brand. Example: igaming
     * @bodyParam enabled int required Is brand enabled? 1-Enabled, 0-Disabled. Example: 1
     */
    public function store(StoreBrandRequest $request)
    {
        $brand_slug = strtolower(implode('-', explode(' ', $request['name'])));
        
        if(!is_null($request) || !empty($request)){
            $brand = new Brand($request->all());
            if(in_array($brand_slug, Brand::all()->pluck('slug')->toArray()))
            {
                $brand->slug = $brand_slug . '-1';
            } else {
                $brand->slug = $brand_slug;
            }
        } else {
            return response()->json(['status' => 'Error: Request empty.']);
        }

        try{
            $brand->save();
        } catch(\Exception $e) {
            return $e->getMessage();
        }
        
        return response()->json(['status' => 'ok', 'id' => $brand->id]);
    }

    /**
     * Display the specified resource.
     * @group Brands
     */
    public function show(Brand $brand)
    {
        if(in_array($brand->id, Auth::user()->brands->pluck('id')->toArray())){
            return Brand::whereId($brand->id)->select('id', 'name', 'type', 'enabled')->first();
        } else {
            return response()->json(['status' => 'forbidden'], 403);
        }
        
    }

    /**
     * Specified w/ BrandThemes.
     * @group Brands
     */
    public function themes(Brand $brand)
    {
        $brand_full = Brand::whereId($brand->id)
                    ->select('id', 'name', 'type', 'enabled')
                    ->with(['themes' => function($query){
                        $query->select('id','name','brand_id','logo','font','font2','font3','colorBD','colorBL','colorBR','colorBRD','colorBRL','colorBRR','colorTD','colorTL','colorTR','colorTRD','colorTRL','colorTRR','color2A','color2D','color2L','color2R','color3A','color3D','color3L','color3R','enabled');
                    }])
                    ->first();
        return $brand_full;
    }

    /**
     * Specified resource w/ BrandUsers.
     * @group Brands
     * @urlParam perPage integer optional Number of users of the brand to show per page.
     */
    public function brandUsers(Brand $brand)
    {
        $per_page = request('perPage', 25);
        $brand_full = Brand::select(['id', 'name', 'type', 'enabled'])->whereId($brand->id)->first();
        $brand_full->setRelation('brandUsersDetails', $brand_full->brandUsersDetails()->select('id','brand_id','brand_user_id','account_id','email','mobile')->paginate($per_page));
        return $brand_full;
    }

    /**
     * Specified w/ BrandUsers' full details (addresses, cards, ibans, ip addresses, custom fields).
     * @group Brands
     * @urlParam perPage integer optional Number of users of the brand to show per page.
     */
    public function brandUsersFull(Brand $brand)
    {
        $per_page = request('perPage', 25);
        $brand_full = Brand::select(['id', 'name', 'type', 'enabled'])->whereId($brand->id)
            ->with('brandUsersDetails')
            ->with('brandUsersDetails.addresses')
            ->with('brandUsersDetails.cards:id,brand_user_detail_id,card_no')
            ->with('brandUsersDetails.ibans:id,brand_user_detail_id,iban')
            ->with('brandUsersDetails.ips:id,brand_user_detail_id,ip_address')
            ->with('brandUsersDetails.customs:id,brand_user_detail_id,type,value')
            ->get();
        return $brand_full;
    }

    /**
     * Update the specified resource in storage.
     * @group Brands
     * @bodyParam name string optional The name of the brand. Example: Casinozer
     * @bodyParam type string optional The type of the brand. Example: igaming
     * @bodyParam enabled int optional Is brand enabled? 1-Enabled, 0-Disabled. Example: 1
     */
    public function update(Request $request, Brand $brand)
    {
        try{
            $brand->update($request->all());
        } catch(\Exception $e) {
            return $e->getMessage();
        }
        
        return response()->json(['status' => 'ok']);
    }

    /**
     * Enables Brand.
     * @group Brands
     */
    public function enable(Brand $brand)
    {
        try{
            $brand = Brand::whereId($brand->id)->update(["enabled" => 1]);
        } catch(\Exception $e) {
            return $e->getMessage();
        }
        
        return response()->json(['status' => 'ok']);
    }

    /**
     * Disables Brand.
     * @group Brands
     */
    public function disable(Brand $brand)
    {
        try{
            $brand = Brand::whereId($brand->id)->update(["enabled" => 0]);
        } catch(\Exception $e) {
            return $e->getMessage();
        }
        
        return response()->json(['status' => 'ok']);
    }

    /**
     * Remove the specified resource from storage.
     * @group Brands
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return response()->json(['status' => 'ok']);
    }
}
