<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$user = "root";
$password = "";
$dbname = "dynamic_project";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM students WHERE student_id=?");
    $stmt->execute([$id]);
    header("Location: new_project.php");
    exit;
}

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $course = $_POST['course'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];

    if(isset($_GET['edit'])){
        $id = $_GET['edit'];
        $stmt = $conn->prepare("UPDATE students SET name=?, email=?, phone=?, course=?, gender=?, dob=?, address=? WHERE student_id=?");
        $stmt->execute([$name,$email,$phone,$course,$gender,$dob,$address,$id]);
    } else {
        $stmt = $conn->prepare("INSERT INTO students (name, email, phone, course, gender, dob, address) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name,$email,$phone,$course,$gender,$dob,$address]);
    }

    header("Location: new_project.php");
    exit;
}

$editStudent = null;
if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM students WHERE student_id=?");
    $stmt->execute([$id]);
    $editStudent = $stmt->fetch(PDO::FETCH_ASSOC);
}

$stmt = $conn->query("SELECT * FROM students");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP CRUD Application</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 10px; text-align: left; }
        form input, form select { margin-bottom: 10px; padding: 5px; width: 200px; }
        form input[type="submit"] { width: 150px; }
    </style>
</head>
<body>

<h2><?php echo isset($editStudent) ? "Edit Student" : "Add Student"; ?></h2>

<form method="POST">
    Name: <br><input type="text" name="name" value="<?= $editStudent['name'] ?? '' ?>" required><br>
    Email: <br><input type="email" name="email" value="<?= $editStudent['email'] ?? '' ?>" required><br>
    Phone: <br><input type="text" name="phone" value="<?= $editStudent['phone'] ?? '' ?>"><br>
    Course: <br><input type="text" name="course" value="<?= $editStudent['course'] ?? '' ?>"><br>
    Gender: <br>
    <select name="gender">
        <option <?= (isset($editStudent) && $editStudent['gender']=='Male') ? 'selected' : '' ?>>Male</option>
        <option <?= (isset($editStudent) && $editStudent['gender']=='Female') ? 'selected' : '' ?>>Female</option>
        <option <?= (isset($editStudent) && $editStudent['gender']=='Other') ? 'selected' : '' ?>>Other</option>
    </select><br>
    DOB: <br><input type="date" name="dob" value="<?= $editStudent['dob'] ?? '' ?>"><br>
    Address: <br><input type="text" name="address" value="<?= $editStudent['address'] ?? '' ?>"><br>
    <input type="submit" name="submit" value="<?= isset($editStudent) ? "Update Student" : "Add Student" ?>">
</form>

<hr>

<h2>Student Records</h2>
<table>
<tr>
    <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Course</th>
    <th>Gender</th><th>DOB</th><th>Address</th><th>Actions</th>
</tr>
<?php foreach($students as $student): ?>
<tr>
    <td><?= $student['student_id'] ?></td>
    <td><?= $student['name'] ?></td>
    <td><?= $student['email'] ?></td>
    <td><?= $student['phone'] ?></td>
    <td><?= $student['course'] ?></td>
    <td><?= $student['gender'] ?></td>
    <td><?= $student['dob'] ?></td>
    <td><?= $student['address'] ?></td>
    <td>
        <a href="?edit=<?= $student['student_id'] ?>">Edit</a> |
        <a href="?delete=<?= $student['student_id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

</body>
</html>
