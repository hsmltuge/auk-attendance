<?php
require_once "inc/header.php";
if($input->get("retire")){
    $id = $general->decrypt($input->get("retire"));
    $db->query("UPDATE Class SET Status = '0' WHERE EntryID LIKE '{$id}'");
}
require_once "inc/nav.php";
$id = $general->decrypt($input->session("UserLoggedIn"));
$info = $db->select("SELECT * FROM Class WHERE CreatedBy LIKE '{$id}' AND Status LIKE 1 ORDER BY Status DESC");

?>
<div class="container mt-5 text-center">
    <div class="loginContainer">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="contact-form">
                <div class="card card-custom mt-15 mb-15">
                        <div class="card-header flex-wrap py-5">
                            <div class="card-title text-left">
                                <img src="../assets/media/logos/logo.png" style="max-width:150px" class="pr-5"/>
                                <div >
                                    <h1 class="text-uppercase text-primary">Al-qalam university, katsina</h1>
                                    <span class="text-uppercase text-primary">Attendance System | Student Management</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                           
                               
                                <form class="form" id="kt_register_form"  method="post" action="../php/students.php" autocomplete="off">
                                   <!--begin::Form group-->
                                    <div class="form-group">
                                        <select name="programmes" data-live-search="true" id="class" class="form-control  h-auto py-7 px-6 rounded-lg border-1">
                                        <option value=''>Select course you wish to upload student for</option>
                                        <?php
                                        if (!empty($info)) {
                                            foreach ($info as $u) {
                                                echo "<option value='{$u['EntryID']}'>{$u['CourseYear']} | {$u['CourseTitle']}</option>";
                                            }
                                        }?>
                                        </select>
                                    </div>
                                   
                                    <!--begin::Form group-->
                                    <div class="form-group">
                                        <input class="form-control h-auto py-7 px-6 rounded-lg border-1" type="file" name="regNo"
                                            autocomplete="off" placeholder="Registration Number" accept=".xls,.xlsx"/>
                                    </div>
                                    <!--end::Form group-->
                                     <!--begin::Form group-->
                                     <div class="form-group">
                                        <input name="jsonRecords" placeholder="Excel data to system readable format" readonly class="form-control h-auto py-7 px-6 rounded-lg border-1"/>
                                    </div>
                                    <!--end::Form group-->
                                    <a href="student_template.xlsx">Click here to download template (Remove the old records and upload your records, follow the template)</a>
                                    <!--begin::Action-->
                                    <div class="pb-lg-0 pb-5">
                                        <button type="submit" id="kt_register_form_submit_button"
                                                class="btn btn-primary btn-block font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3"> Save
                                        </button>
                                    </div>
                                    <!--end::Action-->
                                </form>
                                </div>                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end div row -->
    </div>
</div>
<?php
require_once "inc/footer.php"
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.4/xlsx.full.min.js" integrity="sha512-fQ6X8IIj+AvZyOG6HFXONC0xubDlH3+gbW+QgozYfs9Ra1iSSTLBv7qaLLhea6S62U9GHJjPyyWj5ivz7UJqCA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="../js/students.js"></script>
<script>
     $("input[name='regNo']").change((e) => {
        var oFile = e.target.files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
        var data = e.target.result;
        var workbook = XLSX.read(data, { type: "binary" });
        workbook.SheetNames.forEach(function (sheetName) {
            // Here is your object
            var XL_row_object = XLSX.utils.sheet_to_row_object_array(
            workbook.Sheets[sheetName]
            );
            var json_object = JSON.stringify(XL_row_object);
            console.log(XL_row_object[0])
            if(XL_row_object[0].RegNo !== undefined && XL_row_object[0].FullNames  !== undefined && XL_row_object[0].EmailAddress  !== undefined ){
                $("input[name='jsonRecords']").val(json_object);
            }else{
                Swal.fire({
                text: "Sorry invalid excel sheet",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                  confirmButton: "btn font-weight-bold btn-light-primary",
                },
              });
            }
                
        });
        };
        reader.readAsArrayBuffer(oFile);
    });
</script>