@if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>

@endif
<div>

    <form action="{{ route('commodities.update', ['commodity' => $commodities]) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        商品名稱 : <input type="text" name="name" size="10"  value="{{$commodities->name}}"><br>
        商品分類 : <input value="{{$commodities->category}}" id="category_id" size="10"><br>
        修改分類 :
        <div>
            <input type="radio" name="category" id="man" value="男裝">男裝
            <input type="radio" name="category" id="woman" value="女裝">女裝
            <input type="radio" name="category" id="child" value="童裝">童裝
            <input type="radio" name="category" id="other_category" value="" onclick="setCategoryRequired();" >其他
            <input id="input_category" type="text" name="other_category" onchange="changeothercategory()">
        </div>
        <br>

        商品售價 : <input type="text" name="price" value="{{$commodities->price}}"><br>
        商品數量 : <input type="number" name="quantity" value="{{$commodities->quantity}}"><br>
        商品描述 : <textarea name="description" placeholder="{{ $commodities->description }}" cols="25" rows="4"></textarea><br>
        圖片預覽 : <img src={{ asset('storage/' . $commodities->image) }}><br>
        <input type="file" name="image"><br>



        <table width="850">
            商品尺寸 : <input value="{{$commodities->Commodity_sku->size}}" id="size_id" size="20"><br>
            <tr>
                <th>修改尺寸 :</th>

                <th><input type="radio" name="size" id="XS" value="XS">XS</th>
                <th><input type="radio" name="size" id="S" value="S">S</th>
                <th><input type="radio" name="size" id="M" value="M">M</th>
                <th><input type="radio" name="size" id="other_size" value="" onclick="setSizeRequired();">其他
                    <input id="input_size" type="text" name="other_size" onchange="changeradioother()"></th>
            </tr>

            商品顏色 : <input value="{{$commodities->Commodity_sku->color}}" id="size_id" size="20"><br>
            <tr>
                <th>修改顏色 :</th>

                <th><input type="radio" name="color" id="green" value="綠色">綠色</th>
                <th><input type="radio" name="color" id="blue" value="藍色">藍色</th>
                <th><input type="radio" name="color" id="red" value="紅色">紅色</th>
                <th><input type="radio" name="color" id="other_color" value="" onclick="setColorRequired();">其他
                    <input id="input_color" type="text" name="other_color" onchange="changeradiocolor()"></th>
            </tr>
        </table>

        <table id="table" border="1" width="450">
            <td>尺寸</td><td>顏色</td><td>修改</td>
            <tbody>
            <input type="hidden" id="insert_size" name="size_" value="">
            <input type="hidden" id="insert_color" name="color_" value="">
            </tbody>
        </table>
        <input type="button" onclick="insert();" value="新增"><br>
        </table>



        <button><a href="{{ route('commodities.index') }}">返回</a></button>
        <input type="submit" value="修改商品">
    </form>

    <form action="{{ route('commodities.destroy', [ 'commodity' => $commodities]) }}" method="POST">
        @method('DELETE')
        @csrf
        <input type="submit" value="刪除商品">
    </form>
</div>

<script>

    function setSizeRequired(){

        document.getElementById("input_size").required=true;
    }

    function setCategoryRequired(){

        document.getElementById("input_category").required=true;
    }

    function setColorRequired(){

        document.getElementById("input_color").required=true;
    }

    function changeradioother(){
        var other= document.getElementById("other_size");
        other.value=document.getElementById("input_size").value;
    }

    function changeothercategory(){
        var other= document.getElementById("other_category");
        other.value=document.getElementById("input_category").value;
    }

    function changeradiocolor(){
        var other= document.getElementById("other_color");
        other.value=document.getElementById("input_color").value;
    }

    /*var size = '{{$commodities->Commodity_sku->size}}';
    var color = '{{ $commodities->Commodity_sku->color }}';

    var size_ = size.split(',');
    var color_ = color.split(',');

    for(i=0;i<size_.length;i++) {
        let table = document.getElementById('table');
        let newRow = table.insertRow();
        var cellSize = newRow.insertCell();
        var cellDelete = newRow.insertCell();
        cellSize.innerHTML = size_[i];
        cellDelete.innerHTML = `<a href='javascript:void(0)' onclick="test()" >刪除</a>`;
        function test() {
            let a = cellDelete.children[0];
            a.addEventListener('click', function () {
                let parent = a.parentNode.parentNode;
                parent.remove();

                size_ = size_.splice(i,1);
                color_ = color_.splice(i,1);

                /*size_ = size_.filter(function (value){
                    return value !== size_[i];
                });
                color_ = color_.filter(function (value) {
                    return  value !== color_[i];
                });
            })
            document.getElementById('insert_size').value = size_ ;
            document.getElementById('insert_color').value = color_ ;
            console.log(size_)
        }
    }*/

    var size_ = [];
    var color_ = [];

    function insert(){
        let table = document.getElementById('table');

        var size = document.querySelector('input[name="size"]:checked').value;
        var color = document.querySelector('input[name="color"]:checked').value;



        if (size!=null && color!=null){
            size_.push(size);
            color_.push(color);
            let newRow = table.insertRow();
            let cellSize = newRow.insertCell();
            let cellColor = newRow.insertCell();
            let cellDelete = newRow.insertCell();
            cellSize.innerHTML = size;
            cellColor.innerHTML = color;
            cellDelete.innerHTML = `<a href='javascript:void(0);'>刪除</a>`;

            let a=cellDelete.children[0];

            a.addEventListener('click' , ()=>{
                let parent = a.parentNode.parentNode;
                parent.remove();
                size_ = size_.filter(function(value) {
                    return value !== size;
                });
                color_ = color_.filter(function(value) {
                    return value !== color;
                });
            })
            console.log(size_,color_);
        }
            document.getElementById('insert_size').value = size_ ;
            document.getElementById('insert_color').value = color_ ;
    }
</script>
