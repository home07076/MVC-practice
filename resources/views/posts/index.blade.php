<form method="post" enctype="multipart/form-data">
<table border="1" width="850" align="center">

    @if(session()->has('notice'))
        {{ session()->get('notice') }}
    @endif

    <caption><h1>商品列表</h1><h2>您好，{{$name}}</h2></caption>
    <caption><h2><a href="{{ url('/logout') }}" >登出</a></h2></caption>
    <caption><h2><a href="{{ route('commodities.create') }}">新增商品</a></h2></caption>
    <tr bgcolor="#dddddd">
        <th>商品</th><th>商品名稱</th><th>產品分類</th><th>單價</th><th>數量</th><th>描述</th><th>尺寸</th><th>顏色</th><th>修改商品</th>
    </tr>
    @foreach($commodities as $commodity)
        @if( $commodity->seller == $id)
            <th><img src="{{ asset('storage/' . $commodity->image) }}" width="200" height="150"></th>
            <th>{{ $commodity->name }}</th>
            <th>{{ $commodity->category }}</th>
            <th>{{ $commodity->price }}</th>
            <th>{{ $commodity->quantity }}</th>
            <th>{{ $commodity->description }}</th>
            <th>{{ $commodity->Commodity_sku->size }}</th>
            <th>{{ $commodity->Commodity_sku->color }}</th>

            <th><a href="{{ route('commodities.edit' , [$commodity->id ] ) }}" >修改</a></th>
        </tr>

        @endif
    @endforeach


</table>
