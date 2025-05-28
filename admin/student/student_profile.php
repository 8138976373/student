<?php
require_once '../../includes/auth.php';
require_once '../../includes/functions.php';

$studentId = $_GET['id'] ?? '';
$student = null;
$studentMarks = [];

if (!empty($studentId)) {
    $students = loadStudents();
    $marks = loadMarks();

    // Find the student
    foreach ($students as $s) {
        if ($s['id'] === $studentId) {
            $student = $s;
            break;
        }
    }

    // Get student's marks
    $studentMarks = array_filter($marks, function ($mark) use ($studentId) {
        return $mark['student_id'] === $studentId;
    });

    // Sort marks by date (newest first)
    usort($studentMarks, function ($a, $b) {
        return strtotime($b['created_at']) - strtotime($a['created_at']);
    });
}

// if (!$student) {
//     header('Location: view_students.php');
//     exit();
// }

// Calculate average grade
$avgGrade = 0;
if (!empty($studentMarks)) {
    $totalGrades = array_sum(array_column($studentMarks, 'grade'));
    $avgGrade = round($totalGrades / count($studentMarks), 2);
}

include '../../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="view_students.php">Students</a></li>
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
                        <dt class="col-sm-5">Student ID:</dt>
                        <dd class="col-sm-7"><?php echo htmlspecialchars($student['student_id']); ?></dd>

                        <dt class="col-sm-5">Name:</dt>
                        <dd class="col-sm-7"><?php echo htmlspecialchars($student['name']); ?></dd>

                        <dt class="col-sm-5">Email:</dt>
                        <dd class="col-sm-7"><?php echo htmlspecialchars($student['email']); ?></dd>

                        <dt class="col-sm-5">Class:</dt>
                        <dd class="col-sm-7"><?php echo htmlspecialchars($student['class']); ?></dd>

                        <dt class="col-sm-5">Phone:</dt>
                        <dd class="col-sm-7"><?php echo htmlspecialchars($student['phone'] ?? '—'); ?></dd>

                        <dt class="col-sm-5">Address:</dt>
                        <dd class="col-sm-7"><?php echo htmlspecialchars($student['address'] ?? '—'); ?></dd>

                        <dt class="col-sm-5">Registered:</dt>
                        <dd class="col-sm-7"><?php echo date('M j, Y', strtotime($student['created_at'])); ?></dd>
                    </dl>

                    <div class="d-grid">
                        <a href="add_marks.php?student_id=<?php echo $student['id']; ?>"
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
                            <small class="text-muted">Total Marks</small>
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
                    <a href="add_marks.php?student_id=<?php echo $student['id']; ?>"
                        class="btn btn-sm btn-primary">Add Marks</a>
                </div>
                <div class="card-body">
                    <?php if (empty($studentMarks)): ?>
                        <div class="text-center py-4">
                            <p class="text-muted">No marks recorded yet.</p>
                            <a href="add_marks.php?student_id=<?php echo $student['id']; ?>"
                                class="btn btn-primary">Add First Marks</a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Subject</th>
                                        <th>Exam Type</th>
                                        <th>Grade</th>
                                        <th>Max Marks</th>
                                        <th>Percentage</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($studentMarks as $mark): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($mark['subject']); ?></td>
                                            <td><?php echo htmlspecialchars($mark['exam_type']); ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo getGradeBadgeClass($mark['grade'], $mark['max_marks']); ?>">
                                                    <?php echo $mark['grade']; ?>/<?php echo $mark['max_marks']; ?>
                                                </span>
                                            </td>
                                            <td><?php echo $mark['max_marks']; ?></td>
                                            <td><?php echo round(($mark['grade'] / $mark['max_marks']) * 100, 1); ?>%</td>
                                            <td><?php echo date('M j, Y', strtotime($mark['created_at'])); ?></td>
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