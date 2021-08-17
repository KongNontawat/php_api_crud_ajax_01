<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- CDN Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"
    integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w=="
    crossorigin="anonymous" />
  <!-- SweetAlert2 -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <!-- Bootstrap 5 CSS-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <!-- DataTable -->
  <!-- <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"> -->
  <!-- Link Style Css -->
  <link rel="stylesheet" href="CSS/style.css">
  <title>Document</title>
</head>

<body>


  <div class="container">
    <div class="alert alert alert-primary" role="alert">
      <h4 class="text-primary text-center">PHP CRUD Application Using jQuery Ajax</h4>
    </div>
    <div class="alert alert-success text-center message" role="alert">
    </div>
    <?php
include_once 'form.php';
include_once 'profile.php';
?>
    <div class="row my-3">
      <div class="col-3 mt-3">
        <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#userModal"
          id="addnewbtn">Add New <i class="fa fa-user-circle-o"></i></button>
      </div>
      <div class="col-9 mt-3">
        <div class="input-group input-group-lg">
          <span class="input-group-text" id="basic-addon2"><i class="fa fa-search" aria-hidden="true"></i></span>
          <input type="text" class="form-control" aria-label="Sizing example input"
            aria-describedby="inputGroup-sizing-lg" placeholder="Search..." id="searchinput">

        </div>
      </div>
    </div>
    <?php
include_once 'playerstable.php';
?>
    <nav id="pagination">

    </nav>
    <input type="hidden" name="currentpage" id="currentpage" value="1">
  </div>
  <div>
  </div>
  <div id="overlay" style="display:none;">
    <div class="spinner-border text-danger" style="width: 3rem; height: 3rem;"></div>
    <br>
    Loading...
  </div>

  <div class="box-message float-end me-3 mt-5">
    <div class="toast-message align-items-center shadow-lg px-3" data-bs-delay="2000" data-bs-autohide="true" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body me-4">
        
      </div>
      <button type="button" class="btn-close me-2 m-auto" id="close_message" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
  </div>


  <!-- Bootstrap 5 JS-->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"
    integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"
    integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous">
  </script>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- DataTable -->
  <!-- <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> -->


  <!-- My Script JS-->
  <script src="Js/script.js"></script>
</body>

</html>