<?php
session_start();
error_reporting(0);
include('includes/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>
    /* Preloader styles */
    #js-preloader {
      position: fixed;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      z-index: 9999;
      background-color: #7a6ad8; /* Background color of the preloader */
      display: flex;
      align-items: center;
      justify-content: center;
      color: white; /* Text color */
    }

    .preloader-inner {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .loading-text {
      display: flex;
    }

    .loading-letter {
      font-size: 2rem; /* Adjust font size as needed */
      font-weight: bold;
      animation: loadingAnimation 1.5s infinite;
      opacity: 0;
    }

    .loading-letter:nth-child(1) { animation-delay: 0s; }
    .loading-letter:nth-child(2) { animation-delay: 0.1s; }
    .loading-letter:nth-child(3) { animation-delay: 0.2s; }
    .loading-letter:nth-child(4) { animation-delay: 0.3s; }
    .loading-letter:nth-child(5) { animation-delay: 0.4s; }
    .loading-letter:nth-child(6) { animation-delay: 0.5s; }
    .loading-letter:nth-child(7) { animation-delay: 0.6s; }
    .loading-letter:nth-child(8) { animation-delay: 0.7s; }

    @keyframes loadingAnimation {
      0%, 100% {
        opacity: 0;
        transform: translateY(0);
      }
      50% {
        opacity: 1;
        transform: translateY(-10px);
      }
    }
  </style>
</head>
<body>
  <!-- ***** Preloader Start ***** -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <div class="loading-text">
        <span class="loading-letter">A</span>
        <span class="loading-letter">C</span>
        <span class="loading-letter">E</span>
        <span class="loading-letter">D</span>
        <span class="loading-letter">E</span>
        <span class="loading-letter">M</span>
        <span class="loading-letter">I</span>
        <span class="loading-letter">A</span>
      </div>
    </div>
  </div>

  <script>
    // JavaScript to hide the preloader after the content is loaded with delay
    window.addEventListener('load', function () {
      const preloader = document.getElementById('js-preloader');
      // Ensure full name is displayed first by using setTimeout
      setTimeout(function() {
        // Hide the preloader after an additional delay
        setTimeout(function() {
          preloader.style.display = 'none';
        }, 2000); // 2000ms = 2 seconds delay after full name displayed
      }, 2000); // 2000ms = 2 seconds delay to show the full name first
    });
  </script>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Title -->
    <title>ACEDEMIA | Results</title>
    <!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/animate-css/animate.min.css">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css">
    <link rel="stylesheet" href="css/prism/prism.css">
    <link rel="stylesheet" href="css/main.css">
    <style>
        /* Custom logo style */
        .logo-icon {
            font-size: 3rem;
            color: #7a6ad8;
            margin-right: 10px;
        }
        .logo-img {
            max-width: 200px; /* Adjust as needed */
            height: auto;
        }
        /* Watermark style */
        .watermark {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            font-size: 2rem;
            font-weight: bold;
            text-align: center;
            color: rgba(122, 106, 216, 0.3);
            pointer-events: none;
        }
        /* Print-specific CSS */
        @media print {
            /* Your print styles */
        }
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .logo-icon {
                font-size: 2rem;
            }
            .logo-img {
                max-width: 150px; /* Adjust as needed */
            }
            /* Adjust other styles as needed */
        }
    </style>
</head>
<body>
<div class="main-wrapper">
    <div class="content-wrapper">
        <div class="content-container">
            <!-- Logo -->
            <div class="main-page">
                <div class="container-fluid">
                    <div class="row page-title-div">
                        <div class="col-md-12" align="center">
                            <img src="shree.png" alt="Shree Vinayak Classes" class="logo-img">
                        </div>
                    </div>
                    <!-- Title -->
                    <div class="row page-title-div">
                        <div class="col-md-12">
                          
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->

                <!-- Student Result Details Section -->
                <section class="section" id="exampl" style="position: relative;">
                    <!-- Watermark -->
              
                    <!-- Your existing student result details section -->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h3 align="center">Student Result Details</h3>
                                            <hr/>
                                            <?php
                                            // Code Student Data
                                            $rollid = $_POST['rollid'];
                                            $classid = $_POST['class'];
                                            $_SESSION['rollid'] = $rollid;
                                            $_SESSION['classid'] = $classid;
                                            $qery = "SELECT   tblstudents.StudentName,tblstudents.RollId,tblstudents.RegDate,tblstudents.StudentId,tblstudents.Status,tblclasses.ClassName,tblclasses.Section from tblstudents join tblclasses on tblclasses.id=tblstudents.ClassId where tblstudents.RollId=:rollid and tblstudents.ClassId=:classid ";
                                            $stmt = $dbh->prepare($qery);
                                            $stmt->bindParam(':rollid', $rollid, PDO::PARAM_STR);
                                            $stmt->bindParam(':classid', $classid, PDO::PARAM_STR);
                                            $stmt->execute();
                                            $resultss = $stmt->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            if ($stmt->rowCount() > 0) {
                                                foreach ($resultss as $row) { ?>
                                                    <p><b>Student Name :</b> <?php echo htmlentities($row->StudentName); ?></p>
                                                    <p><b>Student Roll Id :</b> <?php echo htmlentities($row->RollId); ?>
                                                    <p><b>Student Class:</b> <?php echo htmlentities($row->ClassName); ?>(<?php echo htmlentities($row->Section); ?>)
                                                        <?php }

                                                        ?>
                                    </div>
                                    <div class="panel-body p-20">

                                        <table class="table table-hover table-bordered" border="1" width="100%">
                                            <thead>
                                            <tr style="text-align: center">
                                                <th style="text-align: center">#</th>
                                                <th style="text-align: center"> Subject</th>
                                                <th style="text-align: center">Marks</th>
                                            </tr>
                                            </thead>


                                            <tbody>
                                            <?php
                                            // Code for result

                                            $query = "select t.StudentName,t.RollId,t.ClassId,t.marks,SubjectId,tblsubjects.SubjectName from (select sts.StudentName,sts.RollId,sts.ClassId,tr.marks,SubjectId from tblstudents as sts join  tblresult as tr on tr.StudentId=sts.StudentId) as t join tblsubjects on tblsubjects.id=t.SubjectId where (t.RollId=:rollid and t.ClassId=:classid)";
                                            $query = $dbh->prepare($query);
                                            $query->bindParam(':rollid', $rollid, PDO::PARAM_STR);
                                            $query->bindParam(':classid', $classid, PDO::PARAM_STR);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            if ($countrow = $query->rowCount() > 0) {
                                                foreach ($results as $result) {

                                                    ?>

                                                    <tr>
                                                        <th scope="row" style="text-align: center"><?php echo htmlentities($cnt); ?></th>
                                                        <td style="text-align: center"><?php echo htmlentities($result->SubjectName); ?></td>
                                                        <td style="text-align: center"><?php echo htmlentities($totalmarks = $result->marks); ?></td>
                                                    </tr>
                                                    <?php
                                                    $totlcount += $totalmarks;
                                                    $cnt++;
                                                } ?>
                                                <tr>
                                                    <th scope="row" colspan="2" style="text-align: center">Total Marks</th>
                                                    <td style="text-align: center"><b><?php echo htmlentities($totlcount); ?></b>
                                                        out of <b><?php echo htmlentities($outof = ($cnt - 1) * 100); ?></b></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" colspan="2" style="text-align: center">Percentage</th>
                                                    <td style="text-align: center"><b><?php echo htmlentities($totlcount * (100) / $outof); ?> %</b></td>
                                                </tr>

                                                <tr>

                                                  

                                                <tr>

                                                    <td colspan="3" align="center"><i class="fa fa-print fa-2x"
                                                                                   aria-hidden="true"
                                                                                   style="cursor:pointer"
                                                                                   onclick="CallPrint()"></i>
                                                    </td>
                                                </tr>

                                            <?php } else { ?>
                                                <div class="alert alert-warning left-icon-alert" role="alert">
                                                    
                                            <strong>Notice!</strong> Your result not declare yet
 <?php }
?>
                                        </div>
 <?php 
 } else
 {?>

<div class="alert alert-danger left-icon-alert" role="alert">
<strong>Oh snap!</strong>
<?php
echo htmlentities("Invalid Roll Id");
 }
?>
                                        </div>



                                                	</tbody>
                                                </table>

                                            </div>
                                        </div>
                                        <!-- /.panel -->
                                    </div>
                                    <!-- /.col-md-6 -->

                                    <div class="form-group">
                                                           
                                                            <div class="col-sm-6">
                                                               <a href="index.php">Back to Home</a>
                                                            </div>
                                                        </div>

                                </div>
                                <!-- /.row -->
  
                            </div>
                            <!-- /.container-fluid -->
                        </section>
                        <!-- /.section -->

                    </div>
                    <!-- /.main-page -->

                  
                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- /.main-wrapper -->

        <!-- ========== COMMON JS FILES ========== -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
        <script>
            $(function($) {

            });


            function CallPrint() {
                // Open a new window
                var WinPrint = window.open('', '', 'left=0,top=0,width=' + screen.width + ',height=' + screen.height + ',toolbar=0,scrollbars=0,status=0');

                // Write the content of the current document to the new window
                WinPrint.document.write('<html><head><title>Print</title>');
                WinPrint.document.write('<link rel="stylesheet" href="css/bootstrap.min.css">');
                WinPrint.document.write('<link rel="stylesheet" href="css/font-awesome.min.css">');
                WinPrint.document.write('<link rel="stylesheet" href="css/animate-css/animate.min.css">');
                WinPrint.document.write('<link rel="stylesheet" href="css/lobipanel/lobipanel.min.css">');
                WinPrint.document.write('<link rel="stylesheet" href="css/prism/prism.css">');
                WinPrint.document.write('<link rel="stylesheet" href="css/main.css">');
                WinPrint.document.write('</head><body>');

                // Header for print
             

                // Main content
                WinPrint.document.write(document.documentElement.innerHTML);

                // Footer for print
                WinPrint.document.write('<div id="footer">Acedemia </div>');

                WinPrint.document.write('</body></html>');

                // Close the document
                WinPrint.document.close();

                // Focus on the new window
                WinPrint.focus();

                // Print the document
                WinPrint.print();

                // Close the window after printing
                WinPrint.close();
            }
        </script>

        <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->

    </body>
</html>
