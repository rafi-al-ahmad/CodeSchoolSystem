<?php require(APPPATH . 'Views/parents/layouts/preContent.php') ?>

<!-- Content Header (Page header) -->
<div class="content-header my-2 bg-white">

    <div class="row ">
        <div class="col  d-flex align-items-center ">
            تذاكر المدارس
        </div>
        <div class="col-3">
            <button type="button" style="width: inherit; padding: .375rem .75rem;" class="btn btn-light" data-toggle="modal" data-target="#add-temblate">
                إضافة تذكرة جديدة
            </button>
        </div>
    </div>
</div>
<!-- /.content-header -->




<div class="row mt-4  mb-4  d-flex justify-content-center determenators" style="font-size: 1rem;">
    <div class="col-4">
        <div class="form-group">
            <select required class="form-control" id="status">
                <option value="">حالة التذكرة</option>
                <option value="1">مفتوحة</option>
                <option value="2">مغلقة</option>
            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <input type="date" id="date" class="form-control determenators" placeholder="التاريخ">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <input type="text" id="school_name" class="form-control  determenators" placeholder="اسم المدرسة">
        </div>
    </div>
</div>
<!-- /.row -->


<div class="modal fade" id="add-temblate" tabindex="-1" aria-labelledby="add-temblateLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-temblateLabel">إضافة تذكرة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form onsubmit="addTicket(); return false">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="text" class="col-form-label">نص التذكرة</label>
                                <input required  type="text" class="form-control" id="ticket_text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="department" class="col-form-label">القسم</label>
                                <input required  type="text" name="department" class="form-control" id="department">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="type" class="col-form-label">النمط</label>
                                <input required  type="text" name="type" class="form-control" id="type">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="prority" class="col-form-label">الأولوية</label>
                                <input required  type="text" name="prority" class="form-control" id="prority">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="schools" class="col-form-label">المدرسة</label>
                                <select required class="form-control" name="schools" id="schools">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" id="send-ticket-btn" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row" id="tickets-container">
    <!-- <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <p class="card-text" style="font-size: 0.9rem;">الاسم الكامل:</p>
                <p class="card-text" style="font-size: 0.9rem;">البريد الإلكتروني:</p>
                <p class="card-text" style="font-size: 0.9rem;">الهاتف:</p>

                <a href="<?php echo base_url() . '/public/'; ?>school/support/technical/ticket/3" class="btn btn-outline-primary" style="width: -webkit-fill-available;">استعراض التذاكر</a>
            </div>
        </div>
    </div> -->


</div>


<?php include_once(APPPATH . 'Views/school/layouts/postContent.php') ?>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<script>
    var school_id = 24;
    var schools_id = '24,2';
    var parent_id = 23;
    var user_id = 23;

    $(document).ready(function() {
        getTickets();
        getParentSchools();
        $('.determenators').change(function() {
            getTickets();
        });
    });

    function getParentSchools() {
        $.ajax({
                "url": "https://sa.arsail.net/schools/schools/GetSchoolsParent",
                "method": "GET",
                "timeout": 0,
                "headers": {
                    "Authorization": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJUaGVfc2Nob29sIiwiYXVkIjoiVGhlX3Jld3IiLCJpYXQiOiIyMDIxLTAxLTI5IiwiZXhwIjoiMjAyMi0wMS0yOSIsImRhdGEiOnsidXNlcl9pZCI6MTh9fQ.1EfRPKk8zdCvjmn7qkVRKflJDtJjaoN0R_xvphe1No0"
                },
                data: {
                    parent_id: parent_id,
                    schools_id: schools_id
                }
            }).done(function(response) {
                setSchoolOptions(response.data);
            })
            .fail(function(response) {
                console.log(response);
                toastr.error('حدث خطأ ما اثناء تحميل البيانات!', 'خطأ');
            });
    }

    function setSchoolOptions(data) {
        var classSelect = $('#schools');
        $.each(data, function(index, val) {
            classSelect.append($('<option>', {
                value: val.school_id,
                text: val.school_name,
            }));
        });
    }

    function getTickets() {
        $.ajax({
                "url": "https://sa.arsail.net/schools/Tickets/GetParentsSchoolsTickets",
                "method": "GET",
                "timeout": 0,
                "headers": {
                    "Authorization": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJUaGVfc2Nob29sIiwiYXVkIjoiVGhlX3Jld3IiLCJpYXQiOiIyMDIxLTAxLTI5IiwiZXhwIjoiMjAyMi0wMS0yOSIsImRhdGEiOnsidXNlcl9pZCI6MTh9fQ.1EfRPKk8zdCvjmn7qkVRKflJDtJjaoN0R_xvphe1No0"
                },
                data: {
                    parent_id: parent_id,
                    page: 1,
                    limit: 10000,
                    status: $('#status').val(),
                    date: $('#date').val(),
                    school_name: $('#school_name').val(),
                }
            }).done(function(response) {
                displayTickets(response.data);
            })
            .fail(function(response) {
                console.log(response);
                toastr.error('حدث خطأ ما اثناء تحميل البيانات!', 'خطأ');
            });
    }

    function displayTickets(data) {
        $("#tickets-container").html('');

        for (let i = 0; i < data.length; i++) {
            $("#tickets-container").append(`<div class="col-lg-4">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="card-text d-flex pb-3 justify-content-between " style="font-size: 0.9rem;">
                                                          <div>  الاسم الكامل: </div><div> ${data[i].username} </div>
                                                        </div>
                                                        <div class="card-text d-flex pb-3 justify-content-between " style="font-size: 0.9rem;">
                                                          <div>  البريد الإلكتروني: </div><div> ${data[i].email} </div>
                                                        </div>
                                                        <div class="card-text d-flex pb-3 justify-content-between " style="font-size: 0.9rem;">
                                                          <div>  الهاتف: </div><div> ${data[i].phone} </div>
                                                        </div>
                                                        <a href="<?php echo base_url() . '/public/'; ?>parent/support/technical/ticket/${data[i].school_id}" class="btn btn-outline-primary" style="width: -webkit-fill-available;">استعراض التذاكر</a>
                                                    </div>
                                                </div>
                                            </div>`);

        }
    }

    
    function addTicket() {
        $("#send-ticket-btn").attr('disabled', 'true');
        $("#send-ticket-btn").html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    <span class="sr-only">جارٍ الارسال...</span>`);
        $.ajax({
                "url": "https://sa.arsail.net/schools/Tickets/AddParentSchoolTicket",
                "method": "POST",
                "timeout": 0,
                "headers": {
                    "Authorization": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJUaGVfc2Nob29sIiwiYXVkIjoiVGhlX3Jld3IiLCJpYXQiOiIyMDIxLTAyLTIyIiwiZXhwIjoiMjAyMi0wMi0yMiIsImRhdGEiOiIyMyJ9.ZITmmvk9fnZXo8Bfy30vw8uYK2kGZeN_M8XFPErmr_w",
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                "data": {
                    "ticket_text": $("#ticket_text").val(),
                    "school_id": $("#schools").val(),
                    "parent_id": parent_id,
                    "department": $("#department").val(),
                    "type": $("#type").val(),
                    "prority": $("#prority").val()
                }
            }).done(function(response) {
                toastr.success('تم اضافة تذكرة!');
                $("#send-ticket-btn").html('حفظ');
                $("#send-ticket-btn").removeAttr('disabled');
                getTickets();
            })
            .fail(function(response) {
                console.log(response);
                toastr.error('حدث خطأ ما اثناء اضافة تذكرة!', 'خطأ');
                $("#send-ticket-btn").html('حفظ');
                $("#send-ticket-btn").removeAttr('disabled');
            });
    }
    
</script>