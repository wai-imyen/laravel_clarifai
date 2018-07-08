@extends('_head')

@section('body')

<div class="container">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<br>
			<a href="index.php"><h2>Clarifai 訓練模組</h2></a>
			<form action="" method="get">

				<div class="form-group" style="margin-top: 50px;margin-left: 25px;">
					<label for="">模組編號</label>
					<input class="form-control"  type="text" name="model_id" placeholder="請輸入模組編號" value="">
				</div>
				
				<br />

				<button type="submit" class="btn btn-default pull-right">送出</button>
			 
			</form>
		</div>
	</div>
 
</div>

@extends('_footer')

@stop