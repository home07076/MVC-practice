@if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>

@endif

<form action="{{ route('commodities.store') }}" method="post" enctype="multipart/form-data" >

    @csrf
    商品名稱 : <input type="text" name="name" value="{{ old('name') }}"><br>
    <tr>
        <th>商品分類 :</th><br>
        <th><input type="radio" name="category" id="man" value="男裝">男裝</th>
        <th><input type="radio" name="category" id="woman" value="女裝">女裝</th>
        <th><input type="radio" name="category" id="child" value="童裝">童裝</th>
        <th><input type="radio" name="category" id="other_category" value="" onclick="setCategoryRequired();">其他
            <input id="input_category" type="text" name="other_category" onchange="changeothercategory()"></th>
    </tr>
    <br>
    商品售價 : <input type="nember" name="price" value="{{ old('price') }}"><br>
    商品數量 : <input type="number" name="quantity" value="{{ old('quantity') }}"><br>
    商品描述 : <textarea name="description" value="{{ old('description') }}" cols="25" rows="4"></textarea><br>
    商品圖片 : <input type="file" name="image"><br>



    <table  width="850" >
        <br>

        <tr>
            <th>商品尺寸 :</th>

            <th><input type="radio" name="size" id="XS" value="XS">XS</th>
            <th><input type="radio" name="size" id="S" value="S">S</th>
            <th><input type="radio" name="size" id="M" value="M">M</th>
            <th><input type="radio" name="size" id="other_size" value="" onclick="setSizeRequired();">其他
                <input id="input_size" type="text" name="other_size" onchange="changeradioother()"></th>
        </tr>
        <tr>
        <th>商品顏色 :</th>

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

    <input type="submit" value="新增商品">
    <button><a href="{{ route('commodities.index') }}">取消新增</a></button>

</form>

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
            cellDelete.innerHTML = `<a href="javascript:void(0);">刪除</a>`;

                let a = cellDelete.children[0];
                a.addEventListener('click', () => {
                    let parent = a.parentNode.parentNode;
                    parent.remove();
                    size_ = size_.filter(function (value) {
                        return value !== size;
                    });
                    color_ = color_.filter(function (value) {
                        return value !== color;
                    });
                })
            console.log(size_,color_);
        }
            document.getElementById('insert_size').value = size_ ;
            document.getElementById('insert_color').value = color_ ;
    }

    /*function insert_size_array(){
        let table = document.getElementById('table_size');
        var size = document.querySelector('input[name="size"]:checked').value;

        if (size!=null && !size_.includes(size)){
            color_.push(size);
            let newRow = table.insertRow();
            let cellSize = newRow.insertCell();
            let cellDelete = newRow.insertCell();
            cellSize.innerHTML = size;
            cellDelete.innerHTML = `<a href="javascript:void(0);">刪除</a>`;

            let a = cellDelete.children[0];
            a.addEventListener('click', () => {
                let parent = a.parentNode.parentNode;
                parent.remove();
                size_ = size_.filter(function (value) {
                    return value !== size;
                });
            })
            console.log(size_);
        }
        document.getElementById('insert_size').value = size_ ;
    }*/


    /*function insert_color_array(){
        let table = document.getElementById('table_color');
        var color = document.querySelector('input[name="color"]:checked').value;
        var size = document.querySelector('input[name="size"]:checked').value;

        if (size!=null && !size_.includes(size)){
            size_.push(size);
            let newRow = table.insertRow();
            let cellSize = newRow.insertCell();
            let cellDelete = newRow.insertCell();
            cellSize.innerHTML = size;
            cellDelete.innerHTML = `<a href="javascript:void(0);">刪除</a>`;

            let a = cellDelete.children[0];
            a.addEventListener('click', () => {
                let parent = a.parentNode.parentNode;
                parent.remove();
                size_ = size_.filter(function (value) {
                    return value !== size;
                });
            })
            console.log(size_);
        }



        if (color!=null && !color_.includes(color)){
            color_.push(color);
            let newRow = table.insertRow();
            let cellColor = newRow.insertCell();
            let cellDelete = newRow.insertCell();
            cellColor.innerHTML = color;
            cellDelete.innerHTML = `<a href="javascript:void(0);">刪除</a>`;

            let a = cellDelete.children[0];
            a.addEventListener('click', () => {
                let parent = a.parentNode.parentNode;
                parent.remove();
                color_ = color_.filter(function (value) {
                    return value !== color;
                });
            })
            console.log(color_);
        }
        document.getElementById('insert_color').value = color_ ;
    }
*/



</script>
