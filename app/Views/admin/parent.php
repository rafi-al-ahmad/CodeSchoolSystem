<?php require(APPPATH . 'Views/admin/layouts/preContent.php') ?>




<div class="card">
    <div class="card-header">
    <i class="fas fa-chalkboard-teacher"></i>
    <b>تذاكر المدارس وأولياء الأمور
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
                    <input type="text" class="form-control" id="searsh" placeholder="إبحث عن مدرسة" style="box-shadow: 0px 10px 18px 1px rgb(0 0 0 / 10%);">
                </div>

            </div>
            <div class="col-lg-4">
            <label class="sr-only" for="datee">إبحث عن تاريخ</label>
                <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"> <i class="fas fa-search"></i></div>
                    </div>
                
                    <input type="date" class="form-control" id="datee" placeholder="إبحث عن تاريخ" style="box-shadow: 0px 10px 18px 1px rgb(0 0 0 / 10%);">
                </div>


            </div>
            <div class="col-lg-4">
            <div class="input-group mb-3">
  <select id="status" class="custom-select" id="inputGroupSelect02"style="box-shadow: 0px 10px 18px 1px rgb(0 0 0 / 10%);">
    <option selected value="">أختر...</option>
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










<div class="col-lg-4" ></div>




<!--  end  tiket2 -->


<!--  end  tiket3 -->


</div>



<!-- end crad bady -->

   
     

  
  
   



        <?php require(APPPATH . 'Views/admin/layouts/postContent.php'); ?>
        <script>


        
        $(document).ready(function() {
        
    });
    $(document).ready(function() {
        getTicketsParents();
        $('#status').change(function() {
            getTicketsParents();
        });
        $('#searsh').change(function() {
            getTicketsParents();
        });
        $('#datee').change(function() {
            getTicketsParents();
        });
    });
    function getTicketsParents() {
        $.ajax({
                "url": "<?= site_url('') ?>Tickets/GetParentsAdminTickets",
                "method": "GET",
                "timeout": 0,
                "headers": {
                    "Authorization": token
                },
                data: {
                   

            page: 1,
            limit: 10000,
            status: $('#status').val(),
            school_name:$('#searsh').val(),
            date:$('#datee').val(),
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
    //    style="width: 500px;"
        for (let i = 0; i < data.length; i++) {
            $("#tickets-container").append(
            
                `<div class="col-lg-4">

   <div class="card" style="">
        
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
    border-color: #1bc5bd;" href="<?php echo base_url() . '/public/' ;?>admin/viewticketparent/${data[i].parent_id}" onclick="viewt()">استعراض التذاكر</a>


</div>     
</div>
   
   </div>


</div>
<!--  end  tiket1 -->`);

        }

        if (data.length == 0) {

alert("لاتوجد تذاكر متاحة");
}

        

        
    }
    
 function viewt() {
        var jqxhr = $.ajax({
                url: "<?= site_url('') ?>Tickets/GetSchoolsParentsTicketsBySchoolId",
                method: "GET",
                timeout: 0,
                data: {
               
                    parent_id:id, 
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

