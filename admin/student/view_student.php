<?php
require_once '../../includes/auth.php';
require_once '../../includes/functions.php';

$students = loadStudents();
$search = $_GET['search'] ?? '';

// Filter students based on search
if (!empty($search)) {
    $students = array_filter($students, function ($student) use ($search) {
        return stripos($student['name'], $search) !== false ||
            stripos($student['id'], $search) !== false ||
            stripos($student['phno'], $search) !== false ||
            stripos($student['class'], $search) !== false;
    });
}

include '../../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>All Students</h2>
                <a href="add_student.php" class="btn btn-primary">Add New Student</a>
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <div class="row mb-4">
        <div class="col-md-6">
            <form method="GET" class="d-flex">
                <input type="text" class="form-control me-2" name="search"
                    placeholder="Search by name, ID, email, or class..."
                    value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn btn-outline-primary">Search</button>
                <?php if (!empty($search)): ?>
                    <a href="view_students.php" class="btn btn-outline-secondary ms-2">Clear</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <?php if (empty($students)): ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <?php if (!empty($search)): ?>
                        No students found matching your search criteria.
                    <?php else: ?>
                        No students have been added yet. <a href="add_student.php">Add your first student</a>.
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Student ID</th>
                                        <th>Name</th>
                                        <!-- <th>Email</th> -->
                                        <th>Class</th>
                                        <th>Phone</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $student): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($student['id']); ?></td>
                                            <td><?php echo htmlspecialchars($student['name']); ?></td>
                                            <!-- <td><?php echo htmlspecialchars($student['email']); ?></td> -->
                                            <td><?php echo htmlspecialchars($student['class']); ?></td>
                                            <td><?php echo htmlspecialchars($student['phno'] ?? '—'); ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="student_profile.php?id=<?php echo $student['id']; ?>"
                                                        class="btn btn-sm btn-outline-primary" title="View Profile">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                    <a href="add_marks.php?id=<?php echo $student['id']; ?>"
                                                        class="btn btn-sm btn-outline-success" title="Add Marks">
                                                        <i class="fas fa-plus"></i> Marks
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <small class="text-muted">
                                Showing <?php echo count($students); ?> student(s)
                                <?php if (!empty($search)): ?>
                                    for search: "<?php echo htmlspecialchars($search); ?>"
                                <?php endif; ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include '../../includes/footer.php'; ?>