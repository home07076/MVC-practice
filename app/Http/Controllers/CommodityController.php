<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use App\Models\Commodity_sku;
use App\Models\User;
use http\QueryString;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use PHPUnit\TextUI\XmlConfiguration\Group;

class CommodityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()) {
            $user_name = Auth::user()->name ;
            $user_id = Auth::user()->id;
            $commodity_sku = Commodity::join('commodity_skus' , 'commodities.commodities_id' , '=' , 'commodity_skus.commodities_id')
                ->select('commodity_skus.color as color' , 'commodity_skus.size as size' , 'commodity_skus.commodities_id as sku_id')

                ->get();
            //dd($commodity_sku);// 修改搜尋選項


            return view('posts.index', ['commodities' => Commodity::cursor() , 'name' => $user_name , 'id' => $user_id , 'commodity_skus'=>$commodity_sku]);
        }else{
            return redirect('/login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()){
            return view('posts.create');
        }else{
            return redirect('/login');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , Commodity $commodity , Commodity_sku $sku)
    {
        /*$content = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'description' => 'required|max:200'
        ]);*/
            $commodity->name = $request->input('name');
            $commodity->category = $request->input('category');
            $commodity->price = $request->input('price');
            $commodity->quantity = $request->input('quantity');
            $commodity->description = $request->input('description');
            $commodity->seller = Auth::user()->id;
            $commodity->commodities_id = Cache::increment('commodities_id');


            $sku->size = $request->input('size_');
            $sku->color = $request->input('color_');
            $sku->commodities_id = $commodity->commodities_id;




            if ($request->hasFile('image')) {
                if ($commodity->image) {
                    Storage::disk('public')->delete('image', 'public');
                }
                $path = $request->file('image')->store('image', 'public');
                $commodity->image = $path;

            }


            $commodity->save();
            $sku->save();
            return redirect(route('commodities.index')) -> with('notice','商品新增成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commodity  $commodity
     * @return \Illuminate\Http\Response
     */
    public function show(Commodity $commodity)
    {
        return view('posts.show',['commodities' => $commodity]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Commodity  $commodity
     * @return \Illuminate\Http\Response
     */
    public function edit(Commodity $commodity)
    {

        $filter_user = Auth::user()->id;
        $filter_seller = $commodity->seller;

        if ($filter_user == $filter_seller) {
            return view('posts.edit', ['commodities' => $commodity ]);
        }else{
            sleep(1);
            return redirect()->route('commodities.index')->with('notice','無訪問權限');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commodity  $commodity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commodity $commodity, Commodity_sku $sku)
    {

        $content = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'description' => 'required|max:200',
        ]);

        $commodity->name = $request->input('name');
        $commodity->category = $request->input('category');
        $commodity->price = $request->input('price');
        $commodity->quantity = $request->input('quantity');
        $commodity->description = $request->input('description');
        $commodity->seller = Auth::user()->id;
        $commodity->commodities_id = Cache::increment('commodities_id');

        $sku->size = $request->input('size_');
        $sku->color = $request->input('color_');
        $sku->commodities_id = $commodity->commodities_id;

        if ($request->hasFile('image')){
            if ($commodity->image){
                Storage::disk('public')->delete('image','public');
            }
            $path = $request->file('image')->store('image','public');
            $commodity->image = $path;
        }

        $commodity->save();
        $sku->save();
        return redirect(route('commodities.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commodity  $commodity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commodity $commodity)
    {
        $commodity->delete();

        return redirect(route('commodities.index'));
    }

    public function  logout(){
        Auth::logout();
        return redirect('/');
    }

}
