<div id="content">
    <div class ='row'><h1><label class = "control-label" >Thêm yêu cầu</label></h1></div>
    <div class="col-md-12">
        <form margin=3% method="post" id="requestForm">

            <div class="row">
                <div class="form-group col-md-12">
                    <label for ='nameOfWork' class="control-label">Tên công việc</label>
                    <input type="text" name="name" id ="nameOfWork" class="form-control" placeholder="Tên công việc">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for ='nameOfWork' class="control-label">Mức độ ưu tiên</label>
                    <select class="form-control" id="priority">
                        <option>Bình thường</option>
                        <option>Khẩn cấp</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for ='nameOfWork' class="control-label">Ngày hết hạn</label>
                    <input type="text" name="name" id ="nameOfWork" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for ='nameOfWork' class="control-label">Bộ phận IT</label>
                    <select class="form-control" id="">
                        <option>IT-HaNoi</option>
                        <option>IT-DaNang</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for ='nameOfWork' class="control-label">Người liên quan</label>
                    <input type="text" name="name" id ="nameOfWork" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-12">
                    <label class="control-label">Nội dung</label>
                    <textarea font-family ='Time New Roman'></textarea>
                    <div class="btn-group">
                        <button type="button" class ="btn btn-default">Bold</button>
                        <button type="button" class ="btn btn-default" >Italic</button>
                        <button type="button" class ="btn btn-default">Bold</button>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default "><span class="glyphicon glyphicon-bold"></span> </button>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default "><span class="glyphicon glyphicon-italic"></span> </button>
                    </div>
                    <textarea class="form-control" height = 20%></textarea>
                </div>

            </div>
        </form>
    </div>
</div>
