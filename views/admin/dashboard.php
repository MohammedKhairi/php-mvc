<!-- Search bar -->
<div class="d-flex justify-content-center align-content-center my-2">
    <div class="col-md-8">
        <form action="" method="get">
            <div class="d-flex align-items-center">
                <input type="search" class="form-control" placeholder="البحث السريع">
                <button class="btn btn-sm bg-c-gray text-white mx-1 btn-search"><i class="icon-search"></i></button>
            </div>
        </form>
    </div>
</div>
<br>
<!--End Search bar -->
<ul class="responsive-table2 fmedium my-2">
    <li class="table-header">
        <div class="col col-3">المادة</div>
        <div class="col col-2">اليوم</div>
        <div class="col col-2">القاعة</div>
        <div class="col col-2">الوقت</div>
        <div class="col col-2">الشعبة</div>
        <div class="col col-1">العمليات</div>
    </li>
    <li class="table-row border-2 border-bottom">
        <div class="col col-3" data-label="المادة">الانكليزيالانكليزيالانكليزيالانكليزيالانكليزي الانكليزي الانكليزي
            الانكليزي الانكليزي الانكليزي الانكليزي</div>
        <div class="col col-2" data-label="اليوم">الاثنين</div>
        <div class="col col-2" data-label="القاعة">LB-015</div>
        <div class="col col-2" data-label="الوقت">08:30 am الى 09:15 am</div>
        <div class="col col-2" data-label="الشعبة">A</div>
        <div class="col col-1" data-label="العمليات">
            <div class="menu-tools">
                <div class="tools-content">
                    <a href="" class="mx-1 btn btn-sm btn-primary">تعديل</a>
                    <a href="" class="mx-1 btn btn-sm btn-success">اظهار</a>
                    <a href="" class="mx-1 btn btn-sm btn-warning">اخفاء</a>
                    <buttonn onclick="DeleteBtnAlert('/cp/add')" class="mx-1 btn btn-sm btn-danger">حذف</buttonn>
                </div>
            </div>
        </div>
    </li>
</ul>
<ul class="pagination">
    <li class="page-item"> <a class="page-link" href="?page=1">الاول</a></li>
    <li class="page-item"><a class="page-link" href="?page=1">1</a></li>
    <li class="page-item"><a class="page-link" href="?page=2">2</a></li>
    <li class="page-item active"><a class="page-link " href="?page=3">3</a></li>
    <li class="page-item"><a class="page-link" href="?page=4">4</a></li>
    <li class="page-item"><a class="page-link" href="?page=5">5</a></li>
    <li class="page-item"> <a class="page-link" href="?page=6">الاخير</a></li>
</ul>
<br>
<!-- Form Template -->
<div class="container">
    <div class="card p-2">
        <div class="mb-3">
            <label for="" class="form-label">نص</label>
            <input type="email" class="form-control">
        </div>
        <div class="mb-3">
            <label for="" class="form-label">ملف</label>
            <input type="file" class="form-control">
        </div>
        <div class="mb-3">
            <label for="" class="form-label">لست</label>
            <select name="" class="form-control" id="">
                <option value="">1</option>
                <option value="">2</option>
                <option value="">3</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">محتوى نصي</label>
            <textarea class="form-control" id="content" rows="3"></textarea>
        </div>
    </div>

</div>
<br>