
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">檔案上傳</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group" >
                                <label for="file" class="col-md-4 control-label">請選擇檔案</label>

                                <div class="col-md-6">
                                    <input id="file" type="file" class="form-control" name="source" required>

                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        確認上傳
                                    </button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

