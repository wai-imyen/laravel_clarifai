
@extends('_head')

@section('body')

<style>
	td {
		vertical-align: middle;
	}
</style>
<div class="container">
  <br />
  <a href="{{ url('/') }}"><h2>Clarifai 圖片列表</h2></a>
   <br />      
  <table class="table table-striped">
    <thead>
      <tr>
        <th>編號</th>
        <th>圖片</th>
        <th>建立時間</th>
        <th>最後更新時間</th>
        <th>編輯更新</th>
      </tr>
    </thead>
    <tbody>
    	<?=$show_list?>
    </tbody>
  </table>
</div>

</body>

@extends('_footer')

@stop