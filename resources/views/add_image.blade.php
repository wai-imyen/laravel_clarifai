
@extends('_head')

@section('body')

<div class="container">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<br>
			<a href="{{ url('/') }}"><h2>Clarifai 新增圖片</h2></a>
			<form action="{{ url('article') }}" method="post">
				<input type="hidden" name="_token" value="{{ csrf_token()}}">
				<br>
				
				<div class="form-group">
					<label for="">圖片網址</label>
					<input class="form-control"  type="url" name="image" placeholder="請輸入圖片網址">
				</div>
				<br />
				<div class="form-group">
					<label for="">品牌名稱</label>
					<select name="brand" id="" class="form-control">
						<option value="">無</option>
						<option value="adidas">Adidas</option>
						<option value="nike">Nike</option>
					</select>
					
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