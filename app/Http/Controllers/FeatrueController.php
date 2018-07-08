<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use PhpFanatic\clarifAI\ImageClient;

include(app_path().'/system/function.php');

class FeatrueController extends Controller
{   
    /**
     * 辨視圖片
     *
     * @return \Illuminate\Http\Response
     */
    public function recognite()
    {
        $image = (isset($_GET['image'])) ? $_GET['image'] : '' ;

        $show = '';

        if ($image) 
        {   
            $myclient = new ImageClient(Config::get('my_config.clarifai_app_key'));    // Ktrees clarifai

            // Predict Image (model_name)
            $myclient->AddImage($image);

            $response = $myclient->Predict('類型');
            $response = json_decode($response);
            
            $image_concepts = $response->outputs[0]->data->concepts;    // 圖片 Concept 參數資料

            $show .= '<div class="col-md-2">';
            $show .= '<h4>服飾類型</h4> <br />';

            if ($image_concepts) 
            {
                foreach ($image_concepts as $key => $val) 
                {   
                    $opportunity = round($val->value,3)*100 .'%';

                    $show .= '  
                            <label for="">'.$val->id.'  :  '.$opportunity.'</label><br />
                    ';
                }
            }
            $show .= '</div>';

            // ----------------------------------------------------------------------------------------------------

            $response = $myclient->Predict('樣式');
            $response = json_decode($response);
            $image_concepts = $response->outputs[0]->data->concepts;    // 圖片 Concept 參數資料

            $show .= '<div class="col-md-2">';
            $show .= '<h4>服飾樣式</h4> <br />';

            if ($image_concepts) 
            {
                foreach ($image_concepts as $key => $val) 
                {   
                    $opportunity = round($val->value,3)*100 .'%';

                    $show .= '  
                        
                            <label for="">'.$val->id.'  :  '.$opportunity.'</label><br />
                    ';
                }
            }
            $show .= '</div>';
        }

        return view('recognite_image', ['show' => $show, 'image' => $image]);

    }

    /**
     * 訓練模組
     *
     */
    public function train()
    {
        $model_id = (isset($_GET['model_id'])) ? $_GET['model_id'] : '' ;

        if ($model_id) 
        {   
            $myclient = new ImageClient(Config::get('my_config.clarifai_app_key'));    // Ktrees clarifai

            // Train Model (model_id)
            $response = $myclient->ModelTrain($model_id);

            // 回傳狀態
            $response_status = json_decode($response)->status->description;

            if ($response_status == 'Ok')
            {   
                AlertWindow('/', $alertMessage = '訓練成功！');
            }
            else
            {
                AlertWindow('/train', $alertMessage = '訓練失敗！');
            }
        }
        else
        {
            return view('train');
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
