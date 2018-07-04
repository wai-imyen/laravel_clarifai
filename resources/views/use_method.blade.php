<?php

/*****************使用方法*******************/


function method ()
{
	// 回傳狀態:Ok/?
	$response_status = json_decode($response)->status->description;	

	// 新增 Model (mode_name, model_id  
	$response = $myclient->ModelAdd($mode_name, $model_id);

	// 刪除 Model (model_id, app_version)
	$response = $myclient->ModelDelete($model_id, $version);	

	// 增加 Concept (model_id, array(array('id'=>'value')))
	$concept['id'] ='value';
	$response = $myclient->ModelUpdate($model_id, array($concept));

	// 刪除 Concept (model_id, array(array('id'=>'value')),'remove')
	$response = $myclient->ModelUpdate($model_id, array($concept), 'remove');

	// Train Model (model_id)
	$response = $myclient->ModelTrain($model_id);

	// 新增 Image (image, image_id)
	$myclient->AddImage($image, $image_id);
	$response = $myclient->InputsAdd();

	// 更新 Image Concept (image_id, array(array('id'=>'concept', 'value' => T/F )))
	$concept_1['id'] ='條紋';
	$concept_2['id'] ='素色';
	$concept_1['value'] = TRUE;
	$concept_2['value'] = FALSE;
	$myclient->AddConcept($image_id, array($concept_1,$concept_2));
	$response = $myclient->InputsUpdate();

	// 刪除 Image (image_id) / (array())
	$response = $myclient->InputsDelete($image_id);

	// 新增 Image & 附上 Concept (image, image_id, $concept, $meta)
	$concept = array('id'=>'素色', 'value'=>true);	// 若 Concept 不存在則無效
	$meta = array($parm => $value);
	$myclient->AddImage($image, $image_id, $concept, $meta);
	$response = $myclient->InputsAdd();

	// Predict Image (model_name)
	$myclient->AddImage($image);
	$response_1 = $myclient->Predict($model_name);
	$response_2 = $myclient->Predict();				// 未指定則為預設

	// Search
	$meta_data = array($parm, $value);		// array (參數, 值)		
	$response = $myclient->Search($meta_data, 'meta');				// 搜尋符合該 mata 參數值的圖片

	$response = $myclient->Search($concept, 'user_concept', TRUE);	// 搜尋是否含有該 concept 的圖片

	$response = $myclient->Search($image_url, 'url');				// 搜尋符合該 image_url 的圖片

	$response = $myclient->Search($image_url, 'image');			// 搜尋相似於該 image_url 的圖片
}


function Search()
{
	$response = json_decode($response);

	$nums 			= count($response->hits);						// 回傳數量
	$create_time 	= $response->hits[0]->input->created_at;		// 圖片建立時間
	$image_id 		= $response->hits[0]->input->id;				// 圖片 ID
	$image_url 		= $response->hits[0]->input->data->image->url;	// 圖片網址
	$image_concepts = $response->hits[0]->input->data->concepts;	// 圖片 Concept 參數資料
	$image_meta 	= $response->hits[0]->input->data->metadata;	// 圖片 Meta 參數資料

}


function Predict()
{
	$response = json_decode($response);

	$image_url 		= $response->outputs[0]->input->data->image->url;		// 圖片網址
	$image_concepts = $response->outputs[0]->data->concepts;				// 圖片 Concept 參數資料
	$image_concept_name = $response->outputs[0]->data->concepts[0]->name;	
	$image_concept_id = $response->outputs[0]->data->concepts[0]->id;
	$image_concept_value = $response->outputs[0]->data->concepts[0]->value;	// 機率


}

function InputsGet()
{
	$response 		= json_decode($response);

	$nums 			= count($response->inputs);						// 回傳數量
	$create_time 	= $response->input[0]->created_at;					// 圖片建立時間

	$update_time 	= $response->input[0]->modified_at;				// 圖片最後更新時間
	$image_id 		= $response->inputs[0]->id;						// 圖片 ID
	$image_url 		= $response->inputs[0]->data->image->url;		// 圖片網址
	$image_concepts = $response->inputs[0]->data->concepts;			// 圖片 Concept 參數資料
	$image_meta 	= $response->inputs[0]->data->metadata;			// 圖片 Meta 參數資料

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Clarifai Document</title>
</head>
<style>
	body{
		background: black;
		color: white;
		font-size: 16px;
	}

	a ,a:hover{
	color: white;
	text-decoration: none;
	}
</style>
<body>
	<a href="{{ url('/') }}"><h3>　　　　　Clarifai Document</h3></a>
	<pre>
		From: https://github.com/PHPfanatic/clarifai/wiki/Methods

		function method ()
		{
			// 回傳狀態: Ok / fail description
			$response_status = json_decode($response)->status->description;					

			// 新增 Model (mode_name, model_id)                                  
			$response = $myclient->ModelAdd($mode_name, $model_id);						

			// 刪除 Model (model_id, app_version)
			$response = $myclient->ModelDelete($model_id, $version);						

			// 增加 Concept (model_id, array(array('id'=>'value')))
			$concept['id'] ='value';
			$response = $myclient->ModelUpdate($model_id, array($concept));				

			// 刪除 Concept (model_id, array(array('id'=>'value')),'remove')
			$response = $myclient->ModelUpdate($model_id, array($concept), 'remove');		

			// Train Model (model_id)
			$response = $myclient->ModelTrain($model_id);

			// 新增 Image (image, image_id)
			$myclient->AddImage($image, $image_id);
			$response = $myclient->InputsAdd();

			// 更新 Image Concept (image_id, array(array('id'=>'concept', 'value' => T/F )))
			$concept_1['id'] ='條紋';
			$concept_2['id'] ='素色';
			$concept_1['value'] = TRUE;
			$concept_2['value'] = FALSE;
			$myclient->AddConcept($image_id, array($concept_1,$concept_2));
			$response = $myclient->InputsUpdate();

			// 刪除 Image (image_id) / (array())
			$response = $myclient->InputsDelete($image_id);

			// 新增 Image & 附上 Concept (image, image_id, $concept, $meta)
			$concept = array('id'=>'素色', 'value'=>true);	// 若 Concept 不存在則無效
			$meta = array($parm => $value);
			$myclient->AddImage($image, $image_id, $concept, $meta);
			$response = $myclient->InputsAdd();

			// Predict Image (model_name)
			$myclient->AddImage($image);
			$response_1 = $myclient->Predict($model_name);
			$response_2 = $myclient->Predict();	// 未指定則為預設

			// Search
			$meta_data = array($parm, $value); // array (參數, 值)
			$response = $myclient->Search($meta_data, 'meta');// 搜尋符合該 mata 參數值的圖片

			$response = $myclient->Search($concept, 'user_concept', TRUE); // 搜尋是否含有該 concept 的圖片

			$response = $myclient->Search($image_url, 'url'); // 搜尋符合該 image_url 的圖片

			$response = $myclient->Search($image_url, 'image'); // 搜尋相似於該 image_url 的圖片
		}


		function Search()
		{
			$response = json_decode($response);

			$nums 	= count($response->hits);	// 回傳數量
			$create_time = $response->hits[0]->input->created_at;	// 圖片建立時間
			$image_id = $response->hits[0]->input->id;	// 圖片 ID
			$image_url = $response->hits[0]->input->data->image->url;	// 圖片網址
			$image_concepts = $response->hits[0]->input->data->concepts;// 圖片 Concept 參數資料
			$image_meta = $response->hits[0]->input->data->metadata;	// 圖片 Meta 參數資料

		}


		function Predict()
		{
			$response = json_decode($response);

			$image_url = $response->outputs[0]->input->data->image->url; // 圖片網址
			$image_concepts = $response->outputs[0]->data->concepts; // 圖片 Concept 參數資料
			$image_concept_name = $response->outputs[0]->data->concepts[0]->name;	
			$image_concept_id = $response->outputs[0]->data->concepts[0]->id;
			$image_concept_value = $response->outputs[0]->data->concepts[0]->value;	// 機率


		}

		function InputsGet()
		{
			$response = json_decode($response);

			$nums = count($response->inputs); // 回傳數量
			$create_time = $response->input[0]->created_at;	// 圖片建立時間

			$update_time = $response->input[0]->modified_at; // 圖片最後更新時間
			$image_id = $response->inputs[0]->id;// 圖片 ID
			$image_url = $response->inputs[0]->data->image->url; // 圖片網址
			$image_concepts = $response->inputs[0]->data->concepts;	// 圖片 Concept 參數資料
			$image_meta = $response->inputs[0]->data->metadata;	// 圖片 Meta 參數資料

		}




	</pre>
</body>
</html>