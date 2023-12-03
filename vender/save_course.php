<?php
session_start();

function saveFormData($data)
{
    $_SESSION['form_data'] = $data;
}

// Функция для получения сохраненных данных из сессии
function getFormData()
{
    $formData = $_SESSION['form_data'] ?? [];
    unset($_SESSION['form_data']); // Очистим сохраненные данные после использования
    return $formData;
}

require 'connect.php';
$course_name = filter_var(trim($_POST['course_name'] ?? ''), FILTER_SANITIZE_STRING);
$emp_id = $_SESSION['emp_id'];
$lvl = filter_var(trim($_POST['lvl'] ?? ''), FILTER_SANITIZE_STRING);
$overview = filter_var(trim($_POST['overview'] ?? ''), FILTER_SANITIZE_STRING);
$duration = filter_var(trim($_POST['duration'] ?? ''), FILTER_SANITIZE_STRING);
$ind_group = isset($_POST['ind_group']) ? filter_var(trim($_POST['ind_group']), FILTER_VALIDATE_INT) : null;
$ind_price = isset($_POST['ind_price']) ? filter_var(trim($_POST['ind_price']), FILTER_VALIDATE_INT) : null;
$group_group = isset($_POST['group_group']) ? filter_var(trim($_POST['group_group']), FILTER_VALIDATE_INT) : null;
$group_price = isset($_POST['group_price']) ? filter_var(trim($_POST['group_price']), FILTER_VALIDATE_INT) : null;

$start_date = filter_var(trim($_POST['start_date'] ?? ''), FILTER_SANITIZE_STRING);

if (empty($course_name) || empty($lvl) || empty($overview) || empty($duration) || empty($start_date)) {
    saveFormData([
        'course_name' => $course_name,
        'lvl' => $lvl,
        'overview' => $overview,
        'duration' => $duration,
        'start_date' => $start_date,
        'ind_group' => $ind_group,
        'ind_price' => $ind_price,
        'group_group' => $group_group,
        'group_price' => $group_price
    ]);
    $_SESSION['message'] = 'Пожалуйста, заполните все поля';
    header('Location: ../create_course.php');
    exit();
}

if (empty($ind_group) && empty($group_group)) {
    saveFormData([
        'course_name' => $course_name,
        'lvl' => $lvl,
        'overview' => $overview,
        'duration' => $duration,
        'start_date' => $start_date,
        'ind_group' => $ind_group,
        'ind_price' => $ind_price,
        'group_group' => $group_group,
        'group_price' => $group_price
    ]);
    $_SESSION['message'] = 'Заполните хотя бы одну группу';
    header('Location: ../create_course.php');
    exit();
}

if (!empty($ind_group) & empty($ind_price)) {
    saveFormData([
        'course_name' => $course_name,
        'lvl' => $lvl,
        'overview' => $overview,
        'duration' => $duration,
        'start_date' => $start_date,
        'ind_group' => $ind_group,
        'ind_price' => $ind_price,
        'group_group' => $group_group,
        'group_price' => $group_price
    ]);
    $_SESSION['message'] = 'Укажите цену для индивидуальных занятий';
    header('Location: ../create_course.php');
    exit();
}

if (!empty($group_group) & empty($group_price)) {
    saveFormData([
        'course_name' => $course_name,
        'lvl' => $lvl,
        'overview' => $overview,
        'duration' => $duration,
        'start_date' => $start_date,
        'ind_group' => $ind_group,
        'ind_price' => $ind_price,
        'group_group' => $group_group,
        'group_price' => $group_price
    ]);
    $_SESSION['message'] = 'Укажите цену для групповых занятий';
    header('Location: ../create_course.php');
    exit();
}

unset($_SESSION['form_data']);

$statement = $connect->prepare("INSERT INTO courses (course_name, emp_id, lvl, overview, duration, ind_group, ind_price, group_group, group_price, start_date) 
VALUES (:course_name, :emp_id, :lvl, :overview, :duration, :ind_group, :ind_price, :group_group, :group_price, :start_date)");
$statement->bindParam(':course_name', $course_name);
$statement->bindParam(':emp_id', $emp_id);
$statement->bindParam(':lvl', $lvl);
$statement->bindParam(':overview', $overview);
$statement->bindParam(':duration', $duration);
$statement->bindValue(':ind_group', $ind_group, PDO::PARAM_INT);
$statement->bindValue(':ind_price', $ind_price, PDO::PARAM_INT);
$statement->bindValue(':group_group', $group_group, PDO::PARAM_INT);
$statement->bindValue(':group_price', $group_price, PDO::PARAM_INT);
$statement->bindParam(':start_date', $start_date);

if ($statement->execute()) {
    $course_id_stmt = $connect->query("SELECT last_value FROM courses_course_id_seq");
    $course_id = $course_id_stmt->fetchColumn();
    $_SESSION['message'] = 'Курс успешно создан, теперь добавьте расписание!';
    header("Location: ../profile/change.php?course_id=$course_id");
    exit();
} else {
    $_SESSION['message'] = 'Ошибка при создании курса';
    header('Location: ../create_course.php');
    exit();
}
?>
