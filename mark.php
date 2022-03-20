<?php
require_once "inc/header.php";
require_once "inc/nav.php";
$info = $db->select("SELECT * FROM Class WHERE Status LIKE 1 ORDER BY CourseTitle ASC");
?>
<div class="container mt-5 text-center">
    <div class="loginContainer">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="contact-form">
                <div class="card card-custom mt-15 mb-15">
                        <div class="card-header flex-wrap py-5">
                            <div class="card-title text-left">
                                <img src="assets/media/logos/logo.png" style="max-width:150px" class="pr-5"/>
                                <div >
                                    <h1 class="text-uppercase text-primary">Al-qalam university, katsina</h1>
                                    <span class="text-uppercase text-primary">Attendance System | Mark my Attendance</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="form-group">
                                <input class="form-control h-auto py-7 px-6 rounded-lg border-1" type="text" id="search" autocomplete="off" placeholder="Search table(course code, course title)"/>
                            </div>
                            <?php
                            if(!empty($info)){
                                ?>
                                <table class="table table-hover table-bordered ">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Course Code</th>
                                            <th>Course Title</th>
                                            <th>Course Year</th>
                                            <th>Created On</th>
                                            <th>Mark Attendance</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-left">
                                        <?php
                                        $x=1;
                                        foreach($info as $i){
                                            ?>
                                                <tr>
                                                    <td><?=$x?></td>
                                                    <td><?=$i['CourseCode']?></td>
                                                    <td><?=$i['CourseTitle']?></td>
                                                    <td><?=$i['CourseYear']?></td>
                                                    <td><?=$i['CreatedOn']?></td>
                                                    <td>
                                                    <button type="button" json="<?=base64_encode(json_encode($i))?>"  class="btn btn-primary markMyAttendance" >
                                                        Mark My Attendance
                                                    </button>
                                                    </td>
                                                </tr>
                                            <?php
                                            $x++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <?php
                            }else{
                               echo $general->errors("warning","Sorry, there are no training available at the moment","NO TRAINING FOUND");
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end div row -->
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title text-uppercase" id="courseCode"></h1>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
    </div>
  </div>
</div>
<?php
require_once "inc/footer.php"
?>
<script>
    $("#search").on("keyup", function() {
        var value = this.value.toLowerCase().trim();

        $("table tr").each(function (index) {
            if (!index) return;
            $(this).find("td").each(function () {
                var id = $(this).text().toLowerCase().trim();
                var not_found = (id.indexOf(value) == -1);
                $(this).closest('tr').toggle(!not_found);
                return not_found;
            });
        });
    })

    $('.markMyAttendance').click((e) =>{
        const data = JSON.parse(atob($(e.target).attr("json")))
        $('#courseCode').html(`${data.CourseCode} | ${data.CourseTitle}`)
        $(".modal-body").html("Please wait system loading")
        $('.modal').modal("show")
        $.get(`php/student_list.php?i=${btoa(data.EntryID)}`,r =>{
            $(".modal-body").html(r)
        })
    })
    $(document).on("keyup","input[name='token']",(e) => {
        var foo = $(e.target).val().split("-").join(""); // remove hyphens
        if (foo.length > 0) {
            foo = foo.match(new RegExp('.{1,4}', 'g')).join("-");
        }
        $(e.target).val(foo.toUpperCase());
    });
    $(document).on("submit","#kt_register_form",e => {
        e.preventDefault()
        $.post("php/mark.php", $(e.target).serializeArray() ,r => {
            Swal.fire({
                text: r.msg,
                icon: r.type,
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                  confirmButton: "btn font-weight-bold btn-light-primary",
                },
              })
        })
    })
</script>