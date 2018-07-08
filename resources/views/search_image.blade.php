@extends('_head')

@section('body')

<div class="container">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<br>
			<a href="/"><h2>Clarifai 搜尋圖片</h2></a>

			<form action="" method="get">
				<br>
				<div class="row">
					<div class="col-md-10">
						<div class="form-group">
							<label for="">圖片網址</label>
							<input class="form-control"  type="url" name="image" placeholder="請輸入圖片網址" value="<?=$image?>">
						</div>
						<br />

						<div class="form-group">
							<label for="">品牌名稱</label>
							<select name="brand" id="" class="form-control">
								<option value="">無</option>
								<option value="adidas" <?=($brand=='adidas')? 'selected':'' ?>>Adidas</option>
								<option value="nike" <?=($brand=='nike')? 'selected':'' ?>>Nike</option>
							</select>
							
						</div>
					</div>
					<div class="col-md-2">
						<img src="<?=($image)? $image:'http://localhost/clarifai/images/custom-Custom_Size___pic.png'?>" class="pull-right" width="100" style="margin-top: 20px; ">
					</div>
				</div>
				<br />
				<button type="submit" class="btn btn-default pull-right">送出</button>
			 
			</form>
		</div>
	</div>

	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<h4>搜尋結果 :</h4>
			<div class="panel panel-default">
				<div class="panel-body">
					<?=$show?>
				</div>
			</div>
		</div>
	</div>
 
</div>

@extends('_footer')

@stop