
@extends('_head')

@section('body')

<body>
<div class="container index">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<br>
			<a href="index.php"><h2>Clarifai</h2></a>
			<br>
			<ul style="list-style-type:square">

			  <li class=""><a href="{{ url('add_image') }}">新增圖片</a></li>
			  <li class=""><a href="{{ url('image_list') }}">編輯更新圖片</a></li>
			  <li class=""><a href="{{ url('train') }}">訓練模組</a></li>
			  <li class=""><a href="{{ url('recognite') }}">圖片辨視</a></li>
			  <li class=""><a href="{{ url('search') }}">搜尋圖片</a></li>
			   <li class=""><a href="{{ url('use') }}">Document</a></li>
			</ul>
		</div>
	</div>
</div>

</body>

@extends('_footer')

@stop