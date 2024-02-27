<?php 
    require('auth/check-auth.php');
    require_once 'model/autorun.php';
    $myModel = Model\Data::makeModel(Model\Data::FILE);
    $myModel->setCurrentUser($_SESSION['user']);
?>

<?php
    $medicine_filter = isset($_POST['medicine_filter']) ? $_POST['medicine_filter'] : '';
    $selected_recipe = isset($_GET['recipe']) ? $_GET['recipe'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>List of medicines</title>
</head>
<body>
    <header class="header">
        <div>
            <span>Hello <?php echo $_SESSION['user']; ?>!</span>
            <?php if($myModel->checkRight('user', 'admin')): ?>
                <a href="admin/index.php">Administration</a>
            <?php endif; ?>
            <a href="/lr9/auth/logout.php">Log out</a>
        </div>
        <?php if($myModel->checkRight('recipe', 'view')):?>
            <?php $data['recipes'] = $myModel->readRecipes(); ?>
            <form name='recipe-form' method='get' class="recipe-form-container">
                <label for="recipe">Recipe</label>
                <select name="recipe">
                    <option value=""></option>
                    <?php
                        foreach ($data['recipes'] as $currecipe) {
                            echo "<option " . (($currecipe->getId() == $_GET['recipe'])?"selected":"") . " value='" . 
                            $currecipe->getId() . "'>" . $currecipe->getPatient() . "</option>";
                        }
                    ?>
                </select>
                <input type="submit" value="OK">
                <?php if($myModel->checkRight('recipe', 'create')):?>
                    <a href="forms/create-recipe.php" class="add-recipe-button">Add recipe</a>
                <?php endif; ?>
            </form>
            <?php if(isset($_GET['recipe']) && $_GET['recipe']): ?>
                <?php 
                    $data['recipe'] = $myModel->readRecipe($_GET['recipe']);
                ?>
                <div class="header-content">
                    <div class="recipe-name">Recipe for <?php echo $data['recipe']->getPatient(); ?></div>
                    <div class="recipe-info">Born - <span class="recipe-info-highlight"><?php echo $data['recipe']->getBorn(); ?></span></div>
                    <div class="recipe-info">Doctor is <span class="recipe-info-highlight"><?php echo $data['recipe']->getDoctor(); ?></span></div>
                </div>
                <div class='action'>
                    <?php if($myModel->checkRight('recipe', 'edit')):?>
                        <a href="forms/edit-data.php?recipe=<?php echo $_GET['recipe']; ?>">Edit data</a>
                    <?php endif; ?>
                    <?php if($myModel->checkRight('recipe', 'delete')):?>
                        <a href="forms/delete-data.php?recipe=<?php echo $_GET['recipe']; ?>">Delete data</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </header>
    <?php if($myModel->checkRight('medicine', 'view')):?>
        <section class="medicines-list container">
            <?php if(isset($_GET['recipe']) && $_GET['recipe']): ?>
                <?php $data['medicines'] = $myModel->readMedicines($_GET['recipe']); ?>
                <div class="filter-and-button-container">
                    <form name='medicines-filter' method='post'>
                        <label for="medicine_filter">Filter by medicines</label>    
                        <input type="text" id="medicine_filter" name='medicine_filter' value='<?php echo $medicine_filter; ?>'>
                        <input type="submit" value='Filter'>
                    </form>
                    <?php if($myModel->checkRight('medicine', 'create')):?>
                        <a href="forms/create-medicine.php?recipe=<?php echo $_GET['recipe']; ?>" class="add-medicine-button">Add medicine</a>
                    <?php endif; ?>
                </div>
                <table class="medicines-table">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Name</th>
                            <th>Dosage</th>
                            <th>Medicine's form</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($data['medicines']) && is_array($data['medicines'])): ?>
                            <?php foreach($data['medicines'] as $key => $medicine): ?>
                                <?php if(empty($medicine_filter) || stristr($medicine->getName(), $medicine_filter)): ?>
                                    <tr>
                                        <td><?php echo ($key + 1); ?></td>
                                        <td><?php echo $medicine->getName(); ?></td>
                                        <td><?php echo $medicine->getDosage(); ?></td>
                                        <td><?php echo $medicine->getForm(); ?></td>
                                        <td>
                                            <?php if($myModel->checkRight('medicine', 'edit')):?>
                                                <a href="forms/edit-medicine.php?recipe=<?php
                                                    echo $_GET['recipe']; ?>&file=<?php
                                                        echo $medicine->getId();
                                                    ?>">Edit</a>
                                            <?php endif; ?>
                                            |
                                            <?php if($myModel->checkRight('medicine', 'delete')):?>
                                                <a href="forms/delete-medicine.php?recipe=<?php
                                                    echo $_GET['recipe']; ?>&file=<?php
                                                        echo $medicine->getId();
                                                    ?>">Delete</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>
    <?php endif; ?>
</body>
</html>