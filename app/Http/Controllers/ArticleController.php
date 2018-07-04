<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Config;
use PhpFanatic\clarifAI\ImageClient;


class ArticleController extends Controller
{   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    /**
     * 新增圖片表單
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        // $query = Merchandise::all();
        
        return view('add_image');
    }

    /**
     * 新增圖片
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        include(app_path().'/system/function.php');

        $myclient = new ImageClient(Config::get('my_config.clarifai_app_key'));    // Ktrees clarifai

        $image = (isset($_POST['image'])) ? $_POST['image'] : '' ;
        $brand = (isset($_POST['brand'])) ? $_POST['brand'] : '' ;

        $meta = array();

        array_shift($_POST);    // 去掉 csrf_token

        foreach ($_POST as $key => $bool) 
        {   
            if ($key != 'image' && $bool !== '' && $key != 'brand') 
            {   
                $concept[] = array('id'=>$key, 'value'=> $bool);    // 若 Concept 不存在則無效
            }
        }

        if ($brand) 
        {   
            $meta['is_brand'] = 1;
            $meta['brand'] = $brand;
        }
        else
        {
            $meta['is_brand'] = 0;
        }

        if ($image) 
        {   

            $image_id = "test_".time();     // ID 需為字串

            // 新增 Image & 附上 Concept (image, image_id, $concept, $meta)
            
            $myclient->AddImage($image,$image_id, array(), $meta);
            $response = $myclient->InputsAdd();

            // 回傳狀態:Ok/?
            $response_status = json_decode($response)->status->description;

            if ($response_status == 'Ok') 
            {   

                $myclient->AddConcept($image_id, $concept);
                $response = $myclient->InputsUpdate();

                // 回傳狀態:Ok/?
                $response_status = json_decode($response)->status->description;

                if ($response_status == 'Ok')
                {   
                    AlertWindow('back', $alertMessage = '新增成功！');
                }
                else
                {
                    AlertWindow('back', $alertMessage = '圖片已上傳，Concept增加失敗！');
                }

            }
            else
            {   
                $response = $myclient->InputsDelete($image_id);     // 刪除上傳失敗的圖片

                AlertWindow('back', $alertMessage = '上傳圖片失敗！');
            }

        }
        else
        {
            AlertWindow('back', $alertMessage = '請輸入圖片網址！');
        }
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
     * 顯示編輯圖片
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $myclient = new ImageClient(Config::get('my_config.clarifai_app_key'));    // Ktrees clarifai

        $image_id = $id ;

        $show = '';

        $response = $myclient->InputsGet($image_id);

        $response = json_decode($response);

        $image_url = $response->input->data->image->url;        // 圖片網址

        $update_time    = $response->input->modified_at;        // 圖片最後更新時間

        // print_r($response->input->data->concepts);

        if (isset($response->input->data->concepts)) 
        {
            foreach ($response->input->data->concepts as $key => $val) 
            {   
                $opportunity = round($val->value,3)*100 .'%';
                $show .= '  
                    
                        <label for="" style="margin-top:5px;">'.$val->id.'  :  '.$val->value.'</label><br />
                    
                ';
            }
        }

        $data = array(
            'show'          => $show, 
            'image_url'     => $image_url,
            'image_id'      => $image_id,
            'update_time'   => $update_time,
        );

        return view('update_image_concept', $data);
    }

    /**
     * 更新圖片
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        include(app_path().'/system/function.php');

        $myclient = new ImageClient(Config::get('my_config.clarifai_app_key'));    // Ktrees clarifai

        $image_id = (isset($_POST['image_id'])) ? $_POST['image_id'] : '' ;

        array_shift($_POST);    // 去掉 csrf_token
        array_shift($_POST);    // 去掉 _method

        foreach ($_POST as $key => $bool) 
        {   
            if ($key != 'image_id' && $bool !== '') 
            {   
                $concept[] = array('id'=>$key, 'value'=> $bool);    // 若 Concept 不存在則無效
            }
        }

        if ($image_id) 
        {   
            // 更新 Image Concept (image_id, array(array('id'=>'concept', 'value' => T/F )))
            $myclient->AddConcept($image_id, $concept);
            $response = $myclient->InputsUpdate();

            // 回傳狀態
            $response_status = json_decode($response)->status->description;

            if ($response_status == 'Ok')
            {   
                AlertWindow('back' , $alertMessage = '更新成功！');
            }
            else
            {
                AlertWindow('back', $alertMessage = '更新失敗！');
            }

        }
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

    /**
     * 顯示圖片列表
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function image_list()
    {   
        $myclient = new ImageClient(Config::get('my_config.clarifai_app_key'));    // Ktrees clarifai

        $page = (isset($_GET['page'])) ? $_GET['page'] : 1 ;

        $myclient->Paginate($page, 10);         // 指定頁數及數量

        $response = $myclient->InputsGet();

        $response = json_decode($response);

        $show = '';

        foreach ($response->inputs as $key => $val) 
        {
            $show .= '  
                    <tr>
                      <td>'.$val->id.'</td>
                      <td><img src="'.$val->data->image->url.'" width="80"></td>
                      <td>'.$val->created_at.'</td>
                      <td>'.$val->modified_at.'</td>
                      <td><a href="article/'.$val->id.'/edit"><button class="btn btn-default">編輯更新</button></a></td>
                    </tr>
            ';

        }

        return view('image_list', ['show_list' => $show]);
    }

}
