<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="test.css">
</head>
<script>
    function toggleDropdown(dropdownId) {
        var dropdown = document.getElementById(dropdownId);
        var isAlreadyOpen = dropdown.classList.contains("show");

        // Сначала закрываем все открытые выпадающие меню
        var allDropdowns = document.querySelectorAll('.drop_group');
        allDropdowns.forEach(function(dropdown) {
            dropdown.classList.remove('show');
        });

        // Если это меню было открыто, то не открываем заново, а закрываем
        if (!isAlreadyOpen) {
            dropdown.classList.toggle("show");
        }
    }

    // Добавим обработчик события для инпутов в выпадающих меню
    document.addEventListener('click', function (e) {
        var dropdownInput = e.target.closest('.drop_group input');
        if (dropdownInput) {
            e.stopPropagation(); // Предотвращаем всплытие события, чтобы не закрывать выпадающее меню
        }
    });
</script>

<body>
    <div class="test">
        <div class="add" onclick="toggleDropdown('ind_dropdown')">
            <button class="add_group">Добавить группу +</button>

            <div id="ind_dropdown" class="drop_group">
                <label for="ind_group">Индивидуальное занятие:</label>
                <input type="text" id="ind_group" name="ind_group" value="<?php echo $_SESSION['form_data']['ind_group'] ?? ''; ?>">
                
                <label for="ind_price">Цена индивидуального занятия (в тг):</label>
                <input type="number" id="ind_price" name="ind_price" value="<?php echo isset($_SESSION['form_data']['ind_price']) ? $_SESSION['form_data']['ind_price'] : ''; ?>">
            </div>
        </div>  

        <div class="add" onclick="toggleDropdown('group_dropdown')">
            <button class="add_group">Добавить группу +</button>

            <div id="group_dropdown" class="drop_group">
                <label for="group_group">Групповое занятие:</label>
                <input type="text" id="group_group" name="group_group" value="<?php echo $_SESSION['form_data']['group_group'] ?? ''; ?>">

                <label for="group_price">Цена группового занятия (в тг):</label>
                <input type="number" id="group_price" name="group_price" value="<?php echo isset($_SESSION['form_data']['group_price']) ? $_SESSION['form_data']['group_price'] : ''; ?>">
            </div>
        </div>  
    </div>
</body>
</html>
