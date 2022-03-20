<?php
require_once "inc/header.php";
require_once "inc/nav.php";
$id = $general->decrypt($input->session("UserLoggedIn"));
$info = $db->select("SELECT ParticipantType,p.Status Status,StartDate,SelectTrainingBatch,t.Title TrainingTitle,Location FROM ParticipantApplication p JOIN Trainings t ON t.EntryID=p.SelectTraining  WHERE p.PortalID LIKE '{$id}' ORDER BY StartDate,t.Title");


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
                                    <h1 class="text-uppercase text-primary">Thrivent Services Limited</h1>
                                    <span class="text-uppercase text-primary">Your Applied training(s)</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                            if(!empty($info)){
                                ?>
                                <table class="table table-hover table-bordered ">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Title</th>
                                            <th>Participate As</th>
                                            <th>Status</th>
                                            <th>Start Date</th>
                                            <th>Location</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-left">
                                        <?php
                                        $x=1;
                                        foreach($info as $i){
                                            ?>
                                                <tr>
                                                    <td><?=$x?></td>
                                                    <td><?=$i['TrainingTitle']?></td>
                                                    <td><?=$i['ParticipantType']?></td>
                                                    <td><?=$i['Status'] == 0 ? "Pending" : "Approved"?></td>
                                                    <td><?=$i['StartDate']?></td>
                                                    <td><?=$i['Location']?></td>
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


<?php
require_once "inc/footer.php"
?>