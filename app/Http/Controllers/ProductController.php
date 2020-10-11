<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

use Flugg\Responder\Responder;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Responder $responder)
    {
        //carrega todos os produtos
        return responder()->success(Product::all())->respond();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        //envia erro caso o nome esteja vazio
        if(!$request->input('name') || $request->input('name') == ''){
            return responder()->error(400, 'Nome não informado.')->respond();
        }

        try {
            //faz a validação dos campos
            $newProduct = new Product();

            if($request->input('price') != ''){
                if(!is_numeric($request->input('price'))){
                    $newProduct->price = str_replace(',', '.', str_replace('.', '', $request->input('price')));
                }else{
                    //caso já seja um número no formato correto
                    $newProduct->price = $request->input('price');
                }
                
            }else{
                $newProduct->price = 0.0;
            }
            
            if($request->input('weight') != ''){
                if(!is_numeric($request->input('weight'))){
                    $newProduct->weight = str_replace(',', '.', str_replace('.', '', $request->input('weight')));
                }else{
                    $newProduct->weight = $request->input('weight');
                }
                
            }else{
                $newProduct->weight = 0.0;
            }
            
            if($request->input('name')){
                $newProduct->name = $request->input('name');
            }
            
            //gera o id único
            $generatedId = bin2hex(random_bytes(8));

            while(Product::find($generatedId)){
                $generatedId = bin2hex(random_bytes(8));
            }
            $newProduct->id = $generatedId;
            
            $newProduct->save();

            return responder()->success()->respond();
        } catch (\Throwable $th) {
            if(env('APP_DEBUG') == 'true'){
                return responder()->error(400, 'Erro ao inserir produto. '.$th->getMessage())->respond();
            }else{
                return responder()->error(400, 'Erro ao inserir produto.')->respond();
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
        try {
            //faz a validação dos campos
            //carrega o produto
            $product = Product::find($request->input('id'));
            
            if($request->input('price') != ''){
                if(!is_numeric($request->input('price'))){
                    $product->price = str_replace(',', '.', str_replace('.', '', $request->input('price')));
                }else{
                    //caso já seja um número no formato correto
                    $product->price = $request->input('price');
                }
            }
            
            if($request->input('weight') != ''){
                if(!is_numeric($request->input('weight'))){
                    $product->weight = str_replace(',', '.', str_replace('.', '', $request->input('weight')));
                }else{
                    $product->weight = $request->input('weight');
                }                
            }
            
            if($request->input('name')){
                $product->name = $request->input('name');
            }       
            
            $product->save();

            return responder()->success()->respond();
        } catch (\Throwable $th) {
            if(env('APP_DEBUG') == 'true'){
                return responder()->error(400, 'Erro ao atualizar produto. '.$th->getMessage())->respond();
            }else{
                return responder()->error(400, 'Erro ao atualizar produto.')->respond();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    /**
     * Delete (soft) an specified product item
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            //carrega o produto
            $product = Product::find($id);
            
            $product->delete();

            return responder()->success()->respond();
        } catch (\Throwable $th) {
            if(env('APP_DEBUG') == 'true'){
                return responder()->error(400, 'Erro ao remover produto. '.$th->getMessage())->respond();
            }else{
                return responder()->error(400, 'Erro ao remover produto.')->respond();
            }$th;
        }
        
        
    }
}
