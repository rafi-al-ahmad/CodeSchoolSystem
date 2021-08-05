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

            <label class="sr-only" for="inlineFormInputGroupUsername2">إبحث عن مدرسة</label>
                <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"> <i class="fas fa-search"></i></div>
                    </div>
                    <input type="text" class="form-control" id="inlineFormInputGroupUsername2" placeholder="إبحث عن مدرسة" style="cursor: pointer; box-shadow: 0px 10px 18px 1px rgb(0 0 0 / 10%);">
                </div>

            </div>
            <div class="col-lg-4">
            <label class="sr-only" for="inlineFormInputGroupUsername2">إبحث عن تاريخ</label>
                <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"> <i class="fas fa-search"></i></div>
                    </div>
                
                    <input type="date" class="form-control" id="inlineFormInputGroupUsername2" placeholder="إبحث عن تاريخ" style="cursor: pointer; box-shadow: 0px 10px 18px 1px rgb(0 0 0 / 10%);">
                </div>


            </div>
            <div class="col-lg-4">
            <div class="input-group mb-3">
  <select id="status" class="custom-select" id="inputGroupSelect02" style="cursor: pointer; box-shadow: 0px 10px 18px 1px rgb(0 0 0 / 10%);">
    <option value=""  selected > أختر...</option>
    <option value="1">مفتوحة</option>
    <option value="2">مغلقة</option>

  </select>
  <div class="input-group-append">
    <label class="input-group-text" for="inputGroupSelect02">حالة التذاكر</label>
  </div>
</div>




            </div>            </div>

       






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
    });
    function getTickets() {
        $.ajax({
                "url": "https://sa.arsail.net/schools/Tickets/GetAdminSchoolsTickets",
                "method": "GET",
                "timeout": 0,
                "headers": {
                    "Authorization": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJUaGVfc2Nob29sIiwiYXVkIjoiVGhlX3Jld3IiLCJpYXQiOiIyMDIxLTA4LTAxIiwiZXhwIjoiMjAyMi0wOC0wMSIsImRhdGEiOiIxNyJ9.wb3NNCYPAdtG3qnvJiELl0mEhQ9tshj5T6AQvAHcDQU"
                },
                data: {
           school_name: "",
            username: "",
            image_url:"" ,
            category: "",
            email: "",
            phone: "",
            city: "",
            area: "",
            page: 1,
                    limit: 10000,
                   
                    date: "",
                    parent_name: "",
            status: $('#status').val(),
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
            $("#tickets-container").append(
            
            
                `<div class="col-lg-4">

   <div class="card" style="">
        <div class=""><h6 class="text-center" id="school_name">${data[i].school_name}</h6></div>
    <div class="card-header " >
    <div class="row">
                   
                    <div class="col-lg-12">
                        <img src="${data[i].image_url}" class="img-thumbnail img2 d-flex " style="width: 100%; id=imge"></div>

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
        <div class="col-lg-6"><label for=""> الهاتف:

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
    border-color: #1bc5bd;" href="<?php echo base_url() . '/public/';?>admin/viewticket">استعراض التذاكر</a>


</div>     
</div>
   
   </div>


</div>
<!--  end  tiket1 -->`);

        }
    }

</script>






