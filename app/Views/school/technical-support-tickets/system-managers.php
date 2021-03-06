<?php require(APPPATH . 'Views/school/layouts/preContent.php') ?>

<!-- Content Header (Page header) -->
<div class="content-header my-2 bg-white">

    <div class="row ">
        <div class="col  d-flex align-items-center ">
            مراسلة مدير النظام
        </div>
        <div class="col-3">
            <button type="button" style="width: inherit; padding: .375rem .75rem;" class="btn btn-light" data-toggle="modal" data-target="#add-ticket">
                إضافة تذكرة جديدة
            </button>
        </div>
    </div>
</div>
<!-- /.content-header -->



<?php require(APPPATH . 'Views/school/layouts/notifications-service-status.php') ?>


<div class="row mt-4  mb-4  d-flex justify-content-center " style="font-size: 1rem;">
    <div class="col-4">
        <div class="form-group">
            <select required class="form-control" id="status">
                <option value="">حالة التذكرة</option>
                <option value="1">مفتوحة</option>
                <option value="2">مغلقة</option>

            </select>
        </div>

    </div>
</div>
<!-- /.row -->

<div class="modal fade" id="add-ticket" tabindex="-1" aria-labelledby="add-ticketLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-ticketLabel">إضافة تذكرة</h5>
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

                     <textarea name="" id="ticket_text" cols="30" rows="3" class=" form-control"></textarea>
                        

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="department" class="col-form-label">القسم</label>
                            
                                
                        <select id="department" name="department"  class="custom-select" id="inputGroupSelect02" style="cursor: pointer;">
                        <option value="" selected> أختر...</option>
                        <option value="اقتراحات">اقتراحات</option>
                        <option value="استفسارات">استفسارات</option>
                        <option value="شكوى">شكوى</option>
                        <option value="اخرى">اخرى</option>

                        </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="type" class="col-form-label">النمط</label>
                   
                                           
                        <select id="type" name="type"  class="custom-select" id="inputGroupSelect02" style="cursor: pointer;">
                    
                        <option value="-"selected>--</option>
                       

                        </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="prority" class="col-form-label">الأولوية</label>
                             
                                                                
                        <select  required id="prority" name="prority"  class="custom-select" id="inputGroupSelect02" style="cursor: pointer; ">
                        <option value="" selected> أختر...</option>
                        <option value="منخفض">منخفض </option>
                        <option value="متوسط">متوسط </option>
                        <option value="هام جدا">هام جدا </option>
            

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

<button id="reply-to-ticket-btn" type="button" style="display: none;" class="btn btn-light" data-toggle="modal" data-target="#reply-to-ticket"></button>

<!-- Modal -->
<div class="modal fade" id="reply-to-ticket" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="reply-to-ticketLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reply-to-ticketLabel">عرض تذكرة</h5>
                <div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <button type="button" style="padding: 2px;" class="btn btn-link" onclick="refreshTicketReplies()">
                        <span aria-hidden="true" style="font-size: .9rem; font-weight: bolder;"><i class="text-navy fas fa-redo"></i></span>
                    </button>
                </div>
                <input type="hidden" name="" id="modal-id">
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <h4 id="modal-ticket-text">
                        </h4>
                        <small id="modal-date"></small>
                    </div>
                </div>
                <!-- <hr class="pt-3"> -->
                <div class="row">
                    <div class="col-sm-3" id="">
                        <div class="card">
                            <div class="card-body">
                                <h6>القسم</h6>
                                <small id="modal-department"></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3" id="">
                        <div class="card">
                            <div class="card-body">
                                <h6>النوع</h6>
                                <small id="modal-type"></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3" id="">
                        <div class="card">
                            <div class="card-body">
                                <h6>الحالة</h6>
                                <small id="modal-status"></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3" id="">
                        <div class="card">
                            <div class="card-body">
                                <h6>الأولوية</h6>
                                <small id="modal-prority"></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="spinner-control" class="d-flex justify-content-center">
                    <div class="spinner-border m-5" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div id="modal-replies">
                </div>
                <div id="">
                    <div class="form-group">
                        <!-- <label for="exampleFormControlTextarea1">Example textarea</label> -->
                        <textarea class="form-control" placeholder="اكتب ردك هنا..." id="user-reply" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" onclick="sendTicketReply()">ارسال</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">اغلاق</button>
                <!-- <button type="button" class="btn btn-primary">Understood</button> -->
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-2" style="overflow-x: scroll;">
                <table id="content-table" class="table table-striped " style="width:100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>رقم التذكرة</th>
                            <th>النص</th>
                            <th>آخر تحديث</th>
                            <th>آخر من رد</th>
                            <th>القسم</th>
                            <th>النوع</th>
                            <th>الحالة</th>
                            <th>الأولوية</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once(APPPATH . 'Views/school/layouts/postContent.php') ?>
<style>
    .clickable-row {
        cursor: pointer;
    }

    .clickable-row:hover {
        background-color: #00000030 !important;
    }

    .clickable {
        cursor: pointer;
    }

    .clickable:hover {
        background-color: #00000030 !important;
    }
</style>





<script src="<?php echo base_url() . '/public/'; ?>Excel/jquery.table2excel.js"></script>

<script src="<?php echo base_url() . '/public/'; ?>design/js/datatable.all.js"></script>


<link rel="stylesheet" type="text/css" href="<?php echo base_url() . '/public/'; ?>design/css/datatable.all.css" />

<script>
    
    var dataTable = null;
    var studentsData = [];

    $(document).ready(function() {

        dataTable = $('#content-table').DataTable({
            dom: `<"row d-flex justify-content-between mx-1 "fl>rtip`,
            "lengthMenu": [
                [25, 50, 100, 500, -1],
                [25, 50, 100, 500, 'الكل']
            ],
            order: [
                [1, 'asc']
            ],

            responsive: true,
            autoWidth: false,
            rowId: 'id',
            createdRow: function(row, data, index) {
                // $(row).addClass('clickable-row');
            },
            columns: [{
                    "className": 'details-control align-middle ',
                    "orderable": false,
                    searchable: false,
                    exportable: false,
                    "data": null,
                    "defaultContent": ''
                },
                {
                    data: 'id',
                    name: 'id',
                    title: 'رقم التذكرة',
                    className: 'text-center t-id align-middle',
                },
                {
                    data: 'ticket_text',
                    name: 'ticket_text',
                    className: 'text-center t-ticket_text align-middle',
                    title: '<div class="px-5 mx-5">النص</div>',
                    render: function(data, type, row, meta) {
                        return `<button class="btn btn-link" onclick="showReplyModal('${row.id}',\`${row.ticket_text}\`,'${row.date}','${row.username}','${row.department}','${row.type}','${row.status}','${row.prority}')">${data}</button>`;
                    }
                },
                {
                    data: 'date',
                    name: 'date',
                    className: 'text-center t-date align-middle',
                    title: 'اخر تحديث'
                },
                {
                    data: 'username',
                    name: 'username',
                    className: 'text-center t-username align-middle',
                    title: 'اخر من رد'
                },
                {
                    data: 'department',
                    name: 'department',
                    className: 'text-center t-department align-middle',
                    title: 'القسم'
                },
                {
                    data: 'type',
                    name: 'type',
                    className: 'text-center t-type align-middle',
                    title: 'النوع'
                },
                {
                    data: 'status',
                    name: 'status',
                    className: 'text-center t-status align-middle',
                    title: 'الحالة'
                },
                {
                    data: 'prority',
                    name: 'prority',
                    className: 'text-center t-prority align-middle',
                    title: 'الاولوية'
                },
            ],

            "language": {
                "emptyTable": "ليست هناك بيانات متاحة في الجدول",
                "loadingRecords": "جارٍ التحميل...",
                "processing": "جارٍ التحميل...",
                "lengthMenu": "أظهر _MENU_ مدخلات",
                "zeroRecords": "لم يعثر على أية سجلات",
                "info": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                "infoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
                "infoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                "search": "ابحث:",
                "paginate": {
                    "first": "الأول",
                    "previous": "السابق",
                    "next": "التالي",
                    "last": "الأخير"
                },
                "aria": {
                    "sortAscending": ": تفعيل لترتيب العمود تصاعدياً",
                    "sortDescending": ": تفعيل لترتيب العمود تنازلياً"
                },
                "select": {
                    "rows": {
                        "_": "%d قيمة محددة",
                        "0": "",
                        "1": "1 قيمة محددة"
                    },
                    "1": "%d سطر محدد",
                    "_": "%d أسطر محددة",
                    "cells": {
                        "1": "1 خلية محددة",
                        "_": "%d خلايا محددة"
                    },
                    "columns": {
                        "1": "1 عمود محدد",
                        "_": "%d أعمدة محددة"
                    }
                },
                "buttons": {
                    "print": "طباعة",
                    "copyKeys": "زر <i>ctrl<\/i> أو <i>⌘<\/i> + <i>C<\/i> من الجدول<br>ليتم نسخها إلى الحافظة<br><br>للإلغاء اضغط على الرسالة أو اضغط على زر الخروج.",
                    "copySuccess": {
                        "_": "%d قيمة نسخت",
                        "1": "1 قيمة نسخت"
                    },
                    "pageLength": {
                        "-1": "اظهار الكل",
                        "_": "إظهار %d أسطر"
                    },
                    "collection": "مجموعة",
                    "copy": "نسخ",
                    "copyTitle": "نسخ إلى الحافظة",
                    "csv": "CSV",
                    "excel": "Excel",
                    "pdf": "PDF",
                    "colvis": "إظهار الأعمدة",
                    "colvisRestore": "إستعادة العرض"
                },
                "autoFill": {
                    "cancel": "إلغاء",
                    "info": "مثال عن الملئ التلقائي",
                    "fill": "املأ جميع الحقول بـ <i>%d&lt;\\\/i&gt;<\/i>",
                    "fillHorizontal": "تعبئة الحقول أفقيًا",
                    "fillVertical": "تعبئة الحقول عموديا"
                },
                "searchBuilder": {
                    "add": "اضافة شرط",
                    "clearAll": "ازالة الكل",
                    "condition": "الشرط",
                    "data": "المعلومة",
                    "logicAnd": "و",
                    "logicOr": "أو",
                    "title": [
                        "منشئ البحث"
                    ],
                    "value": "القيمة",
                    "conditions": {
                        "date": {
                            "after": "بعد",
                            "before": "قبل",
                            "between": "بين",
                            "empty": "فارغ",
                            "equals": "تساوي",
                            "not": "ليس",
                            "notBetween": "ليست بين",
                            "notEmpty": "ليست فارغة"
                        },
                        "number": {
                            "between": "بين",
                            "empty": "فارغة",
                            "equals": "تساوي",
                            "gt": "أكبر من",
                            "gte": "أكبر وتساوي",
                            "lt": "أقل من",
                            "lte": "أقل وتساوي",
                            "not": "ليست",
                            "notBetween": "ليست بين",
                            "notEmpty": "ليست فارغة"
                        },
                        "string": {
                            "contains": "يحتوي",
                            "empty": "فاغ",
                            "endsWith": "ينتهي ب",
                            "equals": "يساوي",
                            "not": "ليست",
                            "notEmpty": "ليست فارغة",
                            "startsWith": " تبدأ بـ "
                        }
                    },
                    "button": {
                        "0": "فلاتر البحث",
                        "_": "فلاتر البحث (%d)"
                    },
                    "deleteTitle": "حذف فلاتر"
                },
                "searchPanes": {
                    "clearMessage": "ازالة الكل",
                    "collapse": {
                        "0": "بحث",
                        "_": "بحث (%d)"
                    },
                    "count": "عدد",
                    "countFiltered": "عدد المفلتر",
                    "loadMessage": "جارِ التحميل ...",
                    "title": "الفلاتر النشطة"
                },
                "searchPlaceholder": "ابحث ...",
                "infoThousands": ",",
                "datetime": {
                    "previous": "السابق",
                    "next": "التالي",
                    "hours": "الساعة",
                    "minutes": "الدقيقة",
                    "seconds": "الثانية",
                    "unknown": "-",
                    "amPm": [
                        "صباحا",
                        "مساءا"
                    ],
                    "weekdays": [
                        "الأحد",
                        "الإثنين",
                        "الثلاثاء",
                        "الأربعاء",
                        "الخميس",
                        "الجمعة",
                        "السبت"
                    ],
                    "months": [
                        "يناير",
                        "فبراير",
                        "مارس",
                        "أبريل",
                        "مايو",
                        "يونيو",
                        "يوليو",
                        "أغسطس",
                        "سبتمبر",
                        "أكتوبر",
                        "نوفمبر",
                        "ديسمبر"
                    ]
                },
                "editor": {
                    "close": "إغلاق",
                    "create": {
                        "button": "إضافة",
                        "title": "إضافة جديدة",
                        "submit": "إرسال"
                    },
                    "edit": {
                        "button": "تعديل",
                        "title": "تعديل السجل",
                        "submit": "تحديث"
                    },
                    "remove": {
                        "button": "حذف",
                        "title": "حذف",
                        "submit": "حذف",
                        "confirm": {
                            "_": "هل أنت متأكد من رغبتك في حذف السجلات %d المحددة؟",
                            "1": "هل أنت متأكد من رغبتك في حذف السجل؟"
                        }
                    },
                    "error": {
                        "system": "حدث خطأ ما"
                    },
                    "multi": {
                        "title": "قيم متعدية",
                        "restore": "تراجع"
                    }
                }
            }
        });
    });

    function readReply(id, reply) {
        $('#modal-text').html(reply);
        $('#showReplyModalButton').click();
        // sendReadMark(id);
    }

    function setListeners() {


    }
    $(document).ready(function() {

        $('#status').change(function() {
            getTicketsData();
        });

        getTicketsData();

    });


    function getTicketsData() {
        var jqxhr = $.ajax({
                url: "<?= site_url('') ?>Tickets/GetSchoolsAdminTicketsBySchoolId",
                method: "GET",
                timeout: 0,
                data: {
                    school_id: school_id,
                    page: "1",
                    limit: "7000",
                    status: $('#status').val(),
                },
                headers: {
                    "Authorization": token
                },
            })
            .done(function(response) {
                dataTable.clear().rows.add(response.data).draw()
            })
            .fail(function(response) {
                console.log(response);
                toastr.error(response.responseJSON.msg, 'خطأ');
            });
    }

    function selects() {
        var ele = document.getElementsByName('selected_data[]');
        for (var i = 0; i < ele.length; i++) {
            if (ele[i].type == 'checkbox')
                ele[i].checked = true;
            $(ele[i]).closest('.datatable-row').addClass('toprint');
            $(ele[i]).closest('.datatable-row').removeClass('notToExcel');
        }
    }

    function deSelect() {
        var ele = document.getElementsByName('selected_data[]');
        for (var i = 0; i < ele.length; i++) {
            if (ele[i].type == 'checkbox')
                ele[i].checked = false;
            $(ele[i]).closest('.datatable-row').removeClass('toprint');
            $(ele[i]).closest('.datatable-row').addClass('notToExcel');
        }
    }

    function sendReadMark(id, reply) {
        var jqxhr = $.ajax({
                url: "",
                method: "GET",
                timeout: 0,
                data: {
                    school_id: school_id,
                    page: "1",
                    limit: "7000",
                },
                headers: {
                    "Authorization": token
                },
            })
            .done(function(response) {
                $('reply-icon-' + id).parent().html(reply);
            })
            .fail(function(response) {
                console.log(response);
            });

    }

    function showReplyModal(id, ticket_text, date, username, department, type, status, prority) {
        console.log(id, ticket_text, date, username, department, type, status, prority);
        $('#modal-ticket-text').html(ticket_text);
        $('#modal-department').html(department);
        $('#modal-type').html(type);
        $('#modal-status').html(status);
        $('#modal-prority').html(prority);
        $('#modal-date').html(date);
        $('#modal-id').val(id);

        $('#reply-to-ticket-btn').click();

        getTicketReplies(id);
    }

    function getTicketReplies(id) {
        $("#modal-replies").html('');
        $("#spinner-control").attr('style', 'display: .');

        var jqxhr = $.ajax({
                url: "<?= site_url('') ?>Tickets/GetTicketsReply",
                method: "GET",
                timeout: 0,
                data: {
                    ticket_id: id,
                },
                headers: {
                    "Authorization": token
                },
            })
            .done(function(response) {
                $("#spinner-control").attr('style', 'display: none !important');
                setReplies(response.data);
            })
            .fail(function(response) {
                $("#spinner-control").attr('style', 'display: none !important');
                console.log(response);
                toastr.error('حدث خطأ ما اثناء تحميل بيانات الردود!', 'خطأ');
            });

    }

    function setReplies(replies) {

        if (replies.reply) {
            for (let i = 0; i < replies.reply.length; i++) {
                $("#modal-replies").append(`<div class="card">
                    <div class="card-header" style="background-color: rgb(0 0 0 / 0%);">
                        <h6 class="">مستخدم
                            <<<small>${replies.reply[i].username}</small>>>
                        </h6>
                    </div>
                    <div class="card-body">
                        <h6>${replies.reply[i].reply}</h6>

                        <div class="float-right">
                            <small>${moment(replies.reply[i].date).format("YYYY-MM-DD")}</small>
                        </div>
                    </div>
                </div>`);
            }
        }
    }

    function sendTicketReply() {
        var reply = $("#user-reply").val();

        $.ajax({
                "url": "<?= site_url('') ?>Tickets/ReplyTicket",
                "method": "POST",
                "timeout": 0,
                "headers": {
                    "Authorization": token,
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                "data": {
                    "ticket_id": $("#modal-id").val(),
                    "user_id": school_id,
                    "reply": reply
                }
            }).done(function(response) {
                refreshTicketReplies();
                toastr.success('تم اضافة رد!')
            })
            .fail(function(response) {
                console.log(response);
                toastr.error('حدث خطأ ما اثناء ارسال الرد!', 'خطأ');
            });
    }

    function refreshTicketReplies() {
        var id = $("#modal-id").val();
        getTicketReplies(id)
    }

    function addTicket() {
        $("#send-ticket-btn").attr('disabled', 'true');
        $("#send-ticket-btn").html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    <span class="sr-only">جارٍ الارسال...</span>`);
        $.ajax({
                "url": "<?= site_url('') ?>Tickets/AddSchoolAdminTicket",
                "method": "POST",
                "timeout": 0,
                "headers": {
                    "Authorization": token,
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                "data": {
                    "ticket_text": $("#ticket_text").val(),
                    "school_id": school_id,
                    "department": $("#department").val(),
                    "type": $("#type").val(),
                    "prority": $("#prority").val()
                }
            }).done(function(response) {
                toastr.success('تم اضافة تذكرة!');
                $("#send-ticket-btn").html('حفظ');
                $("#send-ticket-btn").removeAttr('disabled');
            })
            .fail(function(response) {
                console.log(response);
                toastr.error('حدث خطأ ما اثناء اضافة تذكرة!', 'خطأ');
                $("#send-ticket-btn").html('حفظ');
                $("#send-ticket-btn").removeAttr('disabled');
            });
    }
</script>