<?php require(APPPATH . 'Views/school/layouts/preContent.php') ?>

<!-- Content Header (Page header) -->
<div class="content-header my-2 bg-white">

    <div class="row ">
        <div class="col ">
            جداول الاختبارات
        </div>
    </div>
</div>
<!-- /.content-header -->



<?php require(APPPATH . 'Views/school/layouts/notifications-service-status.php') ?>


<div class="modal fade" id="add-exam-program" tabindex="-1" aria-labelledby="add-exam-programLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-exam-programLabel">اضف جدول</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form onsubmit="addExamTable(this); return false;">
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="program_name">اسم البرنامج</label>
                                <select required class="form-control" name="exam_id" id="program_name">
                                    <option value="">اسم الجدول</option>
                                    <option  value="6">Final Term</option>
                                    <option  value="7">Midd Term</option>
                                    <option  value="8">برنامج الامتحان النهائي الفصل الاول</option>
                                    <option  value="9">جدول الاختبار للفترة الثانية </option>
                                    <option  value="10">تجربة جدول نهائي </option>
                                    <option  value="11">اختبار الفترة الاولي </option>
                                </select>
                                
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label for="course">المادة</label>
                                <select required class="form-control" name="course" id="course">
                                    <option value="">المادة</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="day" class="col-form-label">اليوم</label>
                                <input type="text" class="form-control" id="day">
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label for="date" class="col-form-label">التاريخ</label>
                                <input type="date" class="form-control" id="date">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="class">الصف</label>
                                <select required class="form-control" name="class" id="class">
                                    <option value="">الصف</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label for="group">الشعبة</label>
                                <select required class="form-control" name="group" id="group">
                                    <option value="">الشعبة</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                <button type="button" id="add-exam-program-submit" class="btn btn-primary">حفظ</button>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-2 d-flex align-items-center bg-white">
                <div class="m-left-auto">
                    <button type="button" class="btn btn-light" data-toggle="modal" data-target="#add-exam-program">اضف جدول اختبار</button>
                </div>
            </div>
            <div class="card-body p-2" style="overflow: scroll;">
                <table id="messages_forms" class="table table-striped " style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>البرنامج</th>
                            <th>المادة</th>
                            <th>الصف</th>
                            <th>اليوم</th>
                            <th>التاريخ</th>
                        </tr>
                    </thead>
                    <tbody></tbody>

                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once(APPPATH . 'Views/school/layouts/postContent.php') ?>



<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.bootstrap4.min.css" />

<script>
    var school_id = 24;
    var dataTable = null;
    var class_id = null;
    var exam_id = null;
    var section_id = null;
    $(document).ready(function() {
        dataTable = $('#messages_forms').DataTable({
            dom: `<"row d-flex"<"col-md-6 d-flex"fl><"col-md-6  d-flex align-items-center "<"m-right-auto"B>>>rtip`,
            "lengthMenu": [
                [5, 10, 20, 50],
                [5, 10, 20, 50]
            ],
            order: [
                [1, 'asc']
            ],

            responsive: true,
            autoWidth: false,
            // rowId: 'id',
            columnDefs: [{
                responsivePriority: 20000,
                targets: 2
            }, ],
            "processing": true,

            columns: [{
                    name: 'id',
                    title: 'م',
                    className: 'text-center t-id',
                    orderable: false,
                    searchable: false,
                    exportable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'program_name',
                    name: 'program_name',
                    className: 'text-center t-program_name',
                    title: 'البرنامج'
                },
                {
                    data: 'subject_name',
                    name: 'subject_name',
                    className: 'text-center t-subject_name',
                    title: `المادة`,
                },
                {
                    data: 'class_name',
                    name: 'class_name',
                    className: 'text-center t-class_name',
                    title: 'الصف'
                },
                {
                    data: 'day',
                    name: 'day',
                    className: 'text-center t-day',
                    title: 'اليوم'
                },
                {
                    data: 'date',
                    name: 'date',
                    className: 'text-center t-date',
                    title: 'التاريخ',
                    render: function(data, type, row, meta) {
                        return moment(data).format("DD-MM-YYYY");
                    }
                },
            ],
            buttons: [{
                    extend: 'collection',
                    text: 'تصدير',
                    className: 'btn btn-sm',
                    buttons: [{
                        extend: 'excel',
                    }, {
                        extend: 'csv',
                    }]
                },
                'colvis'
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

    $(document).ready(function() {
        refreshExamsTable();
        // getSemesters();
        // getClasses();
    });

    function refreshExamsTable() {
        var jqxhr = $.ajax({
                url: "https://sa.arsail.net/schools/Schools/GetSchoolExamTable",
                method: "GET",
                timeout: 0,
                data: {
                    school_id: school_id,
                    page: "1",
                    limit: "10000",
                    class_id: class_id,
                    exam_id: exam_id,
                    section_id: section_id,
                },
                headers: {
                    "Authorization": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJUaGVfc2Nob29sIiwiYXVkIjoiVGhlX3Jld3IiLCJpYXQiOiIyMDIxLTAyLTIyIiwiZXhwIjoiMjAyMi0wMi0yMiIsImRhdGEiOiIyMyJ9.ZITmmvk9fnZXo8Bfy30vw8uYK2kGZeN_M8XFPErmr_w"
                },
            })
            .done(function(response) {
                dataTable.clear().rows.add(response.data).draw()
            })
            .fail(function(response) {
                console.log(response);
                toastr.error('حدث خطأ ما اثناء تحميل البيانات!', 'خطأ');
            });
    }

    function addExamTable(element) {
        // formData = $(element).serializeArray().reduce(function(obj, item) {
        //     obj[item.name] = item.value;
        //     return obj;
        // }, {});
        // $('#add-exam-program-submit').attr("disabled", true);
        // $('#add-spinner').show();

        // var jqxhr = $.ajax({
        //         url: "https://sa.arsail.net/schools/Templates/AddTemplate",
        //         method: "POST",
        //         timeout: 0,
        //         data: {
        //             "name": formData.name,
        //             "content": formData.content,
        //             "letters_number": formData.letters_number,
        //             "message_number": formData.message_number,
        //             "id": formData.id,
        //             "school_id": school_id,
        //             "sender_type": formData.sender_type,
        //         },
        //         headers: {
        //             "Authorization": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJUaGVfc2Nob29sIiwiYXVkIjoiVGhlX3Jld3IiLCJpYXQiOiIyMDIxLTAxLTI5IiwiZXhwIjoiMjAyMi0wMS0yOSIsImRhdGEiOnsidXNlcl9pZCI6MTh9fQ.1EfRPKk8zdCvjmn7qkVRKflJDtJjaoN0R_xvphe1No0",
        //             "Content-Type": "application/x-www-form-urlencoded",
        //         },
        //     })
        //     .done(function(response) {
        //         refreshTemplatesTable();
        //         toastr.success('تم اضافة البيانات بنجاح')
        //     })
        //     .fail(function(response) {
        //         console.log(response);
        //         toastr.error('حدث خطأ ما اثناء اضافة البيانات!', 'خطأ');

        //     }).always(function() {
        //         $('#add-exam-program-submit').removeAttr('disabled');
        //         $('#add-spinner').hide();
        //     });

        // return false;
    }
    // function getClasses() {
    //     var jqxhr = $.ajax({
    //             url: "https://sa.arsail.net/schools/Schools/GetClasses",
    //             method: "GET",
    //             timeout: 0,
    //             headers: {
    //                 "Authorization": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJUaGVfc2Nob29sIiwiYXVkIjoiVGhlX3Jld3IiLCJpYXQiOiIyMDIxLTAyLTIyIiwiZXhwIjoiMjAyMi0wMi0yMiIsImRhdGEiOiIyMyJ9.ZITmmvk9fnZXo8Bfy30vw8uYK2kGZeN_M8XFPErmr_w"
    //             },
    //         })
    //         .done(function(response) {
    //             setClassesOptions(response.data);
    //         })
    //         .fail(function(response) {
    //             console.log(response);
    //             toastr.error('حدث خطأ ما اثناء تحميل البيانات!', 'خطأ');
    //         });

    // }

    // function getSemesters() {
    //     var jqxhr = $.ajax({
    //             url: "https://sa.arsail.net/schools/Schools/GetSemester",
    //             method: "GET",
    //             timeout: 0,
    //             headers: {
    //                 "Authorization": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJUaGVfc2Nob29sIiwiYXVkIjoiVGhlX3Jld3IiLCJpYXQiOiIyMDIxLTAyLTIyIiwiZXhwIjoiMjAyMi0wMi0yMiIsImRhdGEiOiIyMyJ9.ZITmmvk9fnZXo8Bfy30vw8uYK2kGZeN_M8XFPErmr_w"
    //             },
    //         })
    //         .done(function(response) {
    //             setSemestersOptions(response.data);
    //         })
    //         .fail(function(response) {
    //             console.log(response);
    //             toastr.error('حدث خطأ ما اثناء تحميل البيانات!', 'خطأ');
    //         });

    // }
    // // set classes options in classes select box
    // function setClassesOptions(data) {
    //     var classSelect = $('#classes-selector');
    //     $.each(data, function(index, val) {
    //         classSelect.append($('<option>', {
    //             value: val.id,
    //             text: val.name + ' ' + val.code,
    //         }));
    //     });
    // }

    // // set semester options in semesters select box
    // function setSemestersOptions(data) {
    //     var semesterSelect = $('#semesters-selector');
    //     $.each(data, function(index, val) {
    //         semesterSelect.append($('<option>', {
    //             value: val.id,
    //             text: val.name,
    //         }));
    //     });
    // }
</script>