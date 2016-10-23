<?php
include("header.php");
include("../../connection.php");
$check = 0;
if (isset($_POST['savequestion'])) {
    extract($_POST);
    $testid = $_SESSION['test_id'];
    $sql = "insert into mst_question(test_id,que_desc,ans1,ans2,ans3,ans4,true_ans) values ('$testid','$addque','$ans1','$ans2','$ans3','$ans4','$anstrue')";
   // $conn->query($sql);
    if ($conn->query($sql) === TRUE) {
        echo "Question Added Successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    unset($_POST);
}

if (isset($_POST['create'])) {
    $testid = $_POST['testid'];

    $sql = "Select total_que from mst_test where test_id='$testid'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $_SESSION['total_que'] = $row['total_que'];
    $_SESSION['starting'] = 1;
    $_SESSION['test_id'] = $testid;
}
if (!empty($_SESSION['total_que'])) {
    //echo $_SESSION['total_que'];
    ?>
    <div class="container">
        <form class="form-horizontal" action="questionadd.php" method="post">
            <input type="hidden" name="testid " value="<?= $_SESSION['test_id']; ?>">
            <table class="table table-responsive">
                <tr>
                    <td ><div align="left"><strong> Enter Question </strong></div></td>
                    <td>&nbsp;</td>
                    <td><textarea name="addque" cols="60" rows="2" id="addque"  class="form-control" ></textarea></td>
                </tr>
                <tr>
                    <td ><div align="left"><strong>Enter Answer1 </strong></div></td>
                    <td>&nbsp;</td>
                    <td><input name="ans1" type="text" id="ans1"   class="form-control" ></td>
                </tr>
                <tr>
                    <td ><strong>Enter Answer2 </strong></td>
                    <td>&nbsp;</td>
                    <td><input name="ans2" type="text" id="ans2"   class="form-control" ></td>
                </tr>
                <tr>
                    <td ><strong>Enter Answer3 </strong></td>
                    <td>&nbsp;</td>
                    <td><input name="ans3" type="text" id="ans3"   class="form-control" ></td>
                </tr>
                <tr>
                    <td ><strong>Enter Answer4</strong></td>
                    <td>&nbsp;</td>
                    <td><input name="ans4" type="text" id="ans4"   class="form-control" ></td>
                </tr>
                <tr>
                    <td ><strong>Enter True Answer </strong></td>
                    <td>&nbsp;</td>
                    <td><input name="anstrue" type="text" id="anstrue" size="50" maxlength="50" class="form-control" ></td>
                </tr>
                <tr>
                    <td ></td>
                    <td>&nbsp;</td>
                    <td>
                        <input type="submit" name="savequestion" value="Add Question"  class="btn btn-primary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <?php
    $_SESSION['total_que'] --;
    if ($_SESSION['total_que'] == 0) {
        $test_id = $_SESSION['test_id'];
        $sql = "update mst_test set status = 1 where test_id = '$test_id'";
        $conn->query($sql);
        $check = 1;
    }
    $_SESSION['starting'] ++;
}
error_reporting(1);
?>
<?php
extract($_POST);

echo "<BR>";
if (!isset($_SESSION['LOGIN_ID'])) {
    echo "<br><h2><div  class=head1>You are not Logged On Please Login to Access this Page</div></h2>";
    echo "<a href=index.php><h3 align=center>Click Here for Login</h3></a>";
    exit();
}

if ($LOGIN_TYPE == "admin" || $LOGIN_TYPE == "teacher") {
    ?> 
    <div class="col-md-12">
        <?php
        if (empty($_SESSION['total_que']) && $check == 0) {
            echo "<BR><h3 class=head1>Add Question </h3>";
            ?>

        <form name="form1" method="post" action="questionadd.php" >
                <h4 class="text-center"> Subject: <?php echo $LOGIN_SUBJECT; ?></h4>
                <table class="table table-responsive " >
                    <tr>
                        <td ><div align="left"><strong>Select Test Name </strong></div></td>
                        <td width="1%" height="5">  
                        <td width="75%" height="32">

                            <select name="testid" id="testid" class="form-control">
                                <?php
                                $sql = "Select * from mst_test where sub='$LOGIN_SUBJECT' and status = 0 order by test_name";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    // output data of each row
                                    while ($row = $result->fetch_assoc()) {
                                        $testname = strtoupper($row['test_name']);
                                        ?>

                                        <option value="<?= $row['test_id']; ?>"  > <?= $testname; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>  
                        </td>
                        <td>
                            <input type="submit" class="btn btn-primary" name="create" value="Create Question"> 
                        </td>
                    </tr> 
                </table>
            </form>
        <?php } ?>
        <p>&nbsp; </p>
    </div>
    <?php
} else
    echo $notaccess;
?>
</div>
<?php include 'footer.php'; ?>
</div>
</body>
</html>