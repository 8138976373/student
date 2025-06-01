<?php
require_once '../../includes/auth.php';
require_once '../../includes/functions.php';

$studentId = $_GET['id'] ?? '';
$student = null;
$studentMarks = [];

if (!empty($studentId)) {
    $students = loadStudents();
    $studentMarks = loadMarks($studentId);
     

    // Find the student
    foreach ($students as $s) {
        if ($s['admission_no'] === $studentId) {
            $student = $s;
            break;
        }
    }

}

// Calculate average grade
$avgGrade = 0;
// if (!empty($studentMarks)) {
//     $totalGrades = array_sum(array_column($studentMarks, 'grade'));
//     $avgGrade = round($totalGrades / count($studentMarks), 2);
// }

include '../../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/student/admin/admindash.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="view_student.php">Students</a></li>
                    <li class="breadcrumb-item active"><?php echo htmlspecialchars($student['name']); ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <!-- Student Information -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Student Information</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-5">Admission No:</dt>
                        <dd class="col-sm-7"><?php echo htmlspecialchars($student['admission_no']); ?></dd>

                        <dt class="col-sm-5">Name:</dt>
                        <dd class="col-sm-7"><?php echo htmlspecialchars($student['name']); ?></dd>

                        <!-- <dt class="col-sm-5">Email:</dt>
                        <dd class="col-sm-7"><?php echo htmlspecialchars($student['Phone']); ?></dd> -->

                        <dt class="col-sm-5">Department:</dt>
                        <dd class="col-sm-7"><?php echo htmlspecialchars($student['department']); ?></dd>

						 <dt class="col-sm-5">Semester:</dt>
                        <dd class="col-sm-7"><?php echo htmlspecialchars($student['semester']); ?></dd>

                        <dt class="col-sm-5">Phone:</dt>
                        <dd class="col-sm-7"><?php echo htmlspecialchars($student['phno'] ?? '—'); ?></dd>

                        <!-- <dt class="col-sm-5">Address:</dt>
                        <dd class="col-sm-7"><?php echo htmlspecialchars($student['address'] ?? '—'); ?></dd> -->

                        <!-- <dt class="col-sm-5">Registered:</dt>
                        <dd class="col-sm-7"><?php echo date('M j, Y', strtotime($student['created_at'])); ?></dd> -->
                    </dl>

                    <div class="d-grid">
                        <a href="add_marks.php?id=<?php echo $student['id']; ?>"
                            class="btn btn-primary">Add New Marks</a>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Statistics</h5>
                </div>
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="text-primary"><?php echo count($studentMarks); ?></h4>
                            <small class="text-muted">Total Exams</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success"><?php echo $avgGrade; ?>%</h4>
                            <small class="text-muted">Average Grade</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Marks History -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Marks History</h5>
                    <a href="add_marks.php?id=<?php echo $student['id']; ?>"
                        class="btn btn-sm btn-primary">Add Marks</a>
                </div>
                <div class="card-body">
                    <?php if (empty($studentMarks)): ?>
                        <div class="text-center py-4">
                            <p class="text-muted">No marks recorded yet.</p>
                            <a href="add_marks.php?id=<?php echo $student['id']; ?>"
                                class="btn btn-primary">Add First Marks</a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Exam Name</th>
                                        <th>Total Mark</th>
                                        <th>Percentage</th>
                                        <th>Grade</th>
                                        <th>Actions</th>
                                        <!-- <th>Php</th>
                                        <th>Java</th>
                                        <th>DBMS</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($studentMarks as $mark): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($mark['exam_name']); ?></td>
                                            <td><?php echo htmlspecialchars($mark['total']); ?></td>
                                            <td><?php echo htmlspecialchars($mark['percentage']); ?></td>
                                            <td><?php echo htmlspecialchars($mark['grade']); ?></td>
                                             <td> <div class="btn-group" role="group">
            <a href="#"
               onclick='showMarksheet(<?= json_encode($mark) ?>); return false;'
               class="btn btn-sm btn-outline-primary"
               title="View Marksheet">
                <i class="fas fa-eye"></i> View
            </a>
            <button class="btn btn-sm btn-outline-success" onclick='downloadMarksheet(<?= json_encode($mark) ?>)'>
                <i class="fas fa-download"></i> Download
            </button>
        </div>
</td>

                                         </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
<script>
function showMarksheet(mark) {
    let message = 
        "📝 Marksheet\n\n" +
        "Exam: " + mark.exam_name + "\n" +
        "English: " + mark.english + "\n" +
        "Second Language: " + mark.sec_language + "\n" +
        "Maths: " + mark.maths + "\n" +
        "PHP: " + mark.php + "\n" +
        "DBMS: " + mark.dbms + "\n" +
        "Java: " + mark.java + "\n\n" +
        

    alert(message);
}


function downloadMarksheet(mark) {
    const win = window.open('', '', 'width=800,height=600');
    win.document.write(`
        <html>
            <head>
                <title>Marksheet - ${mark.exam_name}</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        padding: 20px;
                        line-height: 1.6;
                    }
                    h2 {
                        text-align: center;
                        text-transform: uppercase;
                        margin-bottom: 30px;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-bottom: 30px;
                    }
                    th, td {
                        border: 1px solid #000;
                        padding: 10px;
                        text-align: left;
                    }
                    th {
                        background-color: #f0f0f0;
                        font-weight: bold;
                    }
                    .stats {
                        margin-top: 20px;
                    }
                    .stat {
                        margin-bottom: 10px;
                        font-size: 16px;
                    }
                    .stat span {
                        font-weight: bold;
                        color: #2c3e50;
                    }
                </style>
            </head>
            <body>
                <h2>Student Marksheet</h2>

                <table>
                    <tr><th>Exam</th><td>${mark.exam_name}</td></tr>
                    <tr><th>English</th><td>${mark.english}</td></tr>
                    <tr><th>Second Language</th><td>${mark.sec_language}</td></tr>
                    <tr><th>Maths</th><td>${mark.maths}</td></tr>
                    <tr><th>PHP</th><td>${mark.php}</td></tr>
                    <tr><th>DBMS</th><td>${mark.dbms}</td></tr>
                    <tr><th>Java</th><td>${mark.java}</td></tr>
                </table>
                 <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Statistics</h5>
                </div>
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="text-primary">${mark.total}</h4>
                            <small class="text-muted">Total Marks:</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success">${mark.percentage}%</h4>
                            <small class="text-muted">Average Percentage</small>
                        </div>
                          <div class="col-6">
                            <h4 class="text-success">${mark.grade}</h4>
                            <small class="text-muted">Average Grade</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

               
                <script>
                    window.onload = function() {
                        window.print();
                    }
                <\/script>
            </body>
        </html>
    `);
    win.document.close();
}

</script>


