<?php require(APPPATH . 'Views/school/layouts/preContent.php') ?>

<!-- Content Header (Page header) -->
<div class="content-header my-2 bg-white">

    <div class="row ">
        <div class="col ">
            اضافة مادة
        </div>
    </div>
</div>
<!-- /.content-header -->



<div class="row mt-4  pb-5" style="font-size: 1rem;">
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body p-2">
                <p class="mb-1">23,508</p>
                <p class="mb-1">رصيد الإشعارات « خدمة الرسائل القصيرة »</p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </div>
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body p-2">
                <p class="mb-1">23,508</p>
                <p class="mb-1">رصيد الإشعارات « خدمة الرسائل القصيرة »</p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </div>
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body p-2">
                <p class="mb-1">23,508</p>
                <p class="mb-1">رصيد الإشعارات « خدمة الرسائل القصيرة »</p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </div>
    <!-- /.col -->
</div>
<!-- /.row -->


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-2">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="col-form-label">اسم المادة</label>
                                <input type="text" name="name" class="form-control" id="name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="level" class="col-form-label">المستوى</label>
                                <select required class="form-control" name="level" id="level">
                                    <option value="">--</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once(APPPATH . 'Views/school/layouts/postContent.php') ?>