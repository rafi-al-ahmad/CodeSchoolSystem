<?php require(APPPATH . 'Views/school/layouts/preContent.php') ?>

<!-- Content Header (Page header) -->
<div class="content-header my-2 bg-white">

    <div class="row ">
        <div class="col ">
            إشعارات الرسائل العامة
        </div>
    </div>
</div>
<!-- /.content-header -->
<?php require(APPPATH . 'Views/school/layouts/notifications-service-status.php') ?>

<div class="content-header my-2 bg-white">

    <div class="row ">
        <div class="col text-center" id="template-text">
            نص القالب
        </div>
    </div>
</div>

<div class="row mt-4  mb-4 justify-content-between" style="font-size: 1rem;">
    <div class="col-md-3">
        <div class="form-group">
            <select required class="form-control" name="submit-type" id="determinants">
                <option value="">المجموعة</option>
                <option value="1">الطلاب</option>
                <option value="2">المعلمين</option>
                <option value="3">الاداريين</option>
                <option value="4">طلاب نظام المقررات</option>
            </select>
        </div>

    </div>

    <div class="col-md-3">
        <div class="form-group">
            <select required class="form-control" onchange="setForm(this)" name="template" id="templates">
                <option value="">القالب</option>
            </select>
        </div>

    </div>

    <div class="col-md-3">
        <div class="form-group">
            <button type="button" onclick="sendToGroup()" style="width: 100%; background-color: #fff;" class="btn btn-light">ارسال الى المجموعة</button>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <button type="button" onclick="sendUsersNotifications()" style="width: 100%; background-color: #fff;" class="btn btn-light">ارسال الى المحدد</button>
        </div>
    </div>
    <!-- /.col -->
</div>

<div id="students_determinants" class="row mt-4 mb-4 justify-content-between" style="font-size: 1rem; display: none;">
    <div class="col-md-6">
        <div class="form-group">
            <select required class="form-control" onchange="getStudentsData()" name="semester" id="semesters">
                <option value="">الفصل</option>
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <select required class="form-control" onchange="getStudentsData()" name="class" id="classes">
                <option value="">الصف</option>
            </select>
        </div>

    </div>

</div>

<div id="course_students_determinants" class="row mt-4 mb-4 justify-content-between" style="font-size: 1rem; display: none;">
    <div class="col-md-6">
        <div class="form-group">
            <select required class="form-control" onchange="getCourssesStudentsData()" name="levels" id="levels">
                <option value="">المستوى</option>
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <select required class="form-control" onchange="getCourssesStudentsData()" name="divisions" id="divisions">
                <option value="">الشعبة</option>
            </select>
        </div>

    </div>

</div>
<!-- /.row -->


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-center">
                <h5 id="table-title" class="m-0"></h5>
            </div>
            <div class="card-body p-2" style="overflow-x: scroll;">
                <table id="content-table" class="table table-striped " style="width:100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>م</th>
                            <th>الاسم </th>
                            <th>الجوال</th>
                        </tr>
                    </thead>
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
    var studentsData = [];

    $(document).ready(function() {

        dataTable = $('#content-table').DataTable({
            dom: `<"row d-flex justify-content-between mx-1 "fl>rtip`,
            "lengthMenu": [
                [25, 50, 100, 500, 1000],
                [25, 50, 100, 500, 1000]
            ],
            order: [
                [2, 'asc']
            ],

            responsive: true,
            autoWidth: false,
            rowId: 'id',
            columns: [{
                    data: 'id',
                    className: 'text-center align-middle',
                    title: `<input type="checkbox" class="select-all"  id="select-all">`,
                    orderable: false,
                    searchable: false,
                    exportable: false,
                    render: function(data, type, row, meta) {
                        return `<input type="checkbox" class='align-middle' value='${data}' name="Users[]" id="checkbox-${data}"/>`;
                    }
                },
                {
                    data: 'id',
                    name: 'id',
                    title: 'م',
                    className: 'text-center t-id align-middle',
                    // orderable: false,
                    searchable: false,
                    exportable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'full_name',
                    name: 'full_name',
                    className: 'text-center t-full_name align-middle',
                    title: 'الاسم'
                },
                {
                    data: 'phone',
                    name: 'phone',
                    className: 'text-center t-phone align-middle',
                    title: 'الجوال'
                },
            ],

            buttons: [{

                className: 'btn btn-sm ',
                text: 'إلغاء تحديد الارقام المكررة',
                action: function(e, dt, node, config) {
                    deselectDuplicate();
                }

            }, ],
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

    function setListeners() {
        $('#select-all').change(function() {
            if (this.checked) {
                selects();
            } else {
                deSelect();
            }
        });
    }

    $(document).ready(function() {
        setListeners();
        getTemplates();
        getClasses();
        getSemesters();
        levels();
        divisions();
        $('#determinants').change(function() {

            if ($('#determinants').val() == '1') {
                dataTable.destroy();
                buildStudentsTable();
                getStudentsData();
                $("#students_determinants").show();
                $("#course_students_determinants").hide();

            } else if ($('#determinants').val() == '2') {
                dataTable.destroy();
                buildTeachersTable();
                getTeachersData();
                $("#students_determinants").hide();
                $("#course_students_determinants").hide();

            } else if ($('#determinants').val() == '3') {
                dataTable.destroy();
                buildEmployeesTable();
                getEmployeesData();
                $("#students_determinants").hide();
                $("#course_students_determinants").hide();

            } else if ($('#determinants').val() == '4') {
                dataTable.destroy();
                buildCourseStudentsTable();
                getCourssesStudentsData();
                $("#students_determinants").hide();
                $("#course_students_determinants").show();
            }
            setListeners();
        });
    });

    function buildStudentsTable() {
        $('#table-title').html('بيانات الطلاب');

        dataTable = $('#content-table').DataTable({
            dom: `<"row d-flex justify-content-center mx-1 my-1"B><"row d-flex justify-content-between mx-1 "fl>rtip`,
            "lengthMenu": [
                [25, 50, 100, 500, 1000],
                [25, 50, 100, 500, 1000]
            ],
            order: [
                [1, 'asc']
            ],

            responsive: true,
            autoWidth: false,
            rowId: 'id',
            columns: [{
                    data: 'id',
                    className: 'text-center align-middle',
                    title: `<input type="checkbox" class="select-all"  id="select-all">`,
                    orderable: false,
                    searchable: false,
                    exportable: false,
                    render: function(data, type, row, meta) {
                        return `<input type="checkbox" class='align-middle' value='${data}' name="Users[]" id="checkbox-${data}"/>`;
                    }
                },
                {
                    data: 'id',
                    name: 'id',
                    title: 'م',
                    className: 'text-center t-id align-middle',
                    // orderable: false,
                    searchable: false,
                    exportable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'full_name',
                    name: 'full_name',
                    className: 'text-center t-full_name align-middle',
                    title: 'اسم الطالب',
                    render: function(data, type, row, meta) {
                        return `<div id="name-${row.id}">${data}</div>`;
                    }
                },
                {
                    data: 'phone',
                    name: 'phone',
                    className: 'text-center t-phone align-middle',
                    title: 'الجوال',
                    render: function(data, type, row, meta) {
                        return `<div id="phone-${row.id}">${data}</div>`;
                    }
                },
            ],

            buttons: [{

                className: 'btn btn-sm ',
                text: 'إلغاء تحديد الارقام المكررة',
                action: function(e, dt, node, config) {
                    deselectDuplicate();
                }

            }, ],
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
    }

    function buildCourseStudentsTable() {
        $('#table-title').html('بيانات طلاب نظام المقررات');

        dataTable = $('#content-table').DataTable({
            dom: `<"row d-flex justify-content-center mx-1 my-1"B><"row d-flex justify-content-between mx-1 "fl>rtip`,
            "lengthMenu": [
                [25, 50, 100, 500, 1000],
                [25, 50, 100, 500, 1000]
            ],
            order: [
                [1, 'asc']
            ],

            responsive: true,
            autoWidth: false,
            rowId: 'id',
            columns: [{
                    data: 'id',
                    className: 'text-center align-middle',
                    title: `<input type="checkbox" class="select-all"  id="select-all">`,
                    orderable: false,
                    searchable: false,
                    exportable: false,
                    render: function(data, type, row, meta) {
                        return `<input type="checkbox" class='align-middle' value='${data}' name="Users[]" id="checkbox-${data}"/>`;
                    }
                },
                {
                    data: 'id',
                    name: 'id',
                    title: 'م',
                    className: 'text-center t-id align-middle',
                    // orderable: false,
                    searchable: false,
                    exportable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'student_name',
                    name: 'student_name',
                    className: 'text-center t-student_name align-middle',
                    title: 'اسم الطالب',
                    render: function(data, type, row, meta) {
                        return `<div id="name-${row.id}">${data}</div>`;
                    }
                },
                {
                    data: 'phone',
                    name: 'phone',
                    className: 'text-center t-phone align-middle',
                    title: 'الجوال',
                    render: function(data, type, row, meta) {
                        return `<div id="phone-${row.id}">${data}</div>`;
                    }
                },
            ],

            buttons: [{

                className: 'btn btn-sm ',
                text: 'إلغاء تحديد الارقام المكررة',
                action: function(e, dt, node, config) {
                    deselectDuplicate();
                }

            }, ],

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
    }

    function buildTeachersTable() {
        $('#table-title').html('بيانات المدرسين');

        dataTable = $('#content-table').DataTable({
            dom: `<"row d-flex justify-content-center mx-1 my-1"B><"row d-flex justify-content-between mx-1 "fl>rtip`,
            "lengthMenu": [
                [25, 50, 100, 500, 1000],
                [25, 50, 100, 500, 1000]
            ],
            order: [
                [1, 'asc']
            ],

            responsive: true,
            autoWidth: false,
            rowId: 'id',
            columns: [{
                    data: 'id',
                    className: 'text-center align-middle',
                    title: `<input type="checkbox" class="select-all"  id="select-all">`,
                    orderable: false,
                    searchable: false,
                    exportable: false,
                    render: function(data, type, row, meta) {
                        return `<input type="checkbox" class='align-middle' value='${data}' name="Users[]" id="checkbox-${data}"/>`;
                    }
                },
                {
                    data: 'id',
                    name: 'id',
                    title: 'م',
                    className: 'text-center t-id align-middle',
                    // orderable: false,
                    searchable: false,
                    exportable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'full_name',
                    name: 'full_name',
                    className: 'text-center t-full_name align-middle',
                    title: 'اسم المعلم',
                    render: function(data, type, row, meta) {
                        return `<div id="name-${row.id}">${data}</div>`;
                    }
                },
                {
                    data: 'phone',
                    name: 'phone',
                    className: 'text-center t-phone align-middle',
                    title: 'الجوال',
                    render: function(data, type, row, meta) {
                        return `<div id="phone-${row.id}">${data}</div>`;
                    }
                },
            ],

            buttons: [{

                className: 'btn btn-sm ',
                text: 'إلغاء تحديد الارقام المكررة',
                action: function(e, dt, node, config) {
                    deselectDuplicate();
                }

            }, ],
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
    }

    function buildEmployeesTable() {
        $('#table-title').html('بيانات الموظفين');

        dataTable = $('#content-table').DataTable({
            dom: `<"row d-flex justify-content-center mx-1 my-1"B><"row d-flex justify-content-between mx-1 "fl>rtip`,
            "lengthMenu": [
                [25, 50, 100, 500, 1000],
                [25, 50, 100, 500, 1000]
            ],
            order: [
                [1, 'asc']
            ],

            responsive: true,
            autoWidth: false,
            rowId: 'id',
            columns: [{
                    data: 'id',
                    className: 'text-center align-middle',
                    title: `<input type="checkbox" class="select-all"  id="select-all">`,
                    orderable: false,
                    searchable: false,
                    exportable: false,
                    render: function(data, type, row, meta) {
                        return `<input type="checkbox" class='align-middle' value='${data}' name="Users[]" id="checkbox-${data}"/>`;
                    }
                },
                {
                    data: 'id',
                    name: 'id',
                    title: 'م',
                    className: 'text-center t-id align-middle',
                    // orderable: false,
                    searchable: false,
                    exportable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'name',
                    name: 'name',
                    className: 'text-center t-name align-middle',
                    title: 'اسم الموظف',
                    render: function(data, type, row, meta) {
                        return `<div id="name-${row.id}">${data}</div>`;
                    }
                },
                {
                    data: 'phone',
                    name: 'phone',
                    className: 'text-center t-phone align-middle',
                    title: 'الجوال',
                    render: function(data, type, row, meta) {
                        return `<div id="phone-${row.id}">${data}</div>`;
                    }
                },
            ],
            

            buttons: [{

            className: 'btn btn-sm ',
            text: 'إلغاء تحديد الارقام المكررة',
            action: function(e, dt, node, config) {
                deselectDuplicate();
            }

            }, ],
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
    }





    function levels() {
        var jqxhr = $.ajax({
                url: "<?= site_url('') ?>schools/GetLevels",
                method: "GET",
                timeout: 0,
                headers: {
                    "Authorization": token,
                },
                data: {
                    school_id: school_id
                }
            })
            .done(function(response) {
                setLevelsOptions(response.data)
            })
            .fail(function(response) {
                console.log(response);
                toastr.error(response.responseJSON.msg, 'خطأ');
            });

    }

    function divisions() {
        var jqxhr = $.ajax({
                url: "<?= site_url('') ?>Schools/GetDivisions",
                method: "GET",
                timeout: 0,
                headers: {
                    "Authorization": token
                },
                data: {
                    school_id: school_id
                }
            })
            .done(function(response) {
                setDivisionsOptions(response.data);
            })
            .fail(function(response) {
                console.log(response);
                toastr.error(response.responseJSON.msg,
                    'خطأ ');
            });

    }

    function setLevelsOptions(data) {
        var levelSelect = $('#levels');
        $.each(data, function(index, val) {
            levelSelect.append($('<option>', {
                value: val.id,
                text: val.title
            }));
        });
    }

    function setDivisionsOptions(data) {
        var divisionSelect = $('#divisions');
        $.each(data, function(index, val) {
            divisionSelect.append($('<option>', {
                value: val.id,
                text: val.title,
            }));
        });
    }




    function getCourssesStudentsData() {
        var jqxhr = $.ajax({
                url: "<?= site_url('') ?>Courses/GetCourses",
                method: "GET",
                timeout: 0,
                data: {
                    school_id: school_id,
                    page: "1",
                    limit: "7000",
                    level_id: $("#levels").val(),
                    division_id: $("#divisions").val(),
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

    function getStudentsData() {
        var jqxhr = $.ajax({
                url: "<?= site_url('') ?>Students/GetStudents",
                method: "GET",
                timeout: 0,
                data: {
                    school_id: school_id,
                    page: "1",
                    limit: "7000",
                    class_id: $("#classes").val(),
                    semester_id: $("#semesters").val(),
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

    function getTeachersData() {
        var jqxhr = $.ajax({
                url: "<?= site_url('') ?>Teachers/GetTeachers",
                method: "GET",
                timeout: 0,
                data: {
                    school_id: school_id,
                    page: "1",
                    limit: "7000"
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

    function getEmployeesData() {
        var jqxhr = $.ajax({
                url: "<?= site_url('') ?>Employee/GetEmployee",
                method: "GET",
                timeout: 0,
                data: {
                    school_id: school_id,
                    page: "1",
                    limit: "7000"
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
        var ele = document.getElementsByName('Users[]');
        for (var i = 0; i < ele.length; i++) {
            if (ele[i].type == 'checkbox')
                ele[i].checked = true;
        }
    }

    function deSelect() {
        var ele = document.getElementsByName('Users[]');
        for (var i = 0; i < ele.length; i++) {
            if (ele[i].type == 'checkbox')
                ele[i].checked = false;

        }
    }

    function getSelectedUsers() {
        var selectedUsers = [];
        var usersCheckBoxes = document.getElementsByName('Users[]');
        for (var i = 0; i < usersCheckBoxes.length; i++) {
            if (usersCheckBoxes[i].type == 'checkbox' && usersCheckBoxes[i].checked) {
                selectedUsers.push(usersCheckBoxes[i].value)
            }
        }

        return selectedUsers;
    }

    function getUsersData() {
        var selectedUsers = getSelectedUsers();
        var usersData = [];

        for (let i = 0; i < selectedUsers.length; i++) {
            selectedUsers[i];
            usersData.push({
                "id": selectedUsers[i],
                "date": moment().format("iYYYY/iM/iD"),
                "name": $('#name-' + selectedUsers[i]).html(),
                "phone": $('#phone-' + selectedUsers[i]).html(),
            });
        }

        console.log(usersData);

        return usersData;

    }

    function sendUsersNotifications() {
        var usersData = getUsersData();

        var selectedUsersNumber = usersData.length;
        if (!confirm("هل انت متأكد من ارسال الاشعارات الى " + selectedUsersNumber + " مستخدم؟")) {
            return;
        }

        var jqxhr = $.ajax({
                "url": "<?= site_url('') ?>Messaging/SendGeneralMessagesToUsers",
                "method": "POST",
                "timeout": 0,
                "headers": {
                    "Authorization": token,
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                "data": {
                    "usersData": JSON.stringify(usersData),
                    "school_id": school_id,
                    "template_id": $('#templates').val(),
                    "group": $('#determinants').val()
                }
            })
            .done(function(response) {
                // refreshContentTable();
                toastr.success(response.msg)
            })
            .fail(function(response) {
                console.log(response);
                toastr.error(response.responseJSON.msg, 'خطأ');
            }).always(function() {
                $('#edit-employee-submit').removeAttr('disabled');
                $('#edit-spinner').hide();
            });
    }

    function getTemplates() {
        var jqxhr = $.ajax({
                url: "<?= site_url('') ?>Templates/GetGeneralMessagingTempalte",
                method: "GET",
                timeout: 0,
                data: {
                    school_id: school_id,
                    page: "1",
                    limit: "7000"
                },
                headers: {
                    "Authorization": token
                },
            })
            .done(function(response) {
                setTemplateOptions(response.data);
            })
            .fail(function(response) {
                console.log(response);
                toastr.error('حدث خطأ ما اثناء تحميل بيانات القوالب!', 'خطأ');
            });
    }

    function setTemplateOptions(data) {
        var templatesSelect = $('#templates');
        $.each(data, function(index, val) {
            templatesSelect.append($('<option>', {
                value: val.id,
                text: val.name,
                title: val.content,
                id: "template-num-" + val.id,
            }));
        });
    }

    function sendToGroup() {

        if ($('#templates').val() == '' || $('#determinants').val() == '') {
            toastr.error('يجب تحديد القالب والمجموعة قبل الارسال!', 'خطأ');
            return;
        }

        if (!confirm("هل انت متأكد من ارسال الاشعارات الى المجموعة المحددة؟")) {
            return;
        }

        var jqxhr = $.ajax({
                "url": "<?= site_url('') ?>Messaging/SendGeneralMessagesToGroup",
                "method": "POST",
                "timeout": 0,
                "headers": {
                    "Authorization": token,
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                "data": {
                    "school_id": school_id,
                    "date": moment().format("iYYYY/iM/iD"),
                    "template_id": $('#templates').val(),
                    "group": $('#determinants').val()
                }
            })
            .done(function(response) {
                toastr.success(response.msg);
            })
            .fail(function(response) {
                console.log(response);
                toastr.error(response.responseJSON.msg, 'خطأ');
            });
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
        var classSelect = $('#classes');
        $.each(data, function(index, val) {
            classSelect.append($('<option>', {
                value: val.id,
                text: val.name + ' ' + val.code,
            }));
        });
    }

    // set semester options in semesters select box
    function setSemestersOptions(data) {
        var semesterSelect = $('#semesters');
        $.each(data, function(index, val) {
            semesterSelect.append($('<option>', {
                value: val.id,
                text: val.name,
            }));
        });
    }

    function setForm(element) {
        console.log(element);
        $("#template-text").html($("#template-num-" + element.value).attr("title"));
    }

    function deselectDuplicate() {
        var selectedData = getUsersData();
        var uniqueData = [];
        selectedData.forEach(element => {

            if (uniqueData.find(unique => unique == element.phone) == undefined) {
                uniqueData.push(element.phone);
            } else {
                $("#checkbox-" + element.id).prop('checked', false);
            }

        });

    }
</script>