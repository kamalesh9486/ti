


<?php
session_start();

if (!isset($_SESSION['register_number'])) {
    die("No register number found. Please submit the form first.");
}

$register_number = $_SESSION['register_number'];

require_once('config/db.php');

$query = "SELECT * FROM `grievance_` WHERE `register_number` = '$register_number'";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

$grievanceType = '';
if ($row = mysqli_fetch_assoc($result)) {
    $grievanceType = htmlspecialchars($row['grievance_type']);
    $_SESSION['grievance_type'] = $grievanceType; // Store grievance type in session
}

mysqli_close($con);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Upload</title>
    <link rel="stylesheet" href="styles3.css">
</head>
<body>
<div class="container">
    <h2>Student Grievances</h2>
    <?php if ($grievanceType): ?>
        <p>Grievance Type: <?php echo $grievanceType; ?></p>
    <?php else: ?>
        <p>No grievances found for this student.</p>
    <?php endif; ?>
</div>

<form id="uploadForm" action="upload.php" method="post" enctype="multipart/form-data">
    <label for="document1" id="label1">fees_payment_details</label>
    <input type="file" name="document1" id="document1" accept=".pdf, .doc, .docx">
    
    <label for="document2" id="label2">Hall Ticket:</label>
    <input type="file" name="document2" id="document2" accept=".pdf, .doc, .docx">
    
    <label for="document3" id="label3">Exam Application Form:</label>
    <input type="file" name="document3" id="document3" accept=".pdf, .doc, .docx">
    
    <label for="document4" id="label4"> Available Mark Statement:</label>
    <input type="file" name="document4" id="document4" accept=".pdf, .doc, .docx">
    
    <label for="document5" id="label5">Consolidated Mark Statement:</label>
    <input type="file" name="document5" id="document5" accept=".pdf, .doc, .docx">
    
    <label for="document6" id="label6">Course Completion Certificate:</label>
    <input type="file" name="document6" id="document6" accept=".pdf, .doc, .docx">
    
    <label for="document7" id="label7">Application Fees:</label>
    <input type="file" name="document7" id="document7" accept=".pdf, .doc, .docx">
    
    <label for="document8" id="label8">Genuine Certificate Fees:</label>
    <input type="file" name="document8" id="document8" accept=".pdf, .doc, .docx">
    
    <label for="document9" id="label9">PSTM:</label>
    <input type="file" name="document9" id="document9" accept=".pdf, .doc, .docx">

    <input type="submit" value="Upload Documents">
</form>

<script>
     document.addEventListener("DOMContentLoaded", function () {
        const grievanceType = "<?php echo $grievanceType; ?>";
        const labels = [
            document.getElementById('label1'),
            document.getElementById('label2'),
            document.getElementById('label3'),
            document.getElementById('label4'),
            document.getElementById('label5'),
            document.getElementById('label6'),
            document.getElementById('label7'),
            document.getElementById('label8'),
            document.getElementById('label9')
        ];

        function hideAllLabels() {
            labels.forEach(label => {
                if (label) {
                    label.style.display = 'none';
                    const input = label.nextElementSibling;
                    if (input) input.style.display = 'none';
                }
            });
        }

        function showLabels(indices) {
            indices.forEach(index => {
                if (labels[index]) {
                    labels[index].style.display = 'block';
                    const input = labels[index].nextElementSibling;
                    if (input) input.style.display = 'block';
                }
            });
        }

        hideAllLabels();

        switch (grievanceType) {
            case 'Course Completion Certificate':
                showLabels([0]);
                break;
            case 'Result':
                showLabels([0, 1, 2]);
                break;
            case 'Current Mark Statement':
                showLabels([3]);
                break;
            case 'Consolidated Mark Statement':
                showLabels([0, 1, 2]);
                break;
            case 'Provisional Certificate':
                showLabels([5, 4, 2, 0]);
                break;
            case 'Genuine Certificate':
                showLabels([0]);
                break;
            case 'PSTM':
                showLabels([8]);
                break;
            default:
                // No default action
                break;
        }
    });
</script>

<?php
//mysqli_close($con);
?>
</body>
</html>
