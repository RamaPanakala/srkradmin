<?php
session_start();

// Redirect to login page if user is not logged in
if (empty($_SESSION['pass'])) {
    header("location:login.php");
}

// Include database connection
include "connect.php";

// Fetch the total number of news items from the database
$dept = 'CSE';

// Fetch news items for the current page
$run = mysqli_query($conn, "SELECT * FROM profiles WHERE dept = '$dept'");
$result = array();
if (mysqli_num_rows($run) > 0) {
    while ($row = mysqli_fetch_assoc($run)) {
        $row['editMode'] = false;
        $result[] = $row;
    }
}

if(isset($_POST['addstaff'])){
    $addPhoto = $_POST['addPhoto'];
    $addDepartment = $_POST['addDepartment'];
    $addDegree = $_POST['addDegree'];
    $addSpecialization = $_POST['addSpecialization'];
    $addEmail = $_POST['addEmail'];
    $addMobile = $_POST['addMobile'];
    $addIntrest = $_POST['addIntrest'];
    $addDesignation = $_POST['addDesignation'];
    $addName = $_POST['addName'];
    $addEid = $_POST['addEid'];
    
    // Corrected department assignment
    $dept = $addDepartment;
    
    $addstaff = $conn->prepare("INSERT INTO `profiles`(`eid`,`name`, `designation`, `dept`, `degree`, `email`, `mobile`, `specialization`) VALUES (?,?,?,?,?,?,?)");
    $addstaff->bind_param("ssssssss", $addEid, $addName, $addDesignation, $dept, $addDegree, $addEmail, $addMobile, $addSpecialization);
    
    if ($addstaff->execute()) {
        // Data inserted successfully
        header("Location: cse_staff.php");
        exit;
    } else {
        // Error in inserting data
        echo "Error: " . $addstaff->error;
    }
    
    $addstaff->close();
}
?>

<!doctype html>
<html class="fixed sidebar-light">

<head>
    <!-- Meta information -->
    <meta charset="UTF-8">
    <title>SRKREC ADMINISTRATION</title>
    <meta name="keywords" content="srkr" />
    <meta name="description" content="srkrec-administration">
    <meta name="author" content="#">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- Web Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="vendor/font-awesome/css/all.min.css" />
    <link rel="stylesheet" href="vendor/boxicons/css/boxicons.min.css" />
    <link rel="stylesheet" href="css/theme.css" />
    <link rel="stylesheet" href="css/skins/default.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="vendor/modernizr/modernizr.js"></script>

</head>

<body>
    <section class="body">
        <?php include 'navbar.php' ?>
        <!-- Content section -->
        <section role="main" class="content-body">
            <header class="page-header">
                <h2>SRKREC ADMINISTRATION</h2>
            </header>
            <!-- News table section -->
            <div class="row">
                <div class="col">
                    <section class="card">
                        <header class="card-header" style="display:flex; flex-direction:row;gap:100px;justify-content:space-between;">
                            <table>
                                <tr>
                                    <td>
                                        <h2 class="card-title mt-2" style="text-transform:uppercase;">SRKREC ECE ADMINISTRATION</h2>
                                    </td>

                                    <div class="col-lg-6">
                                        <div id="datatable-default_filter" class="dataTables_filter">
                                            <label><input type="search" id="myInput" onkeyup="searchFun()" class="form-control pull-right" placeholder="Search by reg id or name..." aria-controls="datatable-default"></label>
                                            <td><button class="btn btn-primary mt-2" id="addButton">+ Add Staff</button></td>

                                        </div>
                                    </div>

                                </tr>
                            </table>
                        </header>
                        <div class="input-group">
                            <div class="card-body">
                                <table id="myTable" class="table table-no-more table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-Start">Photo</th>
                                            <th class="text-Start">Name</th>
                                            <th class="text-Start">Designation</th>
                                            <th class="text-Start">Department</th>
                                            <th class="text-Start">Degree</th>
                                            <th class="text-Start">Specialization</th>
                                            <th class="text-Start">Mobile Number</th>
                                            <th class="text-Start">Mail Id</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        // ...
                                        for ($i = 0; $i < count($result); $i++) {
                                            $id = $result[$i]['eid']; // Get the faculty's eid
                                            $photoPath = '../../profiles/images/CSE/' . $id . '.jpg'; // Construct the photo path using eid

                                            echo '<tr>
        <td data-title="Photo" class="text-Start"><img src="' . $photoPath . '" alt="Faculty Photo" width="100" height="100"></td>     
        <td data-title="Name" class="text-Start">' . $result[$i]['name'] . '</td>
        <td data-title="Designation" class="text-Start">' . $result[$i]['designation'] . '</td>
        <td data-title="Department" class="text-Start">' . $result[$i]['dept'] . '</td>
        <td data-title="Designation" class="text-Start">' . $result[$i]['degree'] . '</td>
        <td data-title="Department" class="text-Start">' . $result[$i]['specialization'] . '</td>
        <td data-title="Mobile_number" class="text-Start">' . $result[$i]['mobile'] . '</td>
        <td data-title="E-Mail" class="text-Start">' . $result[$i]['email'] . '</td>
        <td data-title="Action" class="text-Start">
        <button class="btn btn-primary btn-sm edit-button fas fa-pen mt-2" data-eid="' . $id . '"></button>
        <button class="btn btn-danger btn-sm delete-button fas fa-trash mt-4" data-eid="' . $id . '"></button>
    </td>

    </tr>';
                                        }
                                        // ...
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <!-- Pagination links -->

            <!-- Modal for Editing News -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Staff Item</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm" method="post">
                                <input type="hidden" id="editId" name="id">
                                <div class="form-group">
                                    <label for="editName">Name</label>
                                    <input type="text" class="form-control" id="editName" name="name">
                                </div>

                                <div class="form-group">
                                    <label for="editDesignation">Designation:</label>
                                    <input type="text" class="form-control" id="editDesignation" name="designation">
                                </div>

                                <div class="form-group">
                                    <label for="editDepartment">Department:</label>
                                    <input class="form-control" id="editDepartment" name="dept"></input>
                                </div>
                                <div class="form-group">
                                    <label for="editDegree">Degree:</label>
                                    <input class="form-control" id="editDegree" name="degree"></input>
                                </div>
                                <div class="form-group">
                                    <label for="editSpecialization">Specialization:</label>
                                    <input class="form-control" id="editSpecialization" name="specialization"></input>
                                </div>
                                <div class="form-group">
                                    <label for="editMobile_number">Mobile Number:</label>
                                    <input class="form-control" id="editMobile_number" name="mobile"></input>
                                </div>
                                <div class="form-group">
                                    <label for="editMail_id">Mail Id:</label>
                                    <input class="form-control" id="editMail_id" name="email"></input>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="saveChanges">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal for Adding Staff -->
            <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addModalLabel">Add Staff Member</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="addForm" method="post" action="" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="addEid">Empolyee Id</label>
                                    <input type="text" class="form-control" id="addEid" name="addEid">
                                </div>
                                <div class="form-group">
                                    <label for="addName">Name</label>
                                    <input type="text" class="form-control" id="addName" name="addName">
                                </div>
                                <div class="form-group">
                                    <label for="addDesignation">Designation</label>
                                    <input type="text" class="form-control" id="addDesignation" name="addDesignation">
                                </div>
                                <div class="form-group">
                                    <label for="addIntrest">Intrest</label>
                                    <input type="text" class="form-control" id="addIntrest" name="addIntrest">
                                </div>
                                <div class="form-group">
                                    <label for="addMobile">Mobile Number</label>
                                    <input type="text" class="form-control" id="addMobile" name="addMobile">
                                </div>
                                <div class="form-group">
                                    <label for="addEmail">Email</label>
                                    <input type="email" class="form-control" id="addEmail" name="addEmail">
                                </div>
                                <div class="form-group">
                                    <label for="addSpecialization">Specialization</label>
                                    <input type="text" class="form-control" id="addSpecialization" name="addSpecialization">
                                </div>
                                <div class="form-group">
                                    <label for="addDegree">Degree</label>
                                    <input type="text" class="form-control" id="addDegree" name="addDegree">
                                </div>
                                <div class="form-group">
                                    <label for="addDepartment">Department</label>
                                    <input type="text" class="form-control" id="addDepartment" name="addDepartment" value="CSE" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="addPhoto">Photo</label>
                                    <input type="file" class="form-control-file" id="addPhoto" name="addPhoto">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" name="addstaff" class="btn btn-primary" id="addStaff">Add Staff</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for Delete Confirmation -->
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this staff member?
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="deleteId" value="">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        </div>
    </section>
    <script>
        // Function for filtering the table
        const searchFun = () => {
            let filter = document.getElementById('myInput').value.toUpperCase();
            let myTable = document.getElementById('myTable');
            let tr = myTable.getElementsByTagName('tr');

            for (var i = 0; i < tr.length; i++) {
                let td = tr[i].getElementsByTagName('td')[1];
                let t1 = tr[i].getElementsByTagName('td')[0];

                if (td || t1) {
                    let textvalue = td.textContent || td.innerHTML;
                    let pid = t1.textContent || t1.innerHTML;

                    if (textvalue.toUpperCase().indexOf(filter) > -1 || pid.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>

    <!-- Modal script -->
    <script>
        $(document).on('click', '.edit-button', function() {
            var id = $(this).data('eid');
            var name = $(this).closest('tr').find('td:eq(1)').text();
            var designation = $(this).closest('tr').find('td:eq(2)').text();
            var dept = $(this).closest('tr').find('td:eq(3)').text();
            var degree = $(this).closest('tr').find('td:eq(4)').text();
            var spec = $(this).closest('tr').find('td:eq(5)').text();
            var mobile = $(this).closest('tr').find('td:eq(6)').text();
            var mail = $(this).closest('tr').find('td:eq(7)').text();

            $('#editId').val(id);
            $('#editName').val(name);
            $('#editDesignation').val(designation);
            $('#editDepartment').val(dept);
            $('#editDegree').val(degree);
            $('#editSpecialization').val(spec);
            $('#editMobile_number').val(mobile);
            $('#editMail_id').val(mail);

            $('#editModal').modal('show'); // Show the modal
        });

        // Handle saving changes in the modal
        $('#saveChanges').on('click', function() {
            // Perform AJAX request to update the news item
            var formData = $('#editForm').serialize();
            $.ajax({
                url: 'update_staff.php', // Replace with the actual URL to update the news item
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Handle success, e.g., refresh the table
                    // Close the modal
                    $('#editModal').modal('hide');

                    // Reload the page
                    location.reload();
                },
                error: function(error) {
                    // Handle error
                }
            });
            console.log(formData);
        });



        // Show the delete confirmation modal when the delete button is clicked
        $(document).on('click', '.delete-button', function() {
            var id = $(this).data('eid');
            $('#deleteId').val(id); // Set the staff member's ID to the hidden input field
            $('#deleteModal').modal('show'); // Show the delete confirmation modal
        });

        // Handle the delete confirmation
        $('#confirmDelete').on('click', function() {
            var id = $('#deleteId').val();
            $.ajax({
                url: 'update_staff.php',
                type: 'POST',
                data: {
                    id: id,
                    action: 'delete' // Specify the action as 'delete'
                },
                success: function(response) {
                    // Handle success, e.g., refresh the table
                    $('#deleteModal').modal('hide'); // Hide the delete confirmation modal
                    location.reload(); // Reload the page
                },
                error: function(error) {
                    // Handle error
                }
            });
        });


        // Script For Adding New Staff
        // Show the add staff modal when the add button is clicked
        $(document).on('click', '#addButton', function() {
            $('#addModal').modal('show');
        });

         // Handle adding new staff member
         $('#addStaff').on('click', function() {
             var formData = new FormData($('#addForm')[0]);
             formData.append('action', 'add'); // Add the action 'add' to the form data

             $.ajax({
                 url: 'update_staff.php',
                 type: 'POST',
                 data: formData,
                 contentType: false,
                 processData: false,
                 success: function(response) {
                     // Handle success, e.g., refresh the table
                     $('#addModal').modal('hide'); // Hide the add staff modal
                     // location.reload(); // Reload the page
                 },
                 error: function(error) {
                     // Handle error
                 }
             });
         });
    </script>

    <!-- Vendor -->
    <script src="vendor/jquery/jquery.js"></script>
    <script src="vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
    <script src="vendor/popper/umd/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.js"></script>
    <!-- Theme Base, Components and Settings -->
    <script src="js/theme.js"></script>
</body>

</html>