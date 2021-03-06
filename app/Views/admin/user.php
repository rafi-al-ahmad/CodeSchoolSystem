<?php require(APPPATH . 'Views/admin/layouts/preContent.php') ?>


<!-- start row1 -->

<!-- start card1 -->
<div class="card">

    <div class="card-header ">
        <i class="far fa-user-circle"></i>
        <h6 class=" text-bold d-inline-flex">إدارة عروض شركاء النجاح</h6>
    </div>

    <div class="card-body p-2" style="overflow-x: scroll;">
        <table id="content-table" class="table table-striped " style="width:100%">
            <thead>
                <tr>
                    <th></th>
                    <th>م</th>
                    <th>الشريك</th>
                    <th>المدينة</th>
                    <th>المنطقة</th>
                    <th> اسم الخدمة</th>
                    <th class="small-cell text-center t-image_url align-middle w-100"> توضيح الخدمة
                    </th>
                    <th>سعر الخدمة</th>
                    <th>السعر بعد الخصم</th>
                    <th>مقدار الخصم</th>
                    <th>الحالة</th>
                    <th>انشاء كوبون الخصم</th>
                    <th>تاريخ الانتهاء</th>
                </tr>
            </thead>
            <tbody></tbody>

        </table>
    </div>



</div>

<!-- end card1 -->




<?php require(APPPATH . 'Views/admin/layouts/postContent.php'); ?>


<script src="<?php echo base_url() . '/public/'; ?>design/js/jquery-3.4.1.min.js"></script>



<script src="<?php echo base_url() . '/public/'; ?>Excel/jquery.table2excel.js"></script>

<script src="<?php echo base_url() . '/public/'; ?>design/js/datatable.all.js"></script>


<link rel="stylesheet" type="text/css" href="<?php echo base_url() . '/public/'; ?>design/css/datatable.all.css" />

<script>
    
    var dataTable = null;
    var studentsData = [];

    $(document).ready(function() {

        dataTable = $('#content-table').DataTable({
            dom: `<"row d-flex justify-content-end mx-1 my-1 mb-3 "B><"row d-flex justify-content-between mx-1 "fl>rtip`,
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
                $(row).addClass('datatable-row');
                $(row).addClass('notToExcel');
            },
            columns: [{
                    "className": 'details-control',
                    "orderable": false,
                    searchable: false,
                    exportable: false,
                    "data": null,
                    "defaultContent": ''
                },

                {
                    data: 'id',
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
                    data: 'username',
                    name: 'username',
                    className: 'text-center t-username',
                    title: 'الشريك'
                },
                {
                    data: 'city',
                    name: 'city',
                    className: 'text-center t-city',
                    title: 'المدينة'
                },
                {
                    data: 'area',
                    name: 'area',
                    className: 'text-center t-area',
                    title: 'المنطقة'
                },
                {
                    data: 'service_name',
                    name: 'service_name',
                    className: 'text-center t-service_name',
                    title: ' اسم الخدمة'
                },
                {
                    data: 'image_url',
                    name: 'image_url',
                    className: 'text-center t-image_url align-middle w-100',
                    title: `توضيح الخدمة`,
                    render: function(data, type, row, meta) {
                        return `<a href='${data}'><i class="fas fa-photo-video"></i></a>`;
                    }
                },
                {
                    data: 'service_price',
                    name: 'service_price',
                    className: 'text-center t-service_price',
                    title: 'سعر الخدمة'
                },
                {
                    data: 'price_after_discount',
                    name: 'price_after_discount',
                    className: 'text-center t-price_after_discount',
                    title: 'السعر بعد الخصم'
                },
                {
                    data: 'discount',
                    name: 'discount',
                    className: 'text-center t-discount',
                    title: 'مقدار الخصم'
                },
                {
                    data: 'status',
                    name: 'status',
                    className: 'text-center t-status',
                    title: 'الحالة',
                    render: function(data, type, row, meta) {
                        var checked = (row.status == 1) ? `checked` : ``;
                        var text = (row.status == 1) ? `مفعل` : `غير مفعل`; 

                        return `<div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input"  ${checked} onchange="updateOfferStatus(${row.id},this)" id="customSwitch-${row.id}">
                                    <label id="status-text" class="custom-control-label" for="customSwitch-${row.id}">${text}</label>
                                </div>`;
                    }
                },
                {
                    data: 'cubon',
                    name: 'cubon',
                    className: 'text-center t-cubon',
                    title: 'كوبون الخصم'
                },
                {
                    data: 'end_date',
                    name: 'end_date',
                    className: 'text-center t-end_date',
                    title: 'تاريخ الانتهاء',
                    render: function(data, type, row, meta) {
                        return moment(data, "YYYY-MM-DD").format("iYYYY/iM/iD");
                    }
                },
            ],
            buttons: [{
                    extend: 'collection',
                    text: 'تصدير',
                    className: 'btn btn-sm',
                    buttons: ['excel', ]
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
        getPartnersData();
    });


    function getPartnersData() {
        var jqxhr = $.ajax({
                "url": "<?= site_url('') ?>Partners/GetPartners?page=1&limit=2000",
                "method": "GET",
                "timeout": 0,
                "headers": {
                    "Authorization": token
                },
                data:{
                    user_id: user_id,
                }
            })
            .done(function(response) {
                dataTable.clear().rows.add(response.data).draw()
            })
            .fail(function(response) {
                console.log(response);
                toastr.error(response.responseJSON.msg, 'خطأ');
            });
    }

    
    function updateOfferStatus(id, element) {
        var status = element.checked;

        console.log(status);
        var jqxhr = $.ajax({
                "url": "<?= site_url('') ?>Partners/UpdateServiceStatus",
                "method": "POST",
                "timeout": 0,
                "headers": {
                    "Authorization": token,
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                "data": {
                    "id": id,
                    "status": status ? 1 : 0,
                }
            })
            .done(function(response) {
                getPartnersData();
                toastr.success('تم تحديث حالة النموذج');
                console.log($(element).parent().find("#status-text"));
                status ? $(element).parent().find("#status-text").html("مفعل") : $(element).parent().find("#status-text").html("غير مفعل");
            })
            .fail(function(response) {
                console.log(response);
                toastr.error(response.responseJSON.msg, 'خطأ');
            });
    }

</script>