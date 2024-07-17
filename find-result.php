<?php
session_start();
include('includes/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acedemia | Find Results</title>
    
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Heebo', sans-serif;
        }
        .outer-container {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            margin: auto;
            max-width: 500px;
        }
        .inner-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
        }
        .btn-custom {
            background-color: #7a6ad8;
            color: white;
            border-radius: 25px;
        }
        .btn-custom:hover {
            background-color: #695bc3;
        }
        .link-custom {
            color: #7a6ad8;
        }
        .link-custom:hover {
            color: #695bc3;
            text-decoration: none;
        }
        .logo-text {
            font-size: 2rem;
            font-weight: 600;
            color: #7a6ad8;
        }
        .tagline-text {
            font-size: 0.875rem;
            font-weight: 400;
            color: #7a6ad8;
            margin-top: -10px;
            animation: fadeIn 2s ease-in-out;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        .form-group {
            position: relative;
            margin-bottom: 30px;
        }

        .form-control {
            border: none;
            border-bottom: 1px solid #ced4da;
            outline: none;
            border-radius: 0;
            padding: 10px 0;
            width: 100%;
            background-color: transparent;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #7a6ad8;
        }

        .custom-label {
            position: absolute;
            left: 0;
            top: 0;
            pointer-events: none;
            transition: all 0.3s ease-in-out;
        }

        .form-control:focus + .custom-label,
        .form-control:not(:placeholder-shown) + .custom-label {
            top: -20px;
            font-size: 0.75rem;
            color: #7a6ad8;
        }
    </style>
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
  <!-- ***** Preloader End ***** -->

 
</head>
<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <div class="container">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="outer-container">
                        <div class="logo-text">ACEDEMIA</div>
                        <div class="tagline-text">RESULT PORTAL</div>
                        <div class="inner-container">
                            <form action="result.php" method="post">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="rollid" name="rollid" required>
                                    <label for="rollid" class="custom-label">Roll No.</label>
                                </div>
                                <div class="form-group">
                                    <select name="class" class="form-control" id="class" required>
                                        <option value=""></option>
                                        <?php
                                        $sql = "SELECT * from tblclasses";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) { ?>
                                                <option value="<?php echo htmlentities($result->id); ?>">
                                                    <?php echo htmlentities($result->ClassName); ?>&nbsp; Batch-<?php echo htmlentities($result->Section); ?>
                                                </option>
                                            <?php }
                                        } ?>
                                    </select>
                                    <label for="class" class="custom-label">Institute</label>
                                </div>
                                <button type="submit" class="btn btn-custom py-3 w-100 mb-4">Search</button>
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <a href="admin-login.php" class="link-custom">Admin Panel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
