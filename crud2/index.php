<?php
// Create database connection using config file
include_once("config.php");

// Fetch all users data from database, ordered by name alphabetically
$result = mysqli_query($mysqli, "SELECT * FROM users ORDER BY name ASC");
?>

<html>
<head>
    <title>Daftar Pengguna</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 25px auto; 
            font-size: 18px;
            text-align: center;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: rgb(91, 91, 91);
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .btn {
            padding: 8px 16px;
            margin-right: 8px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .btn-edit {
            background-color: #FF9800;
            border-radius: 10px;
        }
        .btn-delete {
            background-color: #F44336;
            border-radius: 10px;
        }
        h2 {
            text-align: center;
        }
        .center {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        /* Modal styles */
        .modal {
            display: none; 
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }
        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 300px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .modal-content .icon {
            font-size: 40px;
            color: orange;
            margin-bottom: 20px;
        }
        .modal-content p {
            font-size: 18px;
            margin-bottom: 30px;
        }
        .btn-confirm {
            background-color: #d9534f;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }
        .btn-cancel {
            background-color: #5bc0de;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }
    </style>
</head>

<body>
    <h2>Daftar Pengguna</h2>
    <table border=1>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
        <?php  
        $no = 1;
        while($user_data = mysqli_fetch_array($result)) {         
            echo "<tr>";
            echo "<td>".$no++."</td>";
            echo "<td>".$user_data['name']."</td>";
            echo "<td>".$user_data['mobile']."</td>";
            echo "<td>".$user_data['email']."</td>";
            echo "<td>
                    <a href='edit.php?id=".$user_data['id']."' class='btn btn-edit'>Edit</a>
                    <a href='#' class='btn btn-delete' onclick='showModal(".$user_data['id'].")'>Delete</a>
                  </td>";
            echo "</tr>";        
        }
        ?>
    </table>
    <div class="center">
        <a href="add.php" class="btn">Tambah Pengguna Baru</a>
    </div>

    <!-- Modal for delete confirmation -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <div class="icon">⚠️</div>
            <p>Yakin hapus data?</p>
            <button class="btn-confirm" id="confirmBtn">Ya</button>
            <button class="btn-cancel" id="cancelBtn">Batal</button>
        </div>
    </div>

    <script>
        var modal = document.getElementById("deleteModal");
        var confirmBtn = document.getElementById("confirmBtn");
        var cancelBtn = document.getElementById("cancelBtn");
        var deleteId = null;

        // Function to show the modal
        function showModal(id) {
            modal.style.display = "block";
            deleteId = id;  // Store the ID to delete
        }

        // When the user clicks "Ya", redirect to delete.php with the ID
        confirmBtn.onclick = function () {
            window.location.href = "delete.php?id=" + deleteId;
        }

        // When the user clicks "Batal", close the modal
        cancelBtn.onclick = function () {
            modal.style.display = "none";
            deleteId = null;  // Reset the delete ID
        }

        // Close the modal if the user clicks outside of it
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

</body>
</html>
