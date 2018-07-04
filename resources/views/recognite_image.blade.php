
@extends('_head')

@section('body')

<div class="container">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<br>
			<a href="{{ url('/') }}"><h2>Clarifai 圖片辨視</h2></a>
			<form action="" method="get">
				<br>
				
				<div class="form-group">
					<label for="">圖片網址</label>
					<input class="form-control"  type="url" name="image" placeholder="請輸入圖片網址" value="<?=$image?>">
				</div>



				<br />
				<button type="submit" class="btn btn-default pull-right">送出</button>
			 
			</form>
		</div>
	</div>
	<br />
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<h4>辨視結果 :</h4>
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<?=$show?>
						<div class="col-md-2">
							@if ($image)
							<img src="<?=$image?>" alt="" width=100 >
							@endif
						</div>
					</div>
					
					
				</div>
			</div>
		</div>
	</div>
 
</div>

</body>

@extends('_footer')

@stop