<?php require(APPPATH . 'Views/admin/layouts/preContent.php') ?>


<div class="card">
    <div class="card-header">
        <i class="fas fa-clipboard-check"></i>
        <b>
            تذاكر المدارس

        </b>
    </div>

    <div class="card-body">
        <div class="row">

            <div class="col-lg-4">

                <label class="sr-only" for="searsh">إبحث عن مدرسة</label>
                <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"> <i class="fas fa-search"></i></div>
                    </div>
                    <input id="searsh" type="text" class="form-control" placeholder="إبحث عن مدرسة" style="cursor: pointer; box-shadow: 0px 10px 18px 1px rgb(0 0 0 / 10%);">
                </div>

            </div>
            <div class="col-lg-4">
                <label class="sr-only" for="datee">إبحث عن تاريخ</label>
                <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"> <i class="fas fa-search"></i></div>
                    </div>

                    <input id="datee" type="date" class="form-control" placeholder="إبحث عن تاريخ" style="cursor: pointer; box-shadow: 0px 10px 18px 1px rgb(0 0 0 / 10%);">
                </div>


            </div>
            <div class="col-lg-4">
                <div class="input-group mb-3">
                    <select id="status" class="custom-select" id="inputGroupSelect02" style="cursor: pointer; box-shadow: 0px 10px 18px 1px rgb(0 0 0 / 10%);">
                        <option value="" selected> أختر...</option>
                        <option value="1">مفتوحة</option>
                        <option value="2">مغلقة</option>

                    </select>
                    <div class="input-group-append">
                        <label class="input-group-text" for="inputGroupSelect02">حالة التذاكر</label>
                    </div>
                </div>
            </div>
        </div>
        <!-- father tiket -->
        <div class="row" id="tickets-container">
            <div class="col-lg-4"></div>
            <!--  end  tiket2 -->
            <div class="col-lg-4"></div>

            <!--  end  tiket3 -->
        </div>
    </div>

    <!-- end crad bady -->

    <?php require(APPPATH . 'Views/admin/layouts/postContent.php'); ?>
    <script>
        $(document).ready(function() {

        });
        $(document).ready(function() {
            getTickets();
            $('#status').change(function() {
                getTickets();
            });
            $('#searsh').change(function() {
                getTickets();
            });
            $('#datee').change(function() {
                getTickets();
            });
        });

        function getTickets() {
            $.ajax({
                    "url": "<?= site_url('') ?>Tickets/GetAdminSchoolsTickets",
                    "method": "GET",
                    "timeout": 0,
                    "headers": {
                        "Authorization": token
                    },
                    data: {
                        page: 1,
                        limit: 10000,
                        status: $('#status').val(),
                        school_name: $('#searsh').val(),
                        date: $('#datee').val(),
                    }
                }).done(function(response) {
                    displayTickets(response.data);
                })
                .fail(function(response) {
                    console.log(response);
                    toastr.error(response.responseJSON.msg, 'خطأ');
                });
        }


        function displayTickets(data) {

            $("#tickets-container").html('');
            
            for (let i = 0; i < data.length; i++) {
                $("#tickets-container").append(


                    `<div class="col-lg-4">

                    <div class="card" style="">
                            <div class=""><h6 class="text-center" id="school_name">${data[i].school_name}</h6></div>
                        <div class="card-header " >
                    <div class="row">
                   
                        </div>

                      <!-- <h2 class="d-flex justify-content-end"> </h2> -->
                      </div>
                    <div class="card-body">

                 <div class="form-group">
             <div class="row ">
           <div class="col-lg-6"><label for=""> البريد الإلكتروني:
             </label></div>

              <div class="col-lg-6">
               <a  href="#"class="d-flex justify-content-end" id="email" > 
               ${data[i].email} </a></div> 
           </div>


            <div class="row">
        <div class="col-lg-6"><label for=""> الجوال:

       </label></div>

     <div class="col-lg-6">
    <a  href="#"class="d-flex justify-content-end" id="phone"> 
    ${data[i].phone}</a></div> 
    </div>


<div class="row">
    <div class="col-lg-6"><label for="">العنوان:

 </label></div>

 <div class="col-lg-6">
  <a  href="#"class="d-flex justify-content-end" id="city"> 
  ${data[i].city},${data[i].area}</a></div> 
</div>


</div>
<hr>
        <div class="d-flex justify-content-center">
            <a class="btn btn-success m-2" style="color: #fff;
    background-color: #1bc5bd;
    border-color: #1bc5bd;" href="<?php echo base_url() . '/public/'; ?>admin/viewticketschool/${data[i].id}" onclick="viewt('${data[i].id}')">استعراض التذاكر</a>


</div>     
</div>
   
   </div>


</div>
<!--  end  tiket1 -->`);}
 if (data.length == 0) {

alert("لاتوجد تذاكر متاحة");
}

    }

                function viewt(id) {
                    var jqxhr = $.ajax({
                            url: "<?= site_url('') ?>Tickets/GetSchoolsAdminTicketsBySchoolId",
                            method: "GET",
                            timeout: 0,
                            data: {

                                school_id: id,
                                page: "1",
                                limit: "10000",
                                status: $('#status').val()
                            },
                            headers: {
                                "Authorization": token
                            },
                        })
                        .done(function(response) {
                            // dataTable.clear().rows.add(response.data).draw()
                        })
                        .fail(function(response) {
                            console.log(response);
                            toastr.error(response.responseJSON.msg, 'خطأ');
                        });

                }
           
          
       
    </script>