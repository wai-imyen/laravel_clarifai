
@extends('_head')

@section('body')

<style>
	.form-control[readonly], .form-control {

		background-color: white;
	}
</style>

<div class="container">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<br>
			<a href="{{ url('image_list') }}"><h2>Clarifai 更新圖片</h2></a>
			<form action="{{ url('article/'.$image_id) }}" method="post">
				<input type="hidden" name="_token" value="{{ csrf_token()}}">
				<input type="hidden" name="_method" value="PUT">
				<br>
				
				<div class="row">
					
					<div class="col-md-2">
						<img src="<?=$image_url?>" alt="" width=100 >
					</div>
					<div class="col-md-3">
						<?=$show?>
					</div>
					<div class="col-md-7">
						<div class="form-group" >
							<label for="">圖片編號</label>
							<input class="form-control"  type="text" name="image_id" value="<?=$image_id?>" readonly>
						</div>
						<div class="form-group" >
							<label for="">更新時間</label>
							<input class="form-control"  type="text" name="" value="<?=$update_time?>" readonly>
						</div>
					</div>
					
				</div>
				
				<br />
				
				
				<div class="row">
					<div class="col-md-6">
						<h3>服飾類型</h3>
						<hr />
						<div class="form-group">
							<label for="inputdefault">上衣 :　</label>
							<div class="radio-inline">
								<label><input type="radio" name="上衣" value="1">True</label>
							</div>
							<div class="radio-inline">
								<label><input type="radio" name="上衣" value="0">False</label>
							</div>
							<div class="radio-inline">
								<label><input type="radio" name="上衣" value="" checked>Null</label>
							</div>
						</div>

						<div class="form-group">

							<label for="inputdefault">褲子 :　</label>
							<div class="radio-inline">
								<label><input type="radio" name="褲子" value="1">True</label>
							</div>
							<div class="radio-inline">
								<label><input type="radio" name="褲子" value="0">False</label>
							</div>
							<div class="radio-inline">
								<label><input type="radio" name="褲子" value="" checked>Null</label>
							</div>
						</div>

						<div class="form-group">

							<label for="inputdefault">裙子 :　</label>
							<div class="radio-inline">
								<label><input type="radio" name="裙子" value="1">True</label>
							</div>
							<div class="radio-inline">
								<label><input type="radio" name="裙子" value="0">False</label>
							</div>
							<div class="radio-inline">
								<label><input type="radio" name="裙子" value="" checked>Null</label>
							</div>
						</div>
						<br />
					</div>
					<div class="col-md-6">
						<h3>服飾樣式</h3>
						<hr />
						<div class="form-group">
							<label for="inputdefault">條紋 :　</label>
							<div class="radio-inline">
								<label><input type="radio" name="條紋" value="1">True</label>
							</div>
							<div class="radio-inline">
								<label><input type="radio" name="條紋" value="0">False</label>
							</div>
							<div class="radio-inline">
								<label><input type="radio" name="條紋" value="" checked>Null</label>
							</div>
						</div>

						<div class="form-group">

							<label for="inputdefault">素色 :　</label>
							<div class="radio-inline">
								<label><input type="radio" name="素色" value="1">True</label>
							</div>
							<div class="radio-inline">
								<label><input type="radio" name="素色" value="0">False</label>
							</div>
							<div class="radio-inline">
								<label><input type="radio" name="素色" value="" checked>Null</label>
							</div>
						</div>
						
						<div class="form-group">

							<label for="inputdefault">格子 :　</label>
							<div class="radio-inline">
								<label><input type="radio" name="格子" value="1">True</label>
							</div>
							<div class="radio-inline">
								<label><input type="radio" name="格子" value="0">False</label>
							</div>
							<div class="radio-inline">
								<label><input type="radio" name="格子" value="" checked>Null</label>
							</div>
						</div>


						<br />
					</div>
				</div>
				

				<br />
				<button type="submit" class="btn btn-default pull-right">送出</button>
			 
			</form>
		</div>
	</div>
 
</div>

</body>

@extends('_footer')

@stop