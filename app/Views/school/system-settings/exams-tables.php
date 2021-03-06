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
            <form onsubmit="addExamTable(this); return false;">
                <div class="modal-body">
                    <!-- <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="program_name">اسم البرنامج</label>
                                <select required class="form-control" name="exam_id" id="program_name">
                                    <option value="">اسم الجدول</option>
                                    <option value="6">Final Term</option>
                                    <option value="7">Midd Term</option>
                                    <option value="8">برنامج الامتحان النهائي الفصل الاول</option>
                                    <option value="9">جدول الاختبار للفترة الثانية </option>
                                    <option value="10">تجربة جدول نهائي </option>
                                    <option value="11">اختبار الفترة الاولي </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr> -->
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="program-file" class="col-form-label">الملف</label>
                                <input type="file" name="file" class="form-control" id="program-file" accept="image/png, image/jpeg, image/jpg, .pdf, .docx, .doc">
                            </div>
                        </div>
                        <!-- <div class="col-md">
                            <div class="form-group">
                                <label for="hijri-date-picker" class="col-form-label">التاريخ</label>
                                <input required type="text" class="form-control  dependencies" id="hijri-date-picker" placeholder="التاريخ">
                                <input required type="hidden" name="date" class="form-control dependencies" id="date">
                            </div>
                        </div> -->
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="class">الصف</label>
                                <select required class="form-control" name="class" id="classes-selector">
                                    <option value="">الصف</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label for="semester">الفصل</label>
                                <select required class="form-control" name="semester" id="semesters-selector">
                                    <option value="">الفصل</option>
                                </select>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" id="add-exam-program-submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
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
            <div class="card-body p-2" style="overflow-x: scroll;">
                <table id="messages_forms" class="table table-striped " style="width:100%">
                    <thead>
                        <tr>
                            <th>م</th>
                            <th>الصف</th>
                            <th>الفصل</th>
                            <th>الملف</th>
                            <th>التاريخ</th>
                            <th>خيارات</th>
                        </tr>
                    </thead>
                    <tbody></tbody>

                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once(APPPATH . 'Views/school/layouts/postContent.php') ?>







<script src="<?php echo base_url() . '/public/'; ?>Excel/jquery.table2excel.js"></script>

<script src="<?php echo base_url() . '/public/'; ?>design/js/datatable.all.js"></script>


<link rel="stylesheet" type="text/css" href="<?php echo base_url() . '/public/'; ?>design/css/datatable.all.css" />

<script>
    var dataTable = null;
    var class_id = null;
    var exam_id = null;
    var section_id = null;
    $(document).ready(function() {
        dataTable = $('#messages_forms').DataTable({
            dom: `<"row d-flex justify-content-end mx-1 my-1 mb-3 "B><"row d-flex justify-content-between mx-1 "fl>rtip`,
            "lengthMenu": [
                [5, 10, 20, 50],
                [5, 10, 20, 50]
            ],
            // order: [
            //     [1, 'asc']
            // ],

            responsive: true,
            autoWidth: false,
            rowId: 'id',
            columnDefs: [{
                responsivePriority: 20000,
                targets: 2
            }, ],
            "processing": true,

            columns: [{
                    data: null,
                    name: 'id',
                    title: 'م',
                    className: 'text-center t-id',
                    // orderable: false,
                    searchable: false,
                    exportable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'class_name',
                    name: 'class_name',
                    className: 'text-center t-class_name',
                    title: 'الصف'
                },
                {
                    data: 'semester',
                    name: 'semester',
                    className: 'text-center t-semester',
                    title: `الفصل`,
                },
                {
                    data: 'file_path',
                    name: 'file_path',
                    className: 'text-center t-file_path',
                    title: 'الملف',
                    render: function(data, type, row, meta) {
                        return `<a href="${data}" >عرض</a>`;
                    }
                },
                {
                    data: 'date',
                    name: 'date',
                    className: 'text-center t-date',
                    title: 'تاريخ الاضافة',
                    render: function(data, type, row, meta) {
                        return moment(data, "YYYY-MM-DD").format("iYYYY/iM/iD");
                    }
                },
                {
                    data: "id",
                    name: 'action',
                    title: '&nbsp;&nbsp;&nbsp;&nbsp;خيارات&nbsp;&nbsp;&nbsp;&nbsp;',
                    className: 'text-center ',
                    orderable: false,
                    searchable: false,
                    printable: false,
                    render: function(data, type, row, meta) {
                        return `<div class="row justify-content-center  text-white ">
                                    <div class="m-1">
                                        <a type="button" class="btn btn-sm btn-danger " title="delete" style="margin: 0px;" onclick="deleteRecord(${data})">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </div>`;
                    }
                }
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
        getSemesters();
        getClasses();
    });

    function refreshExamsTable() {
        var jqxhr = $.ajax({
                url: "<?= site_url('') ?>Schools/GetSchoolExamTable",
                method: "GET",
                timeout: 0,
                data: {
                    school_id: school_id,
                    page: "1",
                    limit: "10000",
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

    function addExamTable(element) {
        formData = $(element).serializeArray().reduce(function(obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});

        var form = new FormData();
        form.append("school_id", school_id);
        form.append("semester", formData.semester);
        form.append("class", formData.class);
        form.append("file", $("#program-file")[0].files[0]);


        $('#add-exam-program-submit').attr("disabled", true);
        $('#add-spinner').show();

        var jqxhr = $.ajax({
                url: "<?= site_url('') ?>Schools/AddExamTable",
                method: "POST",
                timeout: 0,
                "processData": false,
                "mimeType": "multipart/form-data",
                "contentType": false,
                data: form,
                headers: {
                    "Authorization": token,
                },
            })
            .done(function(response) {
                refreshExamsTable();
                toastr.success('تم اضافة البيانات بنجاح')
            })
            .fail(function(response) {
                console.log(response);
                toastr.error(JSON.parse(response.responseText).msg, 'خطأ');
            }).always(function() {
                $('#add-exam-program-submit').removeAttr('disabled');
                $('#add-spinner').hide();
            });

        return false;
    }

    function getClasses() {
        var jqxhr = $.ajax({
                url: "<?= site_url('') ?>Schools/GetClasses",
                method: "GET",
                timeout: 0,
                headers: {
                    "Authorization": token
                },
            })
            .done(function(response) {
                setClassesOptions(response.data);
            })
            .fail(function(response) {
                console.log(response);
                toastr.error(response.responseJSON.msg, 'خطأ');
            });

    }

    function getSemesters() {
        var jqxhr = $.ajax({
                url: "<?= site_url('') ?>Schools/GetSemester",
                method: "GET",
                timeout: 0,
                headers: {
                    "Authorization": token
                },
            })
            .done(function(response) {
                setSemestersOptions(response.data);
            })
            .fail(function(response) {
                console.log(response);
                toastr.error(response.responseJSON.msg, 'خطأ');
            });

    }

    // set classes options in classes select box
    function setClassesOptions(data) {
        var classSelect = $('#classes-selector');
        $.each(data, function(index, val) {
            classSelect.append($('<option>', {
                value: val.id,
                text: val.name + ' ' + val.code,
            }));
        });
    }

    // set semester options in semesters select box
    function setSemestersOptions(data) {
        var semesterSelect = $('#semesters-selector');
        $.each(data, function(index, val) {
            semesterSelect.append($('<option>', {
                value: val.id,
                text: val.name,
            }));
        });
    }
    
    function deleteRecord(id) {
        if (confirm('هل انت متأكد من انك تريد حذف هذا السجل؟')) {
            var jqxhr = $.ajax({
                    "url": "<?= site_url('') ?>Schools/DeleteSchoolExamTable",
                    "method": "DELETE",
                    "timeout": 0,
                    "headers": {
                        "Authorization": token,
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    "data": {
                        "id": id
                    }
                })
                .done(function(response) {
                    dataTable.row($('tr#' + id)).remove().draw();
                    toastr.success('تم حذف السجل بنجاح!')
                })
                .fail(function(response) {
                    console.log(response);
                    toastr.error('حدث خطأ ما اثناء حذف البيانات!', 'خطأ');
                })
        }
    }
</script>