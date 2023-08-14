<?php

namespace Lundash\SharedModels\Controllers;

use App\Http\Requests\StoreBrandThemeRequest;
use Lundash\SharedModels\Models\BrandTheme;
use Illuminate\Http\Request;

class BrandThemeController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     * @group Brand Themes
     */
    public function index()
    {
        $per_page = request('perPage', 25);
        return BrandTheme::paginate($per_page);
    }

    /**
     * Store a newly created resource in storage.
     * @group Brand Themes
     * @bodyParam name string required Name of the Brand Theme. Example: Casinozer Theme 1
     * @bodyParam brand_id int required ID of the Brand of this Theme. Example: 1
     * @bodyParam logo string optional Brand Theme Logo. Example: logo.png
     * @bodyParam favicon string optional Brand Theme Favicon. Example: favicon.ico
     * @bodyParam font string optional Font name slug. Example: roboto
     * @bodyParam font2 string optional Font name slug. No-example
     * @bodyParam font3 string optional Font name slug. No-example
     * @bodyParam colorBD string optional Back Color Dark. Example: rgb(0,0,0,1)
     * @bodyParam colorBL string optional Back Color Light. No-example
     * @bodyParam colorBR string optional Back Color Regular. No-example
     * @bodyParam colorBRD string optional Back Color Reverse Dark. No-example
     * @bodyParam colorBRL string optional Back Color Reverse Light. No-example
     * @bodyParam colorBRR string optional Back Color Reverse Regular. No-example
     * @bodyParam colorTD string optional Text Color Dark. No-example
     * @bodyParam colorTL string optional Text Color Light. No-example
     * @bodyParam colorTR string optional Text Color Regular. No-example
     * @bodyParam colorTRD string optional Text Color Reverse Dark. No-example
     * @bodyParam colorTRL string optional Text Color Reverse Light. No-example
     * @bodyParam colorTRR string optional Text Color Reverse Regular. No-example
     * @bodyParam color2A string optional Secondary Color Alpha. No-example
     * @bodyParam color2D string optional Secondary Color Dark. No-example
     * @bodyParam color2L string optional Secondary Color Light. No-example
     * @bodyParam color2R string optional Secondary Color Regular. No-example
     * @bodyParam color3A string optional Tertiary Color Alpha. No-example
     * @bodyParam color3D string optional Tertiary Color Dark. No-example
     * @bodyParam color3L string optional Tertiary Color Light. No-example
     * @bodyParam color3R string optional Tertiary Color Regular. No-example
     * @bodyParam enabled string optional Is Theme Enabled? 1-Enabled, 0-Disabled. Example: 1
     */
    public function store(StoreBrandThemeRequest $request)
    {
        $brand_theme = new BrandTheme($request->all());

        try{
            $brand_theme->save();
        } catch(\Exception $e) {
            return $e->getMessage();
        }
        
        return response()->json(['status' => 'ok', 'id' => $brand_theme->id]);
    }

    /**
     * Display the specified resource.
     * @group Brand Themes
     */
    public function show(BrandTheme $brandTheme)
    {
        return $brandTheme;
    }

    /**
     * Update the specified resource in storage.
     * @group Brand Themes
     * @bodyParam name string optional Name of the Brand Theme. Example: Casinozer Theme 1
     * @bodyParam logo string optional Brand Theme Logo. Example: logo.png
     * @bodyParam favicon string optional Brand Theme Favicon. Example: favicon.ico
     * @bodyParam font string optional Font name slug. Example: roboto
     * @bodyParam font2 string optional Font name slug. No-example
     * @bodyParam font3 string optional Font name slug. No-example
     * @bodyParam colorBD string optional Back Color Dark. Example: rgb(0,0,0,1)
     * @bodyParam colorBL string optional Back Color Light. No-example
     * @bodyParam colorBR string optional Back Color Regular. No-example
     * @bodyParam colorBRD string optional Back Color Reverse Dark. No-example
     * @bodyParam colorBRL string optional Back Color Reverse Light. No-example
     * @bodyParam colorBRR string optional Back Color Reverse Regular. No-example
     * @bodyParam colorTD string optional Text Color Dark. No-example
     * @bodyParam colorTL string optional Text Color Light. No-example
     * @bodyParam colorTR string optional Text Color Regular. No-example
     * @bodyParam colorTRD string optional Text Color Reverse Dark. No-example
     * @bodyParam colorTRL string optional Text Color Reverse Light. No-example
     * @bodyParam colorTRR string optional Text Color Reverse Regular. No-example
     * @bodyParam color2A string optional Secondary Color Alpha. No-example
     * @bodyParam color2D string optional Secondary Color Dark. No-example
     * @bodyParam color2L string optional Secondary Color Light. No-example
     * @bodyParam color2R string optional Secondary Color Regular. No-example
     * @bodyParam color3A string optional Tertiary Color Alpha. No-example
     * @bodyParam color3D string optional Tertiary Color Dark. No-example
     * @bodyParam color3L string optional Tertiary Color Light. No-example
     * @bodyParam color3R string optional Tertiary Color Regular. No-example
     * @bodyParam enabled string optional Is Theme Enabled? 1-Enabled, 0-Disabled. Example: 1
     */
    public function update(Request $request, BrandTheme $brandTheme)
    {
        $brandTheme->update($request->all());
    }

    /**
     * Enables the specified resource.
     * @group Brand Themes
     */
    public function enable(BrandTheme $brandTheme)
    {
        try{
            $brandTheme->update(['enabled' => 1]);
        } catch(\Exception $e) {
            return $e->getMessage();
        }
        
        return response()->json(['status' => 'ok']);
    }

    /**
     * Disables the specified resource.
     * @group Brand Themes
     */
    public function disable(BrandTheme $brandTheme)
    {
        try{
            $brandTheme->update(['enabled' => 0]);
        } catch(\Exception $e) {
            return $e->getMessage();
        }
        
        return response()->json(['status' => 'ok']);
    }

    /**
     * Remove the specified resource from storage.
     * @group Brand Themes
     */
    public function destroy(BrandTheme $brandTheme)
    {
        $brandTheme->delete();

        return response()->json(['status' => 'ok']);
    }
}
