<?php
echo '<h1>Xuất thông tin văn bằng ra file Excel</h1>';
?>
<h6>Vui lòng chọn khoảng thời gian ngày cấp bằng của hồ sơ để xuất ra file:</h6>

<form class="form-inline">
    <label for="ngaybatdau" class="mr-sm-2">Thời gian bắt đầu:</label>
    <input type="date" id="ngaybatdau" name="ngaybatdau" class="form-control mb-2 mr-sm-2">
    <label for="ngayketthuc" class="mr-sm-2">Thời gian kết thúc:</label>
    <input type="date" id="ngayketthuc" name="ngayketthuc" class="form-control mb-2 mr-sm-2">
    <input type="submit" class="btn btn-success" value="Xuất file" name="btnXuat"> hoặc 
    <input type="submit" class="btn btn-success" value="Xuất tất cả" name="btnXuatTatCa">
</form>
